<style>
.any_bield { margin:0 !important;}
</style>

<?php
//        echo "<pre>";
//        print_r($products);
//        die();

$db = Yii::app()->db;

if ($_GET['slice']) {
    $have_slice = true;
    $sql_label_desc = 'SELECT label_description FROM pages WHERE uri="'.$_GET['slice'].'"';
    $page_label_desc = $db->createCommand($sql_label_desc)->queryAll();
    $sql_main_desc = 'SELECT main_description FROM pages WHERE uri="'.$_GET['slice'].'"';
    $page_main_desc = $db->createCommand($sql_main_desc)->queryAll();
} elseif ($_GET['uri']) {
    $sql_label_desc = 'SELECT label_description FROM categories WHERE uri="'.$_GET['uri'].'"';
    $page_label_desc = $db->createCommand($sql_label_desc)->queryAll();
    $sql_main_desc = 'SELECT description FROM categories WHERE uri="'.$_GET['uri'].'"';
    $page_main_desc = $db->createCommand($sql_main_desc)->queryAll();
}
?>

<div class="wrap_sizes " style="">
	<?php

            function value_function_asc($a, $b)
            {
                return ($a['cost'] > $b['cost']);
            }

//                                                echo '<pre>';
//                                                print_r($C);
//                                                die();

    $this->renderPartial('../catalog/_items_block', array(
			'products' => $products,
			'category' => $category,
			'categories' => $categories,
			'label' => $label,
			'total' => $total,
			'class' => 'border_none',
			'sort' => true,
			'pages' => $pages,
			'page' => $page,
			'priceRanges' => $priceRanges,
			'prod_season_ids' => $prod_season_ids,
			'prod_order_ids' => $prod_order_ids
	));	?>

    <?php if ($have_slice) :?>
        <div class="wrap_block  description_block " style="min-height: 0px;">
            <div class="block_label"><?php echo $page_label_desc[0]['label_description']; ?></div>
            <div style="margin-top:20px;max-width:720px;"><?php echo $page_main_desc[0]['main_description']; ?></div>
        </div>
    <?php else :?>
		<div class="wrap_block  description_block " style="min-height: 0px;">
			<div class="block_label"><?php echo $C['label_description']?></div>
			<div style="margin-top:20px;max-width:720px;"><?php echo $C['description']?></div>
		</div>
	<?php endif;?>
	<?php
		//pinterest widget script в разделе свадебных букетов
		if ($category && $category['id'] == 74) {
			echo '<script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
		}
	?>
</div>

<pre style="display: none;">
<?php //print_r($products)?>
</pre>