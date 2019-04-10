
              <div class="row bg-white has-shadow">
               
                <!-- Item -->
                <div class="col-xl-12 col-sm-12">
                  
                  <h2>Управление содержанием. <small><?=$data['content_type']['name']?>.</small></h2>
                  <p><strong><a href="/manager/add_content/<?=$data['content_type']['id']?>"><i class="fa fa-plus"></i> Добавить запись</strong></a></p>
                
                    <ul class="tree">
                        <?php foreach($data['content'] as $content ) {?>
                            <li data-id = "<?=$content['id']?>"><a href="/manager/contentedit/<?=$content['id']?>/"><?=$content['name']?></a></li>
                        <?php } ?>
                    </ul>
                  
                </div>
                
              </div>
           
