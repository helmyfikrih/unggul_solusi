<!DOCTYPE html>
<html lang="en">

<head>
  <!-- basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- mobile metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="viewport" content="initial-scale=1, maximum-scale=1" />
  <!-- site metas -->
  <title>It.Next - IT Service Responsive Html Theme</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <!-- site icons -->
  <link rel="icon" href="<?= base_url() ?>assets/frontend/images/fevicon/fevicon.png" type="image/gif" />
  <!-- bootstrap css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/bootstrap.min.css" />
  <!-- Site css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/style.css" />
  <!-- responsive css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/responsive.css" />
  <!-- colors css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/colors1.css" />
  <!-- custom css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/custom.css" />
  <!-- wow Animation css -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/frontend/css/animate.css" />

  <?php
  foreach ($plugins_path_css as $plugin_css) { ?>
    <link href="<?= base_url() ?>assets/plugins/<?= $plugin_css ?>" rel="stylesheet">
  <?php
  }
  ?>
  <?php
  foreach ($css_path as $css) { ?>
    <link href="<?= base_url() ?>assets/frontend/css/<?= $css ?>" rel="stylesheet">
  <?php
  }
  ?>
  <!-- end zoom effect -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>