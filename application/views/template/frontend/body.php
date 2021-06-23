 <body id="default_theme" class="it_shop_detail">
     <!-- loader -->
     <div class="bg_load">
         <img class="loader_animation" src="<?= base_url() ?>assets/frontend/images/loaders/loader_1.png" alt="#" />
     </div>
     <!-- end loader -->
     <!-- header -->
     <header id="default_header" class="header_style_1">
         <?php $this->load->view('template/frontend/_header_top.php') ?>
         <!-- header bottom -->
         <div class="header_bottom">
             <div class="container">
                 <div class="row">
                     <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                         <!-- logo start -->
                         <div class="logo">
                             <a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/frontend/images/logos/it_logo.png" alt="logo" /></a>
                         </div>
                         <!-- logo end -->
                     </div>
                     <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                         <?php $this->load->view('template/frontend/_navbar.php') ?>
                     </div>
                 </div>
             </div>
         </div>
         <!-- header bottom end -->
     </header>
     <!-- end header -->
     <?= $body ?>
     <!-- footer -->
     <?php $this->load->view('template/frontend/_footer.php') ?>
     <!-- end footer -->
     <?php $this->load->view('template/frontend/_script.php') ?>
 </body>

 </html>