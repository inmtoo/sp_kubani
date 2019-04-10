<?php
    class Files {
    
        public function move_to ($source, $destination, $random_rename) {
            
        }
        
        public function copy_from_site_to ($source, $destination, $random_rename) {
            $extension = Files::getExtension($source);
            $basename = basename($source, '.'.$extension);
            if ( $random_rename == 1 ) {
                $newname = md5($basename.date("Y-m-d").date("H:i:s"));
            } else {
                $newname = $basename;
            }
            
            if (copy($source, $destination.$newname.'.'.$extension)) {
               // return $destination.$newname.'.'.$extension;
               return str_replace("/home/m/myzaprosru/sp-kubani/public_html", "", $destination.$newname.'.'.$extension);
            } else {
                return 'Error';
            }
        }
        
        public function getExtension($filename) {
            return end(explode(".", $filename));
        }
    
    }
?>