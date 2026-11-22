<?php
require 'config/database.php'; require 'includes/auth.php'; require_login(); $u=current_user();
if($u['role']==='student'){
 $q=$pdo->prepare("SELECT * FROM wallet_transactions WHERE user_id=? ORDER BY created_at DESC LIMIT 6");$q->execute([$u['id']]);$transactions=$q->fetchAll();
 $r=$pdo->query("SELECT * FROM rewards WHERE active=1 ORDER BY points_required LIMIT 3")->fetchAll();
} elseif($u['role']==='personnel'){header('Location: claims.php');exit;} else {header('Location: admin.php');exit;}
$pageTitle='Student dashboard'; include 'includes/header.php'; ?>
<div class="dashboard-head"><div><span class="eyebrow">STUDENT SPACE</span><h1>Hello, <?= htmlspecialchars(explode(' ',$u['name'])[0]) ?>.</h1><p>Every verified deposit moves your campus toward a cleaner future.</p></div><a class="btn primary" href="recycle.php">＋ Start recycling</a></div>
<div class="dashboard-grid"><div class="balance-card"><span>YOUR ECOPONTS BALANCE</span><strong><?= number_format((int)$u['points_balance']) ?></strong><small>Available points</small><div class="balance-leaf">♻</div></div>
<div class="mini-stat"><span>ACCOUNT ROLE</span><b>Student</b><small>University account</small></div><div class="mini-stat"><span>REWARDS AVAILABLE</span><b><?= count($r) ?></b><small>Catalog items</small></div></div>
<div class="content-grid"><section class="panel"><div class="panel-title"><h2>Recent activity</h2><a href="history.php">View history →</a></div>
<?php if(!$transactions): ?><div class="empty-state">No recycling transactions yet. Your first verified deposit will appear here.</div><?php else: foreach($transactions as $t): ?><div class="activity-row"><span class="activity-icon">♻</span><div><b><?= htmlspecialchars($t['description']) ?></b><small><?= htmlspecialchars($t['created_at']) ?></small></div><strong class="<?= $t['points']>=0?'positive':'negative' ?>"><?= $t['points']>0?'+':'' ?><?= $t['points'] ?> pts</strong></div><?php endforeach; endif; ?></section>
<section class="panel"><div class="panel-title"><h2>Quick links</h2></div><a class="quick-link" href="recycle.php"><span>▦</span><div><b>Recycle an item</b><small>Open a station session</small></div>→</a><a class="quick-link" href="rewards.php"><span>✳</span><div><b>Browse rewards</b><small>Academic supplies catalog</small></div>→</a><a class="quick-link" href="history.php"><span>◷</span><div><b>Transaction history</b><small>Review your activity</small></div>→</a></section></div>
<?php include 'includes/footer.php'; ?>
