<div class="alert_block alert_<?=$result['template']?>" <?= (!empty($result['color']) ? ' style="border: none; background: ' . $result['color'] . '"' : '') ?>>
	<div class="body">
		<?=$result['text']?>
		<?php if (!empty($result['button_text']) && !empty($result['button_link'])) { ?>
			<a class="button" <?= (!empty($result['button_color']) ? ' style="background: ' . $result['button_color'] . '"' : '') ?> href="<?=$result['button_link']?>"><?=$result['button_text']?></a>
		<?php } ?>
	</div>
</div>