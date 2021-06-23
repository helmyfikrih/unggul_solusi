<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= isset($setting->system_settings_app_name) ? $setting->system_settings_app_name : "Test Unggul Solusi" ?> | <?= $header_title ?></title>
    <link id="logo_icon" rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/dist/img/<?= isset($setting->system_settings_app_logo_header) ? $setting->system_settings_app_logo_header : "" ?>?x=<?= time() ?>" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- ColorBox -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/colorbox/css/colorbox.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
    <?php
    foreach ($plugins_path_css as $plugin_css) { ?>
        <link href="<?= base_url() ?>assets/plugins/<?= $plugin_css ?>" rel="stylesheet">
    <?php
    }
    ?>
    <?php
    foreach ($css_path as $css) { ?>
        <link href="<?= base_url() ?>assets/dist/css/<?= $css ?>" rel="stylesheet">
    <?php
    }
    ?>
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/main.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
