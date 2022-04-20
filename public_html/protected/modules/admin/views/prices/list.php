<div class="content_left">
<?php $this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'name', 'label'=> 'Название', 'link' => true, 'style' => 'text-align:left'),
				array('name'=> 'country', 'label'=> 'Страна', 'link' => false, 'style' => 'text-align:left'),
				array('name'=> 'height', 'label'=> 'Высота', 'link' => false, 'style' => 'text-align:left'),
				array('name'=> 'cost', 'label'=> 'Цена', 'link' => false, 'style' => 'text-align:left'),
				array('name'=> 'season', 'label'=> 'Сезонный', 'style' => 'text-align:left'),
				array('name'=> 'order', 'label'=> 'Под заказ', 'style' => 'text-align:left'),
		),
		
		'id_table' => 'prices',
		'class_table' => 'small_table',
		'table_label' => 'Цены',
		'field_sort' => true,
		'tr_sort' => false,
		'empty_message' => 'Цен нет',
		'panel' => true,
)); ?>
<br>
<a href="/admin/prices/new/" class="green_btn btn_def2">Добавить цену</a>
</div>
<div class="content_right">
	
</div>
<div class="br"></div>

