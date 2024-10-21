<?php
session_start();
require 'connection.php';  // Menyertakan koneksi database

// Cek apakah sudah login
if (!isset($_SESSION['nim'])) {
    header('Location: login.php');
    exit();
}

$nim = $_SESSION['nim'];

// Hapus Kandidat (Delete)
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM candidates WHERE id = '$id'");
    echo " ";
}

// Update Kandidat (Edit)
if (isset($_POST['edit_candidate'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    if (!empty($name)) {
        $conn->query("UPDATE candidates SET name = '$name' WHERE id = '$id'");
        echo " ";
    } else {
        echo " ";
    }
}
// Tambahkan Kandidat Baru (Create)
if (isset($_POST['add_candidate'])) {
     $name = $_POST['name'];
     if (!empty($name)) {
         $conn->query("INSERT INTO candidates (name) VALUES ('$name')");
         echo " ";
     } else {
         echo " ";
     }
 }
// Ambil kandidat dari database
$candidates = $conn->query("SELECT * FROM candidates");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CANDIDATE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylecandidate.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary-subtle">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="about.html" onclick="goHome()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                            </svg>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                          <a class="nav-link" href="candidate.php"><b>candidate</b></a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="vote.php"><b>vote</b></a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="logout.php"><b>logout</b></a>
                      </li>
                </ul>
            </div>
        </div>
    </nav>
<br>
<h1><b>AWARD CLASSA EUPHORIA</b></h1>

<h2><b>DAFTAR KANDIDAT</b></h2>
<table>
    <tr>
        <th>Foto</th>
        <th>Nama Kandidat</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $candidates->fetch_assoc()): ?>
        <tr>
            <td><img class="candidate-photo" src="<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>"></td>
            <td><?php echo $row['name']; ?></td>
            <td>
                <!-- Edit Form -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="name" value="<?php echo $row['name']; ?>">
                    <button type="submit" name="edit_candidate">Edit</button>
                </form>
                
                <!-- Delete Link -->
                <a href="candidate.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?')">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<br>
<h2><b>TAMBAH KANDIDAT BARU</b></h2>
<form method="POST" class="add">
    <input type="text" name="name" placeholder="nama">
    <button type="submit" name="add_candidate">tambah</button>
</form>
</body>
</html>
