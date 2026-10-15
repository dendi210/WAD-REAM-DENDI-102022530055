<?php
// KONEKSI DATABASE

$host = "localhost";
$user = "root";
$password = "";
$database = "db_kos_penghuni"; 

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// PROSES HAPUS DATA (DELETE)

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_penghuni = (int)$_GET['id'];
    
    $query_delete = "DELETE FROM penghuni WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query_delete);
    mysqli_stmt_bind_param($stmt, "i", $id_penghuni);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit();
}


// INISIALISASI VARIABEL & VALIDASI
$is_edit = false;
$id_edit = "";
$page = isset($_GET['page']) ? $_GET['page'] : 'tabel'; // default tampil tabel

$nama_lengkap = $no_ktp = $pekerjaan = $no_hp = $kontak_darurat = $hubungan_kontak_darurat = "";
$err_nama = $err_ktp = $err_pekerjaan = $err_hp = $err_darurat = $err_hubungan = "";

// CEK MODE EDIT
if ($_SERVER["REQUEST_METHOD"] != "POST" && isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $is_edit = true;
    $page = 'form';
    $id_edit = (int)$_GET['id'];

    $query_select = "SELECT * FROM penghuni WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query_select);
    mysqli_stmt_bind_param($stmt, "i", $id_edit);
    mysqli_stmt_execute($stmt);
    $result_edit = mysqli_stmt_get_result($stmt);

    if ($data = mysqli_fetch_assoc($result_edit)) {
        $nama_lengkap            = $data['nama_lengkap'];
        $no_ktp                  = $data['no_ktp'];
        $pekerjaan               = $data['pekerjaan'];
        $no_hp                   = $data['no_hp'];
        $kontak_darurat          = $data['kontak_darurat'];
        $hubungan_kontak_darurat = $data['hubungan_kontak_darurat'];
    }
    mysqli_stmt_close($stmt);
}


// PROSES SIMPAN / UPDATE (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $page = 'form';

    if (isset($_POST['is_edit']) && $_POST['is_edit'] == "1") {
        $is_edit = true;
        $id_edit = (int)$_POST['id_edit'];
    }

    // Validasi Input
    if (empty($_POST["nama_lengkap"])) { $err_nama = "Nama lengkap wajib diisi"; } else { $nama_lengkap = trim($_POST["nama_lengkap"]); }
    if (empty($_POST["no_ktp"])) { $err_ktp = "Nomor KTP wajib diisi"; } elseif (strlen(trim($_POST["no_ktp"])) != 16) { $err_ktp = "Nomor KTP harus 16 digit"; } else { $no_ktp = trim($_POST["no_ktp"]); }
    if (empty($_POST["pekerjaan"])) { $err_pekerjaan = "Pekerjaan wajib diisi"; } else { $pekerjaan = trim($_POST["pekerjaan"]); }
    if (empty($_POST["no_hp"])) { $err_hp = "Nomor telepon wajib diisi"; } else { $no_hp = trim($_POST["no_hp"]); }
    if (empty($_POST["kontak_darurat"])) { $err_darurat = "Kontak darurat wajib diisi"; } else { $kontak_darurat = trim($_POST["kontak_darurat"]); }
    if (empty($_POST["hubungan_kontak_darurat"])) { $err_hubungan = "Pilih hubungan kontak darurat"; } else { $hubungan_kontak_darurat = $_POST["hubungan_kontak_darurat"]; }

    // Simpan jika validasi lolos
    if (empty($err_nama) && empty($err_ktp) && empty($err_pekerjaan) && empty($err_hp) && empty($err_darurat) && empty($err_hubungan)) {
        if ($is_edit) {
            $sql = "UPDATE penghuni SET nama_lengkap=?, no_ktp=?, pekerjaan=?, no_hp=?, kontak_darurat=?, hubungan_kontak_darurat=? WHERE id=?";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssi", $nama_lengkap, $no_ktp, $pekerjaan, $no_hp, $kontak_darurat, $hubungan_kontak_darurat, $id_edit);
        } else {
            $sql = "INSERT INTO penghuni (nama_lengkap, no_ktp, pekerjaan, no_hp, kontak_darurat, hubungan_kontak_darurat) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "ssssss", $nama_lengkap, $no_ktp, $pekerjaan, $no_hp, $kontak_darurat, $hubungan_kontak_darurat);
        }

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php");
            exit();
        }
    }
}

