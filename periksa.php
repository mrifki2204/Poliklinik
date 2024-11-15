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

// Variables for editing
$id_pasien = $id_dokter = $tgl_periksa = $catatan = $obat = "";

// Check if editing is requested
if (isset($_GET['id']) && isset($_GET['aksi']) && $_GET['aksi'] == 'ubah') {
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='$id'");
    $data = mysqli_fetch_array($result);
    if ($data) {
        $id_pasien = $data['id_pasien'];
        $id_dokter = $data['id_dokter'];
        $tgl_periksa = date('Y-m-d\TH:i', strtotime($data['tgl_periksa'])); // Format for datetime-local input
        $catatan = $data['catatan'];
        $obat = $data['obat'];
    }
}
?>

<div class="container mt-4">
    <form class="form row" method="POST" action="">
        <div class="mb-3">
            <label for="id_pasien" class="form-label">Pasien</label>
            <select class="form-control" name="id_pasien" id="id_pasien" required>
                <?php
                $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
                while ($data = mysqli_fetch_array($pasien)) {
                    $selected = ($data['id'] == $id_pasien) ? 'selected="selected"' : '';
                    echo "<option value='".$data['id']."' $selected>".$data['nama']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_dokter" class="form-label">Dokter</label>
            <select class="form-control" name="id_dokter" id="id_dokter" required>
                <?php
                $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");
                while ($data = mysqli_fetch_array($dokter)) {
                    $selected = ($data['id'] == $id_dokter) ? 'selected="selected"' : '';
                    echo "<option value='".$data['id']."' $selected>".$data['nama']."</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tgl_periksa" class="form-label">Tanggal dan Waktu Periksa</label>
            <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" value="<?php echo $tgl_periksa; ?>" required>
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <input type="text" class="form-control" id="catatan" name="catatan" rows="3" required><?php echo $catatan; ?></>
        </div>
        <div class="mb-3">
            <label for="obat" class="form-label">Obat</label>
            <input type="text" class="form-control" id="obat" name="obat" rows="3" required><?php echo $obat; ?></>
        </div>
        <?php if (isset($_GET['id']) && isset($_GET['aksi']) && $_GET['aksi'] == 'ubah') { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn btn-primary" name="update">Update</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
        <?php } ?>
    </form>

    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Periksa</th>
                <th>Catatan</th>
                <th>Obat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($mysqli, "SELECT pr.*, d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON pr.id_dokter = d.id LEFT JOIN pasien p ON pr.id_pasien = p.id ORDER BY pr.tgl_periksa DESC");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_pasien'] ?></td>
                    <td><?php echo $data['nama_dokter'] ?></td>
                    <td><?php echo $data['tgl_periksa'] ?></td>
                    <td><?php echo $data['catatan'] ?></td>
                    <td><?php echo $data['obat'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=ubah">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <?php
    // Save new data
    if (isset($_POST['simpan'])) {
        $id_pasien = $_POST['id_pasien'];
        $id_dokter = $_POST['id_dokter'];
        $tgl_periksa = $_POST['tgl_periksa'];
        $catatan = $_POST['catatan'];
        $obat = $_POST['obat'];

        $tambah = mysqli_query($mysqli, "INSERT INTO periksa (id_pasien, id_dokter, tgl_periksa, catatan, obat) VALUES ('$id_pasien', '$id_dokter', '$tgl_periksa', '$catatan', '$obat')");
        echo "<script>document.location='index.php?page=periksa';</script>";
    }

    // Update existing data
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $id_pasien = $_POST['id_pasien'];
        $id_dokter = $_POST['id_dokter'];
        $tgl_periksa = $_POST['tgl_periksa'];
        $catatan = $_POST['catatan'];
        $obat = $_POST['obat'];

        $update = mysqli_query($mysqli, "UPDATE periksa SET id_pasien='$id_pasien', id_dokter='$id_dokter', tgl_periksa='$tgl_periksa', catatan='$catatan', obat='$obat' WHERE id='$id'");
        echo "<script>document.location='index.php?page=periksa';</script>";
    }

    // Delete data
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
        $id = $_GET['id'];
        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id='$id'");
        echo "<script>document.location='index.php?page=periksa';</script>";
    }
    ?>
</div>


</body>
</html>
