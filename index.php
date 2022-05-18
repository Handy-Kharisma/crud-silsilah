<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "silsilah";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) { // cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
/*
else{
    echo "Koneksi berhasil";
}
*/
error_reporting(0);

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'hapus') { // Hapus Data
    $id         = $_GET['id'];
    $sql1       = "delete from keluarga where id = '$id' ";
    $q1         = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "Berhasil menghapus data";
    } else {
        $error      = "Gagal menghapus data";
    }
}

if ($op == 'edit') { // Edit Data
    $id             = $_GET['id'];
    $sql1           = "select * from keluarga where id = '$id' ";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $nama           = $r1['nama'];
    $jenis_kelamin  = $r1['jenis_kelamin'];
    $orang_tua      = $r1['orang_tua'];
    $generasi       = $r1['generasi'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { // untuk create
    $nama           = $_POST['nama'];
    $jenis_kelamin  = $_POST['jenis_kelamin'];
    $orang_tua      = $_POST['orang_tua'];
    $generasi       = $_POST['generasi'];

    if ($nama && $jenis_kelamin && $orang_tua && $generasi) {
        if ($op == 'edit') { // untuk update
            $sql1   = "update keluarga set nama = '$nama', jenis_kelamin = '$jenis_kelamin', orang_tua = '$orang_tua', generasi = '$generasi' where id = '$id' ";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memperbarui data";
            } else {
                $error      = "Gagal memperbarui data";
            }
        } else { // untuk insert
            $sql1   = "insert into keluarga(nama,jenis_kelamin,orang_tua,generasi) values ('$nama','$jenis_kelamin','$orang_tua','$generasi')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukan data baru";
            } else {
                $error      = "Gagal memasukan data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 1000px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <br>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:0.5;url=index.php"); // 0.5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:0.5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row"> <!-- Nama -->
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row"> <!-- Jenis Kelamin -->
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">- Pilih Jenis Kelamin -</option>
                                <option value="Laki-laki" <?php if ($jenis_kelamin == "Laki-laki") echo "selected" ?>>Laki-laki</option>
                                <option value="Perempuan" <?php if ($jenis_kelamin == "Perempuan") echo "selected" ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row"> <!-- Orang Tua -->
                        <label for="orang_tua" class="col-sm-2 col-form-label">Orang Tua</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="orang_tua" name="orang_tua" value="<?php echo $orang_tua ?>">
                        </div>
                    </div>
                    <div class="mb-3 row"> <!-- Generasi -->
                        <label for="generasi" class="col-sm-2 col-form-label">Generasi</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="generasi" name="generasi">
                                <option value="">- Pilih Generasi -</option>
                                <option value="1" <?php if ($jenis_kelamin == "1") echo "selected" ?>>1</option>
                                <option value="2" <?php if ($jenis_kelamin == "2") echo "selected" ?>>2</option>
                                <option value="3" <?php if ($jenis_kelamin == "3") echo "selected" ?>>3</option>
                                <option value="4" <?php if ($jenis_kelamin == "4") echo "selected" ?>>4</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <br>
        <br>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Keluarga
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr> <!-- Header Field -->
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Orang Tua</th>
                            <th scope="col">Generasi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from keluarga order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id              = $r2['id'];
                            $nama            = $r2['nama'];
                            $jenis_kelamin   = $r2['jenis_kelamin'];
                            $orang_tua       = $r2['orang_tua'];
                            $generasi        = $r2['generasi'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $jenis_kelamin ?></td>
                                <td scope="row"><?php echo $orang_tua ?></td>
                                <td scope="row"><?php echo $generasi ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>">
                                        <button type="button" class="btn btn-warning">Edit</button>
                                    </a>
                                    <a href="index.php?op=hapus&id=<?php echo $id ?>" onclick="return confirm('Yakin ingin menghapus data?')">
                                        <button type="button" class="btn btn-danger">Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>