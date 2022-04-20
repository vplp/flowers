
<div class="content_left">
<?php
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $alerts,
		'ARRfields' => array(
			array('name'=> 'name', 'label'=> 'Название' , 'link' => true,  'style' => 'text-align:left;'),
		),
		
		'id_table'=> 'alerts',
		'class_table'=> 'small_table',
		'table_label'=> 'Алерты',
		'field_sort'=> true,
		'tr_sort'=> false,
		'empty_message'=> 'Алертов нет',
		'count_labels'=> array('алерт','алерта','алертов'),
		'panel' => false,
));

?>
<br>
<a href="/admin/alerts/new/" class="green_btn btn_def2">Добавить алерт</a>
</div>
<div class="content_right">
	
</div>
<div class="br"></div>
