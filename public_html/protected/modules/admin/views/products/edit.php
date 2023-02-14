<link rel="stylesheet" type="text/css" href="/css/jcrop/jquery.Jcrop.css" />
<script type="text/javascript" src="/js/jcrop/jquery.Jcrop.js"></script>

<div class="content_left">
<?php
//if ($_SERVER['REMOTE_ADDR'] =='109.124.222.56') {
//	echo '<pre>';
//	//print_r($ARRitem);	print_r($ARRcat);	print_r($ARRaction);	print_r($Catalog);
//	echo '</pre>';
//}

//	echo '<pre>';
//	print_r($ARRholiday);
//	die();

//        echo $holidayid;
//        die();

$this->widget('application.modules.admin.extensions.Admin.OneProduct',array(
		'ARRitem'=> $ARRitem,
        'ARRmaincat'=> $ARRmaincat,
		'ARRmaincat_product' => $ARRmaincat_product,
		'ARRholidays' => $ARRholidays,
		'ARRcat'=> $ARRcat,
		'ARRaction'=> $ARRaction,
		'features' => $features,
		'prices' => $prices,
		'holidayid' => $holidayid
));
?>
</div>
<div class="content_right"> 
<?php 
	$this->widget('application.modules.admin.extensions.Admin.CatalogMenu',array(
			'Catalog'=> $Catalog,
			'select_cat'=> $id,
	));
?>
</div>
<div class="br"></div>
<div id="addimg_other_popup" class="addimg_other_popup orders_popup">
	<div class="popup_label">Выберите подходящий товар</div>
	<div class="popup_del"><img src="/img/big_del.jpg"></div>
	<div class="br"></div>
	<div class="popup_content"></div>
	<div class="popup_wait" id="popup_wait"></div>
</div>