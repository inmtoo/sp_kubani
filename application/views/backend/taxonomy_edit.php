
              <div class="row bg-white has-shadow">
                
                <div class="col-xl-12 col-sm-12">
                  
                  <h2>Редактировать</h2>
                  
                  <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" value="<?=$data['taxonomy']['taxonomy']['name']?>" placeholder="Название"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" value="<?=$data['taxonomy']['taxonomy']['title']?>" placeholder="Title"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="h1" class="form-control" value="<?=$data['taxonomy']['taxonomy']['h1']?>" placeholder="H1 заголовок"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="uri" class="form-control" value="<?=$data['taxonomy']['taxonomy']['uri']?>" placeholder="URI"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="keywords" class="form-control" value="<?=$data['taxonomy']['taxonomy']['keywords']?>" placeholder="keywords"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="description" class="form-control" value="<?=$data['taxonomy']['taxonomy']['description']?>" placeholder="description"/>
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="short_text" class="form-control" <?=$data['taxonomy']['taxonomy']['short_text']?> placeholder="Аннотация"><?=$data['taxonomy']['taxonomy']['short_text']?></textarea>
                    </div>
                    <div class="form-group">
                            <textarea placeholder="Картинка SVG" name="svg" class="form-control"><?=$data['taxonomy']['taxonomy']['svg']?></textarea>
                        </div>
                    <div class="form-group">
                        <textarea type="text" name="content" class="form-control" placeholder="Содержание"><?=$data['taxonomy']['taxonomy']['content']?></textarea>
                    </div>
                    
                    <h3>Блок дополнительных полей</h3>
             
                        <?php foreach ($data['extra-block'] as $extrablock) { ?>
                            <?php if($extrablock['method_id'] == 1) {
                                echo '
                                    <div class="form-group">
                                        <input type="text" name="extra['.$extrablock['name'].']" class="form-control" value="'.$extrablock['value'].'" placeholder="'.$extrablock['name'].'" />
                                    </div>
                                ';
                                }
                            ?>
                        <?php } ?>
                    
                    <input type="submit" name="taxedit" class="btn btn-primary"/>
                    
                  </form>
                  
                </div>
                <!-- Item -->
      
                
              </div>
          