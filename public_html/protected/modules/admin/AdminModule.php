<?php
/**
 * Yii-User module
 * 
 * @author Mikhail Mangushev <mishamx@gmail.com> 
 * @link http://yii-user.googlecode.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: UserModule.php 105 2011-02-16 13:05:56Z mishamx $
 */

class AdminModule extends CWebModule
{
	
	public function Pre($array) {
	
		echo '<pre>';
		Print_r($array);
		echo '</pre>';
	}
	
	
	public function GetProductWhithAll($prod_id) {

        $newArr = [];
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*')
		->from('products AS t1')
		->where('t1.id = '.$prod_id.'')
		->queryRow();
		
//		$ARR['categories'] = Yii::app()->db->createCommand()
//		->select('t2.id, t2.name , t2.uri, t3.tocatalog')
//		->from('products_category as t1,  categories AS t2,  sections AS t3')
//		->where('t1.product_id = '.$ARR['id'].' AND t2.id = t1.category_id AND t2.section_id = t3.id')
//		->queryAll();

        $ARR['categories'] = Yii::app()->db->createCommand()
            ->select('t2.id, t2.name , t2.parent_id, t2.uri, t3.tocatalog')
            ->from('products_category as t1,  categories AS t2,  sections AS t3')
            ->where('t1.product_id = '.$ARR['id'].' AND t2.id = t1.category_id AND t2.section_id = t3.id')
            ->queryAll();
		
		
		$ARR['features_products'] = Yii::app()->db->createCommand()
		->select('t1.variants, t1.admin, t1.price, t1.name, t1.type , t2.*')
		->from('features as t1,features_products AS t2')
		->where('t2.product_id = '.$ARR['id'].' AND t2.feature_id = t1.id AND t1.visibly = 1 GROUP by t1.id order by t1.id asc')
		->queryALL();

		$ARR['prices'] = Yii::app()->db->createCommand('SELECT pp.id, pp.price_id, p.name, p.country, p.height, pp.quantity, p.cost FROM products_prices pp LEFT JOIN prices p ON (pp.price_id = p.id) WHERE pp.product_id = ' . $ARR['id'])->queryALL();

//        				echo '<pre>';
//				print_r($ARR['prices']);
//				die();

		foreach($ARR['features_products'] as $K => $f){
			if ($f['price'] == 1){
				$variants = explode('|', $f['variants']);



                $isRose = false;
                $setPrice = false;

				if ($ARR['categories'][0]['id']==$f['cat_id']) {
                    $ARR['feature_price'] = $f;
                    $ARR['feature_price']['feature_id'] = $f['feature_id'];
                    $isRose = true;
                    $setPrice = true;
				}

				if (!$isRose) {
//				    echo '0';
				    if ($f['cat_id']!=73) {
//				        echo '1';
                        $ARR['feature_price'] = $f;
                        $ARR['feature_price']['feature_id'] = $f['feature_id'];
                        $setPrice = true;
				    }
                }

				unset($ARR['features_products'][$K]);
                if ($setPrice) {
                    foreach($variants as $K2 => $V) {
                        $ARR['feature_price']['prices'][] = Yii::app()->db->createCommand()
                            ->select('t1.value, t1.price')
                            ->from('feature_product_price as t1')
                            ->where('t1.product_id = '.$ARR['id'].' AND t1.feature_id = '.$f['feature_id'].' AND t1.value = "'.$V.'"')
                            ->queryRow();
                    }
                }

                if ($setPrice) {

                }
				if (empty($newArr)) {
                    if ($setPrice) {
//                        echo '3';
                        $newArr = $ARR;
                    }
				}

//                echo '<pre>';
//                print_r($newArr);
//                die();
			}
		}

//        echo '<pre>';
//        print_r($newArr);
//        die();

		$ARR = $newArr;

//		if(!in_array(true, $ARR['feature_price']['prices'])){
//			$prod_price = Yii::app()->db->createCommand()
//					->select('t1.price')
//					->from('feature_product_price as t1')
//					->where('t1.product_id = '.$ARR['id'])
//					->queryRow();
//
//			$ARR['feature_price']['prices'][0] = array(
//						"value"=> '',
//						"price"=> $prod_price['price']
//					);
//		}

//        if ($ARR['feature_price']['prices']) {
//            $ARR['price'] = $ARR['feature_price']['prices'][0]['price'];
//        }

		
		$action_products = Yii::app()->db->createCommand()
		->select('t1.value, t1.name, t1.type , t2.*')
		->from('actions as t1,actions_products AS t2')
		->where('t2.product_id = '.$ARR['id'].' AND t2.action_id = t1.id AND t2.visibly = 1 AND t1.visibly = 1')
		->queryALL();
		
		$action_category = Yii::app()->db->createCommand()
		->select('t1.value, t1.name, t1.type , t2.*')
		->from('actions as t1,actions_category_product AS t2')
		->where('t2.prod_id = '.$ARR['id'].' AND t2.action_id = t1.id AND t2.visibly = 1 AND t1.visibly = 1 Group by t2.action_id')
		->queryALL();
		
		foreach ($action_category  as $K => $V ) {
			$check = true;
			foreach($action_products as $k2 => $v2 ) {
				if ($V['action_id'] == $v2['action_id']) 
					$check = false;
			}
			if ($check)
				$action_products[] = $V;
		}
		
		
// 		$ARR['actions_category'] = array();
// 		foreach ($ARR['categories'] as $K => $cat) {
// 			$category_actions = Yii::app()->db->createCommand()
// 			->select('t1.value, t1.name, t1.type , t2.*, t3.visibly as category_visibly, t3.id as id_actions_category_product')
// 			->from('actions as t1,actions_category AS t2, actions_category_product AS t3')
// 			->where('t2.cat_id = '.$cat['id'].' AND t2.action_id = t1.id AND t2.visibly = 1 AND t1.visibly = 1 AND t3.action_id = t1.id AND t3.prod_id = '.$ARR['id'].'')
// 			->queryALL();
			
// 			foreach ($category_actions as $K => $V) {
// 				$ARR['actions_category'][$V['id']] = $V;
// 			}
			
// 		}
				
		$ARR['actions_products'] = $action_products;
		
		$ARR['others_products'] = Yii::app()->db->createCommand()
		->select('*')
		->from('others_products as t1')
		->where('t1.prod_id = '.$ARR['id'].'')
		->queryrow();

// 		/$this->pre($ARR);
		return $ARR;
	}



