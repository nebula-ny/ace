<?php
require 'connection.php';  // Menyertakan koneksi database

$id = $_GET['id'];
$name = '';

// Ambil data kandidat berdasarkan ID
if ($id) {
    $result = $conn->query("SELECT * FROM candidates WHERE id = $id");
    if ($result->num_rows > 0) {
        $candidate = $result->fetch_assoc();
        $name = $candidate['name'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['name'];

    if (!empty($new_name)) {
        // Update data kandidat
        $stmt = $conn->prepare("UPDATE candidates SET name = ? WHERE id = ?");
        $stmt->bind_param('si', $new_name, $id);

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
    <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>
    <button type="submit">Perbarui Kandidat</button>
</form>
<a href="candidate.php">Kembali ke Daftar Kandidat</a>
