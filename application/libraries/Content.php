<?php
    
    
    class Content {
        
         public function get_extra_fields($args) { //Получаем доступные допполя отдельно для контента, отдельно для таксономий
            
            
            switch ($args) {
                case 'taxonomy':
                    $condition =  "`for_tax` = 1";
                    break;
                case 'content':
                    $condition =  "`for_content` = 1";
                    break;
            }
                        
            $query = "
                SELECT 
                `sp_extra_f_types`.`id` as `extra_id`,
                `sp_extra_f_types`.`name` as `extra_name`,
                `sp_extra_f_types`.`value` as `extra_valuies`,
                `sp_extra_f_types`.`method_id` as `extra_method_id`,
                `sp_extra_fields_methods`.`name` as `method_name`,
                `sp_extra_fields_methods`.`description` as `method_description`
                FROM `sp_extra_f_types` INNER JOIN `sp_extra_fields_methods` 
                ON `sp_extra_fields_methods`.`id` = `sp_extra_f_types`.`method_id` 
                WHERE ".$condition;
            
            return Database::difQuery($query);
           // return $query;
        }
        
        //Получаем все типы таксономий
        public function get_taxonomies_types() {
            $query = "SELECT `id`, `name`, `uri` FROM `sp_taxonomies_types`";
            return Database::difQuery($query);
        }
        
        //Получаем все типы содержания
        public function get_content_types() {
            $query = "SELECT `id`, `name`, `uri` FROM `sp_content_types`";
            return Database::difQuery($query);
        }
        
        //Добавляем тип содержания
        public function insert_content_type ($add) {
            $add['taxonomies_ids'] = implode(',', $add['taxonomies_ids']);
            $add['extra_id_s'] = implode(',', $add['extra_id_s']);
            Database::insert ('sp_content_types', $add);
            
        }
        
        //Добавляем тип таксономии
        public function insert_taxonomy_type ($add) {
            $add['extra_id_s'] = implode(',', $add['extra_id_s']);
            Database::insert ('sp_taxonomies_types', $add);
        }
        
        //Добавляем тип содержания
        public function update_content_type ($add) {
            $add['taxonomies_ids'] = implode(',', $add['taxonomies_ids']);
            $add['extra_id_s'] = implode(',', $add['extra_id_s'], 'id', $add['id']);
            Database::update ('sp_content_types', $add);
            
        }
        
        //Добавляем тип таксономии
        public function update_taxonomy_type ($add) {
            $add['extra_id_s'] = implode(',', $add['extra_id_s']);
            Database::update ('sp_taxonomies_types', $add, 'id', $add['id']);
        }
        
        //Получаем список типов таксономий и их содержание по тип содержания
        public function get_taxonomies_by_content_type($content_type_id) {
            $taxonomies_types__array = Database::getrow($table = 'sp_content_types', $fields = 'taxonomies_ids', $parametr = 'id', $value = $content_type_id, $rownum = 0);
            $taxonomies_types = explode(',', $taxonomies_types__array['taxonomies_ids']);
            for ( $i = 0; $i < count($taxonomies_types); $i++ ) {
                $return[$i]['type'] = Database::getrow($table = 'sp_taxonomies_types', $fields = '*', $parametr = 'id', $value = $taxonomies_types[$i], $rownum = 0);
                $return[$i]['list']  = Database::getrows($table = 'sp_taxonomies', $fields = 'id, name, uri', $parametr = 'tax_type_id', $value = $taxonomies_types[$i]);
            }
            return $return;
        }
        
        //Получаем список типов таксономий и их содержание по тип содержания
        public function get_taxonomies_by_content_type_content_id($content_type_id, $content_id) {
            $taxonomies_types__array = Database::getrow($table = 'sp_content_types', $fields = 'taxonomies_ids', $parametr = 'id', $value = $content_type_id, $rownum = 0);
            $taxonomies_types = explode(',', $taxonomies_types__array['taxonomies_ids']);
            for ( $i = 0; $i < count($taxonomies_types); $i++ ) {
                $return[$i]['type'] = Database::getrow($table = 'sp_taxonomies_types', $fields = '*', $parametr = 'id', $value = $taxonomies_types[$i], $rownum = 0);
                $return[$i]['list'] = Database::getrows($table = 'sp_taxonomies', $fields = 'id, name, uri', $parametr = 'tax_type_id', $value = $taxonomies_types[$i]);
                for ($j = 0; $j < count($return[$i]['list']); $j++) {
                    $check = Database::difQuery(
                        "
                        SELECT * FROM `sp_content_to_taxonomy_rel` WHERE `content_id` = {$content_id} AND `taxonomy_id` = {$return[$i]['list'][$j]['id']}
                        "
                    );
                    if (count($check) > 0) {
                        $return[$i]['list'][$j]['checked'] = 'checked';
                    }
                }
            }
            return $return;
        }
        
        //Получаем список дополнительных полей типа содержания
       public function get_extrafields_by_content_type($content_type_id) {
            $extra_fields = Database::getrow($table = 'sp_content_types', $fields = 'extra_id_s', $parametr = 'id', $value = $content_type_id, $rownum = 0);
            
            $extra_f = explode(',', $extra_fields['extra_id_s']);
            
            for( $i = 0; $i < count($extra_f); $i++ ) {
                $return[$i] = Database::getrow('sp_extra_f_types', '*', 'id', $extra_f[$i], 0);
            }
            return $return;
        }
        
        
        //Получаем список дополнительных полей типа содержания и значения для конкретной записи
       public function get_extrafields_by_content_type_content_id($content_type_id, $content_id) {
            $extra_fields = Database::getrow($table = 'sp_content_types', $fields = 'extra_id_s', $parametr = 'id', $value = $content_type_id, $rownum = 0);
            
            $extra_f = explode(',', $extra_fields['extra_id_s']);
            
            for( $i = 0; $i < count($extra_f); $i++ ) {
                $extra_array = Database::difQuery(
                    "
                        SELECT
                        `sp_extra_f_types`.`id` as `id`,
                        `sp_extra_f_types`.`name` as `name`,
                        `sp_extra_f_types`.`value` as `values`,
                        `sp_extra_f_types`.`method_id` as `method_id`,
                        `sp_content_extra_f`.`value` as `value`
                        FROM `sp_extra_f_types` LEFT JOIN `sp_content_extra_f` ON 
                        `sp_content_extra_f`.`content_id` = {$content_id} AND `sp_content_extra_f`.`extra_f_id` = {$extra_f[$i]}
                        WHERE `sp_extra_f_types`.`id` = {$extra_f[$i]}
                    "
                );
               // $return[$i] = Database::getrow('sp_extra_f_types', '*', 'id', $extra_f[$i], 0);
                $return[$i] = $extra_array[0];
            }
            return $return;
        }
        
         //Получаем список дополнительных полей типа таксономии
       public function get_extrafields_by_taxonomy_type($taxonomy_type_id) {
            $extra_fields = Database::getrow($table = 'sp_taxonomies_types', $fields = 'extra_id_s', $parametr = 'id', $value = $taxonomy_type_id, $rownum = 0);
            
            $extra_f = explode(',', $extra_fields['extra_id_s']);
            
            for( $i = 0; $i < count($extra_f); $i++ ) {
                $return[$i] = Database::getrow('sp_extra_f_types', '*', 'id', $extra_f[$i], 0);
            }
            return $return;
        }
        
         public function get_pricelist_rel($fieldname, $id) { //получаем позиции прайс-листа

            $pricelistfull = Database::difQuery("SELECT `id`, `name` FROM `sp_pricelist`");
            $rell = Database::difQuery("
                SELECT  `pricelist_id` FROM `sp_content_taxonomy_to_price` WHERE `".$fieldname."` = {$id}
            ");
            
            for ($i = 0; $i < count($rell); $i++ ) {
                for($j = 0; $j < count($pricelistfull); $j++ ) {
                
                    if ($pricelistfull[$j]['id'] == $rell[$i]['pricelist_id']) {
                        $pricelistfull[$j]['checked'] = 'checked';
                    }
                    
                }
            }
            return $pricelistfull;
            
        }
        
        //Получаем список дополнительных полей типа содержания и значения для конкретной записи
       public function get_extrafields_by_tax_type_tax_id($tax_type_id, $taxonomy_id) {
            $extra_fields = Database::getrow($table = 'sp_taxonomies_types', $fields = 'extra_id_s', $parametr = 'id', $value = $tax_type_id, $rownum = 0);
            
            $extra_f = explode(',', $extra_fields['extra_id_s']);
            
            for( $i = 0; $i < count($extra_f); $i++ ) {
                $extra_array = Database::difQuery(
                    "
                        SELECT
                        `sp_extra_f_types`.`id` as `id`,
                        `sp_extra_f_types`.`name` as `name`,
                        `sp_extra_f_types`.`value` as `values`,
                        `sp_extra_f_types`.`method_id` as `method_id`,
                        `sp_taxonomies_extra`.`value` as `value`
                        FROM `sp_extra_f_types` LEFT JOIN `sp_taxonomies_extra` ON 
                        `sp_taxonomies_extra`.`taxonomy_id` = {$taxonomy_id} AND `sp_taxonomies_extra`.`extra_f_id` = {$extra_f[$i]}
                        WHERE `sp_extra_f_types`.`id` = {$extra_f[$i]}
                    "
                );
               // $return[$i] = Database::getrow('sp_extra_f_types', '*', 'id', $extra_f[$i], 0);
                $return[$i] = $extra_array[0];
            }
            return $return;
        }
        
        //Поулчаем содержание по типу
        
        public function get_content_by_content_type_id($content_type_id) {
            return Database::getrows($table = 'sp_content', $fields = 'id, name', $parametr = 'content_type_id', $value = $content_type_id);
        }
        
        public function get_extra_fields_type_id_by_name($fieldname) { //получаем id типа доп. поля по наименованию. Нужно для работы с формами
            $return = Database::getrow('sp_extra_f_types', 'id', 'name', $fieldname, 0);
            return $return['id'];
        }
        
       
        //Добавляем контент
        public function content_add($content, $taxonomies, $extra, $price) {
        
            Database::insert('sp_content', $content);
            
            $return_content = Database::difQuery("
                SELECT `id` from `sp_content` WHERE `content_type_id` = {$content['content_type_id']} AND `date` = '{$content['date']}' AND `time` = '{$content['time']}'
            ");
            
           for ($i = 0; $i < count($taxonomies); $i++) { //Записываем связи содержания с таксономиями
                $add_tax['content_id'] = $return_content[0]['id'];
                $add_tax['taxonomy_id'] = $taxonomies[$i];
                Database::insert('sp_content_to_taxonomy_rel', $add_tax);
            }
           
            $extra_keys = array_keys($extra);
            
            for ($j = 0; $j < count($extra_keys); $j++) {
                $add_extra['value'] = $extra[$extra_keys[$j]];
                $add_extra['extra_f_id'] = Content::get_extra_fields_type_id_by_name($extra_keys[$j]);
                $add_extra['content_id'] = $return_content[0]['id'];
                Database::insert('sp_content_extra_f', $add_extra);
            }
            
            for ($k = 0; $k < count($price); $k++) {
                $add_price['content_id'] = $return_content[0]['id'];
                $add_price['pricelist_id'] = $price[$k];
                Database::insert('sp_content_taxonomy_to_price', $add_price);
            }
            
        }
        
        //Обновляем контент
        public function content_update($content, $taxonomies, $extra, $content_id, $price) {
            
            Database::deletrow_where_param( 'sp_content_extra_f', 'content_id', $content_id );
            Database::deletrow_where_param( 'sp_content_to_taxonomy_rel', 'content_id', $content_id );
            Database::deletrow_where_param( 'sp_content_taxonomy_to_price', 'content_id', $content_id );
            
            Database::update( 'sp_content', $content, 'id', $content_id );
            
            for ($i = 0; $i < count($taxonomies); $i++) { //Записываем связи содержания с таксономиями
                $add_tax['content_id'] = $content_id;
                $add_tax['taxonomy_id'] = $taxonomies[$i];
                Database::insert('sp_content_to_taxonomy_rel', $add_tax);
            }
            
            for ($k = 0; $k < count($price); $k++) {
                $add_price['content_id'] = $content_id;
                $add_price['pricelist_id'] = $price[$k];
                Database::insert('sp_content_taxonomy_to_price', $add_price);
            }
            
            $extra_keys = array_keys($extra);
            
            for ($j = 0; $j < count($extra_keys); $j++) {
                $add_extra['value'] = $extra[$extra_keys[$j]];
                $add_extra['extra_f_id'] = Content::get_extra_fields_type_id_by_name($extra_keys[$j]);
                $add_extra['content_id'] = $content_id;
                Database::insert('sp_content_extra_f', $add_extra);
            }
            
        }
        
        
        
        //Удаляем контент
        public function content_delete($content_id) {
            Database::deletrow_where_param( 'sp_content_extra_f', 'content_id', $content_id );
            Database::deletrow_where_param( 'sp_content_to_taxonomy_rel', 'content_id', $content_id );
            Database::deletrow_where_param( 'sp_content', 'id', $content_id );
            Database::deletrow_where_param( 'sp_content_taxonomy_to_price', 'content_id', $content_id );
        }
        
        //Добавляем таксономию
        
        public function taxonomy_add($taxonomy, $extra, $price) {
            
           Database::insert('sp_taxonomies', $taxonomy);
            
            $return_taxonomy = Database::difQuery("
                SELECT `id` from `sp_taxonomies` WHERE `tax_type_id` = {$taxonomy['tax_type_id']} AND `date` = '{$taxonomy['date']}' AND `time` = '{$taxonomy['time']}'
            ");
            
            $extra_keys = array_keys($extra);
            
            for ($j = 0; $j < count($extra_keys); $j++) {
                $add_extra['value'] = $extra[$extra_keys[$j]];
                $add_extra['extra_f_id'] = Content::get_extra_fields_type_id_by_name($extra_keys[$j]);
                $add_extra['taxonomy_id'] = $return_taxonomy[0]['id'];
                Database::insert('sp_taxonomies_extra', $add_extra);
            }
            
            for ($k = 0; $k < count($price); $k++) {
                $add_price['taxonomy_id'] = $return_taxonomy[0]['id'];
                $add_price['pricelist_id'] = $price[$k];
                Database::insert('sp_content_taxonomy_to_price', $add_price);
            }
            //return $return;
        }
        
        //Обновляем таксономию
         public function taxonomy_update($taxonomy, $extra, $taxonomy_id, $price) {
            
            Database::deletrow_where_param( 'sp_taxonomies_extra', 'taxonomy_id', $taxonomy_id );
            Database::deletrow_where_param( 'sp_content_taxonomy_to_price', 'taxonomy_id', $taxonomy_id );
            Database::update( 'sp_taxonomies', $taxonomy, 'id', $taxonomy_id );
            
            
            $extra_keys = array_keys($extra);
            
            for ($j = 0; $j < count($extra_keys); $j++) {
                $add_extra['value'] = $extra[$extra_keys[$j]];
                $add_extra['extra_f_id'] = Content::get_extra_fields_type_id_by_name($extra_keys[$j]);
                $add_extra['taxonomy_id'] = $taxonomy_id;
                Database::insert('sp_taxonomies_extra', $add_extra);
            }
            for ($k = 0; $k < count($price); $k++) {
                $add_price['taxonomy_id'] = $taxonomy_id;
                $add_price['pricelist_id'] = $price[$k];
                Database::insert('sp_content_taxonomy_to_price', $add_price);
            }
        }
        
        //Получаем список таксономий по типу
        public function get_taxonomies_by_type($taxonomy_type_id, $fields) {
            if (empty($fields)) {
                $fields = '*';
            }
            return Database::getrows('sp_taxonomies', $fields, 'tax_type_id', $taxonomy_type_id);
        }
        
        //Получаем список содержания по типу
        public function get_content_by_type($content_type_id, $fields) {
            if (empty($fields)) {
                $fields = '*';
            }
            return Database::getrows('sp_content', $fields, 'content_type_id', $content_type_id);
        }
        
        public function get_content($content_id) {
            $return['content'] = Database::getrow('sp_content', '*', 'id', $content_id, 0);
            $return['extra'] = Database::getrows('sp_content_extra_f', '*', 'content_id', $content_id);
            $return['taxonomies'] = Database::getrows('sp_content_to_taxonomy_rel', '*', 'content_id', $content_id);
            return $return;
        }
        
        public function get_content_by_uri($uri) {
            
            $return['content'] = Database::getrow('sp_content', '*', 'uri', $uri, 0);
            $return['extra'] = Database::getrows('sp_content_extra_f', '*', 'content_id', $return['content']['id']);
           // $return['taxonomies'] = Database::getrows('sp_content_to_taxonomy_rel', '*', 'content_id', $return['content']['id']);
            $query = "
                SELECT 
                `sp_content_to_taxonomy_rel`.`taxonomy_id` as `taxonomy_id`,
                `sp_taxonomies`.`name` as `name`,
                `sp_taxonomies`.`uri` as `uri` 
                FROM `sp_content_to_taxonomy_rel`
                INNER JOIN `sp_taxonomies` ON `sp_taxonomies`.`id` = `sp_content_to_taxonomy_rel`.`taxonomy_id`
                WHERE `sp_content_to_taxonomy_rel`.`content_id` = {$return['content']['id']}
            ";
            $return['taxonomies'] = Database::difQuery($query);
            return $return;
        }
        
        public function get_taxonomy($taxonomy_id) {
            $return['taxonomy'] = Database::getrow('sp_taxonomies', '*', 'id', $taxonomy_id, 0);
            $return['extra'] = Database::getrows('sp_taxonomies_extra', '*', 'taxonomy_id', $taxonomy_id);
            return $return;
        }
        
        public function get_taxonomy_by_uri_($uri) {
            $return['taxonomy'] = Database::getrow('sp_taxonomies', '*', 'uri', $uri, 0);
            $return['extra'] = Database::getrows('sp_taxonomies_extra', '*', 'taxonomy_id', $return['taxonomy']['id']);//полуить uri и name
            return $return;
        }
        
        public function get_taxonomy_by_uri($uri) {
            
            $return['taxonomy'] = Database::getrow('sp_taxonomies', '*', 'uri', $uri, 0);
            $return['extra'] = Database::getrows('sp_taxonomies_extra', '*', 'taxonomy_id', $return['taxonomy']['id']);
           // $return['taxonomies'] = Database::getrows('sp_content_to_taxonomy_rel', '*', 'content_id', $return['content']['id']);
            $query = "
                SELECT 
                `sp_content_to_taxonomy_rel`.`content_id` as `content_id`,
                `sp_content`.`name` as `name`,
                `sp_content`.`uri` as `uri` 
                FROM `sp_content_to_taxonomy_rel`
                INNER JOIN `sp_content` ON `sp_content`.`id` = `sp_content_to_taxonomy_rel`.`content_id`
                WHERE `sp_content_to_taxonomy_rel`.`taxonomy_id` = {$return['taxonomy']['id']}
            ";
            $return['content'] = Database::difQuery($query);
            return $return;
        }
        
        public function getpricelist_full() {
            return Database::SelectFrom('sp_pricelist', '*');
        }
        
        public function getpricefor($field, $uri) {
            $t_arr['content_id'] = 'sp_content';
            $t_arr['taxonomy_id'] = 'sp_taxonomies';
            $table = $t_arr[$field];
            $query = "
                SELECT 
                `{$table}`.`id` as `{$field}`, 
                `sp_content_taxonomy_to_price`.`pricelist_id` as `pricelist_id`, 
                `sp_pricelist`.`name` as `name`, 
                `sp_pricelist`.`price` as `price`, 
                `sp_pricelist`.`webuyers` as `webuyers`, 
                `sp_pricelist`.`description` as `description` 
                FROM `{$table}` 
                INNER JOIN `sp_content_taxonomy_to_price` ON `sp_content_taxonomy_to_price`.`{$field}` = `{$table}`.`id` 
                INNER JOIN `sp_pricelist` ON `sp_pricelist`.`id` = `sp_content_taxonomy_to_price`.`pricelist_id` 
                WHERE `{$table}`.`uri` = '{$uri}'
            ";
            return Database::difQuery($query);
        }
        

        
        
    }
    
?>