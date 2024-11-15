<?php
include_once("koneksi.php");

session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $mysqli->query("SELECT * FROM user WHERE username='$username'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Password salah.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Username tidak ditemukan.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sistem Informasi Poliklinik</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo $page == 'home' ? 'active' : ''; ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($page, ['dokter', 'pasien']) ? 'active' : ''; ?>" href="#" id="dataMasterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Data Master
          </a>
          <ul class="dropdown-menu" aria-labelledby="dataMasterDropdown">
            <li><a class="dropdown-item <?php echo $page == 'dokter' ? 'active' : ''; ?>" href="index.php?page=dokter">Dokter</a></li>
            <li><a class="dropdown-item <?php echo $page == 'pasien' ? 'active' : ''; ?>" href="index.php?page=pasien">Pasien</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $page == 'periksa' ? 'active' : ''; ?>" href="index.php?page=periksa">Periksa</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user_id'])) { ?>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="registrasiUser.php">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="loginUser.php">Login</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>


    <!-- Login Form -->
    <div class="container mt-5">
        <h2 class="text-center">Login User</h2>
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
            <button type="submit" class="btn btn-primary" name="login">Login</button>
        </form>
        <p class="mt-3"><a href="registrasiUser.php">Belum punya akun? Register di sini.</a></p>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
