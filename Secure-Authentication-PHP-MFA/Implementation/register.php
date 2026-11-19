<?php
require __DIR__.'/config.php'; $error=''; $ok='';
if($_SERVER['REQUEST_METHOD']==='POST'){ csrf_check(); $u=trim($_POST['username']??''); $e=trim($_POST['email']??''); $p=$_POST['password']??'';
 if(!preg_match('/^[A-Za-z0-9_]{3,50}$/',$u)) $error='Username must be 3–50 letters, numbers, or underscores.';
 elseif(!filter_var($e,FILTER_VALIDATE_EMAIL)) $error='Enter a valid email.';
 elseif(strlen($p)<10) $error='Password must be at least 10 characters.';
 else { try{$s=$pdo->prepare('INSERT INTO users(username,email,password_hash) VALUES(?,?,?)');$s->execute([$u,$e,password_hash($p,PASSWORD_DEFAULT)]);$ok='Account created. You can sign in.';}catch(PDOException $x){$error=$x->getCode()==='23000'?'Username or email already exists.':'Registration failed.';} }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register</title><link rel="stylesheet" href="style.css"></head><body><main class="card"><h1>Create account</h1><p class="muted">Secure Authentication Project</p>
<?php if($error):?><div class="alert error"><?=h($error)?></div><?php endif;?><?php if($ok):?><div class="alert success"><?=h($ok)?></div><?php endif;?>
<form method="post"><input type="hidden" name="csrf_token" value="<?=h(csrf_token())?>"><label>Username</label><input name="username" required minlength="3" maxlength="50"><label>Email</label><input type="email" name="email" required><label>Password (10+ characters)</label><input type="password" name="password" required minlength="10"><button>Create account</button></form><p>Already registered? <a href="login.php">Sign in</a></p></main></body></html>