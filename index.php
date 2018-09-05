<?php 
ob_start();
include "config/settings.php";
?>
<!DOCTYPE html>
<html lang="en-us">
<head>

    <?php include "template/title.php" ?>
    <?php include "template/meta.php" ?>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/css/main.min.css">
</head>
<body class="o-page">
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->

<div class="o-page__sidebar js-page-sidebar">
    <div class="c-sidebar">
        <a class="c-sidebar__brand" href="./">
            <img class="c-sidebar__brand-img" src="assets/img/logo.png" alt="Logo"> <?= $settings['title']; ?>
        </a>

        <ul class="c-sidebar__list">

            <?php include "template/nav.php" ?>           
        </ul>

    </div><!-- // .c-sidebar -->
</div><!-- // .o-page__sidebar -->

<main class="o-page__content">
    <header class="c-navbar u-mb-medium">
        <button class="c-sidebar-toggle u-mr-small">
            <span class="c-sidebar-toggle__bar"></span>
            <span class="c-sidebar-toggle__bar"></span>
            <span class="c-sidebar-toggle__bar"></span>
        </button><!-- // .c-sidebar-toggle -->

        <h2 class="c-navbar__title u-mr-auto"><?= $title ?></h2>

        <div class="c-dropdown dropdown">
            <?php include "template/notification.php"; ?>
        </div>

        <?php if (!empty($_SESSION['masuk'])): ?>
            <?php include "template/user.php"; ?>
        <?php endif ?>
    </header>

    <div class="container-fluid">                   

        <div class="row">
         <?php include "template/nav.process.php" ?>
     </div><!-- // .row -->

 </div><!-- // .container -->

</main><!-- // .o-page__content -->

<script src="assets/js/main.min.js"></script>
<script type="text/javascript" src="assets/js/dataTables.checkboxes.min.js"></script>
<script src="assets/js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<?php  
if (!empty($_SESSION['execute'])) {
    echo $_SESSION['execute'];
    unset($_SESSION['execute']);
}
ob_end_flush();
?>
</body>
</html>