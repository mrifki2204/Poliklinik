<?php
include_once("koneksi.php");

$message = "";
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $result = $mysqli->query("SELECT * FROM user WHERE username='$username'");
    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Username sudah ada! buat username yang lain</div>";
    } elseif ($password !== $confirm_password) {
        $message = "<div class='alert alert-danger'>Password tidak sama </div>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $mysqli->query("INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')");
        $message = "<div class='alert alert-success'>Registrasi berhasil <a href='loginUser.php'>Silahkan login</a>.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi User</title>
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
            <li class="nav-item">
              <a class="nav-link" href="registrasiUser.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="loginUser.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Registration Form -->
    <div class="container mt-5">
        <h2 class="text-center">Registrasi User</h2>
        <?php echo $message; ?>
        <form method="POST" action="" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="register">Register</button>
        </form>
        <p class="mt-3"><a href="loginUser.php">Sudah punya akun? Login di sini.</a></p>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
