<div class="ias_parent catalog-page <?php echo $page == 'index' ? 'index' : ''?>">
<?php

if($page !== 'index' && $page !== 'product'){
	$this->widget('widget.CatalogForm',array(
 ));
} ?>
<?php
$i = 0;

//sorting products of season and order type
$sort_products = $products;

//echo '<pre>';
//print_r($pages);
//die();

foreach($products as $key => $product){
	if(in_array($product['id'], $prod_season_ids) && !in_array($product['id'], $prod_order_ids)){
		unset($products[$key]);
		array_unshift($products, $product);
	}
	elseif((in_array($product['id'], $prod_order_ids) && !in_array($product['id'], $prod_season_ids)) || (in_array($product['id'], $prod_order_ids) && in_array($product['id'], $prod_season_ids))){
		unset($products[$key]);
		$products[] = $product;
	}
}
//sorting products of season and order type end


//echo "<pre>";
//print_r($products);
//die();

foreach( $products as $product) :
				$i++;
				if($i == 8 && $page == 'product') break;

				$Arrimg = explode('|', $product['img']);
				$Arrimg = array_diff($Arrimg, array(''));

				?>

				<div class="item ani_box aloading ias_child " <?php if (Yii::app()->user->getState('auth')) echo 'id="item_'.$product['id'].'"' ?>>
					<?php if ($product['hot'] == 1) echo '<span class="hot_item"></span>'?>
					<!--<a href="/catalog/<?php //echo $product['cat_uri']?>/<?php //echo $product['id']?>">
                        <img src="/uploads/300x300/<?php //echo current($Arrimg);?>" class=" ">
                    </a> -->
                    <a href="/catalog/<?php echo $product['id']?>">
                        <img src="/uploads/300x300/<?php echo current($Arrimg);?>" class=" ">
                    </a>

                    <input type="hidden" class="sortprice" value="<?php echo $product['price']?>">
					<?php if (isset($product['feature_value'])) :?>
						<input type="hidden" class="sorttype" value="<?php echo $product['feature_value']?>">
						<input type="hidden" class="sortorder" value="<?php echo $product['orders']?>">
						<input type="hidden" data-sort="category" value="<?php echo $product['cat_id']?>">
					<?php endif;?>
					<div class="item_desc">
						<div class="item_desc-name">
							<!--<a class="blue" href="/catalog/<?php //echo $product['cat_uri']?>/<?php //echo
                              // $product['id']?>"><?php //echo $product['name']?></a>-->
                            <a class="blue" href="/catalog/<?php echo $product['id']?>"><?php echo $product['name']?></a>
						</div>
						<span class="item_price"><?php echo number_format( ($product['price']), 0, ',', ' ' );?> <span class="b-rub">Р</span></span>

						<?php if ($page !== 'index') {


							$sql = 'SELECT * FROM feature_product_price WHERE product_id = '.$product['id'].' AND price > 0 ORDER BY feature_product_price.price ASC LIMIT 1';
							$db = Yii::app()->db;
							$product['features_price'] = $db->createCommand($sql)->queryAll();

							$fid = '';
							foreach($product['features_price'] as $K => $FP){
								$fid = $FP['id'];
							}

							$cart =  (string)Yii::app()->request->cookies['cart'];
							$ARR_products = explode('|', $cart);

							$checkProduct = false;

								foreach ($ARR_products as $K => $V){
									$ARRone = explode(':', $V);
									if ((int)$ARRone[0] == (int)$product['id']) {
										$checkProduct = true;
										break;
									}else{
										$checkProduct = false;
									}
								}
								$product_in_cart = $checkProduct ? 'in_cart' : 'addtocart';
								$product_in_cart_text = $checkProduct ? 'В корзине' : 'В корзину';
								$fid = ($fid != '') ? '?fid='.$fid : '';
								$product_is_cart_link = $checkProduct ? '/cart' : '/catalog/add/' . $product['id'] . $fid;
							?>
						<div class="item_add_to_cart d-flex">
							<a class="<?php echo $product_in_cart;?>" href="<?php echo $product_is_cart_link; ?>"><?php echo $product_in_cart_text; ?></a>
						</div>
						<?php } ?>

					</div>
				</div>
				<?php if ($page == 'index' && ($i > 5 || $i>= $productsCount)) { ?>
					<div class="item products_allButton">
						<span class="products_allButton_text">
							Показать все
							<a href="<?php echo $catUri; ?>" class="blue"><?php echo $productsCount?>&nbsp;наименование<?php echo Formats::end_eyai($productsCount)?></a>
						</span>
						<a href="<?php echo $catUri; ?>" class="products_allButton_arrow"></a>
					</div>
				<?php break; } ?>
		<?php
			endforeach;
		?>
<div class="br"></div>

</div>

<div class="br"></div>
<?php if (isset($pages)):?>
<div class="ias_pager">
	<?php
 			$this->widget('CLinkPager', array(
 				'pages'=>$pages,
 			));
		?>
</div>
<?php endif;?>