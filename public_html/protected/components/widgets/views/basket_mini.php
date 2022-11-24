<?php 
$get_correct_str = new GetFormatStr();
			$price = 0;
			$all_price = 0;
			$all_count = 0;

			foreach ($products as $product) {
				$all_price +=(int)$product['price'] * (int)$product['count'];
				$price +=(int)$product['price'] * (int)$product['count'];
				$all_count += (int)$product['count'];
			}

			$all_count_html = $all_count > 0 ? '<div class="mini-cart-count">'.$all_count.'</div>' : '';
			$all_price = number_format($all_price, 0, ',', ' ');

			$cart_is_empty = count($products) > 0 ? '<a href="/cart" class="d-flex">
			<span data-price="'.$all_price.'" class="mini-cart-price">'.$all_price . ' ' .$get_correct_str->get_correct_str((int)$price, 'рубль', 'рубля', 'рублей').' </span>
			<span class="mini-cart-link">Оформить заказ</span>
		</a>' : 'Корзина пуста';

			echo '
			<div class="mini-cart-icon">
				<a href="/cart" >
					<img src="/images/mini-cart-icon.svg" alt="mini-cart">
				</a>
				'.$all_count_html.'
			</div>
			
			<div class="mini-cart-text">
				'.$cart_is_empty.'
			</div>';