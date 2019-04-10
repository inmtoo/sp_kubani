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
                <div class="col-xl-6 col-sm-12">
                  
                  <h2>Новый тип таксономии</h2>
                  <form action="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="type"/>
                    </div>
                    <?php foreach($data['extra-fields'] as $extra) {?>
                        <div class="i-checks">
                              <input id="extra_id_s" value="<?=$extra['extra_id']?>" name="extra_id_s[]" class="checkbox-template" type="checkbox">
                            <label for="extra_id_s"><?=$extra['extra_name']?> (<?=$extra['method_name']?>)</label>
                        </div>
                    <?php } ?>
                    
                    <div class="i-checks">
                              <input id="hierarchical" value="" class="checkbox-template" name="hierarchical" type="checkbox">
                              <label for="hierarchical">Иерархический</label>
                    </div>
                    
                    <input type="submit" value="Добавить" class="btn btn-primary" />
                    
                  </form>
                </div>
                
                 <div class="col-xl-6 col-sm-12">
                  
                  <h2>Список типов полей</h2>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Тип название</th>
                              <th>Способ ввода</th>
                              <th>Значения</th>
                              <th>Описание</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><a href="">1</a></td>
                              <td><a href="">Template</a></td>
                              <td><a href="">text</a></td>
                              <td><a href=""></a></td>
                              <td><a href=""></a></td>
                            </tr>
                             <tr>
                              <td><a href="">1</a></td>
                              <td><a href="">Template</a></td>
                              <td><a href="">text</a></td>
                              <td><a href=""></a></td>
                              <td><a href=""></a></td>
                            </tr>
                          </tbody>
                        </table>
                </div>
                
              </div>
            </div>
          </section>
 
 <?php require_once('layouts/footer.php');?>