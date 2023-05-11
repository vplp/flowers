<?php
  if ( $feature['value'] != '' ){?>

<div class="item_feature">

    <?php if ($feature['name']=='Состав' && empty($product_prices)) {?>
	    <div class="item_feature_label hide"><?php echo $feature['name']?></div>
    <?php } else {?>
          <div class="item_feature_label"><?php echo $feature['name']?></div>
    <?php } ?>

	<?php
		if($feature['id'] == 10 && isset($product_prices)){
   
			foreach($product_prices as $price){
				$country = $price['country'] ? '('.$price['country'].')' : '';
				echo '<div>'.$price['name']. ' ' .$price['title']. ' ' . $country . ' '.$price['height']. ' — ' .$price['quantity'] . ' шт.</div>';
			}

		}
	?>

    <?php
//        echo '<pre>';
//        print_r($product_prices);
//        die();
    ?>

	<?php if ($feature['type'] == 'textarea' ) :?>
	
		<p><?php echo $text = preg_replace('/(^\r\n|\r|\n)\r\n|\r|\n(^\r\n|\r|\n)/is', '$1<br><br>$2', $feature['value']);?></p>
		
	<?php elseif ($feature['type'] == 'multiselect' && $feature['value'] != '') :?>
		<?php 
			$arrValue = explode('|', $feature['value']);
			foreach($arrValue as $K => $val):
		?>
			<?php if ($feature['tocart'] == 1):?>
<!--					 <span class="blue">--><?php //echo $val?><!--</span>--><?php //if ($K < count($arrValue) - 1)echo ', '?>
			<?php else :?>
<!--					 <span class="">--><?php //echo $val?><!--</span>--><?php //if ($K < count($arrValue) - 1)echo ', '?>
			<?php endif;?>
			
		<?php endforeach;?>

	<?php endif;?>
	
</div>

<?php }else{ ?>

	
	<?php if($feature['id'] == 10 && !empty($product_prices) && $feature['name']!='Размер'){ ?>
	<div class="item_feature">
	
	<div class="item_feature_label"><?php echo $feature['name']?></div>

	<?php 
		foreach($product_prices as $price){
			$country = $price['country'] ? '('.$price['country'].')' : '';
			echo '<div>'.$price['name']. ' ' .$price['title']. ' ' . $country . ' '.$price['height']. ' — ' .$price['quantity'] . ' шт.</div>';
		}
	?>
	</div>
<?php } }; ?>