<?php

use Yii;

class CatalogController extends Controller
{
	public $layout = 'main';

	public function actionIndex($uri = '', $id= '', $slice= '')
	{
        global $start;
        $start = microtime(true);

//        $label = " ";

		$db = Yii::app()->db;

//        $flowers_have_hpu = $db->createCommand('SELECT * from flowers where have_sef=1')->queryAll();
//
//        $arr = [];
//
//        foreach ($flowers_have_hpu as $name_flower) {
//            $arr[$name_flower['name']] = $db->createCommand("SELECT product_id, value from features_products fp where visibly=1 and feature_id=10 and value like '%".$name_flower['name']."%'")->queryAll();
//        }
//
//        $flowers_have_hpu = [];
//        foreach ($arr as $key=>$item) {
//            if(!empty($item)) {
//                $flowers_have_hpu[] = $key;
//            }
//        }

//        echo microtime(true) - $start;exit;

//    echo '<pre>';
//    die(print_r($flowers_have_hpu));

//        echo 'uri:'.$uri.'<br>';
//        echo 'id:'.$id.'<br>';
//        echo 'slice:'.$slice.'<br>';
//        die();

        $sql = 'SELECT id  FROM pages WHERE  uri = "'.$slice.'"';
        $flower_is_availability = $db->createCommand($sql)->queryAll();

        $mono_byket = $db->createCommand('select * from pages where is_mono_byket=1')->queryRow();


        if(!empty($slice)){
            $sql = 'SELECT *  FROM flowers WHERE  uri = "'.$slice.'"';
            $uri_arr = $db->createCommand($sql)->queryAll();

            if (empty($uri_arr) && $flower_is_availability[0]['id']!=30 && $flower_is_availability[0]['id']!=31) {
                if ($slice!=$mono_byket['uri']) {
                    throw new CHttpException(404,'Ой, такой страницы нет');
                }
            }

            Yii::app()->params['cat_uri'] = $slice;
        }



		if($id == '' or !empty($slice)){

            if ($uri != ''){
                $breadcrumbs['/'] = ['title'=>'Цветы в Кинеле','url'=>'/'];

				$sql = 'SELECT c.*, f.name as feature_name, f.variants as feature_variants
				FROM categories c
				LEFT JOIN features_category fc ON fc.cat_id = c.id
				LEFT JOIN features f ON fc.feature_id = f.id
				WHERE (fc.visibly=1 or c.typeCategory=0)
					AND c.uri = "'.$uri.'"
				GROUP by c.id
				ORDER by f.id ASC';
//				$sql = 'SELECT c.*, f.name as feature_name, f.variants as feature_variants FROM categories c LEFT JOIN features_category fc ON fc.cat_id = c.id LEFT JOIN features f ON fc.feature_id = f.id  WHERE  f.type="multiselect" AND f.visibly = 1 AND  c.hidden = 0 AND c.uri = "'.$uri.'" GROUP by c.id ORDER by f.id ASC';
                $category = $db->createCommand($sql)->queryRow();

                if ($category['parent_id'] != 0){
                    $sql = 'SELECT * FROM categories where id = '.$category['parent_id'];
                    $parent_category = $db->createCommand($sql)->queryRow();
                    $breadcrumbs[$parent_category['uri']] = ['title'=>$parent_category['name'],'url'=>'/catalog/'.$parent_category['uri'].'/'];
                }else{
                    $breadcrumbs[$category['uri']] = ['title'=>$category['name'],'url'=>'/catalog/'.$category['uri'].'/'];
                }

                $sql = "SELECT page_title FROM categories WHERE uri='".$uri."'";
                $label_page = $db->createCommand($sql)->queryScalar();


                if (!empty($slice)) {
                    $sql = 'SELECT *  FROM pages WHERE page_title != "" and meta_title != "" and meta_description != "" and uri = "' . $slice . '"';
                    $page = $db->createCommand($sql)->queryRow();
                    $breadcrumbs[$page['uri']] = ['title'=>$page['page_title'], 'url'=>'/catalog/'.$page['uri'].'/'];

                    if ($category['id'] == 84) {
                        $sql = "SELECT label_description FROM pages WHERE uri='".$slice."'";
                        $label_page = $db->createCommand($sql)->queryScalar();
                    }

                }

                if (!empty($page)){

                    $label = $label_page ? $label_page : $page['page_title'];
                    $this->pageTitle= $page['meta_title'].'';
                    Yii::app()->clientScript->registerMetaTag($page['meta_description'], 'description');
                    Yii::app()->clientScript->registerMetaTag($page['meta_keywords'], 'keywords');

                }else{
                    $sql = 'SELECT *  FROM categories WHERE  uri = "'.$uri.'" GROUP by id';//  visibly = 1 AND
                    $C = $db->createCommand($sql)->queryRow();

                    $label = $label_page ? $label_page : $C['name'];

                    if ($label == '')
                        $label = $C['name'];
//                        throw new CHttpException(404,'Ой, такой страницы нет');

                    if (isset($C['meta_title']) && $C['meta_title'] != ''){
                        $this->pageTitle=$C['meta_title'].'';
                        Yii::app()->clientScript->registerMetaTag($C['meta_description'], 'description');
                        Yii::app()->clientScript->registerMetaTag($C['meta_keywords'], 'keywords');
                    } else
                        $this->pageTitle=$label.'';

                    $breadcrumbs[$C['uri']] = ['title'=>$C['name'], 'url'=>'/catalog/'.$C['uri'].'/'];
                }


			}else {
				$label = 'Каталог';
				$this->pageTitle=$label.'';
				$category = array('feature_variants' => '');
//				$C = array('label_description' => '', 'description' => '');
				$category = false;
			}

            $p = new CHtmlPurifier;

            $GetPice = '';
            $GetType = '';
            $GetSort  = '';

            if (isset($_GET['price']) && is_numeric(str_replace(' ', '', $_GET['price']))){
                $GetPice = (int)str_replace(' ', '', $_GET['price']);
            }
            if (isset($_GET['type']) && $p->purify($_GET['type']) != '' &&  $p->purify($_GET['type']) != 'Все'){
                $GetType = $p->purify($_GET['type']);
            }

            if (isset($_GET['sort']) && ( $p->purify($_GET['sort']) != 'asc' || $p->purify($_GET['sort']) != 'desc')){
                $GetSort  = $p->purify($_GET['sort']);
            }

            $sql0 = 'SELECT id FROM categories WHERE uri="'.$uri.'"';
            $parent_id = $db->createCommand($sql0)->queryScalar();

            if (!$parent_id)
                $parent_id = 0;

            $sql = 'SELECT p.id FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE p.visibly = 1 '.(($uri != '')? 'AND c.uri = "'.$uri.'"' : '').(($GetPice != '')? 'AND p.price <= '.$GetPice : '').' AND p.img != "" AND p.img != "|" GROUP by p.id ORDER by '.(($GetSort) ? 'p.price '.$GetSort.'' :'p.orders ASC');//' AND c.visibly = 1 '.
            $total = $db->createCommand($sql)->queryAll();

            $pageisze = count($total);


            $pages = new CPagination(count($total));
            $pages->pageSize = $pageisze;
            $offset = $pages->getOffset();
            $limit = $pages->getLimit();

            if ($slice==$mono_byket['uri']) {
                $products = [];
                $sql = 'SELECT p.*, c.uri as cat_uri, c.id as cat_id, c.name cat_name, p.orders, c.parent_id
				FROM products p
				INNER JOIN  products_category pc ON pc.product_id = p.id
				INNER JOIN categories c ON c.id = pc.category_id
				WHERE p.is_mono_byket=1 and p.visibly = 1 '.(($uri != '')? 'AND (c.uri = "'.$uri.'" OR c.parent_id='.$parent_id.')' : '').(($GetPice != '')? 'AND p.price <= '.$GetPice : '').'
				GROUP by p.id
				ORDER by '.(($GetSort) ? 'p.price '.$GetSort.'' :'p.orders ASC, p.id DESC');
                $products = $db->createCommand($sql)->queryAll();
            } else {
				$sql = 'SELECT p.*, c.uri as cat_uri, c.id as cat_id, c.name cat_name, p.orders, c.parent_id
				FROM products p
				INNER JOIN products_category pc ON pc.product_id = p.id
				INNER JOIN categories c ON c.id = pc.category_id
				WHERE p.visibly = 1 '.(($uri != '')? 'AND (c.uri = "'.$uri.'" OR c.parent_id='.$parent_id.')' : '').(($GetPice != '')? 'AND p.price <= '.$GetPice : '').'
				GROUP by p.id
				ORDER by '.(($GetSort) ? 'p.price '.$GetSort.'' :'p.orders ASC, p.id DESC');

				//$sql = 'SELECT p.*, c.uri as cat_uri, c.id cat_id, c.name cat_name, c.parent_id FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE   p.visibly = 1 '.(($uri != '')? 'AND c.uri = "'.$uri.'" OR c.parent_id="'.$parent_id.'"' : '').(($GetPice != '')? 'AND p.price <= '.$GetPice : '').' AND p.img != "" AND p.img != "|" GROUP by p.id ORDER by '.(($GetSort) ? 'p.price '.$GetSort.'' :'p.orders ASC, p.id DESC').' LIMIT '.$offset.','.$limit;
				$products = $db->createCommand($sql)->queryAll();//' AND c.visibly = 1 '.
			}

//            echo '<pre>';
//            print_r($products);
//            die();

            if ($uri == 'rozy'){
                $sql = "SELECT * FROM `products` WHERE visibly = 1 and visible_in_roses = 1 order by orders asc";
                $products = $db->createCommand($sql)->queryAll();//' AND c.visibly = 1 '.

                $sql2 = "SELECT product_id as id, name, price, price_update, img, orders, visibly, visible_in_roses, products_category.category_id as cat_id FROM products INNER JOIN products_category ON products.id = product_id WHERE (category_id=73 and visible_in_roses=0 and visibly=1) ORDER BY orders ASC";
                $rozy = $db->createCommand($sql2)->queryAll();

                $products = array_merge($products, $rozy);
            }


            $productId = array();
            $categories = array();
            foreach ($products as $product) {
                $productId[] =  $product['id'];
                if (empty($categories[$product['cat_id']]) && $product['cat_id'] != 73) {
                    $categories[$product['cat_id']] = array('id' => $product['cat_id'],'name' => $product['cat_name']);
                }
            }
            ksort($categories);

            $ProductsTo = array();
            if (count($productId) > 0) {
                $sql3 = 'SELECT fp.product_id, fp.value as feature_value FROM features_products fp LEFT JOIN {{features}} f ON fp.feature_id = f.id WHERE fp.product_id IN ('.implode(',', $productId).') AND f.name = "'.(($uri == 'rozy') ? 'Ростовка' : 'Состав').'" '.(($GetType != '') ? 'AND LOWER(fp.value) LIKE "%'.$GetType.'%"' : '').' GROUP by fp.product_id ';
                $ProductsTo = $db->createCommand($sql3)->queryAll();
            }

            $ProductsToNew = array();
            $features = [];


            $sql = "SELECT IF(prices.order = 1, '|На заказ', '|В наличии') as order_type, products_prices.product_id as id
                           FROM prices INNER JOIN products_prices ON prices.id=products_prices.price_id
                           ORDER BY prices.order ASC";

            $readyProduct = $db->createCommand($sql)->queryAll();

            $readyProductArr = [];
            foreach ($readyProduct as $readyItem)
                $readyProductArr[$readyItem['id']] = $readyItem['order_type'];

            $arr = [];

//            foreach ($readyProduct as $readyItem) {
                foreach ($ProductsTo as $key => $product) {
                    $ProductsToNew[$product['product_id']] = $product;

//                    $sql_orders = "SELECT IF(prices.order = 1, '|На заказ', '|Готовые') as order_type
//                           FROM prices, products_prices
//                           WHERE products_prices.price_id = prices.id and products_prices.product_id = " . $product['product_id'] . ' order by prices.order desc';
//
//                    $isReadyProduct = $db->createCommand($sql_orders)->queryAll();

                    if (!empty($readyProductArr[$product['product_id']])) {
                        $ProductsToNew[$product['product_id']]['feature_value'] = ltrim($ProductsToNew[$product['product_id']]['feature_value'] . $readyProductArr[$product['product_id']], '|');
                        $ProductsTo[$key]['feature_value'] .= $readyProductArr[$product['product_id']];
                    }

//                    echo '<pre>';
//                    print_r($arr);

//                    if (!empty($isReadyProduct[0]['order_type']))
//                        $ProductsToNew[$product['product_id']]['feature_value'] = ltrim($ProductsToNew[$product['product_id']]['feature_value'] . $isReadyProduct[0]['order_type'], '|');

//                    $product['feature_value'] .= $readyItem['order_type'];
//                    if (!empty($product['feature_value'])) {
//                        $featureArr = explode('|', $product['feature_value']);
//                        foreach ($featureArr as $f) {
//                            if (!in_array($f, $features)) {
//                                $features[] = $f;
//                            }
//                        }
//                    }
                }
//            }


            $productsTo = array();
            $i = 0;
            $priceRanges = [];
            $priceMax = 0;
            $priceSteps = [1000,3000];
            foreach ($products as $product) {

                $productsTo[$i] = $product;
                if (isset($ProductsToNew[$product['id']])){
                    $productsTo[$i]['feature_value'] = $ProductsToNew[$product['id']]['feature_value'];
                }
                if (empty($priceRanges[0]) && $product['price'] < $priceSteps[0]) {
                    $priceRanges[0] = [
                        'prices'=>$priceSteps[0],
                        'title' => 'до&nbsp;'.number_format($priceSteps[0], 0, ',', '&nbsp;')
                    ];
                } elseif (empty($priceRanges[1]) && $product['price'] >= $priceSteps[0] && $product['price'] < $priceSteps[1]) {
                    $priceRanges[1] = [
                        'prices'=>$priceSteps[0].'-'.$priceSteps[1],
                        'title' => number_format($priceSteps[0], 0, ',', '&nbsp;').'&ndash;'.number_format($priceSteps[1], 0, ',', '&nbsp;')
                    ];
                }
                if ($priceMax < $product['price']) {
                    $priceMax = $product['price'];
                }

                $i++;
            }
            if ($priceMax > $priceSteps[1]) {
                $priceRanges[2] = [
                    'prices'=>$priceSteps[1].'-'.$priceMax,
                    'title' => number_format($priceSteps[1], 0, ',', '&nbsp;').'&ndash;'.number_format($priceMax, 0, ',', '&nbsp;')
                ];
                //$priceRanges['3000-6000'] = number_format($priceSteps[1], 0, ',', '&nbsp;').'&ndash;'.number_format($priceMax, 0, ',', '&nbsp;');
            }
            if (count($priceRanges) > 1) {
                ksort($priceRanges);
            }

            $products = $productsTo;

            $sql = 'SELECT t1.price_id, t1.quantity, t2.name, t2.height,t2.cost, t2.country, t2.title, t1.product_id as product_id
                    FROM products_prices t1 INNER JOIN prices t2 ON t1.price_id = t2.id 
                    order by t2.cost asc';
            $product_prices = $db->createCommand($sql)->queryAll();

            $products_all = [];
            foreach ($products as $product){
                /* product_prices */
//                $sql = 'SELECT t1.price_id, t1.quantity, t2.name, t2.height,t2.cost, t2.country, t2.title
//                        FROM products_prices t1 INNER JOIN prices t2 ON t1.price_id = t2.id
//                        WHERE product_id = '.$product['id'].' order by t2.cost asc';
//                $product['prices'] = $db->createCommand($sql)->queryAll();

                $product['prices'] = array_filter($product_prices, function ($data) use($product){
                    return $data['product_id'] == $product['id'];
                });

                $product['prices'] = array_values($product['prices']);

                $product['visible_cost'] = $product['prices'][0]['cost'];

                if ($product['cat_id']) {
                    if ($product['cat_id']==73) {
                        $product['price'] = $product['prices'][0]['cost'];
                    }
                }

                $products_all[] = $product;
            }


            $products = $products_all;

//            echo '<pre>';
//            print_r($label);
//            die();

//            echo '<pre>';
//            die(print_r($breadcrumbs));

//            echo microtime(true) - $start;exit;

            Yii::app()->params['breadcrumbs'] = $breadcrumbs;


            if(Yii::app()->request->isPostRequest)
 				$this->renderPartial('items_line', array(
 						'products' => $products,
 						'pages'=>$pages,
						'prod_season_ids' => $prod_season_ids,
						'prod_order_ids' => $prod_order_ids
 				));
 			else {

				$this->render('index', array(
						'products' => $products,
						'pages'=>$pages,
						'total' => count($total),
						'category'=> $category,
						'categories'=> $categories,
						'label' => $label,
						'C' => $C,
						'page' => $page,
						'priceRanges' => $priceRanges,
						'prod_season_ids' => $prod_season_ids,
						'prod_order_ids' => $prod_order_ids
				));
 			}

		} else {
			/* get all Products in categody */

            if ($uri != '') {
                throw new CHttpException(404,'Ой, такой страницы нет');
            }

			$sql = 'SELECT p.*, c.typeCategory, c.name as cat_name, c.id as cat_id, c.parent_id as cat_parent_id,c.uri as cat_uri, op.others FROM products p INNER JOIN (select * from products_category order by category_id desc) pc ON pc.product_id = p.id INNER JOIN (select * from categories order by typeCategory desc) c ON c.id = pc.category_id LEFT JOIN  others_products op ON op.prod_id = p.id WHERE p.visibly = 1 '.(($uri != '')? 'AND c.uri = "'.$uri.'"' : '').' AND p.img != "" AND p.img != "|"  GROUP by p.id ORDER by c.id DESC, p.orders ASC,p.id DESC';// AND c.visibly = 1
			$productsAll = $db->createCommand($sql)->queryAll();

			$sql = 'SELECT count FROM categories  WHERE uri = "'.$uri.'"';
			$CheckCount = $db->createCommand($sql)->queryScalar();

            $temp_uri = '';
            foreach ($productsAll as $key => $item) {
                if ($item['id']== $id) {
                    $temp_uri = $item['cat_uri'];
                }
            }

            $sql = 'SELECT id as cat_id, parent_id as parent_id FROM categories  WHERE uri = "'.$temp_uri.'"';
            $categoryId = $db->createCommand($sql)->queryRow();

            $tempProductsAll = $productsAll;
            foreach ($tempProductsAll as $key => $item) {
                if ($item['cat_id']==$categoryId['cat_id'] ||  ($item['cat_parent_id']!=0 && $item['cat_parent_id']==$categoryId['parent_id'])) {
                    continue;
                } else {
                    unset($tempProductsAll[$key]);
                }
            }

//            echo '<pre>';
//            echo $id;
//            print_r($tempProductsAll);
//            die();


			/* get select product & prev and next */
            $prev = '';
            $next = '';

            foreach($tempProductsAll as $k => $p){
                if ($p['id'] == $id){
                    $product = $p;
                    if (isset($tempProductsAll[$k - 1]))
                        $prev = $tempProductsAll[$k - 1];
                    if (isset($tempProductsAll[$k + 1]))
                        $next = $tempProductsAll[$k + 1];
                }
            }

            $productsAllIds = array();
            foreach($productsAll as $k => $p){
                $productsAllIds[] = $p['id'];
            }


            if (!isset($product['id']))
			    throw new CHttpException(404,'Ой, такого товара нет');


           $breadcrumbs['/'] = ['title'=>'Цветы в Кинеле', 'url'=>'/'];

            if ($product['cat_parent_id'] != 0){
                $sql = 'SELECT * FROM categories where id = '.$product['cat_parent_id'];
                $parent_category = $db->createCommand($sql)->queryRow();
                $breadcrumbs[$parent_category['uri']] = ['title'=>$parent_category['name'],'url'=>'/catalog/'.$parent_category['uri'].'/'];

                $breadcrumbs[$product['cat_uri']] = ['title'=>$product['cat_name'], 'url'=>'/catalog/'.$product['cat_uri'].'/'];
            }else{
                $breadcrumbs[$product['cat_uri']] = ['title'=>$product['cat_name'], 'url'=>'/catalog/'.$product['cat_uri'].'/'];
            }

            $ref = array_pop(explode('/', Yii::app()->request->urlReferrer));
            if (!empty($ref)){
                $sql = 'SELECT *  FROM pages WHERE page_title != "" and meta_title != "" and meta_description != "" and uri = "' . $ref . '"';
                $page = $db->createCommand($sql)->queryRow();
                if (!empty($page)){
                    $breadcrumbs[$page['uri']] = ['title'=>$page['page_title'], 'url'=>'/catalog/byketi/'.$page['uri'].'/'];
                }
            }


            $breadcrumbs['last'] = ['title'=>$product['name'], 'url'=>'last'];

            if (isset($product['meta_title']) && $product['meta_title'] != ''){
				$this->pageTitle=$product['meta_title'].'';
				Yii::app()->clientScript->registerMetaTag($product['meta_description'], 'description');
				Yii::app()->clientScript->registerMetaTag($product['meta_keywords'], 'keywords');
			} else
				$this->pageTitle= $product['name'].'';


			$sql = 'SELECT fpp.id, fpp.value, fpp.price, fpp.product_id, fpp.feature_id FROM feature_product_price fpp LEFT JOIN features f ON f.id = fpp.feature_id WHERE f.visibly = 1 AND (f.price = "1" OR f.price = 1) AND fpp.product_id = '.$id.'';
			$product['features_price'] = $db->createCommand($sql)->queryAll();

			$product['features_price_name'] = '';

			/* get all features in all products in category */

			if (count($productsAllIds) > 0){
				$sql = 'SELECT f.*,  fp.value, fp.product_id  FROM features f LEFT JOIN features_products fp ON f.id = fp.feature_id WHERE f.visibly = 1 AND fp.visibly = 1 AND fp.product_id IN ('.implode(',',$productsAllIds).') ORDER by f.type';
				$featuresAll = $db->createCommand($sql)->queryAll();
			} else
				$featuresAll = array();

//            echo '<pre>';
//            print_r($featuresAll);
//            die();

			/* merge features with here products */
			$Fetures_product = array();
			foreach($featuresAll as $f) {
				if($f['price'] == 1)
					$product['features_price_name'] = $f['name'];

                if (!empty($f['value']))
				    $Fetures_product[$f['product_id']][$f['id']] = $f;
			}

//			echo '<pre>';
//			print_r($Fetures_product);
//			die();

			foreach($productsAll as $k => $p){
				if(isset($Fetures_product[$p['id']]))
					$productsAll[$k]['features'] = $Fetures_product[$p['id']];
			}
			if(isset($Fetures_product[$product['id']]))
				$product['features'] = $Fetures_product[$product['id']];
			else
				$product['features'] = array();

			/* sort all products width select product features */
			foreach($product['features'] as $f){
				$name = strtolower($f['name']);
				if ( $name == 'состав' || $name == 'pостовка' || $name == 'Состав' || $name == 'Ростовка') {
					$sort_feature = $f;
					$Subject_arr = explode('|', $f['value']);
					$Subject_arr = array_diff($Subject_arr, array(''));
					$sort_feature['patterns'] = $Subject_arr;
					if ($name == 'состав' || $name == 'Состав'){
						break;
					}
				}
			}

			/* sort to features */
			$SortProduct = array();
			//if (isset($sort_feature)){

//            echo '<pre>';
//            print_r($productsAll);
//            die();

				foreach($productsAll as $k => $p){
					if (isset($sort_feature['id']) && isset($p['features'][$sort_feature['id']])){
						$subject = $p['features'][$sort_feature['id']]['value'];
						$m = 0;
						foreach($sort_feature['patterns'] as $parent){
							preg_match('/'.$parent.'/is', $subject, $matches);
							$m += count($matches);
						}

						$SortProduct[$m.$p['id']] = $p;
					}else
						$SortProduct['0'.$p['id']] = $p;
				}
			//}
			krsort($SortProduct);


			/* sort to prices */
			//$price_start = (int)$product['price'] - (int)$product['price']*0.3;
			//$price_end = (int)$product['price'] + (int)$product['price']*0.3;
			$price_start = (int)$product['price'] - 500;
			$price_end = (int)$product['price'] + 500;
			foreach ($SortProduct as $k => $p ){
				if ((int)$p['price'] > $price_start && (int)$p['price'] < $price_end){

				}else
					unset($SortProduct[$k]);
			}

			$pages = new CPagination(count($SortProduct));
			$pages->pageSize = 16;


			/* OTHERS PRODUCTS */
			$others = explode('|',$product['others']);
			$IdsOthers = array();
			foreach($others as $oth) {
				if ($oth != ''){
					$ar = explode(':', $oth);
					$IdsOthers[] = $ar[0];
				}
			}
			if (count($IdsOthers) > 0){
				$sql = 'SELECT p.*, c.uri as cat_uri FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE  p.visibly = 1 AND p.id IN ('.implode(', ',$IdsOthers).')  GROUP by p.id ';//  c.visibly = 1 AND
				$product['others'] = $db->createCommand($sql)->queryAll();
			} else
				$product['others'] = array();

			/* product_prices */
			$sql = 'SELECT t1.price_id, t1.quantity, t2.name, t2.height,t2.cost, t2.country, t2.title FROM products_prices t1 INNER JOIN prices t2 ON t1.price_id = t2.id WHERE product_id = '.$product['id'].'';

			$product['prices'] = $db->createCommand($sql)->queryAll();
//            $product['features_price'] = $product['prices'];


            if ($product['cat_uri']) {
                if ($product['cat_uri']=='rozy') {
                    $product['price'] = $product['prices'][0]['cost'];
                }
            }


//            $newSortProduct = [];
//            foreach ($SortProduct as $key => $item) {
//                if ($item['cat_uri']=='rozy') {
//                    $sql = 'SELECT product_id, price FROM feature_product_price WHERE product_id='.$item['id'].' order by price asc';
//                    $item['price'] = $db->createCommand($sql)->queryAll();
//                    $newSortProduct[$item['id']] = $item;
//                } else {
//                    $newSortProduct[$item['id']] = $item;
//                }
//
////                $newSortProduct[$item['visible_cost']] = $item['price'];
//            }
//            $SortProduct = $newSortProduct;

            usort($SortProduct, function ($a, $b) {
                return $a['price'] > $b['price'];
            });

//                        echo '<pre>';
//            print_r($SortProduct);
//            die();

//            echo '<pre>';
//            die(print_r($breadcrumbs));

            Yii::app()->params['breadcrumbs'] = $breadcrumbs;

			if(Yii::app()->request->isPostRequest){
				$this->renderPartial('view', array(
						'product' => $product,
						'prev' => $prev,
						'next' => $next,
						'products' => $SortProduct,
						'pages' => $pages,
						'CheckCount' => $CheckCount,
				));
			}else {
				$this->render('view', array(
						'product' => $product,
						'prev' => $prev,
						'next' => $next,
						'products' => $SortProduct,
						'pages' => $pages,
						'CheckCount' => $CheckCount,
				));
			}

		}
	}

