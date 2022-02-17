<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$id = $nisn = $nama = $kelas = $jurusan = $urutan = $tmp_lahir = $tgl_lahir = $hobi = "";
$nisn_err = $nama_err = $kelas_err = $jurusan_err = $urutan_err = $tmp_lahir_err = $tgl_lahir_err = $hobi_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate nisn
    $input_nisn = trim($_POST["nisn"]);
    if(empty($input_nisn)){
        $nisn_err = "Please enter nisn.";
    } else{
        $nisn = $input_nisn;
    }
    
    // Validate nama
    $input_nama = trim($_POST["nama"]);
    if(empty($input_nama)){
        $nama_err = "Please enter a nama.";
    } else{
        $nama = $input_nama;
    }

    // Validate kelas
    $input_kelas = trim($_POST["kelas"]);
    if(empty($input_kelas)){
        $kelas_err = "Please enter kelas.";
    } else{
        $kelas = $input_kelas;
    }

    // Validate jurusan
    $input_jurusan = trim($_POST["jurusan"]);
    if(empty($input_jurusan)){
        $jurusan_err = "Please enter Jurusan.";
    } else{
        $jurusan = $input_jurusan;
    }
    
    // Validate urutan
    $input_urutan = trim($_POST["urutan"]);
    if(empty($input_urutan)){
        $urutan_err = "Please enter a urutan.";
    } else{
        $urutan = $input_urutan;
    }

    // Validate tempat lahir
    $input_tmp_lahir = trim($_POST["tmp_lahir"]);
    if(empty($input_tmp_lahir)){
        $tmp_lahir_err = "Please enter an Tempat Lahir.";
    } else{
        $tmp_lahir = $input_tmp_lahir;
    }

    // Validate tanggal lahir
    $input_tgl_lahir = trim($_POST["tgl_lahir"]);
    if(empty($input_tgl_lahir)){
        $tgl_lahir_err = "Please enter an Tanggal Lahir.";
    } else{
        $tgl_lahir = $input_tgl_lahir;
    }

    // Validate hobi
    $input_hobi = trim($_POST["hobi"]);
    if(empty($input_hobi)){
        $hobi_err = "Please enter a hobi.";
    } else{
        $hobi = $input_hobi;
    }

    // Check input errors before inserting in database
    if (empty($nisn_err) && empty($nama_err) && empty($kelas_err) && empty($jurusan_err) && empty($urutan_err) && empty($tmp_lahir_err) && empty($tgl_lahir_err) && empty($hobi_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO siswa (nisn, nama, kelas, jurusan, urutan, tmp_lahir, tgl_lahir, hobi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters s=3
            mysqli_stmt_bind_param($stmt, "isssssss", $param_nisn, $param_nama, $param_kelas, $param_jurusan, $param_urutan, $param_tmp_lahir, $param_tgl_lahir, $param_hobi);

            // Set parameters
            $param_nisn = $nisn;
            $param_nama = $nama;
            $param_kelas = $kelas;
            $param_jurusan = $jurusan;
            $param_urutan = $urutan;
            $param_tmp_lahir = $tmp_lahir;
            $param_tgl_lahir = $tgl_lahir;
            $param_hobi = $hobi;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Tambah Record</h2>
                    </div>
                    <p>Silahkan isi form di bawah ini kemudian submit untuk menambahkan data siswa ke dalam database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nisn_err)) ? 'has-error' : ''; ?>">
                            <label>NISN</label>
                            <input type="text" name="nisn" class="form-control" value="<?php echo $nisn; ?>">
                            <span class="help-block"><?php echo $nisn_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                            <span class="help-block"><?php echo $nama_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($kelas_err)) ? 'has-error' : ''; ?>">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="<?php echo $kelas; ?>">
                            <span class="help-block"><?php echo $kelas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($jurusan_err)) ? 'has-error' : ''; ?>">
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="<?php echo $jurusan; ?>">
                            <span class="help-block"><?php echo $jurusan_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($urutan_err)) ? 'has-error' : ''; ?>">
                            <label>Urutan</label>
                            <input type="text" name="urutan" class="form-control" value="<?php echo $urutan; ?>">
                            <span class="help-block"><?php echo $urutan_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tmp_lahir_err)) ? 'has-error' : ''; ?>">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tmp_lahir" class="form-control" value="<?php echo $tmp_lahir; ?>">
                            <span class="help-block"><?php echo $tmp_lahir_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tgl_lahir_err)) ? 'has-error' : ''; ?>">
                            <label>Tanggal Lahir</label>
                            <input type="text" name="tgl_lahir" class="form-control" value="<?php echo $tgl_lahir; ?>">
                            <span class="help-block"><?php echo $tgl_lahir_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($hobi_err)) ? 'has-error' : ''; ?>">
                            <label>Hobi</label>
                            <input type="text" name="hobi" class="form-control" value="<?php echo $hobi; ?>">
                            <span class="help-block"><?php echo $hobi_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>