<?php

class CategoriesController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex($cat_uri = '') {

        if(\Yii::app()->request->isAjaxRequest){
            if ($_POST['stat'] == 'edit_subcat') {
//                echo '<pre>';
//                print_r($_POST);
//                return true;
                $db = Yii::app()->db;
//                $sql = 'INSERT INTO categories (parent_id, name, uri, meta_title, page_title, meta_keywords, meta_description) VALUES (\''.$_POST['parent_id'].'\', \''.$_POST['page_title'].'\', \''.$_POST['uri'].'\', \''.$_POST['meta_title'].'\', \''.$_POST['page_title'].'\', \''.$_POST['keyw'].'\', \''.$_POST['desc'].'\')';
//                $db->createCommand($sql)->execute();

                $sql = 'UPDATE categories SET
                        parent_id = '.$_POST['parent_id'].'
                        
                        WHERE id ='.$_POST['cat_id'];
                $cmd = $db->createCommand($sql);
                $cmd->execute();
            }
        }

		$this->redirect('/admin/categories/list/',array());
	}	
	
	public function actionList($cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());	
		
			$this->render('list',array(
			 		'ARRitems' => $this->module->GetAllCategories(),
					'ARRsection' => $this->module->GetAllSections(),
			 	)
			 );
	}
	
	public function actionEdit($id) {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
			$ARRCategory = $this->module->GetCategoryWithAll($id);

//        echo '<pre>';
//        print_r($this->module->GetMainCategories());
//        die();
		
			$this->render('edit',array(
                    'ARRmaincat' =>$this->module->GetMainCategories(),
//                    'SubCatId' => $_POST['cat_id'],
                    'ARRmaincat_product' =>$this->module->GetMainCategoriesId($id),
					'ARRCategory' => $ARRCategory,
					'ARRsection' => $this->module->GetAllSections(),
					'ARRFeatures' => $this->module->GetAllFeatures(),
					'ARRActions' => $this->module->GetAllActions(),
					'countProduct' => count($this->module->GetCategoryWhithAllProducts($id)),
			)
			);


	}
	
	public function actionNew() {
		$db = Yii::app()->db;
	
		$sql = 'SELECT id FROM categories Order by id DESC';
		$newNum = (int)$db->createCommand($sql)->queryScalar() + 1;
	
		$sql = 'INSERT INTO categories (name,uri,visibly,section_id) VALUES ("Новая категрия'.$newNum.'", "category'.$newNum.'",1,1)';
		$db->createCommand($sql)->execute();
	
		$this->redirect('/admin/'.$this->id.'/edit/'.$db->getLastInsertId('categories').'?new=1',array());
	}
}
