<?php
// Start the session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: loginUser.php"); // Redirect to login page if not authenticated
    exit();
}

include_once("koneksi.php");

// CRUD operations for dokter data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokter</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-OPUBBU9d4uEhp75ZB6Zjx1 at these locationsHHnLf0CQgzKE4v7h5I2UIH35WOR/Mnfu5aJvP8bP8T" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <?php
        // Initialize variables for editing
        $nama = $alamat = $no_hp = "";

        // Check if editing mode is triggered
        if (isset($_GET['id']) && isset($_GET['aksi']) && $_GET['aksi'] == 'ubah') {
            $id = $_GET['id'];
            $result = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id='$id'");
            $data = mysqli_fetch_array($result);
            if ($data) {
                $nama = $data['nama'];
                $alamat = $data['alamat'];
                $no_hp = $data['no_hp'];
            }
        }
        ?>

        <form class="row g-3" method="POST" action="">
            <div class="col-12">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?php echo $nama; ?>" required>
            </div>
            <div class="col-12">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" required>
            </div>
            <div class="col-12">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No HP" value="<?php echo $no_hp; ?>" required>
            </div>
            <div class="col-12">
                <?php if (isset($_GET['id']) && isset($_GET['aksi']) && $_GET['aksi'] == 'ubah') { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                <?php } else { ?>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                <?php } ?>
            </div>
        </form>


        <!-- Table for Displaying Data -->
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No HP</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($mysqli, "SELECT * FROM dokter ORDER BY id");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['alamat']; ?></td>
                        <td><?php echo $data['no_hp']; ?></td>
                        <td>
                            <a class="btn btn-success btn-sm rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id']; ?>&aksi=ubah">Ubah</a>
                            <a class="btn btn-danger btn-sm rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id']; ?>&aksi=hapus" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

        <?php
        // Insert new data
        if (isset($_POST['simpan'])) {
            $nama = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $no_hp = $_POST['no_hp'];

            $tambah = mysqli_query($mysqli, "INSERT INTO dokter(nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')");
            echo "<script>document.location='index.php?page=dokter';</script>";
        }

        // Update existing data
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $no_hp = $_POST['no_hp'];

            $update = mysqli_query($mysqli, "UPDATE dokter SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id='$id'");
            echo "<script>document.location='index.php?page=dokter';</script>";
        }

        // Delete data
        if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
            $id = $_GET['id'];
            $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '$id'");
            echo "<script>document.location='index.php?page=dokter';</script>";
        }
        ?>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-OPUBBU9d4uEhp75ZB6Zjx1HHnLf0CQgzKE4v7h5I2UIH35WOR/Mnfu5aJvP8bP8T" crossorigin="anonymous"></script>
</body>
</html>