	public function GetProductFeaturePrice($prod_id, $product = false) {
		if (!$product) {
			$ARR = Yii::app()->db->createCommand()
			->select('t1.*')
			->from('products AS t1')
			->where('t1.id = '.$prod_id.'')
			->queryRow();
		} else {
			$prod_price = Yii::app()->db->createCommand()
				->select('t1.price')
				->from('feature_product_price as t1')
				->where('t1.product_id = '.$product->id.' ORDER BY t1.price ASC')
				->queryRow();

			$product->feature_price['prices'][0] = [
				"value"=> '',
				"price"=> $prod_price['price']
			];
			return $product;
		}
/*
		$ARR['features_products'] = Yii::app()->db->createCommand()
		->select('t1.variants, t1.admin, t1.price, t1.name, t1.type , t2.*')
		->from('features as t1,features_products AS t2')
		->where('t2.product_id = '.$ARR['id'].' AND t2.feature_id = t1.id AND t2.visibly = 1 AND t1.visibly = 1 GROUP by t1.id order by t1.id desc')
		->queryALL();

		foreach($ARR['features_products'] as $K => $f){
			if ($f['price'] == 1){
				$variants = explode('|', $f['variants']);
				$ARR['feature_price'] = $f;
				unset($ARR['features_products'][$K]);
				foreach($variants as $K2 => $V) {
					$ARR['feature_price']['prices'][] = Yii::app()->db->createCommand()
					->select('t1.value, t1.price')
					->from('feature_product_price as t1')
					->where('t1.product_id = '.$ARR['id'].' AND t1.feature_id = '.$f['feature_id'].' AND t1.value = "'.$V.'"')
					->queryRow();
				}
				
			}
		}

		if(!in_array(true, $ARR['feature_price']['prices'])){
			$prod_price = Yii::app()->db->createCommand()
					->select('t1.price')
					->from('feature_product_price as t1')
					->where('t1.product_id = '.$ARR['id'])
					->queryRow();

			$ARR['feature_price']['prices'][0] = array(
						"value"=> '',
						"price"=> $prod_price['price']
					);
		}
*/		
		$prod_price = Yii::app()->db->createCommand()
			->select('t1.price')
			->from('feature_product_price as t1')
			->where('t1.product_id = '.$ARR['id'].' ORDER BY t1.price ASC')
			->queryRow();

		$ARR['feature_price']['prices'][0] = [
			"value"=> '',
			"price"=> $prod_price['price']
		];

		return $ARR;
	}
	
