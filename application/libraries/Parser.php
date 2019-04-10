<?php

/*

$name =array();
			if(preg_match_all('/<a class="catalog_section_href" href="[^>]+?[^>]+">(.*?)<\/a>/',$out,$regs))
			{
				$name = $regs[1];
			}

*/
	
	class Parser {
	
		function index($url) {
		
			if (strpos($url, 'sima-land') !== false) {
				$function = 'simaland';
			} elseif (strpos($url, 'happywear') !== false) {
				$function = 'happywear';
			}
			
			return Parser::$function($url);
		
		}
		
		function simaland($url) {
		
			$out = array();
			$out .= file_get_contents($url);
			
			$provider_info = Database::getrow('sp_providers', 'markup', 'id', 1, 0);
			
			$return['name'] =array();
			if(preg_match_all('/<h1 itemprop="name">(.*?)<\/h1>/', $out, $name))
			{
				$return['name'] = $name[1][0];
			}
			
			$return['price'] =array();
			if(preg_match_all('/<meta itemprop="price" content="(.*?)">/', $out, $price))
			{
				$return['cost_price'] = $price[1][0];
			}
			
			$return['currency'] =array();
			if(preg_match_all('/<meta itemprop="priceCurrency" content="(.*?)">/', $out, $currency))
			{
				$return['currency'] = $currency[1][0];
			}
			
			$return['min_order'] =array();
			if(preg_match_all('/<span class="b-properties__value">по (.*?) шт<\/span>/', $out, $min_order))
			{
				$return['min_order'] = $min_order[1][0];
			}
			
			$return['images-tmp'] =array();
			if(preg_match_all('/data-large="(.*?)"/', $out, $images))
			{
				$return['images-tmp'] = $images[1];
			}
			
			$return['categories'] =array();
			if(preg_match_all('/<a class="link link_dark-blue no-visited popup_positioner" href="[^>]+?[^>]+">(.*?)<\/a>/', $out, $categories))
			{
				$return['categories'] = $categories[1];
			}
			
			array_pop($return['images-tmp']);
			
			for( $i=0; $i < count($return['images-tmp']); $i++ ) {
                            $return['images'][$i] = Files::copy_from_site_to (strtok($return['images-tmp'][$i], '?'),  $_SERVER['DOCUMENT_ROOT'].'/uploads/sima/', 1);
			}
			
			$return['provider_id'] = 1;
			$return['markup'] = $provider_info['markup'];
			return $return;
		
		}
		
		
		function csplast($url) {
		
			$out = array();
			$out .= file_get_contents($url);
			
    
                
			$return['images-tmp'] =array();
			if(preg_match_all('/<a href="(.*?)" class="more_photo_item">/', $out, $images))
			{
				$return['images-tmp'] = $images;
			}

			array_pop($return['images-tmp']);
			
			for( $i=0; $i < count($return['images-tmp']); $i++ ) {
                            $return['images'][$i] = Files::copy_from_site_to (strtok($return['images-tmp'][$i], '?'),  $_SERVER['DOCUMENT_ROOT'].'/uploads/csplast/', 1);
			}
			
			return $return;
		
		}
		
		public function happywear($url) {
		
		
                    $out = array();
                    $out .= file_get_contents($url);
                    $provider_info = Database::getrow('sp_providers', 'markup', 'id', 2, 0);
                    
                    $return['name'] =array();
                    if(preg_match_all('/<h1 class="cart_information_title" itemprop="name">(.*?)<\/h1>/', $out, $name))
                    {
				$return['name'] = $name[1][0];
                    }
                    
                    $return['artno'] =array();
                    if(preg_match_all('/<span class="cart_information_composition_list_item_description item-article">(.*?)<\/span>/', $out, $artno))
                    {
				$return['artno'] = $artno[1][0];
                    }
                    
                    //$return['characteristic']['color'] =array();
                    if(preg_match_all('/<span class="cart_information_composition_list_item_description item-color">(.*?)<\/span>/', $out, $color))
                    {
				$return['characteristic']['color'] = $color[1][0];
                    }
                    
                    if(preg_match_all('/<span class="cart_information_composition_list_item_description item-sostav">(.*?)<\/span>/', $out, $sostav))
                    {
				$return['characteristic']['sostav'] = $sostav[1][0];
                    }
                    
                     if(preg_match_all('/<span class="cart_information_composition_list_item_description item-country">(.*?)<\/span>/', $out, $country))
                    {
				$return['characteristic']['country'] = $country[1][0];
                    }
                    
                     if(preg_match_all('/<span class="cart_information_list_item__new">(.*?)р. <\/span>/', $out, $price))
                    {
				$return['cost_price'] = $price[1][0];
                    }
                    
                    $return['currency'] = 'RUR';
                    
                    if(preg_match_all('/<span itemprop="name">(.*?)<\/span>/', $out, $categories))
                    {
				$return['categories'] = $categories[1];
                    }
                    
                   $return['categories'] = array_values($return['categories']);
                    
                    
                    if(preg_match_all('/<img src="(.*?)" title="[^>]+?[^>]+" alt="[^>]+?[^>]+" class="cart_foto_img" id="image" itemprop="image"/', $out, $images))
                    {
				$return['images-tmp'] = $images[1];
                    }
                    

                    
                    if(preg_match_all('/<tr>\s*<td class="cart_information_form_table_size" >\s*(.*?)\s*<\/td>\s*<td class="cart_information_form_table_presence">\s*Есть/', $out, $sizes))
                    {
				$return['characteristic']['sizes'] = $sizes[1];
                    }
                    
                    
                    unset($return['categories'][0]);
                    $catlastelement = count($return['categories']);
                    unset( $return['categories'][$catlastelement] );
                    $return['categories'] = array_values($return['categories']);
                    
                    $return['provider_id'] = 2;
                    $return['markup'] = $provider_info['markup'];
                    //$return['ttt'] = $return['images-tmp'][0];
                    $return['images'][0] = Files::copy_from_site_to (strtok('https:'.$return['images-tmp'][0], '?'),  $_SERVER['DOCUMENT_ROOT'].'/uploads/happy/', 1);
                    
                    return $return;
                    
		}
	
	}
	
?>
