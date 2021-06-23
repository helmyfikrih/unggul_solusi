<!-- js section -->
<script src="<?= base_url() ?>assets/frontend/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/frontend/js/bootstrap.min.js"></script>
<!-- menu js -->
<script src="<?= base_url() ?>assets/frontend/js/menumaker.js"></script>
<!-- wow animation -->
<script src="<?= base_url() ?>assets/frontend/js/wow.js"></script>
<!-- custom js -->
<script src="<?= base_url() ?>assets/frontend/js/custom.js"></script>
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
    <script src="<?= base_url() ?>assets/frontend/js/<?= $js ?>"></script>
<?php
}
?>