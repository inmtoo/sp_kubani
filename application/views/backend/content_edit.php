
              <div class="row bg-white has-shadow">
               
                <!-- Item -->
                <div class="col-xl-12 col-sm-12">
                  
                  <h2>Добавление содержания. <small><?=$data['content_type']['name']?>.</small></h2>
                 
                 <form action="" method="post" class="margin-bottom-40">
                 <div class="row margin-bottom-30">
                    <div class="col-xl-8 col-sm-12">
                        <div class="form-group">
                            <input type="text" placeholder="Название" name="name" value="<?=$data['content']['content']['name']?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="uri" name="uri" value="<?=$data['content']['content']['uri']?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="TITLE" name="title" value="<?=$data['content']['content']['title']?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="H1" name="h1" value="<?=$data['content']['content']['h1']?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Ключевые слова" name="keywords" value="<?=$data['content']['content']['keywords']?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Описание (meta-description)" name="description" value="<?=$data['content']['content']['description']?>" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Аннотация" name="short_text" class="form-control"><?=$data['content']['content']['short_text']?></textarea>
                        </div>
                         <div class="form-group">
                            <textarea placeholder="Картинка SVG" name="svg" class="form-control"><?=$data['content']['content']['svg']?></textarea>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Содержание" id="editor" name="content" class="form-control"><?=$data['content']['content']['content']?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Опубликовать?</label>
                            <select class="form-control" name="published">
                                <option value="1">Да</option>
                                <option value="0">Нет</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="preview">Картинка анонса</label>
                            <input type="file" class="form-control-file" id="preview"/>
                        </div>
                        
                        <h3>Блок дополнительных полей</h3>
             
                        <?php foreach ($data['extra-block'] as $extrablock) { ?>
                            <?php if($extrablock['method_id'] == 1) {
                                echo '
                                    <div class="form-group">
                                        <input type="text" name="extra['.$extrablock['name'].']" class="form-control" value="'.$extrablock['value'].'" placeholder="'.$extrablock['name'].'"/>
                                    </div>
                                ';
                                }
                            ?>
                        <?php } ?>
                        
                    </div>
                    <div class="col-xl-4 col-sm-12">
                        <?php for ($j = 0; $j < count($data['tax-block']); $j++ ) {?>
                            <div class="taxt-block margin-bottom-20">
                                <h4><?=$data['tax-block'][$j]['type']['name']?></h4>
                                <?php for( $i=0; $i <count($data['tax-block'][$j]['list']); $i++ ) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="taxonomies[]" value="<?=$data['tax-block'][$j]['list'][$i]['id']?>" <?=$data['tax-block'][$j]['list'][$i]['checked']?>/>
                                        <label class="form-check-label" for="defaultCheck1">
                                            <?=$data['tax-block'][$j]['list'][$i]['name']?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        
                        
                        <div class="pricelist">
                            <h4>Прайс-лист</h4>
                            <div style="max-height:400px; overflow-y:scroll;">
                            <?php foreach ($data['pricelist'] as $price) { ?>
                                <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pricelist[]" value="<?=$price['id']?>" <?=$price['checked']?> />
                                        <label class="form-check-label" for="defaultCheck1">
                                            <?=$price['name']?>
                                        </label>
                                    </div>
                            <?php } ?>
                            </div>
                        </div>
                        
                    </div>
                 </div>
                 <input type="submit" name="content-edit" value="Сохранить" class="btn btn-primary"/>
                  
                  </form>
                  
                
                  
                </div>
                
              </div>
           