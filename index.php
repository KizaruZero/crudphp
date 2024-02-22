<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'crud';

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {  // cek koneksi ke database
  die('Tidak bisa konek ke database');
}

$nim = ""; // deklarasi variabel nim
$nama = ""; // deklarasi variabel nama
$alamat = ""; // deklarasi variabel alamat
$fakultas = ""; // deklarasi variabel fakultas

$sukses = ""; // deklarasi variabel sukses
$error = ""; // deklarasi variabel error

if (isset($_POST['simpan'])) { // cek jika tombol simpan di klik
  $nim = $_POST['nim']; // ambil data dari form input nim
  $nama = $_POST['nama']; // ambil data dari form input nama
  $alamat = $_POST['alamat']; // ambil data dari form input alamat
  $fakultas = $_POST['fakultas']; // ambil data dari form input fakultas

  if ($nim && $nama && $alamat && $fakultas) { // cek jika semua data sudah diisi
    $sql1 = "insert into mahasiswa (nim, nama, alamat, fakultas) values ('$nim', '$nama', '$alamat', '$fakultas')"; // query untuk insert data ke database
    $result = mysqli_query($koneksi, $sql1); // eksekusi query
    if ($result) { // cek jika eksekusi query sukses
      $sukses = "Data berhasil disimpan"; // tampilkan pesan data berhasil disimpan
    } else {
      $error = "Data gagal disimpan"; // tampilkan pesan data gagal disimpan
    }
  }
} else {
  $error = "Data Tidak Boleh Kosong"; // tampilkan pesan data tidak boleh kosong
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <title>Data Mahasiswa</title>
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg bg-dark navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">INFORMATIKA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
          <a class="nav-link" href="#">Home</a>
          <a class="nav-link" href="#">About Us</a>
          <a class="nav-link" href="#">Assignment</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero" id="hero">
    <div class="container">
      <div class="welcome text-center blur-bg">
        <h1>SELAMAT DATANG DI TEKNIK INFORMATIKA "A"</h1>
      </div>
    </div>
  </section>

  <section class="mahasiswa" id="mahasiswa">
    <div class="container">
      <div class="judul text-center mt-2">
        <h1>
          DATA MAHASISWA
        </h1>
      </div>

      <!-- Input Data -->
      <div class="card mt-2">
        <div class="card-header bg-dark text-white">
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
          }
          ?>

          <?php
          if ($sukses) {
            ?>
            <div class="alert alert-success" role="alert">
              <?php echo $sukses ?>
            </div>
            <?php
          }
          ?>
          <form action="" method="POST">
            <div class="mb-1 row">
              <label for="nim" class="col-sm-2 col-form-label">Nim</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nim" id="nim" value="<?php echo $nim ?>">
              </div>
            </div>
            <div class="mb-1 row">
              <label for="nama" class="col-sm-2 col-form-label">Nama</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
              </div>
            </div>
            <div class="mb-1 row">
              <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama" name="alamat" value="<?php echo $alamat ?>">
              </div>
            </div>
            <div class="mb-1 row">
              <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
              <div class="col-sm-10">
                <select class="form-control" id="fakultas" name="fakultas">
                  <option value="">
                    -- Pilih Fakultas --
                  </option>
                  <option value="VOKASI" <?php if ($fakultas == "VOKASI")
                    echo "selected" ?>>
                      Fakultas Vokasi
                    </option>
                    <option value="teknik" <?php if ($fakultas == "teknik")
                    echo "selected" ?>>
                      Fakultas Teknik
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-12">
                <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
              </div>
            </form>
          </div>
        </div>

        <!-- Output Data -->
        <div class="card mt-2">
          <div class="card-header bg-dark text-white">
            Data Mahasiswa
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr class="text-center">
                  <th scope="col">#</th>
                  <th scope="col">Nim</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Fakultas</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sql2 = "SELECT * FROM mahasiswa ORDER BY id DESC";
                  $result = mysqli_query($koneksi, $sql2);
                  $nomor = 1;
                  while ($data = mysqli_fetch_array($result)) {
                    $id = $data['id'];
                    $nim = $data['nim'];
                    $nama = $data['nama'];
                    $alamat = $data['alamat'];
                    $fakultas = $data['fakultas'];
                    ?>
                <tr class="text-center">
                  <th scope="row">
                    <?php echo $nomor++ ?>
                  </th>
                  <td>
                    <?php echo $nim ?>
                  </td>
                  <td>
                    <?php echo $nama ?>
                  </td>
                  <td>
                    <?php echo $alamat ?>
                  </td>
                  <td>
                    <?php echo $fakultas ?>
                  </td>
                  <td scope="row">
                    <a href="index.php?op=edit&id=<?php echo $id ?>"> <button type="button"
                        class="btn btn-warning">Edit</button></a>

                    <button type="button" class="btn btn-danger">Delete</button>
                  </td>
                </tr>
                <?php
                  }
                  ?>
            </tbody>
          </table>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>