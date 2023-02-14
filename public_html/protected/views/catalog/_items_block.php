<?php
	$Cockiesort = Formats::getCoockieSort();

    $db = Yii::app()->db;
$fp = $db->createCommand("select fp.value as val, fp.cat_id
                             FROM features_products as fp, products as p, products_category as pc 
                             WHERE fp.feature_id = 10 and fp.value != '' and fp.product_id = p.id and p.visibly = 1 and fp.product_id = pc.product_id and pc.category_id = 84")->queryAll();

    $tmp = [];
    foreach ($fp as $arr){
        $new_arr = explode('|', $arr['val']);
        foreach ($new_arr as $n){
            $tmp[trim($n)] = trim($n);
        }
    }

    $flowersInFilter = $db->createCommand("SELECT * FROM flowers where have_sef=1")->queryAll();

    $flowersInFilter = array_filter($flowersInFilter, function ($data) use ($tmp){
        foreach ($tmp as $item) {
            $pos = strpos($item, $data['name']);
            if ($pos !== false)
                return $data['name'];
        }
    });

    if ($_GET['slice'])
        $isPromo = $db->createCommand("SELECT visible_in_menu FROM flowers WHERE uri = '".$_GET['slice']."'")->queryScalar();


//    echo '<pre>';
//    print_r($_GET);
//    die();

    $mono_byket = $db->createCommand('select * from pages where is_mono_byket=1')->queryRow();

    if (!empty($_GET['uri'])) {
        $sql = 'SELECT * FROM categories c WHERE c.visibly = 1 AND c.hidden = 0 Group by c.id ORDER BY c.orders';
        $categories = $db->createCommand($sql)->queryAll();

        $Catalog = [];
        $parent_cat = [];
        $subcategory_arr = [];
        foreach ($categories as $cat){
            $Catalog[$cat['id']] = $cat;
            if ($cat['id'] == $category['parent_id'])
                $parent_cat = $cat;
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

        foreach ($Catalog as $cat) {
            foreach ($cat['submenu'] as $submenu)
            if (($cat['submenu'] || $cat['parent_id']!=0) && ($cat['uri']==$_GET['uri'] || $submenu['uri']==$_GET['uri'])) {

//                if ($cat['parent_id']!=0) {
//
//                }

                $subcategory_arr = $cat['submenu'];
            }
        }

        $flower_uri = explode('/', Yii::app()->request->requestUri)[3];
		
		
        if ($page) {
			$seoPage['text'] = $page['text'];
			$seoPage['label_description'] = $page['label_description'];
			$seoPage['main_description'] = $page['main_description'];
			$seoPage['subtitle'] = $page['subtitle'];
		} elseif ($_GET['slice']) {
//            $have_slice = true;
            $sql_text = 'SELECT * FROM pages WHERE uri="'.$_GET['slice'].'"';
            $page = $db->createCommand($sql_text)->queryRow();
			
			$seoPage['text'] = $page['text'];
			$seoPage['label_description'] = $page['label_description'];
			$seoPage['main_description'] = $page['main_description'];
			$seoPage['subtitle'] = $page['subtitle'];
			
            // $sql_label_desc = 'SELECT label_description FROM pages WHERE uri="'.$_GET['slice'].'"';
            // $page_label_desc = $db->createCommand($sql_label_desc)->queryAll();

            // $sql_main_desc = 'SELECT main_description FROM pages WHERE uri="'.$_GET['slice'].'"';
            // $page_main_desc = $db->createCommand($sql_main_desc)->queryAll();

            // $sql_subtitle = 'SELECT subtitle FROM pages WHERE uri="'.$_GET['slice'].'"';
            // $subtitle = $db->createCommand($sql_subtitle)->queryScalar();

        } elseif ($_GET['uri']) {
			//echo '<pre>';print_r($category);exit;
			$seoPage['text'] = $category['text'];
			$seoPage['subtitle'] = $category['subtitle'];
			
            // $sql_text = 'SELECT text FROM categories WHERE uri="'.$_GET['uri'].'"';
            // $page_text = $db->createCommand($sql_text)->queryAll();

            // $sql_subtitle = 'SELECT subtitle FROM categories WHERE uri="'.$_GET['uri'].'"';
            // $subtitle = $db->createCommand($sql_subtitle)->queryScalar();
        }
    }

?>

<div style="<?php if (Yii::app()->user->getState('edit')) echo 'position:static !important';?>" class="wrap_block resize_block <?php if ($Cockiesort['smbig'] == 'big') echo 'big_block'?> <?php if (Yii::app()->user->getState('auth')) echo 'sortable' ?>   <?php if (isset($class)) echo $class; ?>">
		<div class="block_label-wrap d-flex">
			<h1 class="my block_label aloading"><?php echo $label;?><?php if (!isset($class)) echo '<sup>&nbsp;'.count($products).'штук</sup>'?></h1>
			<?php if(!empty($seoPage['subtitle'])) {?>
                <div class="availability_panel"><?php echo $seoPage['subtitle'];?></div>
            <?php }?>
		</div>

		<?php if (isset($sort) && $sort) :

		//EA($Cockiesort);
		?>

		<?php if ($category) { ?>
                <div class="categoryText">
                    <?php echo $seoPage['text'];?>
                </div>
			<div style="position:relative;">
				<div class="sm_big_chahge aloading">
					<div class="one_sort_label">Вид каталога</div>
					<div class="s_big_img <?php if ($Cockiesort['smbig'] == 'big') echo 'select'?>"></div>
					<div class="s_sm_img <?php if ($Cockiesort['smbig'] == 'sm') echo 'select'?>"></div>
				</div>
                <?php

                $Arrvar = explode('|', $category['feature_variants']);

//                echo '<pre>';
//                print_r($category);
//                die();

                ?>
				<div class="sort_product block_label aloading">
					<?php if ($category['typeCategory']!=0 ):?>
					    <?php if (empty($subcategory_arr) and $category['id'] !=84):?>
                            <?php if($category['id'] !=74) {?>
                                <div id="sort_type" class="one_sort">

                                    <div class="one_sort_label"><?php echo $category['feature_name']?></div>

                                    <div class="one_sort_label_variants">
                                        <a href="/catalog/<?php echo $category['uri'];?>/" class="blue" data-subtype="flowertype">Все</a>

                                        <?php if($category['id']!=73) { ?>
                                            <?php foreach ($flowersInFilter as $flower): ?>
                                                <a href="/catalog/<?php echo $category['uri'];?>/<?php echo $flower['uri'];?>" class="blue <?= ($flower_uri == $flower['uri'])? 'select' : '' ?>" data-cat-id="<?php echo $category['id'];?>" data-subtype="flowertype"><?php echo $flower['name']?></a>
                                            <?php endforeach;?>
                                        <?php } else {?>

                                            <?php foreach ($Arrvar as $var):?>
                                                <a href="" class="blue" data-subtype="flowertype"><?php echo $var?></a>
                                            <?php endforeach;?>
                                        <?php }?>

                                        <!--                            <a href="/catalog/byketi/nazakaz" class="blue hide-filter-item" data-subtype="flowertype">На заказ</a>-->
                                        <!--                            <a href="/catalog/byketi/gotovie" class="blue hide-filter-item" data-subtype="flowertype">Готовые</a>-->

                                    </div>
                                </div>
                            <?php }?>
                        <?php else: ?>

                            <?php if($_GET['slice']!=$mono_byket['uri']) {?>
                                <div class="one_sort">

                                    <?php if(!empty($subcategory_arr) && $category['id'] !=84) {?>
                                        <div class="one_sort_label" style="opacity: 0;"><?php echo $category['feature_name']?></div>
                                    <?php } else {?>
                                        <div class="one_sort_label"><?php echo $category['feature_name']?></div>
                                    <?php }?>

                                    <div class="one_sort_label_variants one_sort_type">
                                        <a href="/catalog/<?= !empty($parent_cat['uri']) ? $parent_cat['uri'] : $category['uri'] ?>/" class="blue" data-subtype="flowertype">Все</a>

                                        <?php if(!empty($subcategory_arr)) { ?>
                                            <?php foreach ($subcategory_arr as $item):?>
                                                <?php if($item['count_products']>0) {?>
                                                    <a href="/catalog/<?php echo $item['uri']?>" class="blue <?= ($_GET['uri'] == $item['uri'])? 'select' : '' ?>" data-subtype="noflowertype"><?php echo $item['name']?></a>
                                                <?php }?>
                                            <?php endforeach;?>
                                        <?php } elseif($category['id']!=73) { ?>
                                            <?php foreach ($flowersInFilter as $flower): ?>

                                                <a href="/catalog/<?php echo $category['uri'];?>/<?php echo $flower['uri'];?>" class="blue <?= ($flower_uri == $flower['uri'])? 'select' : '' ?>" data-cat-id="<?php echo $category['id'];?>" data-subtype="flowertype"><?php echo $flower['name']?></a>

                                            <?php endforeach;?>
                                        <?php } elseif($category['id']==73) {?>

                                            <?php foreach ($Arrvar as $var):?>
                                                <a href="" class="blue " data-subtype="flowertype"><?php echo $var?></a>
                                            <?php endforeach;?>
                                        <?php }?>

                                        <a href="/catalog/byketi/nazakaz" class="blue hide-filter-item <?= ($_GET['slice'] == "nazakaz")? 'select' : '' ?>" data-subtype="flowertype">На заказ</a>
                                        <a href="/catalog/byketi/gotovie" class="blue hide-filter-item <?= ($_GET['slice'] == "gotovie")? 'select' : '' ?>" data-subtype="flowertype">В наличии</a>

                                    </div>

                                </div>
                            <?php }?>

                        <?php endif;?>

                    <?php
//                        echo '<pre>';
//                        print_r($category);
//                        die();
                        ?>

                        <div id="sort_status" class="one_sort hide-filter-item">
<!--                            <a class="blue --><?//= ($_GET['slice'] == "nazakaz") ? 'select' : '' ?><!--">На заказ</a>-->
<!--                            <a class="blue --><?//= ($_GET['slice'] == "gotovie") ? 'select' : '' ?><!--">В наличии</a>-->
                        </div>


					<?php endif;?>
					<?php if ( isset($category['count']) && $category['count'] != 1 && !empty($priceRanges)) { ?>
					<div id="sort_price" class="one_sort">
						<div class="one_sort_label">Цена</div>
						<div class="one_sort_label_variants price">
							<a href="" data-price="" class="blue select" >Любая</a>
							<?php foreach ($priceRanges as $priceRange) { ?>
								<a href="" data-price="<?php echo $priceRange['prices']?>" class="blue " ><?php echo $priceRange['title']?> <span class="b-rub">Р</span></a>
							<?php } ?>
							<!--
							<a href="" data-price="1000" class="blue " >до&nbsp;1&nbsp;000</a>
							<a href="" data-price="1000-3000" class="blue">1&nbsp;000&ndash;3&nbsp;000</a>
							<a href="" data-price="3000-6000" class="blue " >3&nbsp;000&ndash;6&nbsp;000</a>
							-->
<!--							<span>-->
<!--                                <span class="b-rub">Р</span>-->
<!--							</span>-->

						</div>
					</div>
					<?php } ?>
					<div  id="sort_sort" class="one_sort sort_sort">
						<div class="one_sort_label">Сортировка</div>
						<div class="one_sort_label_variants">
							<a href="" data-sort="asc" class="blue" >По возрастанию</a>
							<a href="" data-sort="desc" class="blue" >По убыванию</a>
						</div>
					</div> 
					<div id="sort_price" class="one_sort sort_name">
						<div class="one_sort_label">Поиск по названию</div>
						<div class="one_sort_label_variants price">
						<form class="searchByName">
							<input name="searchByName" type="text" placeholder="Ввести название" maxlength="50" autocomplete="off">
						</form>
						</div>
					</div>
					<div class="br"></div>
				</div>
			</div>
		<?php } ?>
		
		<?php $this->widget('widget.Alert')->get(); ?>
		<?php endif;?>

    <?php
//        echo '<pre>';
//        print_r($products);
//        die();
    ?>

        <div class="catalog_empty">Нет товаров</div>
			<div id="products_line" class="products_line " data-category="<?=($category) ? $category['id'] : '' ?>">
				<?php $this->renderPartial('items_line', array(
						'products' => $products,
						'pages' => $pages,
						'sort' => $sort,
						'page' => '',
						'prod_season_ids' => $prod_season_ids,
						'prod_order_ids' => $prod_order_ids
				));	?>
			</div>

				<div class="krutilka"></div>	

        </div>

<?php //var_dump($this->actionFormorder());?>
