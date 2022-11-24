<?php
class OnePrice extends CWidget
{
	public $htmlOptions = array();
	public $ARRprice = array();
	public $flowers = array();
	public $sizes = array();
	public $countries = array();

	public function init()
	{
		$this->htmlOptions['id'] = $this->getId();
		$route = $this->getController()->getRoute();
		//	$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		echo $this->RenderOnePrice($this->ARRprice, $this->flowers, $this->sizes, $this->countries);
	}

	public function RenderOnePrice($price, $flowers = [], $sizes = [], $countries = [])
	{
		$_flowers = '<div class="features_one">
						<div class="features_one_label">Товар</div>
						<div class="features_one_input">
							<select class="price_field select-product-name" name="name" id="name__'.$price['id'].'">
								<option'.(($price['name'] == '') ? ' selected' : '').' value=""></option>';

		if (!empty($flowers)) {
			foreach ($flowers as $flower) {
				$_flowers .= '<option'.(($price['name'] == $flower) ? ' selected' : '').' value="'.$flower.'">'.$flower.'</option>';
			}
		}

		$_flowers .= '</select></div></div>';

		$_countries = '<div class="features_one">
						<div class="features_one_label">Страна</div>
						<div class="features_one_input">
							<select class="price_field" name="country" id="country__'.$price['id'].'">
								<option'.(($price['country'] == '') ? ' selected' : '').' value=""></option>';

		if (!empty($countries)) {
			foreach ($countries as $country) {
				$_countries .= '<option'.(($price['country'] == $country) ? ' selected' : '').' value="'.$country.'">'.$country.'</option>';
			}
		}

		$_countries .= '</select></div></div>';

		$_sizes = '<div class="features_one">
						<div class="features_one_label">Размер</div>
						<div class="features_one_input">
							<select class="price_field" name="height" id="height__'.$price['id'].'">
								<option'.(($price['height'] == '') ? ' selected' : '').' value=""></option>';

		if (!empty($sizes)) {
			foreach ($sizes as $size) {
				$_sizes .= '<option'.(($price['height'] == $size) ? ' selected' : '').' value="'.$size.'">'.$size.'</option>';
			}
		}

		$_sizes .= '</select></div></div>';

		return '<h1 style="display:none;" id="price_'.$price['id'].'"></h1>
				
				'.$_flowers.'
				<div class="features_one">
					<div class="features_one_label">Название (сорт, цвет)</div>
					<div class="features_one_input"><input class="price_field" type="text" name="title" id="title__'.$price['id'].'" value="'.$price['title'].'"></div>
				</div>
				'.$_sizes.'
				'.$_countries.'
				<div class="features_one">
						<div class="features_one_label">Цена</div>
						<div class="features_one_input"><input class="price_field" type="text" name="cost" id="cost__'.$price['id'].'" value="'.$price['cost'].'"></div>
				</div>
				<div class="features_one" >
						<div style="float:left" class="features_one_label">Сезонный</div>
						<div style="float:left; margin-top:-2px; width:20px" class="features_one_input"><input style="width:20px" type="checkbox" class="price_field" type="text" name="season"  id="season__'.$price['id'].'" '.(($price['season'] == 1) ? 'checked="checked"' : '').' value="1" ></div>
						<div class="br"></div>
				</div>
				<div class="features_one" >
						<div style="float:left" class="features_one_label">Под заказ</div>
						<div style="float:left; margin-top:-2px; width:20px" class="features_one_input"><input style="width:20px" type="checkbox" class="price_field" type="text" name="order"  id="order__'.$price['id'].'" '.(($price['order'] == 1) ? 'checked="checked"' : '').' value="1" ></div>
						<div class="br"></div>
				</div>';
	}
}