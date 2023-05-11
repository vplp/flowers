<div class="ias_parent catalog-page <?php echo $page == 'index' ? 'index' : '' ?>">
    <?php

    if ($page !== 'index' && $page !== 'product') {
        $this->widget('widget.CatalogForm', array());
    } ?>
    <?php
    $i = 0;

    //sorting products of season and order type
    $sort_products = $products;


    foreach ($products as $key => $product) {
        if (in_array($product['id'], $prod_season_ids) && !in_array($product['id'], $prod_order_ids)) {
            unset($products[$key]);
            array_unshift($products, $product);
        } elseif ((in_array($product['id'], $prod_order_ids) && !in_array($product['id'], $prod_season_ids)) || (in_array($product['id'], $prod_order_ids) && in_array($product['id'], $prod_season_ids))) {
            unset($products[$key]);
            $products[] = $product;
        }
//        usort($product['price'], "value_function_asc");
    }
	
	//товары в корзине
	$cart = (string)Yii::app()->request->cookies['cart'];
	$cartProducts = explode('|', $cart);

	foreach ($cartProducts as $cp) {
		$ARRone = explode(':', $cp);
		$productId = (int)$ARRone[0];
		$cartProductIds[$productId] = $productId;
	}
	
    foreach ($products as $product) { ?>
        <?php
		/**
        if (!$product['prices']) {
            $product['prices'] = Yii::app()->params['products_global'][$i]['prices'];
        }
		*/
        $i++;
        if ($i == 8 && $page == 'product') break;

        $Arrimg = explode('|', $product['img']);

        $Arrimg = array_diff($Arrimg, array(''));

        ?>
        <div class="item ani_box aloading ias_child a_end" <?php if (Yii::app()->user->getState('auth')) echo 'id="item_' . $product['id'] . '"' ?>>
            <?php if ($product['hot'] == 1) echo '<span class="hot_item"></span>' ?>
            <!--<a href="/catalog/<?php //echo $product['cat_uri']?>/<?php //echo $product['id']?>">
                        <img src="/uploads/300x300/<?php //echo current($Arrimg);?>" class=" ">
                    </a> -->
            <a href="/catalog/<?php echo $product['id'] ?>">
                <img src="/uploads/300x300/<?php echo current($Arrimg); ?>" class=" " loading="lazy">
            </a>

            <input type="hidden" class="sortprice" value="<?php echo $product['price'] ?>">

                <input type="hidden" class="sorttype" value="<?php //echo $product['feature_value'] ?>">
                <input type="hidden" class="sortorder" value="<?php echo $product['orders'] ?>">
                <input type="hidden" data-sort="category" value="<?php echo $product['cat_id'] ?>">

            <div class="item_desc">
                <div class="item_desc-name">
                    <a class="blue" href="/catalog/<?php echo $product['id'] ?>"><?php echo $product['name'] ?></a>
                </div>

                <?php if(!empty($product)) { ?>
                    <?php if ($product['price']) { ?>
                        <span class="item_price"><?php echo number_format(($product['price']), 0, ',', ' '); ?>
                            <span class="b-rub">Р</span>
                        </span>
                    <?php } ?>
                <?php } ?>

                <?php if ($page !== 'index') {
                    /*
					//Код не актуален
					$sql = 'SELECT * FROM feature_product_price WHERE product_id = ' . $product['id'] . ' AND price > 0 ORDER BY feature_product_price.price ASC LIMIT 1';
                    $db = Yii::app()->db;
                    $product['features_price'] = $db->createCommand($sql)->queryAll();

                    $fid = '';
                    foreach ($product['features_price'] as $K => $FP) {
                        $fid = $FP['id'];
                    }*/

                    $checkProduct = !empty($cartProductIds[(int)$product['id']]);

                    ?>
                    <div class="item_add_to_cart d-flex">
                        <a class="<?php echo $checkProduct ? 'in_cart' : 'addtocart'; ?>"
                           href="<?php echo $checkProduct ? '/cart' : '/catalog/add/' . $product['id'] . (($fid != '') ? '?fid=' . $fid : ''); ?>"><?php echo $checkProduct ? 'В корзине' : 'В корзину'; ?></a>
                    </div>
                <?php } ?>

            </div>
        </div>
        <?php if ($page == 'index' && ($i > 5 || $i >= $productsCount)) { ?>
            <div class="item products_allButton">
				<span class="products_allButton_text">
					Показать все
					<a href="<?php echo $catUri; ?>"
					   class="blue"><?php echo $productsCount ?>&nbsp;наименовани<?php echo Formats::end_eyai($productsCount) ?></a>
				</span>
                <a href="<?php echo $catUri; ?>" class="products_allButton_arrow"></a>
            </div>
            <?php break; ?>
        <?php } ?>
    <?php } ?>
    <div class="br"></div>

</div>

<div class="br"></div>
<?php if (isset($pages)): ?>
    <div class="ias_pager">
        <?php
        $this->widget('CLinkPager', array(
            'pages' => $pages,
        ));
        ?>
    </div>
<?php endif; ?>