	<link rel="stylesheet" type="text/css" href="/css/admin/redactor.css" />
	<script type="text/javascript" src="/js/admin/redactor/redactor.js"></script>
<div class="content_left">

<?php

//echo '<pre>';
//print_r($ARRmaincat_product);
//die();

$this->widget('application.modules.admin.extensions.Admin.OneCategory',array(
        'ARRmaincat' => $ARRmaincat,
        'ARRmaincat_product' => $ARRmaincat_product,
		'ARRsection' => $ARRsection,
		'ARRCategory'=> $ARRCategory,
		'ARRFeatures'=> $ARRFeatures,
		'ARRActions' => $ARRActions,
		'countProduct'=> $countProduct
));
?>
</div>
<div class="content_right">

</div>




