<?php
require __DIR__.'/config.php'; $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){csrf_check();$id=trim($_POST['identity']??'');$pw=$_POST['password']??'';
 $_SESSION['tries']=$_SESSION['tries']??0;$_SESSION['locked_until']=$_SESSION['locked_until']??0;
 if(time()<(int)$_SESSION['locked_until'])$error='Too many attempts. Wait two minutes.';
 else{$s=$pdo->prepare('SELECT id,password_hash FROM users WHERE username=? OR email=? LIMIT 1');$s->execute([$id,$id]);$u=$s->fetch();
 if($u&&password_verify($pw,$u['password_hash'])){$_SESSION['tries']=0;unset($_SESSION['user_id'],$_SESSION['authenticated']);$_SESSION['pending_user_id']=(int)$u['id'];session_regenerate_id(true);redirect('send_otp.php');}
 $_SESSION['tries']++;if($_SESSION['tries']>=5){$_SESSION['locked_until']=time()+120;$_SESSION['tries']=0;}$error='Invalid username/email or password.';}
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title><link rel="stylesheet" href="style.css"></head><body><main class="card"><h1>Sign in</h1><p class="muted">Password + one-time code</p><?php if($error):?><div class="alert error"><?=h($error)?></div><?php endif;?>
<form method="post"><input type="hidden" name="csrf_token" value="<?=h(csrf_token())?>"><label>Username or email</label><input name="identity" required><label>Password</label><input type="password" name="password" required><button>Continue</button></form><p>New user? <a href="register.php">Create an account</a></p></main></body></html>