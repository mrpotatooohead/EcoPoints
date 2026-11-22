<?php
require 'config/database.php'; require 'includes/auth.php'; require_role('student');
$stations=$pdo->query("SELECT * FROM stations WHERE active=1")->fetchAll(); $materials=$pdo->query("SELECT * FROM material_categories WHERE active=1")->fetchAll();
$msg=''; $kind='info';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $station=(int)($_POST['station_id']??0); $material=(int)($_POST['material_id']??0);
 $check=$pdo->prepare("SELECT id FROM stations WHERE id=? AND active=1"); $check->execute([$station]);
 $check2=$pdo->prepare("SELECT id FROM material_categories WHERE id=? AND active=1"); $check2->execute([$material]);
 if($check->fetch() && $check2->fetch()){
   $insert=$pdo->prepare("INSERT INTO recycling_sessions(user_id,station_id,material_id,status) VALUES(?,?,?,'active')");
   $insert->execute([current_user()['id'],$station,$material]);
   $sessionId=$pdo->lastInsertId();
   $msg='Session #'.$sessionId.' opened. Place the selected item in the bin. Points will only be credited after a matching IoT sensor reading is received and verified.';
   $kind='success';
 } else { $msg='Please select a valid active station and material.'; $kind='info'; }
}
$pageTitle='Recycle'; include 'includes/header.php'; ?>
<div class="page-heading"><span class="eyebrow">RECYCLING STATION</span><h1>Make a deposit.</h1><p>Select the station and material before placing your item in the designated bin.</p></div>
<div class="two-col"><form class="panel form-panel" method="post"><h2>Start a recycling session</h2><?php if($msg): ?><div class="notice <?= $kind ?>"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<label>Recycling station<select name="station_id" required><?php foreach($stations as $s): ?><option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?> · <?= htmlspecialchars($s['location']) ?></option><?php endforeach; ?></select></label>
<label>Material type<select name="material_id" required><?php foreach($materials as $m): ?><option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?> · <?= $m['points'] ?> pts</option><?php endforeach; ?></select></label>
<button class="btn primary full">Continue to deposit</button><p class="muted">Prototype note: the live QR scanner and sensor connection must be integrated with the physical ESP32 station.</p></form>
<div class="panel"><h2>Before you deposit</h2><ol class="steps"><li><b>Scan station QR</b><small>Identifies the station and starts a time-limited session.</small></li><li><b>Select your material</b><small>Choose the correct accepted material category.</small></li><li><b>Place item in the bin</b><small>The load cell detects a physical weight change.</small></li><li><b>Wait for verification</b><small>Only valid readings can earn points automatically.</small></li></ol></div></div>
<?php include 'includes/footer.php'; ?>