	public function actionSlice($slice='') {



//        $this->render('index', array(
//            'products' => $products,
//        ));

    }


	public function actionAdd($id)
	{
		$db = Yii::app()->db;
		$sql = 'SELECT p.id, p.name, p.price, p.img, p.visible_in_roses, c.uri as cat_uri FROM {{products}} p
				INNER JOIN {{products_category}} pc ON pc.product_id = p.id
				INNER JOIN {{categories}} c ON pc.category_id = c.id			
 				WHERE p.id = '.$id.' AND p.visibly = 1';

		$product = $db->createCommand($sql)->queryRow();

		$fid = 0;
		if(isset($_GET['fid'])){
			if (!is_numeric($_GET['fid']))
				throw new CHttpException(401,'Ошибка добавления в корзину. Такого товара не существует');


			$sql = 'SELECT price FROM feature_product_price WHERE id = '.$_GET['fid'].' AND product_id = '.$id.' order by price asc';
			$FPrice = $db->createCommand($sql)->queryScalar();

			if (!is_numeric($FPrice))
				throw new CHttpException(401,'Ошибка добавления в корзину. Такого товара не существует');

			$fid = $_GET['fid'];
		} else
			$FPrice = $product['price'];

		if (!isset($product['id']))
				throw new CHttpException(401,'Ошибка добавления в корзину. Такого товара не существует');

		$count = 1;
		if(isset($_POST['count']) && is_numeric($_POST['count'])){
			$count = $_POST['count'];
			if ((int)$count > 999)
				$count = 999;
		}


		$cart =  (string)Yii::app()->request->cookies['cart'];

		$i = 0;
		$ARR_products = explode('|', $cart);

        $checkProduct = false;

        $currentPrice = str_replace(' ', '',$_POST['current_price']);

		foreach ($ARR_products as $K => $V){
			$ARRone = explode(':', $V);
			if ((int)$ARRone[0] == (int)$product['id'] && (int)$currentPrice == (int)$ARRone[1] && (int)$fid == (int)$ARRone[3]) {
				$ARRone[2] = (int)$ARRone[2] + $count;
				$count = $ARRone[2];
				$ARR_products[$K] = implode(':', $ARRone);
				$checkProduct = true;
			}
		}

		if ($checkProduct == false)
            $ARR_products[] = $product['id'].':'.$currentPrice.':'.$_POST['count'].':'.$fid;

//                            echo '<pre>';
//        print_r($ARR_products);

		$ARR_products = array_diff($ARR_products, array(''));
		Yii::app()->request->cookies['cart'] = new CHttpCookie('cart', implode('|', $ARR_products));
		if(Yii::app()->request->isPostRequest){
			$Arrimg = explode('|', $product['img']);
			$Arrimg = array_diff($Arrimg, array(''));
			$link = '/catalog/'.$product['id'];
			$price = number_format( $FPrice, 0, ',', ' ' );

			echo CJSON::encode(array(
				'error' => 0,
				'id'=> $product['id'].$fid,
				'preview' =>
						'
							<img src="/uploads/81x84/'.current($Arrimg).'" width="50">
							<div class="preview_item_name"><a href="'.$link.'" class="blue ">'.trim(str_replace(' ', '&nbsp;', $product['name'])).'</a></div>
							<div class="preview_item_name_overlay"></div>
							<div class="preview_item_price item_price">'.$price.' <span class="b-rub">Р</span>, '.$count.' шт</div>
							<a href="/catalog/delete/'.$product['id'].'" title="удалить из корзины" class="non basket_item_del">×</a>
						',
			));
		}else {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}

	public function actionDelete($id)
	{
		$cart =  (string)Yii::app()->request->cookies['cart'];

		$i = 0;
		$check = false;
		$ARR_products = explode('|', $cart);

		$ARR_products = array_diff($ARR_products, array(''));
		$del_all_item_line = isset($_GET['all']) && $_GET['all'] == 'true' ? true : false;



		foreach($ARR_products as $K => $V){
			$Arrone = explode(':', $V);
			if ($Arrone[3] == $id && !$check && $Arrone[2] == 1 ){
				unset($ARR_products[$K]);
				$check = true;
			}elseif($Arrone[3] == $id && $del_all_item_line){
				unset($ARR_products[$K]);
				$check = true;
			}elseif($Arrone[3] == $id && (int)$Arrone[2] > 1){
				$Arrone[2] = (int)$Arrone[2] - 1;
				$ARR_products[$K] = implode(':', $Arrone);
				$check = false;
			}

		}
		Yii::app()->request->cookies['cart'] = new CHttpCookie('cart', implode('|', $ARR_products));
		if(Yii::app()->request->isPostRequest){

			echo CJSON::encode(array(
					'error' => 0,
					'check' => $check
			));
		}else {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}

	public function actionDelall()
	{
		Yii::app()->request->cookies['cart'] = new CHttpCookie('cart', '');

		if(Yii::app()->request->isPostRequest){
			echo CJSON::encode(array(
					'error' => 0,
			));
		}else {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}

	public function actionSort()
	{

		if(Yii::app()->request->isPostRequest){
			Formats::setCoockieSort($_POST);

		}else {
			throw new CHttpException(404,'Ой, такой страницы нет');
		}
	}



public function actionFormorder(){
	$form=new FormOrder;

	$this->render('formorder',array('user'=>$form));
}


}