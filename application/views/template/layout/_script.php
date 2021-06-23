<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ColorBox -->
<script src="<?= base_url() ?>assets/plugins/colorbox/js/jquery.colorbox-min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url() ?>assets/dist/js/main.js"></script>
<script>
    var base_url = "<?= base_url() ?>";
</script>
<?php
foreach ($plugins_path_js as $plugin_js) { ?>
    <script src="<?= base_url() ?>assets/plugins/<?= $plugin_js ?>"></script>
<?php
}
?>
<?php
foreach ($js_path as $js) { ?>
    <script src="<?= base_url() ?>assets/dist/js/<?= $js ?>"></script>
<?php
}
?>