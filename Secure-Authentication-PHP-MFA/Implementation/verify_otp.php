<?php
require __DIR__.'/config.php';if(empty($_SESSION['pending_user_id']))redirect('login.php');if($_SERVER['REQUEST_METHOD']!=='POST')redirect('send_otp.php');csrf_check();
$otp=trim($_POST['otp']??'');$error='';
if(!preg_match('/^[0-9]{6}$/',$otp))$error='Enter the six-digit code.';
else{$s=$pdo->prepare('SELECT id,otp_hash,expires_at,attempts FROM otp_codes WHERE user_id=? AND used=0 ORDER BY id DESC LIMIT 1');$s->execute([(int)$_SESSION['pending_user_id']]);$r=$s->fetch();
 if(!$r||strtotime($r['expires_at'])<time()||(int)$r['attempts']>=5){if($r)$pdo->prepare('UPDATE otp_codes SET used=1 WHERE id=?')->execute([$r['id']]);$error='Code expired or attempt limit reached. Sign in again.';}
 else{$pdo->prepare('UPDATE otp_codes SET attempts=attempts+1 WHERE id=?')->execute([$r['id']]);if(password_verify($otp,$r['otp_hash'])){$pdo->prepare('UPDATE otp_codes SET used=1 WHERE id=?')->execute([$r['id']]);session_regenerate_id(true);$_SESSION['user_id']=(int)$_SESSION['pending_user_id'];$_SESSION['authenticated']=true;unset($_SESSION['pending_user_id']);redirect('dashboard.php');}$error='Incorrect code.';}
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Verify</title><link rel="stylesheet" href="style.css"></head><body><main class="card"><h1>Verification failed</h1><div class="alert error"><?=h($error)?></div><p><a href="send_otp.php">Try again</a> · <a href="logout.php">Cancel</a></p></main></body></html>