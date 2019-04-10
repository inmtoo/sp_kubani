
              <div class="row bg-white has-shadow">
                
                <div class="col-xl-6 col-sm-6">
                  
                  <h2>Добавить таксономию</h2>
                  
                  <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Название"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Title"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="h1" class="form-control" placeholder="H1 заголовок"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="uri" class="form-control" placeholder="URI"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="keywords" class="form-control" placeholder="keywords"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="description" class="form-control" placeholder="description"/>
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="short_text" class="form-control" placeholder="Аннотация"></textarea>
                    </div>
                    <div class="form-group">
                            <textarea placeholder="Картинка SVG" name="svg" class="form-control"></textarea>
                        </div>
                    <div class="form-group">
                        <textarea type="text" name="content" class="form-control" placeholder="Содержание"></textarea>
                    </div>
                    
                    <h3>Блок дополнительных полей</h3>
             
                        <?php foreach ($data['extra-block'] as $extrablock) { ?>
                            <?php if($extrablock['method_id'] == 1) {
                                echo '
                                    <div class="form-group">
                                        <input type="text" name="extra['.$extrablock['name'].']" class="form-control" placeholder="'.$extrablock['name'].'"/>
                                    </div>
                                ';
                                }
                            ?>
                        <?php } ?>
                        
                        
                        
                        <div class="pricelist">
                            <h3>Связь с прайс-листом</h3>
                            <div style="max-height:400px; overflow-y:scroll;">
                            <?php foreach ($data['pricelist'] as $price) { ?>
                                <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pricelist[]" value="<?=$price['id']?>" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            <?=$price['name']?>
                                        </label>
                                    </div>
                            <?php } ?>
                            </div>
                        </div>
                    
                    <input type="submit" name="taxadd" class="btn btn-primary"/>
                    
                  </form>
                  
                </div>
                <!-- Item -->
                <div class="col-xl-6 col-sm-6">
                  
                  <h2>Список таксономий</h2>
                  
                  <ul class="content-list">

                            <?php foreach($data['tax_list'] as $taxonomy) { ?>
                                <li><a href="/manager/taxonomy/<?=$taxonomy['id']?>"><?=$taxonomy['name']?></a></li>
                            <?php } ?>
                      
                  </ul>
                  
                </div>
                
              </div>
          