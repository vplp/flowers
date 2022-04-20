<?php

class alertsController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex($cat_uri = '') {
		$this->redirect('/admin/alerts/list/',array());
	}
	
	public function actionList($cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		$alerts = $this->module->GetAllAlerts();
	
		$this->render('list',array(
			'alerts' => $alerts,	
			)
		);	
	}
	
	public function actionEdit($id) {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		$this->render('edit', array(
			'alert' => $this->module->GetAlertWithAll($id),
			)
		);
	}

	public function actionNew() {
		$db = Yii::app()->db;
	
		$sql = 'INSERT INTO alerts (name) VALUES ("Новый alert")';
		$db->createCommand($sql)->execute();
		$this->redirect('/admin/'.$this->id.'/edit/'.$db->getLastInsertId('alerts').'?new=1',array());
	}
}
