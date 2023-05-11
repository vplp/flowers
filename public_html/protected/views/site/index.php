<style>
.any_bield { 
	/* position: absolute;  */
	margin:0 !important;
	}


/*.products_line * {*/
/*    color: black;*/
/*    background: red !important;*/
/*    z-index: 100000 !important;*/
/*    opacity: 1 !important;*/
/*    display: block !important;*/
/*}*/
</style>

<?php if (0) : ?>
	<div class="wrap_sizes" style="overflow:hidden;">
		<div  class="h_fotorama aloading" data-fit="cover" data-transition="slide" data-height="400" style="">
			<img src="/img/avd_1.jpg">
			<img src="/img/avd_2.jpg">
		</div>
	</div>

	<script>
		$(function(){
			var posY = -1;
			var posX = -1;
			$('body').on('mousedown', '.h_fotorama img', function(e){
				posY = e.clientY;
				posX = e.clientX;
				console.log(posY+' '+posX);
			})
	
			$('body').on('mouseup', function(e){
				if (posY > e.clientY - 20 && posY < e.clientY + 20 && posX > e.clientX - 20 && posX < e.clientX + 20){
						location.href = 'http://google.com';
					}	
					
			})
		})
	</script>
<?php endif;?>


<div class="promo">
	<div class="promo_column">
		<div  href="<?php echo $actions[0]['link']?>" class="one_promo aloading one_promo1" >
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[0]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'" width="460" height="452">';
					$i++;
				}
			?>
			
			<div class="promo_desc <?php if($actions[0]['plashka'] == 1) echo 'green'?>">
				<?php if ($actions[0]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[0]['link']?>"><?php echo $actions[0]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[0]['link']?>"></a></div>
				<?php endif;?>
				
				<?php if ($actions[0]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[0]['title']?></div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="sep_vert"></div>
	<div class="promo_column">
		<div class="one_promo aloading sm_hor1">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[1]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'"  width="460" height="224">';
					$i++;
				}
			?>
	
			<div class="promo_desc <?php if($actions[1]['plashka'] == 1) echo 'green'?>">
				<?php if ($actions[1]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[1]['link']?>"><?php echo $actions[1]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[1]['link']?>"><?php echo $actions[1]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[1]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[1]['title']?></div>
				<?php endif;?>
				
			</div>
		</div>
		<div class="sep_hor"></div>
		<div class="one_promo aloading sm_hor2">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[2]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'"  width="460" height="224">';
					$i++;
				}
			?>
			<div class="promo_desc <?php if($actions[2]['plashka'] == 1) echo 'green'?>">
				<?php if ($actions[2]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[2]['link']?>"><?php echo $actions[2]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[2]['link']?>"><?php echo $actions[2]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[2]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[2]['title']?></div>
				<?php endif;?>
				
			</div>
		</div>
	</div>
	<div class="sep_vert"></div>
	
		<div class="one_promo aloading sm_ver1">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[3]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'"   width="228" height="452">';
					$i++;
				}
			?>
			<div class="promo_desc <?php if($actions[3]['plashka'] == 1) echo 'green'?> ">
				<?php if ($actions[3]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[3]['link']?>"><?php echo $actions[3]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[3]['link']?>"><?php echo $actions[3]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[3]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[3]['title']?></div>
				<?php endif;?>
			</div>
		</div>
		<div class="sep_vert"></div>
		<div class="one_promo aloading sm_ver2">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[4]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'"   width="228" height="452">';
					$i++;
				}
			?>
			<div class="promo_desc <?php if($actions[4]['plashka'] == 1) echo 'green'?>">
				<?php if ($actions[4]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[4]['link']?>"><?php echo $actions[4]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[4]['link']?>"><?php echo $actions[4]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[4]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[4]['title']?></div>
				<?php endif;?>
			</div>
		</div>
	
	<div class="sep_vert"></div>
	<div class="promo_column">
		<div class="one_promo aloading one_promo2">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[5]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'" width="460" height="452">';
					$i++;
				}
			?>
			<div class="promo_desc <?php if($actions[5]['plashka'] == 1) echo 'green'?> ">
				<?php if ($actions[5]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[5]['link']?>"><?php echo $actions[5]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[5]['link']?>"><?php echo $actions[5]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[5]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[5]['title']?></div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="br"></div>
</div>

<script>
	$(function(){

		$('.one_promo').on('click', function(){
			location.href = $(this).find('.promo_desc_name a').attr('href')
		})
	})
</script>

<div class="wrap_sizes ">
<h1><?php echo $page['page_title']?></h1>
<p>Наш магазин находится по адресу: город Кинель​​​​​, <a class="fakeLink" href="#map">улица Орджоникидзе, дом 76</a>.</p>
<p>В наличии всегда широкий ассортимент свежих цветов. Приезжайте и выберите букет с витрины или закажите с доставкой.</p>

<?php $this->widget('widget.Alert')->get(); ?>

<br>
	 <!-- <div class="wrap_block resize_block fixed_height  <? //if (isset($class)) echo $class;?>  a_load_block">
		
		<div class="block_label aloading"><h1>Магазин цветов в Кинеле</h1></div>
			
			
			<div id="products_line" class="products_line ">
				<?php //$this->renderPartial('../catalog/items_line', array(
						//'products' => $products,
						//'sort' => false,
				//));	?>
			</div> 
			
		</div>-->
    <?php
//    echo '<pre>';
//    print_r($categories);
//    die();
    ?>

    <?php
/*
    //добавляем в categories свойства из прайс-листа для продукта (для рендера на главной)
    $product_index = 0;
    foreach ($categories as $cat) {
        $cat_index = 0;
        foreach ($cat['products'] as $cat_item) {
            $product_id = $categories[$product_index]['products'][$cat_index]['id'];
            $categories[$product_index]['products'][$cat_index]['prices'] = $products[$product_id]['prices'];
            $cat_index++;
        }
        $product_index++;
    }
*/
    $db = Yii::app()->db;
    $count_byket_in_roses = $db->createCommand('select count(id) as count from products where visible_in_roses=1')->queryScalar();
/*
    $promo_info = $db->createCommand('select * from flowers where visible_in_menu=1')->queryRow();
    $promo_page = $db->createCommand('select * from pages where uri="'.$promo_info['uri'].'"')->queryRow();
*/
    $promo_page = $db->createCommand('
	select p.name, p.uri, f.name f_name
	from pages p, flowers f
	where f.visible_in_menu=1 and p.uri=f.uri')->queryRow();
	// echo '<pre>11';print_r($promo_page2);exit;

    $promo_name = substr_replace($promo_page['f_name'], '', -2);

    $promo = $db->createCommand("
	select p.*
	from products as p, features_products as fp
	WHERE fp.value LIKE '%".$promo_name."%' and fp.product_id=p.id and p.visibly=1
	group by p.id")->queryAll();

    foreach ($promo as $key => $item) {
        $promo[$key]['prices'] = $products[$item['id']]['prices'];
    }

//    echo '<pre>';
//    print_r($promo_name);
//    die();
    ?>

    <?php if (!empty($promo) && !empty($promo_page['name'])) {?>
        <div class="wrap_block resize_block fixed_height  <?if (isset($class)) echo $class;?>  a_load_block">
            <div class="block_label aloading"><a class="blue"  href="/catalog/byketi/<?php echo $promo_page['uri']?>"><?php echo $promo_page['name']?></a><sup>&nbsp;<?php echo Formats::getCountItems(count($promo))?></sup></div>
            <div id="products_line" class="products_line ">
                <?php $this->renderPartial('../catalog/items_line', array(
                    'products' => $promo,
                    'sort' => false,
                    'catUri' => "/catalog/byketi/".$promo_page['uri'],
                    'page' => 'index',
                    'productsCount' => count($promo)
                ));	?>
            </div>
        </div>
    <?php }?>

<?php
//новый вывод категорий с товарами
foreach ($cats as $cat) { ?>
	<?php if (!empty($cat->products)) {
		$productsCount = count($cat->products);
		if ($cat->id == 73) {
			$productsCount += $count_byket_in_roses;
		}?>
		<div class="wrap_block resize_block fixed_height  <?if (isset($class)) echo $class;?>  a_load_block">
			<div class="block_label aloading"><a class="blue"  href="/catalog/<?php echo $cat->uri?>"><?php echo $cat->name?></a><sup>&nbsp;<?php echo Formats::getCountItems($productsCount)?></sup></div>
				<div id="products_line" class="products_line ">
					<?php $this->renderPartial('../catalog/items_line_new', array(
							'products' => $cat->products,
							'sort' => false,
							'catUri' => "/catalog/".$cat->uri,
							'page' => 'index',
							'productsCount' => $productsCount
					));	?>
				</div>
		</div>
	<?php
		}
	}
?>

	<?php
	//код не используется
	foreach ($categories as $c) :?>
	    <?php if (!empty($c['products'])) :?>
	    <?php
            $productsCount = count($c['products']);
	        if ($c['id']==73)
                $productsCount += $count_byket_in_roses;
	    ?>
            <div class="wrap_block resize_block fixed_height  <?if (isset($class)) echo $class;?>  a_load_block">
                <div class="block_label aloading"><a class="blue"  href="/catalog/<?php echo $c['uri']?>"><?php echo $c['name']?></a><sup>&nbsp;<?php echo Formats::getCountItems($productsCount)?></sup></div>
                    <div id="products_line" class="products_line ">
                        <?php $this->renderPartial('../catalog/items_line', array(
                                'products' => $c['products'],
                                'sort' => false,
                                'catUri' => "/catalog/".$c['uri'],
                                'page' => 'index',
                                'productsCount' => $productsCount
                        ));	?>
                    </div>
            </div>
		<?php endif;?>
	<?php endforeach;?>

	<div class="wrap_block home_bottom" style="border:none; margin-top:0; margin-bottom:0;">
		<div class="mini-contacts_left">
			<!--<div class="block_label ">О компании «Флау-вил»</div>-->
			<p><?php echo $page['text']?></p>
			<?php if (0) :?>
			<div class="block_label ">Схема проезда</div>
			<p style="margin:-5px 0 10px 0;"><?php echo $page['addres']?></p>
			
			<div class="mini-contacts_map" style="">
				<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=rsXqYWI5EOWtXJiWICC8iXN62vUefhs5&width=100%&height=247"></script>
			</div>
			<?php endif;?>
		</div>
		<!--<div class="mini-contacts_right">
			<div class="block_label ">Отзывы</div>
			<div class="mini-contacts_comments">
							
							<script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>
							
							<script type="text/javascript">
							  VK.init({apiId: 4222157, onlyWidgets: true});
							</script>
							
							<div id="vk_comments"></div>
							<script type="text/javascript">
							VK.Widgets.Comments("vk_comments", {limit: 15, width: "380", height: "339", attach: "*"}, 123);
							</script>
							</div>
		</div>-->
		<div class="br"></div>
	</div>
</div>
