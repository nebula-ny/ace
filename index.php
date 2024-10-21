<?php
session_start();
require 'connection.php';  // Menyertakan koneksi database

// Cek apakah sudah login
if (!isset($_SESSION['nim'])) {
    header('Location: login.php');
    exit();
}

$nim = $_SESSION['nim'];

// Tambahkan Kandidat Baru (Create)
if (isset($_POST['add_candidate'])) {
    $name = $_POST['name'];
    if (!empty($name)) {
        $conn->query("INSERT INTO candidates (name) VALUES ('$name')");
        echo "Kandidat berhasil ditambahkan!";
    } else {
        echo "Nama kandidat tidak boleh kosong!";
    }
}

// Hapus Kandidat (Delete)
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM candidates WHERE id = '$id'");
    echo "Kandidat berhasil dihapus!";
}

// Update Kandidat (Edit)
if (isset($_POST['edit_candidate'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    if (!empty($name)) {
        $conn->query("UPDATE candidates SET name = '$name' WHERE id = '$id'");
        echo "Kandidat berhasil diperbarui!";
    } else {
        echo "Nama kandidat tidak boleh kosong!";
    }
}

// Ambil kandidat dari database
$candidates = $conn->query("SELECT * FROM candidates");

// Fungsi untuk menghitung suara berdasarkan kategori
function getVotes($conn, $category, $order) {
    return $conn->query("SELECT candidates.name, COUNT(votes.id) AS total_votes 
                         FROM candidates 
                         LEFT JOIN votes ON candidates.id = votes.candidate_id 
                         AND votes.category = '$category' 
                         GROUP BY candidates.id 
                         ORDER BY total_votes $order");
}

// Ambil urutan kandidat berdasarkan suara (default ASC)
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Data untuk setiap kategori
$famous_candidates = getVotes($conn, 'most_famous', $order);
$active_candidates = getVotes($conn, 'most_active', $order);
$friendly_candidates = getVotes($conn, 'most_friendly', $order);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
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
                          <a class="nav-link" href="news.html"><b>vote</b></a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="form.html"><b>logout</b></a>
                      </li>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <h1><b>AWARD CLASS A EUPHORIA</b></h1>
    <!-- Form untuk Tambah Kandidat (Create) -->
    <h2>Tambah Kandidat Baru</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Nama Kandidat Baru">
        <button type="submit" name="add_candidate">Tambah Kandidat</button>
    </form>

    <h2>Daftar Kandidat</h2>
    <table>
        <tr>
            <th>Nama Kandidat</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $candidates->fetch_assoc()): ?>
            <tr>
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

    <h2>Pilih Kandidat untuk Most Famous</h2>
    <form method="POST">
        <select name="candidate_id">
            <?php $candidates->data_seek(0); ?>
            <?php while ($row = $candidates->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="vote_famous">Vote Most Famous</button>
    </form>

    <h2>Pilih Kandidat untuk Most Active</h2>
    <form method="POST">
        <select name="candidate_id">
            <?php $candidates->data_seek(0); ?>
            <?php while ($row = $candidates->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="vote_active">Vote Most Active</button>
    </form>

    <h2>Pilih Kandidat untuk Most Friendly</h2>
    <form method="POST">
        <select name="candidate_id">
            <?php $candidates->data_seek(0); ?>
            <?php while ($row = $candidates->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="vote_friendly">Vote Most Friendly</button>
    </form>

    <h2>Hasil Voting</h2>

    <h3>Most Famous</h3>
    <table>
        <tr>
            <th>Kandidat</th>
            <th>Suara</th>
        </tr>
        <?php while ($row = $famous_candidates->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['total_votes']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Most Active</h3>
    <table>
        <tr>
            <th>Kandidat</th>
            <th>Suara</th>
        </tr>
        <?php while ($row = $active_candidates->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['total_votes']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Most Friendly</h3>
    <table>
        <tr>
            <th>Kandidat</th>
            <th>Suara</th>
        </tr>
        <?php while ($row = $friendly_candidates->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['total_votes']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>
