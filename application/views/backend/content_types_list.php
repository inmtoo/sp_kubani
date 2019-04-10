

            
              <div class="row bg-white has-shadow">
               
                <!-- Item -->
                <div class="col-xl-6 col-sm-12">
                  
                  <h2>Новый тип содержания</h2>
                  <form action="" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Тип содержания" name="type"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="uri" name="uri"/>
                    </div>
                    <h3>Список таксономий</h3>
                    <?php foreach($data['taxonomies_ids'] as $taxtype) {?>
                        <div class="i-checks">
                              <input id="extra_id_s" value="<?=$taxtype['id']?>" name="taxonomies_ids[]" class="checkbox-template" type="checkbox">
                            <label for="extra_id_s"><?=$taxtype['name']?> </label>
                        </div>
                    <?php } ?>
                    <h3>Список дополнительных полей</h3>
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
                    
                    <input type="submit" name="add_content_type" value="Добавить" class="btn btn-primary" />
                    
                  </form>
                </div>
                
                 <div class="col-xl-6 col-sm-12">
                  
                  <h2>Список типов таксономий</h2>
                        <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Тип таксономии</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php foreach ( $data['content_types'] as $contenttype ) {?>
                            <tr>
                              <th scope="row"><?=$contenttype['id']?></th>
                              <td><a href="/manager/content_type/<?=$contenttype['id']?>/"><?=$contenttype['name']?></a></td>
                            </tr>
                        <?php } ?>
                          </tbody>
                        </table>
                </div>
                
              </div>
              

              