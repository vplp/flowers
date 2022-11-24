<?php 
	$url = Yii::app()->request->url;		
?>
	
<div class="header_menu d-flex">

	<div class="header-menu-desctop-hide">
		<div class="contacts-geo d-flex">
			<div class="contacts-icon">
				<img src="/images/header-geo.svg" alt="geo">
			</div>
			<div class="contacts-desc header-geo-js" data-href="#map">Кинель: ул. Орджоникидзе, д.76 (6:40-23:00)</div>
		</div>
		<div class="toggle-wrap-btn d-flex">
			<button class="toggle-popup-handler">Заказать букет на мой бюджет</button>
		</div>
	</div>
	
	<?php foreach ($Catalog as $catalog) { 
		$menu_item_arr = ['73', '74', '75', '83', '84'];	
		$red_menu_item = '';
		if(!in_array($catalog['id'], $menu_item_arr)){
			$red_menu_item = 'red-item';
		}
		?>

		<?php if (preg_match('/'.$catalog['uri'].'$/', $url) ) { ?>
				<span class="gray select <?php echo $red_menu_item; ?>"><?php echo $catalog['name']?></span>
		<?php } elseif (preg_match('/'.$catalog['uri'].'.+/', $url)) { ?>
				<a class="gray select <?php echo $red_menu_item; ?>" href="/catalog/<?php echo $catalog['uri']?>"><?php echo $catalog['name']?></a>
		<?php } else { ?>
				<a class="gray <?php echo $red_menu_item; ?>" href="/catalog/<?php echo $catalog['uri']?>"><?php echo $catalog['name']?></a>
		<?php } ?>

		<?php } ?>

	<?php foreach ($pages as $page) { ?>
		<?php if (preg_match('/'.$page['uri'].'/', $url)) { ?>
			<span class="gray select"><?php echo $page['name']?></span>
		<?php } else { ?>
			<a class="gray" href="<?php echo ($page['uri'] != '/' ? '/' : '').$page['uri']?>"><?php echo $page['name']?></a>
		<?php } ?>
	<?php } ?>


	<div class="header_menu-mobile-sub-menu">
		<div class="extra-header-menu_links">
			<ul class="d-flex">
				<li><a href="/dostavka">Оплата и Доставка</a></li>
				<li><a href="/contacts">Контакты</a></li>
			</ul>
		</div>
		<iframe src="https://yandex.ru/sprav/widget/rating-badge/129741371697" width="150" height="50" frameborder="0"></iframe>
	</div>
</div>

