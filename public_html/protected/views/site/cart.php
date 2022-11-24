<div class="wrap_sizes">
	<div class="wrap_page cart-page" style="padding-top:0;">
			<div class="page-title-wrap">
				<h1><?php echo $page['meta_title']?></h1>
			</div>

			<div class="cart-content-wrap d-flex">

				<div class="cart-item-list d-flex">

				<?php 
					$all_price = 0;
					if(count($products) > 0){

						// print_r($products);

						foreach($products as $product){ 
							$all_price +=(int)$product['price'] * (int)$product['count'];
							$Arrimg = array();
							$all_count = 0;	
							$Arrimg = explode('|', $product['img']);
							$Arrimg = array_diff($Arrimg, array(''));
							$all_count += (int)$product['count'];
							
							?>
							<div class="cart-item-wrapper">

								<div class="cart-item d-flex" id="pr<?php echo $product['id'].$product['fid']?>">

								<div class="cart-item-img">
									<img src="/uploads/300x300/<?php echo current($Arrimg);?>" alt="">
								</div>

								<div class="cart-item-right">

								<div class="cart-item-name">
									<!--<a href="/catalog/<?php //echo $product['cat_uri']?>/<?php //echo $product['id']?>"class="blue ">-->
                                    <a href="/catalog/<?php echo $product['id']?>" class="blue ">
										<?php //echo str_replace(' ', '&nbsp;', trim($product['name']))?>
										<?php echo trim($product['name'])?>
									</a>	
								</div>

								<div class="cart-item-count">
									<div class="count-minus-wrap">
										<a class="count-minus basket_item_del" href="/catalog/delete/<?php echo $product['id']?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="2" viewBox="0 0 14 2" fill="none">
												<path d="M0 2V0H14V2H0Z" fill="#333333"/>
											</svg>
										</a>
									</div>
									<div class="count-input">
										<input type="text" readonly name="order-count" value="<?php echo $all_count; ?>">
									</div>
									<div class="count-plus-wrap">
										<a class="addtocart count-plus" href="/catalog/add/<?php echo $product['id']?><?php if ($product['fid']) echo '?fid='. $product['fid']; ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
												<path d="M8 8V14H6V8H0V6H6V0H8V6H14V8H8Z" fill="#333333"/>
											</svg>
										</a>
									</div>
								</div>

								<div class="cart-item-price">
									<span><?php echo number_format( $product['price'], 0, ',', ' ' );?> ₽</span>	
								</div>

								<div class="cart-item-remove">
								<a href="/catalog/delete/<?php echo $product['id']?>?all=true"  alt="удалить из корзины" class="non basket_item_del">	
								<span>Удалить</span>
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
										<path d="M12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41L12.59 0Z" fill="#333333"/>
									</svg>
								</a>	
								</div>

								</div>



								</div>

								<div class="item-line"></div>

								</div>

						<?php }

					}else{
						echo 'Корзина пуста';
					}
				
				?>
				
		

				</div>

				<?php 
					if(count($products) > 0){ 
						
					
						?>
						<div class="cart-total-wrap">
							<div class="cart-total-content">

								<div class="cart-total">
									<span>Итого</span>
									<span><?php echo number_format($all_price, 0, ',', ' '); ?> ₽</span>
								</div>
								
							</div>
						</div>
					<?php } 
				?>

			

			</div> <!-- cart-content-wrap end -->

		
	

	</div>
</div>

<?php 
	if(count($products) > 0){  ?>

<div class="cart-contact-info-wrap">
	
		<div class="cart-contact-info-content">

			<div class="cart-contact-info-title">
				<h2>Контактная информация</h2>
			</div>

			<form action="/order" id="order" method="post">
				<div class="form-row">
					<label>
						Имя заказчика
						<input class="form-input" type="text" name="Order[name]" autocomplete="no">
					</label>

					<label>
							Имя получателя
							<input class="form-input" type="text" name="Order[name_to]" autocomplete="no">
					</label>
				</div>
				<div class="form-row">
					<label>
								Телефон заказчика
								<input class="form-input" type="tel" name="Order[phone]" placeholder="+7 (___) ___ __ __" autocomplete="new-pass" autocomplete="no">
					</label>

					<label>
							Телефон получателя
							<input class="form-input" type="tel" name="Order[phone_to]" placeholder="+7 (___) ___ __ __" autocomplete="new-pass" autocomplete="no">
					</label>
				</div>
				<div class="form-row">
					<label>
					Куда доставить
					<select name="Order[address_region]" id="">
						<?php
							foreach($page_dostavka as $region){ 
								
								$valute = ($region["id"] == 32 || $region["id"] == 33 || $region["id"] == 34) ? '' : ' ₽'; 
								$region_price = '';
								if($region["id"] == 32){
									$region_price = 'individual';
								}elseif($region["id"] == 33){
									$region_price = 0;
								}elseif($region["id"] == 34){
									$region_price = 'samovivoz';
								}else{
									$region_price = $region['region_price'];
								}   
								$price_individual = ($region_price == 'individual' || $region_price == 'samovivoz') ? '' : $region['region_price'];
								?>
								<option data-delivery="<?php echo $region_price; ?>" value="<?php echo $region['region_name'] . ' ' . $price_individual . $valute; ?>"><?php echo $region['region_name'] . ' ' . $price_individual . $valute; ?></option>	
							<?php }
						?>
					</select>
					</label>
				</div>
				<div class="form-row">
					<label>
								Адрес доставки
								<input class="form-input" type="text" name="Order[address]" autocomplete="no">
					</label>
					<label class="datepicker-label">
								Дата доставки
								<input class="form-input" type="text" id="datepicker" name="Order[delivery_date]" autocomplete="no">
					</label>
				</div>
				<div class="form-row row-textarea">
						<label>
							Комментарий для курьера
							<textarea class="form-input" id="" cols="30" rows="10" name="Order[delivery_comment]" autocomplete="no"></textarea>
						</label>
				</div>

				<div class="form-row row-textarea">
					<label class="row-textarea-last">
						<div>
							<span>Текст открытки</span>
							<span>Добавим к заказу бесплатно!</span>
						</div>
						<textarea id="field_text-otkritki" class="form-input" name="Order[postcard]" id="" cols="30" rows="10" autocomplete="no"></textarea>
						<span>Добавим к заказу бесплатно!</span>
					</label>
				</div>

			</form>
		</div>

</div>

               

<div class="cart-order-list-wrap">

	<div class="cart-order-list-content">
		<ul class="cart-order-list">

		<?php 
					if(count($products) > 0){
						
						foreach($products as $product){ ?>

							<li id="pr<?php echo $product['id'].$product['fid']?>">
								<span><?php echo trim($product['name'])?></span>
								<span><?php echo number_format( trim($product['price']), 0, ',', ' ' );?> ₽</span>
							</li>

						<?php } 
					}	
		?>				


			
			
		</ul>
		<div class="cart-order-delivery">
			<span>Доставка</span>
			<span>0 ₽</span>
		</div>
		<div class="cart-order-otkritka">
			<span>Открытка</span>
			<span>Бесплатно</span>
		</div>
		<div class="cart-order-total">
			<span>Итого с учетом доставки</span>
			<span><?php echo number_format(($all_price), 0, ',', ' '); ?> ₽</span>
		</div>
		<div class="cart-order-checkout-btn">
			<button class="confirm_btn">Оформить заказ</button>
		</div>
	</div>

</div>

<?php } ?>

