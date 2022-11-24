<?php

class PricesController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex() {
		$this->redirect('/admin/prices/list/',array());
	}	
	
	public function actionList() {
		if (!Yii::app()->user->getState('auth'))
		    $this->redirect('/',array());

		$this->render('list',array(
		 		'ARRitems' => $this->module->GetAllPrices(),
		 		'countries' => $this->module->GetCountries(),
		 	)
		);
	}
	
	public function actionNew() {
		$db = Yii::app()->db;
		
		$sql = 'SELECT id FROM prices Order by id DESC';
		$newNum = (int)$db->createCommand($sql)->queryScalar() + 1;
				
		$sql = 'INSERT INTO prices (name) VALUES ("Страница '.$newNum.'")';
		$db->createCommand($sql)->execute();
		$id = $db->getLastInsertId('prices');
		/*		
		$sql = 'SELECT id FROM features  WHERE tocart != "1" ';
		$features = $db->createCommand($sql)->queryAll();
		foreach($features as $K => $feature){
		
			$db = Yii::app()->db;
			$sql = 'INSERT  INTO  features_products (feature_id, visibly, product_id) VALUES (\''.$feature['id'].'\',\'1\',\''.$id.'\')';
			$cmd = $db->createCommand($sql)->execute();
		}
		*/
		$this->redirect('/admin/'.$this->id.'/edit/'.$id.'?new=1',array());
	}
	
	public function actionEdit($id) {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
				
		$ARRprice= $this->module->GetPriceWithAll($id);
	
		$this->render('edit',array(
				'ARRprice' => $ARRprice,
				'flowers' => $this->module->GetFlowers(),
				'sizes' => $this->module->GetSizes(),
				'countries' => $this->module->GetCountries(),
			)
		);
	}
}
