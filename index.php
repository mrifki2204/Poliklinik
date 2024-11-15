<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Poliklinik</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sistem Informasi Poliklinik</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
         Data Master
        </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
            <li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=periksa">Periksa</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user_id'])) { ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php } else { ?>
          <li class="nav-item"><a class="nav-link" href="registrasiUser.php">Register</a></li>
          <li class="nav-item"><a class="nav-link" href="loginUser.php">Login</a></li>
        <?php } ?>
      </ul>
      
    </div>
  </div>
</nav>

<!-- Main Content -->
<main role="main" class="container mt-4">
    <?php
    // Display the requested page or a default welcome message
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        echo "<h2 class='mb-4'>" . ucwords($page) . "</h2>";
        
        // Sanitize the page input and check if the file exists
        $file = basename($page) . ".php";
        if (file_exists($file)) {
            include($file);
        } else {
            echo "<p class='alert alert-danger'>Halaman tidak ditemukan!</p>";
        }
    } else {
        echo "<h2>Selamat Datang di Sistem Informasi Poliklinik</h2>";
        echo "<p class='lead'>Silakan pilih opsi di menu navigasi untuk mengelola data dokter, pasien, dan pemeriksaan.</p>";
    }
    ?>
</main>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
