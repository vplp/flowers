<?php
class OneAlert extends CWidget
{
	public $htmlOptions = array();
	public $alert = array();

	public function init()
	{
		$this->htmlOptions['id'] = $this->getId();
		$route = $this->getController()->getRoute();
	}

	public function run()
	{
		echo $this->RenderOneAlert($this->alert);
	}

	public function RenderOneAlert($alert)
	{
		return '<h1 style="display:none;" id="alert_'.$alert['id'].'"></h1>
			<div class="features_one">
				<div class="features_one_label">Название</div>
				<div class="features_one_input">
					<input class="page_field" type="text" name="name" id="name__'.$alert['id'].'" value="'.$alert['name'].'">
				</div>
			</div>
			<div class="features_one" >
				<div style="float:left" class="features_one_label">Активен</div>
				<div style="float:left; margin-top:-2px; width:20px" class="features_one_input">
					<input style="width:20px" type="checkbox" class="alert_active" type="text" name="active"  id="active__'.$alert['id'].'" '.(($alert['active'] == 1) ? 'checked="checked"' : '').' value="1" >
				</div>
				<div class="br"></div>
			</div>

			<div class="view_order_details" style="width:570px">
				<div class="alert_text" id="text__'.$alert['id'].'" name="text"  style="outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$alert['text'].'</div>
			</div><br>

			<div class="features_one">
				<div class="features_one_label">Текст кнопки</div>
				<div class="features_one_input">
					<input class="page_field" type="text" name="button_text" id="button_text__'.$alert['id'].'" value="'.$alert['button_text'].'">
				</div>
			</div>

			<div class="features_one">
				<div class="features_one_label">Ссылка кнопки</div>
				<div class="features_one_input">
					<input class="page_field" type="text" name="button_link" id="button_link__'.$alert['id'].'" value="'.$alert['button_link'].'">
				</div>
			</div>

			<div class="features_one">
				<div class="features_one_label">Цвет кнопки (#HEX)</div>
				<div class="features_one_input">
					<input class="page_field" type="text" name="button_color" id="button_color__'.$alert['id'].'" value="'.$alert['button_color'].'">
				</div>
			</div>

			<div class="absolute_left">

				<div class="features_one">
					<div class="features_one_label">Шаблон</div>
					<div class="features_one_input">
						<select class="page_field" name="template" id="template__'.$alert['id'].'">
							<option'.(($alert['template'] == 'border') ? ' selected' : '').' value="border">Рамка</option>
							<option'.(($alert['template'] == 'fill') ? ' selected' : '').' value="fill">Заливка</option>
						</select>
					</div>
				</div>

				<div class="features_one">
					<div class="features_one_label">Цвет (#HEX)</div>
					<div class="features_one_input">
						<input class="page_field" type="text" name="color" id="color__'.$alert['id'].'" value="'.$alert['color'].'">
					</div>
				</div>

				<div class="features_one">
 					<div class="features_one_label">Показывать:</div>
 					<div class="chose_type_feature">
						<div class="one_type">
							<input class="alert_checkbox" type="radio" name="show" id="show_0__'.$alert['id'].'" '.(($alert['show'] == 0) ? 'checked="checked"' : '').' value="0">
							<label for="show_0">Только на</label>	
						</div>
						<div class="one_type">
							<input class="alert_checkbox" type="radio" name="show" id="show_1__'.$alert['id'].'" '.(($alert['show'] == 1) ? 'checked="checked"' : '').' value="1">
							<label for="show_1">Везде, кроме</label>	
						</div>
 						<div class="br"></div>
 					</div>
 				</div>	

				<div class="features_one" style="margin-left:0;">
						<div class="features_one_label">Страницы</div>
						<div class="features_one_input"><textarea style="height:206px" class="page_text" type="text" name="pages" id="pages__'.$alert['id'].'" >'.$alert['pages'].'</textarea></div>
				</div>
			</div>';
	}
}