<?php
require 'connection.php';  // Menyertakan koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    if (!empty($name)) {
        // Menambah kandidat baru
        $stmt = $conn->prepare("INSERT INTO candidates (name) VALUES (?)");
        $stmt->bind_param('s', $name);

        if ($stmt->execute()) {
            echo " ";
        } else {
            echo " ";
        }
        $stmt->close();
    } else {
        echo " ";
    }
}
?>

<form method="POST">
    <label for="name">Nama Kandidat:</label>
    <input type="text" name="name" id="name" required>
    <button type="submit">Tambah Kandidat</button>
</form>
<a href="candidate.php">Lihat Kandidat</a>
