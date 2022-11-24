<?php

class OrderController extends Controller
{

	public $layout = 'main';
	
	
	public function actionIndex()
	{
		if(!Yii::app()->request->isPostRequest || !isset($_POST['Order']) || (string)Yii::app()->request->cookies['cart'] == '')
			throw new CHttpException(404,'Страница не найдена');
		$p = new CHtmlPurifier;
			
		$cart = (string)Yii::app()->request->cookies['cart'];
		$ARR_products = explode('|', $cart);
		$price = 0;
		foreach($ARR_products as $K => $product) {
			$Arrone = explode(':', $product);
			
			$price += (int)$Arrone[1] * (int)$Arrone[2];
		}
		
		$Order = $_POST['Order'];
		
		// $name = $p->purify($Order['name']);
		// $phone = $p->purify($Order['phone']);
		
		$order = new Order();
		
		$order->date = date('Y.m.d') ;
		$order->time = date('H:i') ;
		$order->create_time = time();

		$order->to_name = $p->purify($Order['name']);
		$order->from_name = $p->purify($Order['name_to']);

		$order->to_phone = $p->purify($Order['phone']);
		$order->from_phone = $p->purify($Order['phone_to']);

		$order->address_region = $p->purify($Order['address_region']);
		$order->address = $p->purify($Order['address']);

		$order->products_id = $cart;
		$order->price = $price;
		$order->discount_price = $price;
		$comment = '';

		if (!empty($Order['delivery_type'])) {
			$comment .= 'Тип доставки: '.$Order['delivery_type'].'<br>';
		}
		if (!empty($Order['address'])) {
			$comment .= '<br>Адрес доставки: '.$Order['address'].'<br>';
		}
		if (!empty($Order['delivery_date'])) {
			$comment .= '<br>Дата доставки: '.$Order['delivery_date'].'<br>';
		}
		if (!empty($Order['address_region'])) {
			$comment .= '<br>Регион доставки: '.$Order['address_region'].'<br>';
		}
		if (!empty($Order['pay_type'])) {
			$comment .= 'Оплата: '.$Order['pay_type'].'<br>';
		}
		if (!empty($Order['postcard'])) {
			$comment .= 'Текст для открытки: '.$Order['postcard'].'<br>';
		}
		if (!empty($Order['delivery_comment'])) {
			$comment .= 'Комментарий для курьера: '.$Order['delivery_comment'].'<br>';
		}
		if (!empty($comment)) {
			$order->comment = $comment;
		}

		if ($order->save(false)){
			Yii::app()->request->cookies['cart'] = new CHttpCookie('cart', '');
			$mail = new SendToMail();
			$mail->SendOrder($order);	
				echo CJSON::encode(array(
						'error' => 0,
						'id'=> $order->id,
						'message' =>'<span class="success">Заказ оформлен!</span> Мы скоро позвоним вам, чтобы обговорить детали',
						'data' => array(
							'order_name' => $order->to_name,
							'order_phone' => $order->to_phone,
							'order_price' => $order->price,
						)
				));
			
		} else {
			echo CJSON::encode(array(
					'error' => 1,
					'id'=> 0,
					'message' =>'<span class="error">Ошибка оформления, <a href="/cart" id="resend" class="gray">повторить попытку<a>.</span>',
			));
		}
		
	}
	
	
}