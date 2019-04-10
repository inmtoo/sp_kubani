    <?php require_once('layouts/header.php');?>
    
      <div class="page-content d-flex align-items-stretch"> 
        <!-- Side Navbar -->
        <nav class="side-navbar">
          
         <?php require_once('layouts/sidebar.php');?>
        
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom"><?=$data['page-title']?></h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
               
                <!-- Item -->
                <div class="col-xl-12 col-sm-12">
                  
                  <h2>Добавить новую страницу</h2>
                  
                </div>
                
              </div>
            </div>
          </section>
 
 <?php require_once('layouts/footer.php');?>