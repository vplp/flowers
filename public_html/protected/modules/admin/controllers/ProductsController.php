<?php

class ProductsController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';

	public function actionIndex($cat_uri = '') {
		$this->redirect('/admin/products/list/',array());
	}	
	
	public function actionList($id = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		$products = $this->module->GetAllProducts();
		
			// foreach ($products as $key => $value) {
				// $feature_price_arr = $this->module->GetProductFeaturePrice($value['id']);
				// $feature_price = 9999999;

				// foreach($feature_price_arr['feature_price']['prices'] as $price){
					// if(isset($price['price']) && $price['price'] < $feature_price) $feature_price = $price['price'];
				// }
				// if($feature_price == 9999999) $feature_price = $value['price'];
				// $products[$key]['feature_price'] = $feature_price;

			// }

		if ($id == ''){
			$this->render('list',array(
			 		'ARRitems' => $products,
			 		'ARRcat' =>$this->module->GetAllCategories(),
					'ARRaction' => $this->module->GetAllActions(),
					'Catalog' => $this->module->GetSectionsWithCategory(),
					'id' => $id
			 	)
			 );
		} else {

			$this->render('list',array(
					'ARRitems' => $this->module->GetCategoryWhithAllProducts($id),
					'ARRcat' =>$this->module->GetAllCategories(),
					'ARRaction' => $this->module->GetAllActions(),
					'Catalog' => $this->module->GetSectionsWithCategory(),
					'id' => $id
						
				)
			);
		}
	}
	
	public function actionEdit($id = '', $cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());

		if ($cat_uri == 'new') {
			
		} elseif ($id != '') {
			
			$ARRitem = $this->module->GetProductWhithAll($id);

//			echo '<pre>';
//			print_r($ARRitem);
//			die();
			
			$db = Yii::app()->db;
			$sql = 'SELECT id FROM features  WHERE tocart != "1"';
			$features = $db->createCommand($sql)->queryAll();

			$this->render(
				'edit',
				array(
					'ARRitem' => $ARRitem,
                    'ARRmaincat' =>$this->module->GetMainCategories(),
                    'ARRholidays' =>$this->module->GetHolidays(),
                    'ARRmaincat_product' =>$this->module->GetMainCategoriesId($id),
                    'holidayid' =>$this->module->GetHolidayId($id),
					'ARRcat' =>$this->module->GetAllCategories(),
					'ARRaction' => $this->module->GetAllActions(),
					'Catalog' => $this->module->GetSectionsWithCategory(),
					'features' => $features,
					'prices' => $this->module->GetAllPrices(),
					'id' => 'aaa',
				)
			);

		}
	}
	
	public function actionNew() {
		$db = Yii::app()->db;
		
		$sql = 'SELECT id FROM products Order by id DESC';
		$newNum = (int)$db->createCommand($sql)->queryScalar() + 1;
				
		$sql = 'INSERT INTO products (name, price, visibly) VALUES ("Букет '.$newNum.'",0,1)';
		$db->createCommand($sql)->execute();
		$id = $db->getLastInsertId('products');
				
		$sql = 'SELECT id FROM features  WHERE tocart != "1" ';
		$features = $db->createCommand($sql)->queryAll();
		foreach($features as $K => $feature){
		
			$db = Yii::app()->db;
			$sql = 'INSERT  INTO  features_products (feature_id, visibly, product_id) VALUES (\''.$feature['id'].'\',\'1\',\''.$id.'\')';
			$cmd = $db->createCommand($sql)->execute();
		}
		
		$this->redirect('/admin/'.$this->id.'/edit/'.$id,array());//.'?new=1'
	}

    public function actionProductRose($id = '')
    {
        if (!empty($id)){
            $db = Yii::app()->db;
            $sql = "UPDATE `products` SET `visible_in_roses` = '1' WHERE `products`.`id` = ".$id;
            $db->createCommand($sql)->execute();
            return true;
        }
        return false;
	}

}
