<div class="wrap_sizes">
	<?php $this->widget('widget.Alert')->get(); ?>
	<div class="wrap_page" style="padding-top:0; margin-top:30px;">
		<div class="contacts_left" style=" margin-bottom:20px;">
			<div class="contact_label"><?php echo $page['page_title']?></div>
			<?php echo $page['addres']?>
			<div class="contact_label2">Режим работы:</div>
			<?php echo $page['mode']?>

            <div class="contact_delivery">
                <p>Подробнее об <a class="blue" href="/dostavka">условиях доставки и оплаты</a></p>
            </div>
		</div>
		<div class="contacts_right">
			<div class="contact_label2" style="margin-top:0;">О нас</div>
			<p><?php echo $page['text']?></p>
			
		</div>
		<div class="br"></div>
		
		<br>
	</div>
</div>