<?php 
session_start();
require 'connection.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nim'])) {
    die("Anda harus login terlebih dahulu.");
}

$nim = $_SESSION['nim'];

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

// Fungsi untuk memeriksa apakah pengguna sudah memberikan suara dalam kategori
function hasVoted($conn, $category, $nim) {
    $result = $conn->query("SELECT * FROM votes WHERE category = '$category' AND nim = '$nim'");
    return $result->num_rows > 0;
}

// Proses vote Most Famous
if (isset($_POST['vote_famous'])) {
    if (!hasVoted($conn, 'most_famous', $nim)) {
        $candidate_id = $_POST['candidate_id_famous'];
        $conn->query("INSERT INTO votes (candidate_id, category, nim) VALUES ('$candidate_id', 'most_famous', '$nim')");
        echo "Terima kasih telah memberikan suara untuk Most Famous!";
    } else {
        echo "Anda sudah memberikan suara untuk kategori ini.";
    }
}

// Proses vote Most Active
if (isset($_POST['vote_active'])) {
    if (!hasVoted($conn, 'most_active', $nim)) {
        $candidate_id = $_POST['candidate_id_active'];
        $conn->query("INSERT INTO votes (candidate_id, category, nim) VALUES ('$candidate_id', 'most_active', '$nim')");
        echo "Terima kasih telah memberikan suara untuk Most Active!";
    } else {
        echo "Anda sudah memberikan suara untuk kategori ini.";
    }
}

// Proses vote Most Friendly
if (isset($_POST['vote_friendly'])) {
    if (!hasVoted($conn, 'most_friendly', $nim)) {
        $candidate_id = $_POST['candidate_id_friendly'];
        $conn->query("INSERT INTO votes (candidate_id, category, nim) VALUES ('$candidate_id', 'most_friendly', '$nim')");
        echo "Terima kasih telah memberikan suara untuk Most Friendly!";
    } else {
        echo "Anda sudah memberikan suara untuk kategori ini.";
    }
}

// Ambil data voting berdasarkan kategori
$famous_candidates = getVotes($conn, 'most_famous', $order);
$active_candidates = getVotes($conn, 'most_active', $order);
$friendly_candidates = getVotes($conn, 'most_friendly', $order);

// Ambil data kandidat
$candidates = $conn->query("SELECT * FROM candidates");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOTE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylesvote.css">
    
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
                        <a class="nav-link" href="index.html" onclick="goHome()">
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
    
    <h2><b>Most Famous</b></h2>
    <form method="POST">
        <select name="candidate_id_famous">
            <?php while ($row = $candidates->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="vote_famous">Vote Most Famous</button>
    </form>

    <h2><b>Most Active</b></h2>
    <form method="POST">
        <select name="candidate_id_active">
            <?php $candidates->data_seek(0); ?>
            <?php while ($row = $candidates->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="vote_active">Vote Most Active</button>
    </form>

    <h2><b>Most Friendly</b></h2>
    <form method="POST">
        <select name="candidate_id_friendly">
            <?php $candidates->data_seek(0); ?>
            <?php while ($row = $candidates->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="vote_friendly">Vote Most Friendly</button>
    </form>

    <h3>Hasil Vote</h3>

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

</body>
</html>
