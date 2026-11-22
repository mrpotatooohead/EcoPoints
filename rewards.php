<?php
require 'config/database.php'; require 'includes/auth.php'; require_role('student');
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['reward_id']??0); $pdo->beginTransaction();
 try{$q=$pdo->prepare("SELECT * FROM rewards WHERE id=? AND active=1 FOR UPDATE");$q->execute([$id]);$reward=$q->fetch();$q=$pdo->prepare("SELECT points_balance FROM users WHERE id=? FOR UPDATE");$q->execute([current_user()['id']]);$user=$q->fetch();
 if(!$reward||$reward['stock']<1||$user['points_balance']<$reward['points_required'])throw new Exception('Not enough points or item is out of stock.');
 $code=strtoupper(bin2hex(random_bytes(4)));$pdo->prepare("INSERT INTO redemptions(user_id,reward_id,code,status) VALUES(?,?,?,'pending')")->execute([current_user()['id'],$id,$code]);
 $pdo->prepare("UPDATE users SET points_balance=points_balance-? WHERE id=?")->execute([$reward['points_required'],current_user()['id']]);$pdo->prepare("UPDATE rewards SET stock=stock-1 WHERE id=?")->execute([$id]);
 $pdo->prepare("INSERT INTO wallet_transactions(user_id,points,description) VALUES(?,?,?)")->execute([current_user()['id'],-$reward['points_required'],'Redeemed '.$reward['name']]);$pdo->commit();header('Location: rewards.php?code='.urlencode($code));exit;
 }catch(Exception $e){$pdo->rollBack();$error=$e->getMessage();}
}
$items=$pdo->query("SELECT * FROM rewards WHERE active=1 ORDER BY points_required")->fetchAll();$pageTitle='Rewards catalog';include 'includes/header.php'; ?>
<div class="page-heading"><span class="eyebrow">REWARDS CATALOG</span><h1>Good habits, useful rewards.</h1><p>Exchange your EcoPoints for available academic supplies.</p></div>
<?php if(isset($_GET['code'])): ?><div class="redemption-banner"><span class="eyebrow">YOUR REDEMPTION CODE</span><strong><?= htmlspecialchars($_GET['code']) ?></strong><p>Present this code to authorized personnel at the claiming office. Keep it available until your claim is verified.</p></div><?php endif; ?>
<?php if(!empty($error)): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="reward-grid"><?php foreach($items as $it): ?><article class="reward-card"><div class="reward-visual"><?= ['Eraser'=>'▰','Ballpen'=>'✎','Notebook'=>'▤','Yellow Pad'=>'▧'][$it['name']]??'✳' ?></div><div class="reward-info"><span class="stock"><?= $it['stock'] ?> in stock</span><h3><?= htmlspecialchars($it['name']) ?></h3><p>Academic supply</p><div class="reward-bottom"><b><?= $it['points_required'] ?> pts</b><form method="post"><input type="hidden" name="reward_id" value="<?= $it['id'] ?>"><button class="btn small primary" <?= $it['stock']<1?'disabled':'' ?>>Redeem</button></form></div></div></article><?php endforeach; ?></div>
<?php include 'includes/footer.php'; ?>
