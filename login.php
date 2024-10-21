<?php
session_start();
require 'connection.php';  // Menyertakan koneksi database

if (isset($_POST['login'])) {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    // Cek apakah NIM dan password cocok
    $result = $conn->query("SELECT * FROM users WHERE nim = '$nim' AND password = '$password'");
    if ($result->num_rows == 1) {
        // Set session login
        $_SESSION['nim'] = $nim;
        header('Location: index.html');
    } else {
        echo " ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <div class="login">
    <h1><b>LOGIN</b></h1>
    <form method="POST">
        <label for="nim">NIM:</label>
        <input type="text" name="nim" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit" name="login">Login</button>
    </form>
</div>
</body>
</html>