	public function GetCategoryWhithAllProducts($id='') {
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*, t2.name as cat_name')
		->from('products AS t1,  products_category AS t3,categories AS t2')
		->where('t1.id = t3.product_id AND t3.category_id = t2.id AND  t2.id = '.$id.' GROUP by t1.id ORDER by t1.orders ASC , t1.id DESC')
		->queryALL();
	
		foreach( $ARR as $k => $P) {
			
			 $categories = Yii::app()->db->createCommand()
			->select('t2.name')
			->from('products_category as t1,  categories AS t2')
			->where('t1.product_id = '.$P['id'].' AND t2.id = t1.category_id GROUP by t2.id ')
			->queryAll();
			 $category_list = array();
			 foreach($categories as $K => $V) {
			 	$category_list[] = $V['name'];
			 }
			 $ARR[$k]['categories_list'] = implode(', ', $category_list);
		}
		
		foreach ($ARR as $key => $value) {
			$feature_price_arr = $this->GetProductFeaturePrice($value['id']);
			$feature_price = 9999999;

			foreach($feature_price_arr['feature_price']['prices'] as $price){
				if(isset($price['price']) && $price['price'] < $feature_price) $feature_price = $price['price'];
			}
			if($feature_price == 9999999) $feature_price = $value['price'];
			$ARR[$key]['feature_price'] = $feature_price;

		}
	
		return $ARR;
	}
	
	public function GetCategoryWithAll($cat_id='') {
		
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('categories')
		->where('id = '.$cat_id.'')
		->queryRow();
		
		$ARR['features_categories'] = Yii::app()->db->createCommand()
		->select('t1.variants, t1.admin, t1.name, t1.type , t2.*')
		->from('features as t1,features_category AS t2')
		->where('t2.cat_id = '.$ARR['id'].' AND t2.feature_id = t1.id AND t2.visibly = 1 AND t1.visibly = 1')
		->queryALL();
		
		$ARR['actions_categories'] = Yii::app()->db->createCommand()
		->select('t1.value, t1.name, t1.type , t2.*')
		->from('actions as t1,actions_category AS t2')
		->where('t2.cat_id = '.$ARR['id'].' AND t2.action_id = t1.id AND t2.visibly = 1 AND t1.visibly = 1')
		->queryALL();
		
		return $ARR;
	}
	
	public function GetAllCategories() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*')
		->from('categories as t1  ')
		->where('t1.id  != 0  GROUP by t1.id ORDER BY t1.orders ASC ')
		->queryALL();

