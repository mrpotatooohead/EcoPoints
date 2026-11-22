<?php
require 'config/database.php'; session_start(); $error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $sid=trim($_POST['student_id']??''); $pw=$_POST['password']??'';
 if (!$name||!filter_var($email,FILTER_VALIDATE_EMAIL)||!$sid||strlen($pw)<8) $error='Complete all fields. Password must be at least 8 characters.';
 else { try { $s=$pdo->prepare("INSERT INTO users(name,email,student_id,password_hash,role) VALUES(?,?,?,?, 'student')"); $s->execute([$name,$email,$sid,password_hash($pw,PASSWORD_DEFAULT)]); header('Location: login.php?registered=1'); exit; } catch(PDOException $e){$error='That email or Student ID may already be registered.';} }
}
$pageTitle='Create account'; include 'includes/header.php'; ?>
<div class="auth-wrap"><div class="auth-side"><span class="eyebrow">JOIN THE CYCLE</span><h1>Earn points by doing something good.</h1><p>Use your university email and Student ID to create a student account.</p></div>
<form class="form-card" method="post"><span class="eyebrow">STUDENT REGISTRATION</span><h2>Create account</h2><?php if($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<label>Full name<input name="name" required></label><label>University email<input type="email" name="email" required></label><label>Student ID<input name="student_id" required></label><label>Password<input type="password" name="password" minlength="8" required></label>
<button class="btn primary full">Create account</button><p class="form-foot">Already registered? <a href="login.php">Log in</a></p><small class="muted">A real deployment should add university email verification and a privacy notice/consent step.</small></form></div>
<?php include 'includes/footer.php'; ?>
