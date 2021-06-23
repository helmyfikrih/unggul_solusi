<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <?php $this->load->view("template/layout/_navbar") ?>
        <?php $this->load->view("template/layout/_sidebar") ?>

        <?= $body ?>
        <?php $this->load->view("template/layout/_footer") ?>
        <?php $this->load->view("template/layout/_rightside") ?>
    </div>
    <!-- ./wrapper -->
    <?php $this->load->view("template/layout/_script") ?>
</body>

</html>