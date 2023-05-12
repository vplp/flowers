<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="language" content="en" />
<!--    <meta name='robots' content='noindex'/>-->
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<title><?php echo $this->pageTitle ?></title>

	<link href="/css/template.css?v=6" type="text/css" rel="stylesheet" />
	<link href='https://fonts.googleapis.com/css?family=PT+Serif:400,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
		<!--[if lt IE 8 ]>
			<link href="/css/ie7.css?v=7" type="text/css" rel="stylesheet" />
		<![endif]-->
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>	
	<script type="text/javascript" src="/js/jquery_modernizr.js"></script>
	<script src="/js/maskedinput.min.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<script src="/js/datepicker-ru.js"></script>
	<?php if (Yii::app()->user->getState('edit')) :?>
		
		<!-- <script type="text/javascript" src="/js/jquery-ui-1.9.2.custom.min.js"></script>	 -->
	
	<?php endif;?>
	
	<!-- Media queries -->
  <link rel="stylesheet" href="/css/media-queries.css?v=5">
  <script src="/js/toggle-menu.js"></script>
</head>

<body <?php if (Yii::app()->user->getState('edit')) echo 'class="body_edit"'?>>
  <!-- Toggle menu -->
  <div class="toggle-wrap">
	<div class="toggle-wrap-top">
		<button type="button" class="toggle-menu" id="toggleMenu">
		<span></span>
		<span></span>
		<span></span>
		</button>
			
			<?php $home_link_open = (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index') ? '' : '<a href="/">'; ?>
			<?php $home_link_close = (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index') ? '' : '</a>'; ?>

			<?php echo $home_link_open;?>	
					<div class="header-menu-center_logo d-flex">
						<div class="logo-icon">
							<div class="logo-icon-bg"></div>
								<img src="/images/logo.png">
						</div>
						<div class="logo-desc d-flex">
							<span>Дом цветов</span>
							<span></span>
						</div>
					</div>
			<?php echo $home_link_close;?>	


		<div class="extra-header-menu_socials d-flex">
			<div class="header-telegramm">
				<a href="https://t.me/cvety_kinel" target="_blank">
				</a>
			</div>
			<div class="header-viber">
				<a href="viber://chat?number=%2B79967414590">
				</a>
			</div>
			<div class="header-whatsapp">
				<a href="https://wa.me/79967414590">
				</a>
			</div>
		</div>
		
		<div class="toggle-header-icons d-flex">
			<div class="header-menu-center_contacts d-flex">
			
				<div class="contacts-phone d-flex">
					<div class="contacts-icon">
						<a href="tel:+79967414590">
							<img src="/images/header-phone.svg" alt="phone">
						</a>
					</div>
				</div>

			</div>	
			<div class="header-menu-center_mini-cart d-flex">

					<?php 
						$this->widget('widget.Basket',array());
					?>

			</div>	
		</div>
	</div> 		

	<div class="toggle-wrap-bottom">
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

	

  </div>
	<?php if (0):?>
		<div class="admin_line">
			<div class="admin_menu">
			<span>пользователь: <b><?php echo Yii::app()->user->getState('username')?></b></span>&nbsp;|&nbsp; 
			<a href="/admin/products/" class="gray">Администрирование</a>
			<a  title="Выйти" href="/logout" class="logout" id="logout2"></a>
			
			</div>
		</div>
	<?php endif;?>
				<?php 
				 	// $this->widget('widget.Basket',array(
					// 		'aloading' => (Yii::app()->controller->id == '_site' && Yii::app()->controller->action->id == 'index') ? true : false,
					// ));
				?>
				
					
				
	<div style="width:100%;">
	
	<div class="extra-header-menu_bg alert-banner">
		<div class="wrap_sizes">
			<div class="extra-header-menu d-flex">
				<div class="extra-header-menu-close">&times;</div>
				<div class="extra-header-menu-top">
					<div class="extra-header-call">
						<div>Принимаем заказы по телефону</div>
						<div><b>с 7:00 до 22:00</b></div>
					</div>
					<div class="extra-header-delivery">
						<div>Доставляем в течение 2-х часов после</div>
						<div>подтверждения <b>с 8:00 до 22:00</b></div>
					</div>
					<div class="extra-header-warn">
						<div>Крайний срок принятия заказов на</div>
						<div>текущий день <b>не позднее 20:00</b></div>
					</div>
				</div>
				<div class="extra-header-menu-bottom">
					<span>Написать нам в 
						<a href="https://web.whatsapp.com/?phone=79967414590" target="_blank">WhatsApp</a>, 
						<a href="https://t.me/cvety_kinel" target="_blank">Telegramm</a>, 
						<a href="viber://chat?number=%2B79967414590">Viber</a>
					</span>
				</div>
			</div>
		</div>
	</div>	

	<div class="wrap_header <?php if (Yii::app()->controller->id == '_site' && Yii::app()->controller->action->id == 'index') echo 'aloading'?>">

	<div class="extra-header-menu_bg postcard active">

		<div class="wrap_sizes">
		
				<div class="extra-header-menu d-flex">
							<div class="extra-header-menu_links">
								<ul class="d-flex">
									<li><a href="/dostavka">Оплата и Доставка</a></li>
									<li><a href="/contacts">Контакты</a></li>
								</ul>
							</div>

							<div class="extra-header-menu_present d-flex">
								<img src="/images/header-present.svg" alt="present">
								<span>Открытка в подарок к каждому заказу!</span>
							</div>

							<div class="extra-header-menu_socials d-flex">
								<div class="header-telegramm">
									<a href="https://t.me/cvety_kinel" target="_blank">
										<img src="/images/telegramm_hover.svg" alt="">
									</a>
								</div>
								<div class="header-viber">
									<a href="viber://chat?number=%2B79967414590">
										<img src="/images/viber_hover.svg" alt="">
									</a>
								</div>
								<div class="header-whatsapp">
									<a href="https://web.whatsapp.com/?phone=79967414590" target="_blank">
										<img src="/images/whatsapp_hover.svg" alt="">
									</a>
								</div>
							</div>
				</div>	

		</div>

	</div>
	

	<div class="wrap_sizes">	

		<div class="header-menu-center d-flex">

		<?php echo $home_link_open;?>			
				<div class="header-menu-center_logo d-flex">
					<div class="logo-icon">
						<div class="logo-icon-bg"></div>
							<img src="/images/logo.png">
					</div>
					<div class="logo-desc d-flex">
						<span>Дом цветов</span>
						<span>Доставка цветов в Кинеле</span>
					</div>
				</div>	
		<?php echo $home_link_close;?>			
				<div class="header-menu-center_contacts d-flex">
					<div class="contacts-geo d-flex">
						<div class="contacts-icon">
							<img src="/images/header-geo.svg" alt="geo">
						</div>
						<div class="contacts-desc header-geo-js" data-href="#map">Наш салон в г. Кинель: ул. Орджоникидзе, д.76</div>
					</div>
					<div class="contacts-time d-flex">
						<div class="contacts-icon">
							<img src="/images/header-time.svg" alt="time">
						</div>
						<div class="contacts-desc">Ежедневно<br>с 6.40 до 23.00</div>
					</div>
					<div class="contacts-phone d-flex">
						<div class="contacts-icon">
							<img src="/images/header-phone.svg" alt="phone">
						</div>
						<div class="contacts-desc">
							<a href="tel:+79967414590"> +7 996 741 45 90</a>
						</div>
					</div>
					<div class="contacts-rating d-flex">
						<iframe src="https://yandex.ru/sprav/widget/rating-badge/129741371697" width="150" height="50" frameborder="0"></iframe>
					</div>
					
				</div>	
				<div class="header-menu-center_mini-cart d-flex">

			
							
							<?php 
								$this->widget('widget.Basket',array());
							?>
			
						
				</div>	
		</div>
				
	</div>

	
	
	<div class="extra-header-menu_bg">

		<div class="wrap_sizes">
			<?php 
			 	$this->widget('widget.CatalogMenu',array(
					'cat' => Yii::app()->request->url,		
				));
			?>
			
			<div class="header_phone">
				
				<?php if (!Yii::app()->user->getState('auth')) :?>
				
				<?php else :?>
					<a style="font-size:14px; margin-top:2px; line-height:1em; float:left; display:block;" href="/admin/products/" class="gray">Редактирование</a>
					<a href="/edit?stat=edit" class="non front_edit <?php if (Yii::app()->user->getState('edit')) echo 'enable'?>"></a>
					<div class="br"></div>
				<?php endif;?>
			</div>
			<div class="br"></div>
		</div>

	</div>	

	</div>

	</div>
	</div>

  <?php if(!empty(Yii::app()->params['breadcrumbs']) && count(Yii::app()->params['breadcrumbs'])>2): ?>
      <div class="breadcrumbs">
          <div class="breadcrumbs-items">
              <?php
              $count = count(Yii::app()->params['breadcrumbs']);
              foreach(Yii::app()->params['breadcrumbs'] as $crumb): ?>
                  <?php if(--$count <= 0) {
                      break;
                  }?>
                    <?php if(!empty($crumb)) {?>
                        <div class="breadcrumbs-item">
                            <a href="<?= $crumb['url'] ?>" class="breadcrumbs-link"><?= $crumb['title'] ?></a>
                            <img src="/img/icon/arrow_right_breadcrumb.svg" alt="" class="breadcrumbs-svg">
                        </div>
                    <?php } ?>
              <?php endforeach; ?>
          </div>
      </div>
  <?php endif; ?>

	<?php echo $content;?>
<div class="wrap_sizes" id="map">
	<div class="contact_label2" style="margin-bottom:20px;">Схема проезда</div>	
	<div style="width:100%; height:500px;	border-radius:15px; border:1px solid #ddd;">
		<?php /*<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=CIkDQ7T3ELYNfF-UEVYhE4SfklDVANj8&height=500"></script>*/?>
		<iframe src="https://yandex.ru/map-widget/v1/?z=12&ol=biz&oid=129741371697" width="100%" height="500" frameborder="0"></iframe>
	</div>
</div>
<div style="width:100%; height:130px;"></div>
<!--  test git1-->
	<div class="footer">

			<div class="scroll-top-btn-wrap">
				<div class="scroll-top-btn d-flex">
					<img src="/images/arrow-top.svg" alt="">
					<span>Наверх</span>
				</div>
			</div>

			<?php 
			 	$this->widget('widget.CookiesAccept',array());
			?>	

		<div class="wrap_sizes">
			<div class="footer_left">© 2004–<?php echo date('Y')?>  <a href="/">Цветы в Кинеле</a></div>
			<!--<div style="width:25%;text-align:left; float:left"><a class="gray" href="/actions">Акции</a><a class="gray" style="margin-left:30px" href="/contacts">Контакты</a></div> 
			<div class="artcream">Сайт разработан в <a href="http://artcream.ru" class="artcream_logo">
				<span class="artcream_text">Арткриме</span></a>
			</div>-->
			<div class="br"></div>
		</div>

			

	</div>
	<div class="footer_lock">
		<?php if (!Yii::app()->user->getState('auth')) {?>
			<a title="Войти"  href="#" id="login" class="login"></a>
		<?php } elseif (Yii::app()->user->getState('auth')) {?>
			<a  title="Выйти" href="#" class="logout" id="logout"></a>
			
		<?php }?>
		
	</div>
	<div class="footer_login "><input class="login_input" type="password" placeholder="Введите пароль" id="login_input" value=""></div>
	
	<script type="text/javascript" src="/js/template.js?v=170622"></script>
	
	<?php 
		$db = Yii::app()->db;
		$sql = 'SELECT * FROM pages WHERE uri = "/"';
		$C = $db->createCommand($sql)->queryRow();
		
		echo $C['counter'];
	?>

<div class="popup-header">
	<?php $this->widget('widget.CatalogFormQuick',array()); ?>
</div>

<div class="popup-success-pink-form-wrap">

</div>
  <script type="text/javascript" src="https://spikmi.org/Widget?id=16264"></script>
</body>
</html>
