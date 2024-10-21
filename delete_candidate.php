<?php
require 'connection.php';  // Menyertakan koneksi database

$id = $_GET['id'];

if ($id) {
    // Hapus kandidat berdasarkan ID
    $stmt = $conn->prepare("DELETE FROM candidates WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo " ";
    } else {
        echo " ";
    }
    $stmt->close();
}

header('Location: candidate.php'); // Redirect setelah penghapusan
exit();
?>