// QUERY AMBIL DATA UNTUK TABEL
$query_tampil = "SELECT * FROM penghuni ORDER BY id DESC";
$result_tabel = mysqli_query($koneksi, $query_tampil);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengelolaan Kos</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

    <div class="container">
        <h1>Sistem Pengelolaan Data Penghuni Kost</h1>
        <p class="subtitle">Modul Tugas Besar Web Application Development (tubesWad)</p>

        <!-- TAMPILAN 1: TABEL DAFTAR PENGHUNI -->
        <?php if ($page == 'tabel' && !$is_edit): ?>
            <div style="margin-bottom: 20px;">
                <a href="index.php?page=tambah" class="btn btn-add">+ Tambah Penghuni Baru</a>
            </div>

            <h2>Daftar Penghuni Kost</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Penghuni</th>
                            <th>Nomor KTP</th>
                            <th>Pekerjaan</th>
                            <th>No. Telepon</th>
                            <th>Kontak Darurat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($result_tabel) > 0) {
                            while ($row = mysqli_fetch_assoc($result_tabel)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($row['nama_lengkap']); ?></strong></td>
                            <td><code><?= htmlspecialchars($row['no_ktp']); ?></code></td>
                            <td><?= htmlspecialchars($row['pekerjaan']); ?></td>
                            <td><?= htmlspecialchars($row['no_hp']); ?></td>
                            <td>
                                <?= htmlspecialchars($row['kontak_darurat']); ?> <br>
                                <span class="badge"><?= htmlspecialchars($row['hubungan_kontak_darurat']); ?></span>
                            </td>
                            <td>
                                <a href="index.php?action=edit&id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="index.php?action=delete&id=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Belum ada data penghuni.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        <!-- TAMPILAN 2: FORM TAMBAH / EDIT DATA -->
        <?php else: ?>
            <h2><?= $is_edit ? "Edit Data Penghuni" : "Tambah Penghuni Baru"; ?></h2>
            
            <form action="index.php" method="POST">
                <input type="hidden" name="is_edit" value="<?= $is_edit ? "1" : "0"; ?>">
                <input type="hidden" name="id_edit" value="<?= htmlspecialchars($id_edit); ?>">

                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($nama_lengkap); ?>">
                    <span class="error"><?= $err_nama; ?></span>
                </div>

                <div class="form-group">
                    <label for="no_ktp">Nomor KTP (NIK)</label>
                    <input type="text" id="no_ktp" name="no_ktp" maxlength="16" value="<?= htmlspecialchars($no_ktp); ?>">
                    <span class="error"><?= $err_ktp; ?></span>
                </div>

                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan / Status</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" value="<?= htmlspecialchars($pekerjaan); ?>">
                    <span class="error"><?= $err_pekerjaan; ?></span>
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor Telepon / WA</label>
                    <input type="tel" id="no_hp" name="no_hp" value="<?= htmlspecialchars($no_hp); ?>">
                    <span class="error"><?= $err_hp; ?></span>
                </div>

                <div class="form-group">
                    <label for="kontak_darurat">Nomor Kontak Darurat</label>
                    <input type="tel" id="kontak_darurat" name="kontak_darurat" value="<?= htmlspecialchars($kontak_darurat); ?>">
                    <span class="error"><?= $err_darurat; ?></span>
                </div>

                <div class="form-group">
                    <label for="hubungan_kontak_darurat">Hubungan Kontak Darurat</label>
                    <select id="hubungan_kontak_darurat" name="hubungan_kontak_darurat">
                        <option value="" disabled <?= empty($hubungan_kontak_darurat) ? 'selected' : ''; ?>>-- Pilih Hubungan --</option>
                        <option value="Orang Tua" <?= ($hubungan_kontak_darurat == 'Orang Tua') ? 'selected' : ''; ?>>Orang Tua</option>
                        <option value="Saudara" <?= ($hubungan_kontak_darurat == 'Saudara') ? 'selected' : ''; ?>>Saudara</option>
                        <option value="Teman / Kerabat" <?= ($hubungan_kontak_darurat == 'Teman / Kerabat') ? 'selected' : ''; ?>>Teman / Kerabat</option>
                        <option value="Lainnya" <?= ($hubungan_kontak_darurat == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                    </select>
                    <span class="error"><?= $err_hubungan; ?></span>
                </div>

                <div class="form-actions" style="margin-top: 15px;">
                    <button type="submit" class="btn btn-add"><?= $is_edit ? "Update Data" : "Simpan Data"; ?></button>
                    <a href="index.php" class="btn btn-secondary">Batal / Kembali</a>
                </div>
            </form>
        <?php endif; ?>

    </div>

</body>
</html>