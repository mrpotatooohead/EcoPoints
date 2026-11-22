<?php
// ESP32 integration scaffold. Send JSON: {session_id, weight_grams, device_key}
require '../config/database.php';
header('Content-Type: application/json');
$data=json_decode(file_get_contents('php://input'),true) ?? [];
$key=$_SERVER['HTTP_X_DEVICE_KEY'] ?? ($data['device_key'] ?? '');
$expected=getenv('ECOPONTS_DEVICE_KEY') ?: 'CHANGE_THIS_DEVICE_KEY';
if(!hash_equals($expected,(string)$key)){http_response_code(401);echo json_encode(['ok'=>false,'message'=>'Unauthorized device']);exit;}
$session=(int)($data['session_id']??0);$weight=(float)($data['weight_grams']??-1);
if($session<1||$weight<0){http_response_code(422);echo json_encode(['ok'=>false,'message'=>'Invalid sensor payload']);exit;}
$q=$pdo->prepare("SELECT s.*,m.min_weight,m.max_weight,m.points FROM recycling_sessions s JOIN material_categories m ON m.id=s.material_id WHERE s.id=? AND s.status='active'");$q->execute([$session]);$s=$q->fetch();
if(!$s){http_response_code(404);echo json_encode(['ok'=>false,'message'=>'No active session']);exit;}
$valid=$weight >= $s['min_weight'] && $weight <= $s['max_weight'];
$status=$valid?'verified':'flagged';
$pdo->prepare("INSERT INTO sensor_readings(session_id,weight_grams,received_at) VALUES(?,?,NOW())")->execute([$session,$weight]);
$pdo->prepare("UPDATE recycling_sessions SET weight_grams=?,status=? WHERE id=?")->execute([$weight,$status,$session]);
if($valid){
 $pdo->prepare("UPDATE users SET points_balance=points_balance+? WHERE id=?")->execute([$s['points'],$s['user_id']]);
 $pdo->prepare("INSERT INTO wallet_transactions(user_id,points,description) VALUES(?,?,?)")->execute([$s['user_id'],$s['points'],'Verified recycling deposit']);
}
echo json_encode(['ok'=>true,'status'=>$status,'points_awarded'=>$valid?(int)$s['points']:0]);