		return $ARR;
	}

    public function GetMainCategories() {

        $ARR = Yii::app()->db->createCommand()
            ->select('t1.*')
            ->from('categories as t1  ')
            ->where('t1.typeCategory = 1 ORDER BY t1.orders ASC ')
            ->queryALL();

        return $ARR;
    }

    public function GetHolidays() {

        $ARR = Yii::app()->db->createCommand()
            ->select('t1.*')
            ->from('categories as t1  ')
            ->where('t1.typeCategory = 0 ORDER BY t1.orders ASC ')
            ->queryALL();

        return $ARR;
    }

    public function GetMainCategoriesId($product_id) {

        $ARR = Yii::app()->db->createCommand()
            ->select('pc.category_id')
            ->from('products_category as pc,  categories as c,')
            ->where('pc.product_id = '.$product_id.' and  c.id = pc.category_id and c.typeCategory = 1')
            ->queryAll();

        return $ARR[0]['category_id'];
    }

    public function GetHolidayId($product_id) {

        $ARR = Yii::app()->db->createCommand()
            ->select('pc.category_id')
            ->from('products_category as pc,  categories as c,')
            ->where('pc.product_id = '.$product_id.' and  c.id = pc.category_id and c.typeCategory = 0')
            ->queryAll();

        return $ARR[0]['category_id'];
    }
	
	public function GetAllProducts() {

		// $ARR = Yii::app()->db->createCommand()
		// ->select('t1.*')
		// ->from('products AS t1')
		// ->where('t1.id != "" ORDER BY t1.orders ASC , t1.id DESC ')
		// ->limit(10)
		// ->queryALL();
		
		global $start;
		$start = microtime(true);
		
		$criteria=new CDbCriteria;
		$criteria->select='*, (select price from feature_product_price fpp where fpp.product_id = t.id ORDER BY fpp.price ASC limit 1) as feature_price';
		//$criteria->limit = 10;
		$criteria->order = 't.orders ASC, t.id DESC';
		$products=Product::model()
			->with('categories')
			->findAll($criteria);
		// echo microtime(true) - $start;exit;

		foreach($products as $k => $product) {
			//Определяем categories_list
			$category_list = [];
			foreach($product->categories as $cat) {
				$category_list[] = $cat['name'];
			}
            $products[$k]->categories_list = implode(', ', $category_list);
			
			//Определяем feature_price
			/*
			$feature_price_arr = $this->GetProductFeaturePrice($product['id'],$product);
			$feature_price = 9999999;
			foreach($feature_price_arr->feature_price['prices'] as $price){
				if(isset($price['price']) && $price['price'] < $feature_price) $feature_price = $price['price'];
			}
			if($feature_price == 9999999) $feature_price = $product['price'];
			$products[$k]['feature_price'] = $feature_price;
			*/
			if (empty($products[$k]->feature_price)) {
				$products[$k]->feature_price = $product['price'];
			}
		}
		
		// echo microtime(true) - $start;exit;		
		// echo '<pre>';
		// print_r($ARR);
		// die();
/*
		foreach( $ARR as $k => $P) {

			 $categories = Yii::app()->db->createCommand()
			->select('t2.name')
			->from('products_category as t1,  categories AS t2')
			->where('t1.product_id = '.$P['id'].' AND t2.id = t1.category_id GROUP by t2.id ')
			->queryAll();
			 $category_list = array();
			 foreach($categories as $K => $V) {
			 	$category_list[] = $V['name'];
			 }
			 $ARR[$k]['categories_list'] = implode(', ', $category_list);
		}
*/
		return $products;
	}
	
	public function GetAllSections() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*')
		->from('sections as t1')
		->where('t1.id !=""  ORDER BY t1.orders ASC ')
		->queryALL();
	
	
		return $ARR;
	}
	
	public function GetSectionWithAll($cat_id='') {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('sections')
		->where('id = '.$cat_id.'')
		->queryRow();
		
		$ARR['count_poduct'] = Yii::app()->db->createCommand()
		->select('count(id)')
		->from('categories')
		->where('section_id = '.$cat_id.'')
		->queryScalar();
		
		return $ARR;
	}
	
	
	public function GetSectionsWithCategory () {
		
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*, t2.name as section_name')
		->from('categories as t1, sections as t2')
		->where('t1.section_id = t2.id  GROUP by t1.id order by t1.orders')
		->queryALL();
		
		
		$Catalog = array();
		foreach($ARR as $K => $V) {
			$Catalog[$V['section_id']]['category'][] = $V;
			$Catalog[$V['section_id']]['name'] = $V['section_name'];
		}
		
		return $Catalog;
	}
	
	
	public function GetTypesFeatures() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('features_types')
		->where('id != "" order by id DESC')
		->queryALL();
	
	
		return $ARR;
	}
	
	public function GetFeatureWithAll($id) {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('features')
		->where('id = '.$id.'')
		->queryRow();
		
			$ARR['categories'] = Yii::app()->db->createCommand()
			->select('t1.cat_id, t2.name')
			->from('features_category as t1, categories as t2')
			->where('t1.feature_id = '.$ARR['id'].' AND t2.id = t1.cat_id AND t1.visibly = 1')
			->queryALL();
		
			$ARR['products'] = Yii::app()->db->createCommand()
			->select('t1.product_id, t2.name')
			->from('features_products as t1, products as t2')
			->where('t1.feature_id = '.$ARR['id'].' AND t2.id = t1.product_id AND t1.visibly = 1')
			->queryALL();
		
		return $ARR;
	}
	
	public function GetAllFeatures() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*, t2.name as type_name')
		->from('features as t1, features_types as t2')
		->where('t1.id != "" AND t2.type = t1.type  Order By id DESC')
		->queryALL();
		
		return $ARR;
	}
	
	public function GetAllActions() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*, t2.name as type_name')
		->from('actions as t1, actions_types as t2')
		->where('t1.id != "" AND t2.type = t1.type  Order By id DESC')
		->queryALL();
	
		foreach( $ARR as $k => $P) {
				
			$categories = Yii::app()->db->createCommand()
			->select('t2.name')
			->from('actions_category as t1,  categories AS t2')
			->where('t1.action_id = '.$P['id'].' AND t2.id = t1.cat_id GROUP by t2.id ')
			->queryAll();
		
			$category_list = array();
			foreach($categories as $K => $V) {
				$category_list[] = $V['name'];
			}
			 $ARR[$k]['categories_list'] = implode(', ', $category_list);
		}
		
		return $ARR;
	}
	
	public function GetActionWithAll($id) {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('actions')
		->where('id = '.$id.'')
		->queryRow();
	
		$ARR['categories'] = Yii::app()->db->createCommand()
		->select('t1.cat_id, t2.name')
		->from('actions_category as t1, categories as t2')
		->where('t1.action_id = '.$ARR['id'].' AND t2.id = t1.cat_id AND t1.visibly = 1')
		->queryALL();
	
		$ARR['products'] = Yii::app()->db->createCommand()
		->select('t1.product_id, t2.name')
		->from('actions_products as t1, products as t2')
		->where('t1.action_id = '.$ARR['id'].' AND t2.id = t1.product_id AND t1.visibly = 1')
		->queryALL();
	
		return $ARR;
	}
	
	public function GetTypesACtions() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('actions_types')
		->where('id != "" ')
		->queryALL();
	
	
		return $ARR;
	}
	
	
	public function GetAllBanners() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*')
		->from('banners as t1')
		->where('t1.id != "" Order By id DESC')
		->queryALL();
	
		return $ARR;
	}
	
	public function GetBannerWithAll($id) {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('banners')
		->where('id = '.$id.'')
		->queryRow();
	
		return $ARR;
	}
	
	
	public function translit($str)
	{
		$tr = array(
				"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
				"Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
				"Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
				"О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
				"У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
				"Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
				"Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
				"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
				"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
				"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
				"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
				"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
				"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
				"."=>""," "=>"","?"=>"","/"=>"","\\"=>"",
				"*"=>"",":"=>"","*"=>"","\""=>"","<"=>"",
				">"=>"","|"=>""
		);
		return strtr($str,$tr);
	}
	
	public function GetAllPages() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('pages')
		->where('id != "" and is_visible=1')
		->queryALL();
	
		return $ARR;
	}
	
	public function GetPageWithAll($id) {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('pages')
		->where('id = '.$id.'')
		->queryRow();
	
		return $ARR;
	}

	public function GetDeliveryRegions() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('delivery_regions')
		->where('id != "" order by orders ASC')
		->queryALL();
	
		return $ARR;
	}
	
	public function GetOrderWithAll($id) {
	
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*, t2.name as status_name')
		->from('orders as t1,  orders_status as t2')
		->where('t1.status = t2.uri AND t1.id ='.$id.'')
		->queryrow();
	
		return $ARR;
	}
	
	public function GetAllOrders() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('t1.*, t2.name as status_name')
		->from('orders as t1,  orders_status as t2')
		->where('t1.status = t2.uri')
		->queryALL();
	
		return $ARR;
	}
	
	public function GetAllOrdersStatus() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('orders_status')
		->where('id != ""')
		->queryALL();
	
		return $ARR;
	}
	
	public function GetAllOrdersToStatus($cat_uri) {
	
		$query = Yii::app()->db->createCommand()
		->select('t1.*, t2.name as status_name')
		->from('orders as t1,  orders_status as t2')
		->group('t1.id')
		->order('id desc');
		if (!empty($cat_uri)) {
			$query->where('t1.status = t2.uri AND t2.uri = "'.$cat_uri.'"');
		}
		$ARR = $query->queryALL();
	
		return $ARR;
	}
	
	public function GetAllOrdersDelivery() {
	
		$ARR = array(
			array('id'=>'1',  	'name'=>'Самовывоз по Самаре', 				'short_name'=>'Самовывоз',),
			array('id'=>'2', 	'name'=> 'Курьером EMC по городам Росии', 	'short_name'=> 'Курьером EMC'),		
			array('id'=>'3', 	'name'=> 'Почта России', 					'short_name'=> 'Почта России'),
		);
	
		return $ARR;
	}
	
	public function GetAllOrdersPayment(){
	
		return array(
				array('id'=> '1', 			'name'=> 'Наличными'),
				array('id'=> '2', 			'name'=> 'Банковские переводы'),
				array('id'=> '3', 			'name'=> 'Яндекс.Деньги'),
				array('id'=> '4', 			'name'=> 'Киви-кошелек'),
		);
	}
	
	public function GetAllOrdersPaid(){
	
		return array(
				array('id'=> '0', 'uri'=> '0',	'name'=> 'Неоплачен'),
				array('id'=> '1', 'uri'=> '1', 	'name'=> 'Оплачен'),
		);
	}
	
	
	public function GetAllReviews() {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('reviews')
		->where('id != ""')
		->queryALL();
	
		return $ARR;
	}
	
	
	public function GetReviewWhithAll($id) {
	
		$ARR = Yii::app()->db->createCommand()
		->select('*')
		->from('reviews')
		->where('id ='.$id.'')
		->queryrow();
	
		return $ARR;
	}

	public function GetAllPrices() {
//		$sql = 'SELECT * FROM prices ORDER BY orders ASC';
		$sql = 'SELECT * FROM `prices` ORDER BY `name` ASC, `country` ASC, `height` ASC';
		$ARR = Yii::app()->db->createCommand($sql)->queryALL();

// [id] => 74
// [country] => Р РѕСЃСЃРёСЏ
// [name] => Р РѕР·Р°
// [title] =>
// [height] => 60 cРј
// [cost] => 110
// [season] => 0
// [order] => 0
// [orders] => 0
// )

		return $ARR;
	}

	public function GetAllFormatPrices() {
		$sql = 'SELECT * FROM prices';
		$ARR = Yii::app()->db->createCommand($sql)->queryALL();

		$result = [];

		foreach ($ARR as $item) {
			$result[] = $item['name'] . ' ' . $item['height'] . ' ' . $item['country'];
		}

		natcasesort($result);

		return $result;
	}

	public function GetPriceWithAll($id) 
	{
		$sql = 'SELECT * FROM prices WHERE id = ' . $id;
		$ARR = Yii::app()->db->createCommand($sql)->queryRow();
		return $ARR;
	}

	public function GetFlowers()
	{
		$ARR = Yii::app()->db->createCommand('SELECT variants FROM features WHERE id = 10')->queryRow();
		$result = explode('|', $ARR['variants']);
		natcasesort($result);
		return $result;
	}

	public function GetSizes()
	{
		$ARR = Yii::app()->db->createCommand('SELECT variants FROM features WHERE id = 12')->queryRow();
		$result = explode('|', $ARR['variants']);
		natcasesort($result);
		return $result;
	}

	public function GetCountries()
	{
		$ARR = Yii::app()->db->createCommand('SELECT variants FROM features WHERE id = 15')->queryRow();
		$result = explode('|', $ARR['variants']);
		natcasesort($result);
		return $result;
	}

	public function GetAllAlerts() {
		$sql = 'SELECT * FROM alerts';
		$ARR = Yii::app()->db->createCommand($sql)->queryALL();
		return $ARR;
	}

	public function GetAlertWithAll($id) 
	{
		$sql = 'SELECT * FROM alerts WHERE id = ' . $id;
		$ARR = Yii::app()->db->createCommand($sql)->queryRow();
		return $ARR;
	}
}
