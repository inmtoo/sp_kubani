
              <div class="row bg-white has-shadow">
               
                <!-- Item -->
                <div class="col-xl-6 col-sm-12">
                  
                  <h2>Новый тип таксономии</h2>
                  <form action="" method = "post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder = 'Тип таксономии' name="type"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="uri" name="uri"/>
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
                    
                    <input type="submit" value="Добавить" name="add_tax_type" class="btn btn-primary" />
                    
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
                          <?php foreach( $data['taxonomy-types'] as $type ) { ?>
                            <tr>
                              <th scope="row"><?=$type['id']?></th>
                              <td><a href="/manager/taxonomy_type/<?=$type['id']?>"><?=$type['name']?></a></td>
                            </tr>
                            <tr>
                        <?php } ?>
                          </tbody>
                        </table>
                </div>
                
              </div>
           