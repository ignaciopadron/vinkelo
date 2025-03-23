<?php
session_start();
require 'config.php';
?>
<?php
$password = 'tu_contraseña';
echo password_hash($password, PASSWORD_DEFAULT);
?>