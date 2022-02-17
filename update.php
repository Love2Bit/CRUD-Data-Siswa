<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$id = $nisn = $nama = $kelas = $jurusan = $urutan = $tmp_lahir = $tgl_lahir = $hobi = "";
$id_err = $nisn_err = $nama_err = $kelas_err = $jurusan_err = $urutan_err = $tmp_lahir_err = $tgl_lahir_err = $hobi_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
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
        // Prepare an update statement
        $sql = "UPDATE siswa SET nisn=?, nama=?, kelas=?, jurusan=?, urutan=?, tmp_lahir=?, tgl_lahir=?, hobi=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssssssi", $param_nisn, $param_nama, $param_kelas, $param_jurusan, $param_urutan, $param_tmp_lahir, $param_tgl_lahir, $param_hobi, $param_id);

            // Set parameters
            $param_id = $id;
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM siswa WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $id = $row["id"];
                    $nisn = $row["nisn"];
                    $nama = $row["nama"];
                    $kelas = $row["kelas"];
                    $jurusan = $row["jurusan"];
                    $urutan = $row["urutan"];
                    $tmp_lahir = $row["tmp_lahir"];
                    $tgl_lahir = $row["tgl_lahir"];
                    $hobi = $row["hobi"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the record siswa.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" name="nisn" class="form-control <?php echo (!empty($nisn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nisn; ?>">
                            <span class="invalid-feedback"><?php echo $nisn_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control <?php echo (!empty($nama_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nama; ?>">
                            <span class="invalid-feedback"><?php echo $nama_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control <?php echo (!empty($kelas_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $kelas; ?>">
                            <span class="invalid-feedback"><?php echo $kelas_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" class="form-control <?php echo (!empty($jurusan_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jurusan; ?>">
                            <span class="invalid-feedback"><?php echo $jurusan_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="text" name="urutan" class="form-control <?php echo (!empty($urutan_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $urutan; ?>">
                            <span class="invalid-feedback"><?php echo $urutan_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tmp_lahir" class="form-control <?php echo (!empty($tmp_lahir_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tmp_lahir; ?>">
                            <span class="invalid-feedback"><?php echo $tmp_lahir_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="text" name="tgl_lahir" class="form-control <?php echo (!empty($tgl_lahir_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tgl_lahir; ?>">
                            <span class="invalid-feedback"><?php echo $tgl_lahir_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Hobi</label>
                            <input type="text" name="hobi" class="form-control <?php echo (!empty($hobi_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $hobi; ?>">
                            <span class="invalid-feedback"><?php echo $hobi_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>