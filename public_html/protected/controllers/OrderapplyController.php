<?php

class OrderapplyController extends Controller
{

	public $layout = 'main';
	
	
	public function actionIndex()
	{
		if(!Yii::app()->request->isPostRequest || !isset($_POST['Order']))
			throw new CHttpException(404,'Страница не найдена');
		$p = new CHtmlPurifier;

		if (isset($_POST['user-name']) && $_POST['user-name'] != '') {
			exit;
		}
			
		$Order = $_POST['Order'];
		
		$order = new Order();
		
		$order->date = date('Y.m.d') ;
		$order->time = date('H:i') ;
		$order->create_time = time();

		$order->budget  = $p->purify($Order['budget']);
		$order->color_gamma  = $p->purify($Order['color_gamma']);
		$order->sostav_buketa  = $p->purify($Order['sostav_buketa']);
		$order->to_name  = $p->purify($Order['name']);
		$order->from_name  = $p->purify($Order['name_to']);
		$order->to_phone  = $p->purify($Order['phone']);
		$order->from_phone  = $p->purify($Order['phone_to']);
		$order->address  = $p->purify($Order['delivery_address']);

		$comment = '';
		
		if (!empty($Order['budget'])) {
			$comment .= 'Бюджет: <b>'.$Order['budget']. 'р.</b>' . PHP_EOL;
		}
		// if (!empty($Order['pay_type'])) {
		// 	$comment .= 'Оплата: <b>'.$Order['pay_type'].'</b>' . PHP_EOL;
		// }
		if (!empty($Order['color_gamma'])) {
			$comment .= 'Цветовая гамма: <b>'.$Order['color_gamma'].'</b>' . PHP_EOL;
		}
		if (!empty($Order['sostav_buketa'])) {
			$comment .= 'Состав букета: <b>'.$Order['sostav_buketa'].'</b>' . PHP_EOL;
		}
		if (!empty($Order['delivery_address'])) {
			$comment .= 'Когда и куда доставить: <b>'.$Order['delivery_address'].'</b>' . PHP_EOL;
		}
		if (!empty($Order['postcard'])) {
			$comment .= 'Текст для открытки: <b>'.$Order['postcard'].'</b>' . PHP_EOL;
		}
		if (!empty($comment)) {
			$order->comment = $comment;
		}

		$comment_for_tlg_quick = '';
		// if (!empty($Order['pay_type'])) {
		// 	$comment_for_tlg_quick .= 'Оплата: '.$Order['pay_type'] . PHP_EOL;
		// }
		if (!empty($Order['delivery_address'])) {
			$comment_for_tlg_quick .= 'Когда и куда доставить: '.$Order['delivery_address'] . PHP_EOL;
		}
		if (!empty($Order['postcard'])) {
			$comment_for_tlg_quick .= 'Текст для открытки: '.$Order['postcard'] . PHP_EOL;
		}

		$body = '<body style="color:#333333; font-family:arial; font-size:14px;">
							<h1 style="color:#78c028;">Флау-вил</h1>
							<p style="width:50%; margin:10px 0; height:1px; background-color:#999999"></p>
							<h2 style="font-weight:bold;">Новый Заказ</h2>
							<br><br>								
							<h5>Отправитель</h5>		
							
								Имя заказчика:  <b>'.$order->to_name.'</b>
								<br>
								Имя получателя:  <b>'.$order->from_name.'</b>
								<br>
								Тел. заказчика:  <b>'.$order->to_phone.'</b>	
								<br>	
								Тел. получателя:  <b>'.$order->from_phone.'</b>	
								<br>	
								'.$order->comment.'
							<br><br>
							<p style="width:100%; margin:20px 0; height:1px; background-color:#999999"></p>
							<span style="color:#888888;font-size:13px;">Интернет-магазин &ndash; <a tyle="color:#333333;" href="http://flowersvillage.ru/">Флау-вил</a>
							<br>
							</body>
			';

		if ($order->save(false)){
			$mail = new SendToMail();
			$mail->SendMail(implode(', ', Yii::app()->params['toEmail']), $body, $header,  '', 'Flau-vil');	
			$mail->SendTgQuickForm($order, $comment_for_tlg_quick);
				echo CJSON::encode(array(
						'error' => 0,
						'id'=> $order->id,
						'message' =>'<span class="success">Заказ оформлен!</span> Мы скоро позвоним вам, чтобы обговорить детали',
						'data' => array(
							'order_name' => $order->to_name,
							'order_phone' => $order->to_phone,
							'budget' => $order->budget,
							'color_gamma' => $order->color_gamma,
							'sostav_buketa' => $order->sostav_buketa,
							'comment' => $comment
						)
				));
			
		} else {
			echo CJSON::encode(array(
					'error' => 1,
					'id'=> 0,
					'message' =>'<span class="error">Ошибка оформления, <a href="/catalog" id="resend" class="gray">повторить попытку<a>.</span>',
			));
		}
		
	}
	
	
}