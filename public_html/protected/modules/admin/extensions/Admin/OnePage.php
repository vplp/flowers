<?php
class OnePage extends CWidget
{


	public $htmlOptions =array();
	public $ARRpage =array();
	public $ARRregions =array();

	public function init()
	{
		$this->htmlOptions['id']=$this->getId();
		$route=$this->getController()->getRoute();
		//	$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		echo $this->RenderOnePage($this->ARRpage, $this->ARRregions);
	}

	public function RenderOnePage($page, $regions)
	{

		$region_res = '';

        $db = Yii::app()->db;
        $sql = 'SELECT * FROM flowers WHERE visible_in_menu=1';
        $flower_in_menu = $db->createCommand($sql)->queryRow();

        $sql = 'SELECT id FROM pages where uri="'.$flower_in_menu['uri'].'"';
        $flower_check_page_id = $db->createCommand($sql)->queryScalar();

//        		echo '<pre>';
//		print_r($flower_check_page_id);
//		die();


        $sql = 'SELECT count(visible_in_menu) as count FROM flowers WHERE visible_in_menu=1';
        $count_flower_in_menu = $db->createCommand($sql)->queryScalar();
		
		foreach($regions as $region){
			
			$region_res .= '<tr id="'.$region['id'].'"><td><input type="text" name="region_name" value="'.$region["region_name"].'"</td>';
			$region_res .= '<td><input type="text" name="region_price" value="'.$region["region_price"].'"</td></tr>';
		}

		$body = '';
		$body .=  ($page["is_flower"]==1 ? '<a target="_blank" href="/catalog/byketi/'.$page['uri'].'" class="return_for_list non"></a>' :
                    '<a target="_blank" href="/'.$page['uri'].'" class="return_for_list non"></a>'). '
				<h1 style="display:none;" id="page_'.$page['id'].'"></h1>
				
				<div class="features_one">
						<div class="features_one_label">Название</div>
						<div class="features_one_input"><input class="page_field" type="text" name="name" id="name__'.$page['id'].'" value="'.$page['name'].'"></div>
				</div>		
				'.(($page['uri'] == 'contacts') ? '
					<div class="block_label">Адрес</div>
					<div class="br"></div>				
					<div class="view_order_details" style="width:330px">
						<div class="page_text" id="addres_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['addres'].'</div>
					</div>
						
					<div class="block_label">Режим работы</div>
					<div class="br"></div>				
					<div class="view_order_details" style="width:330px">
						<div class="page_text" id="mode_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['mode'].'</div>
					</div>		
						
					<div class="block_label">О нас</div>
					<div class="br"></div>				
					<div class="view_order_details" style="width:100%;">
						<div class="page_text" id="text_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['text'].'</div>
					</div>
				
				' : '
					
				').'	
				
				'.(($page['uri'] == '/') ? '
						<div class="block_label">О компании «Флау-вил»</div>
						<div class="br"></div>				
						<div class="view_order_details" style="width:570px;">
							<div class="page_text" id="text_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['text'].'</div>
						</div>
						<div class="block_label">Схема проезда</div>
						<div class="br"></div>				
						<div class="view_order_details" style="width:520px">
							<div class="features_one_input"><input style="width:520px" class="page_field"  type="text" name="addres" id="addres__'.$page['id'].'" value="'.$page['addres'].'"></div>
						</div>
				' : '').'

				'.(($page['uri'] == 'dostavka') ? '
					<div class="features_one-delivery">
						<div class="features_one_label">Регионы доставки</div>
						<table id="regions-delivery-admin">
							<tr>
								<td>Регион</td>
								<td>Тариф</td>
							</tr>
							'. $region_res .'
						</table>
					</div>
				' : '').'
				
				'.(($page['uri'] != '/' && ($page['uri'] != 'contacts')) ? '
						<div class="block_label">uri</div>
						<div class="features_one_input"><input class="page_field page_field_uri" type="text" name="name" id="uri__'.$page['id'].'" value="'.$page['uri'].'"></div>
						<div class="block_label">Содержимое</div>
						<div class="br"></div>				
						<div class="view_order_details" style="width:570px;">
							<div class="page_text" id="text_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['text'].'</div>
						</div>
						
				        <div class="features_one">	
				        	<div class="block_label">Описание</div>
						    <div class="br"></div>				
						    <div class="view_order_details" style="width:570px;">
							<div class="page_text" id="maindescription_'.$page['id'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['main_description'].'</div>
						    </div>		
				        </div>
				                
				        <div class="features_one">				
				        	<div class="features_one_label">Заголовок описания</div>
				        		<div class="br"></div>				
				        		<div class="view_order_details" style="width:548px">
				        			<div class="features_one_input label_desc"><input style="width:548px" class="page_field"  type="text" name="label_description" id="label_description__'.$page['id'].'" value="'.$page['label_description'].'"></div>
				        		</div>	
				        </div>
				        
				        <div class="features_one">				
				        	<div class="features_one_label">Подзаголовок на странице</div>
				        		<div class="br"></div>				
				        		<div class="view_order_details" style="width:548px">
				        			<div class="features_one_input subtitle"><input style="width:548px" class="page_field"  type="text" name="subtitle" id="subtitle" value="'.$page['subtitle'].'"></div>
				        		</div>	
				        </div>
						' : '').'
				
				    '.(!$page['is_flower'] ? '
					<div class="block_label">Сортировка меню (0 - не выводить)</div>
					<div class="features_one_input">
						<input class="page_field" type="text" name="name" id="menu_sort__'.$page['id'].'" value="'.$page['menu_sort'].'">
					</div>' : '
						<div class="features_one" style="display: flex;align-items: center;margin-top: 24px;">
				            <input '.($flower_in_menu['uri']==$page['uri'] ? 'checked="checked"' : '').' type="checkbox" name="page_in_menu" '.(($flower_in_menu['uri']!=$page['uri'] && $count_flower_in_menu>0) ? 'disabled' : '').' id="page_in_menu"  data-selected="" style="display: inline-block;margin: 0px; margin-right: 10px;">
				            <label for="page_in_menu" class="checkbox_desc '.(($flower_in_menu['uri']!=$page['uri'] && $count_flower_in_menu>0) ? 'opacity_label' : '').'">Выводить отдельно в меню</label>
				        </div>
					').'	
					
					 '.(($page['is_flower'] && $flower_in_menu['uri']!=$page['uri'] && $count_flower_in_menu>0) ? '
                         <span style="margin-left: 20px; margin-top: -10px; display: block;">(Сейчас уже выбран <a href="/admin/pages/edit/'.$flower_check_page_id.'/">'.$flower_in_menu['name'].')</a></span>':'
				     ').'
								
						
				'.(($page['uri'] != 'minicontacts') ? '
				<div class="block_label"><span class="show_seo green_d">Поисковое продвижение</span></div>
				<div class="seo_input_block">
						
						<div class="features_one">
								<div class="features_one_label">Тайтл</div>
								<div class="features_one_input"><input class="page_field" type="text" name="meta_title" id="meta_title__'.$page['id'].'" value="'.$page['meta_title'].'"></div>
						</div>

						<div class="features_one">
								<div class="features_one_label">Заголовок на странице</div>
								<div class="features_one_input"><input class="page_field" type="text" name="page_title" id="page_title__'.$page['id'].'" value="'.$page['page_title'].'"></div>
						</div>

						<div class="features_one">
								<div class="features_one_label">Кейвордс</div>
								<div class="features_one_input"><input class="page_field" type="text" name="meta_keywords" id="meta_keywords__'.$page['id'].'" value="'.$page['meta_keywords'].'"></div>
						</div>

						<div class="features_one non_boder_features_one">
								<div class="features_one_label ">Дескрипшен</div>
								<div class="features_one_input"><textarea class="page_field"   name="meta_description" id="meta_description__'.$page['id'].'"  >'.$page['meta_description'].'</textarea></div>
						</div>
						'.(($page['uri'] == '/') ? '
				 		<div class="absolute_left">
							<div class="features_one non_boder_features_one">
								<div class="features_one_label ">Счетчик <span>(Яндекс-метрика, Гугл-аналитикс)</span></div>
								<div class="features_one_input"><textarea style="height:170px;" class="page_field"   name="counter" id="counter__'.$page['id'].'"  >'.$page['counter'].'</textarea></div>
							</div>
						</div>
						' : '').'							
				</div>
				' : '').'							
		';
		return $body;
	}
	
	
}