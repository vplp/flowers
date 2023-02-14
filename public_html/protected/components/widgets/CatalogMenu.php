<?php

class CatalogMenu extends CWidget
{
    public $cat = false;


    public function init()
    {
        $db = Yii::app()->db;
        $sql = 'SELECT * FROM {{categories}} c WHERE c.visibly = 1 AND c.hidden = 0 Group by c.id ORDER BY c.orders';
        $categories = $db->createCommand($sql)->queryAll();

        $sql = 'SELECT * FROM {{pages}} c WHERE menu_sort > 0 ORDER BY menu_sort';
        $pages = $db->createCommand($sql)->queryAll();

        /*
        $this->widget('widget.CatalogMenu',array(
            'cat' => Yii::app()->request->url,
        ));
        */

//        echo '<pre>';
//        print_r($categories);
//        die();
        $Catalog = [];
        foreach ($categories as $cat) {
            $Catalog[$cat['id']] = $cat;
        }

        $count_products_in_category = 0;

        foreach ($Catalog as $cat){
            $count_products_in_category = 0;
            if ($cat['parent_id'] > 0){
                $sql = 'SELECT count(*) as count FROM products_category WHERE category_id='.$cat['id'];
                $count_products_in_category = $db->createCommand($sql)->queryScalar();

                $Catalog[$cat['parent_id']]['submenu'][$cat['id']] = $cat;
                $Catalog[$cat['parent_id']]['submenu'][$cat['id']]['count_products'] = $count_products_in_category;
                unset($Catalog[$cat['id']]);
            }
        }
//        echo '<pre>';
//        print_r($Catalog);
//        die();

        $this->render('catalog_menu', array(
            'Catalog' => $Catalog,
            'cat' => $this->cat,
            'pages' => $pages,
        ));
    }


}
