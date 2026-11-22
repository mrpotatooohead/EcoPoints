<?php
require 'config/database.php'; session_start();
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $email=trim($_POST['email']??''); $password=$_POST['password']??'';
 $q=$pdo->prepare("SELECT id,name,email,password_hash,role,points_balance FROM users WHERE email=? AND status='active'"); $q->execute([$email]); $u=$q->fetch();
 if ($u && password_verify($password,$u['password_hash'])) { unset($u['password_hash']); $_SESSION['user']=$u; header('Location: dashboard.php'); exit; }
 $error='Incorrect email or password.';
}
$pageTitle='Log in'; include 'includes/header.php'; ?>
<div class="auth-wrap"><div class="auth-side"><span class="eyebrow">WELCOME BACK</span><h1>Your next good habit starts here.</h1><p>Sign in to check your EcoPoints balance, track deposits, and explore available rewards.</p></div>
<form class="form-card" method="post"><span class="eyebrow">ECOPONTS ACCOUNT</span><h2>Log in</h2><?php if($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<label>University email<input type="email" name="email" required placeholder="you@university.edu"></label>
<label>Password<input type="password" name="password" required placeholder="Enter your password"></label>
<button class="btn primary full">Log in</button><p class="form-foot">New to EcoPoints? <a href="register.php">Create an account</a></p>
<div class="demo-hint">Demo accounts are listed in the README file.</div></form></div>
<?php include 'includes/footer.php'; ?>
