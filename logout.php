<?php
session_start(); // Memulai sesi
session_destroy(); // Menghancurkan sesi

header('Location: login.php?message=logout_success'); 
exit();
?>
