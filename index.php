<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "db_stok_toko";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$kode        = "";
$nama       = "";
$jumlah     = "";
$kategori   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $kode         = $_GET['kode'];
    $sql1       = "delete from stok_barang where kode = '$kode'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $kode         = $_GET['kode'];
    $sql1       = "select * from stok_barang where kode = '$kode'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $kode        = $r1['kode'];
    $nama       = $r1['nama'];
    $jumlah     = $r1['jumlah'];
    $kategori   = $r1['kategori'];

    if ($kode == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $kode        = $_POST['kode'];
    $nama       = $_POST['nama'];
    $jumlah     = $_POST['jumlah'];
    $kategori   = $_POST['kategori'];

    if ($kode && $nama && $jumlah && $kategori) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update stok_barang set kode = '$kode',nama='$nama',jumlah = '$jumlah',kategori='$kategori' where kode = '$kode'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into stok_barang(kode,nama,jumlah,kategori) values ('$kode','$nama','$jumlah','$kategori')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Barang Mario Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
        body {
            background-image : url(y-so-serious-white.png)
        }
    </style>
</head>

<body>


    <br>
    <h4 color : white><center>STOK BARANG MARIO STORE</center></h4>
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
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" kode="kode" name="kode" value="<?php echo $kode ?>" placeholder = "A-000">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" kode="nama" name="nama" value="<?php echo $nama ?>" placeholder = "Cantumkan Nama Barang">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Stok </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" kode="jumlah" name="jumlah" value="<?php echo $jumlah ?>" placeholder = "Jumlah Dalam Satuan">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kategori" class="col-sm-2 col-form-label">Kategori Barang</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="kategori" kode="kategori">
                                <option value="">- Pilih Kategori -</option>
                                <option value="Snack" <?php if ($kategori == "Snack") echo "selected" ?>>Snack</option>
                                <option value="Minuman" <?php if ($kategori == "Minuman") echo "selected" ?>>Minuman</option>
                                <option value="Bahan Pokok" <?php if ($kategori == "Bahan Pokok") echo "selected" ?>>Bahan Pokok</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Stok Barang 
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from stok_barang order by kode desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $kode         = $r2['kode'];
                            $kode        = $r2['kode'];
                            $nama       = $r2['nama'];
                            $jumlah     = $r2['jumlah'];
                            $kategori   = $r2['kategori'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $kode ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $jumlah ?></td>
                                <td scope="row"><?php echo $kategori ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&kode=<?php echo $kode ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&kode=<?php echo $kode?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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
</div>
</html>
