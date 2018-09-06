<?php  
if (file_exists('../config/mysql.php')) {
include "../config/mysql.php";
if ($mysql->connect_error) {
unlink('../config/mysql.php');
echo "Pengaturan Database Salah Silahkan Refresh Halaman ini untuk mengatur ulang";
exit;
}else{		
echo "<div class='c-alert c-alert--info u-mt-medium'>Aplikasi Sudah Di Install, Jika Salah Pengaturan silahkan Hapus file config/mysql.php</div>";
exit;
} 
}
?>
<!doctype html>
<html lang="en-us">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Install IG Tools</title>
<meta name="description" content="Dashboard UI Kit">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600" rel="stylesheet">

<!-- Stylesheet -->
<link rel="stylesheet" href="../assets/css/main.min.css">
</head>
<body class="o-page o-page--center">
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->

<div class="o-page__card">
<div class="c-card u-mb-xsmall">
<header class="c-card__header u-pt-large">
<a class="c-card__icon" href="#!">
<img src="../assets/img/logo.png" alt="Dashboard UI Kit">
</a>
<h1 class="u-h3 u-text-center u-mb-zero">Install IG Tools</h1>
</header>

<form class="c-card__body" method="POST">
<div class="c-field u-mb-small">
<label class="c-field__label">HOST</label> 
<input name="host" class="c-input" type="text" placeholder="localhost" value="localhost"> 
</div>

<div class="c-field u-mb-small">
<label class="c-field__label">Username</label> 
<input name="username" class="c-input" type="text" placeholder="Username" value=""> 
</div>

<div class="c-field u-mb-small">
<label class="c-field__label">Password</label> 
<input name="password" class="c-input" type="password" placeholder="Password" value=""> 
</div>

<div class="c-field u-mb-small">
<label class="c-field__label">Database</label> 
<input name="database" class="c-input" type="text" placeholder="Database"> 
</div>

<button name="input" class="c-btn c-btn--info c-btn--fullwidth" type="submit">Install</button>

<?php  
if (isset($_POST['input'])) {
file_put_contents('../config/mysql.php', 
'<?php  
@$mysql = new mysqli(\''.$_POST['host'].'\',\''.$_POST['username'].'\',\''.$_POST['password'].'\',\''.$_POST['database'].'\');
?>'
);
header("location: install.php");
}
?>

</form>
</div>

</div>

<script src="../assets/js/main.min.js"></script>
</body>
</html>