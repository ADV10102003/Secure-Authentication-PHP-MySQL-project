<?php
declare(strict_types=1);
$isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$isHttps,'httponly'=>true,'samesite'=>'Lax']);
session_start();
const DB_HOST='127.0.0.1'; const DB_NAME='secure_auth'; const DB_USER='root'; const DB_PASS='';
const DEMO_SHOW_OTP=true; // LOCAL DEMO ONLY. Disable for deployment and configure SMTP.
try {
 $pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,
 [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);
} catch(PDOException $e) { http_response_code(500); exit('Database connection failed. Check config.php and import schema.sql.'); }
function h(string $s): string { return htmlspecialchars($s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function csrf_token(): string { if(empty($_SESSION['csrf_token'])) $_SESSION['csrf_token']=bin2hex(random_bytes(32)); return $_SESSION['csrf_token']; }
function csrf_check(): void { $a=$_POST['csrf_token']??''; $b=$_SESSION['csrf_token']??''; if(!is_string($a)||!is_string($b)||$b===''||!hash_equals($b,$a)){http_response_code(403);exit('Invalid CSRF token.');} }
function redirect(string $p): never { header('Location: '.$p); exit; }
function require_login(): void { if(empty($_SESSION['authenticated'])||empty($_SESSION['user_id'])) redirect('login.php'); }
