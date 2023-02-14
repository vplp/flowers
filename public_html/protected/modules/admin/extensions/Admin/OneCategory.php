<?php

class OneCategory extends CWidget
{

    public $ARRmaincat =array();
    public $ARRmaincat_product='';

//    public $SubCatId='';

	public $ARRCategory = array();
	public $ARRFeatures = array();
	public $ARRActions = array();
	public $countProduct = '';
	public $ARRsection = '';

	public function init()
	{
		$route=$this->getController()->getRoute();
	//	$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		//echo '<div  style="margin:0 0 10px 5px;font-size:14px; color:#4cb86f; font-weight:bold;">Кликните двойным щелчком чтобы редактировать поле!</div>';
		echo '<div class="edit_category" style="width:100%;">';
		echo $this->RenderRow($this->ARRCategory);
		echo '</div>';
	}

	public function RenderRow($category){
//        echo '<pre>';
//        print_r($category);
//        die();


			return '<a target="_blank" href="/catalog/'.$category['uri'].'" class="return_for_list non"></a>
				<h1 style="display:none;" type="'.$category['uri'].'" id="category_'.$category['id'].'" ></h1>
				<div class="features_one">
						<div class="features_one_label">Название пункта меню</div>
						<div class="features_one_input"><input class="category_field" maxlength="40" type="text" name="name" id="name__'.$category['id'].'" '.((isset($_GET['new']) && $_GET['new'] = '1') ? 'placeholder' : 'value').'="'.$category['name'].'"></div>
				</div>
				
				<div class="features_one non_boder_features_one">	
					<div class="features_one_label">Текст до контента</div>
					<div class="br"></div>				
					<div class="view_order_details" style="width:800px;">
						<div class="category_text" id="text_'.$category['id'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$category['text'].'</div>
					</div>			
				</div>
				
				<div class="features_one non_boder_features_one">
				    <p class="features_one_label">Родительская категория</p>
				    <div class="features_one_input subcat" id="subcat_id">'.$this->getSubCategorySelect($this->ARRmaincat, $this->ARRmaincat_product, $category) . '</div>
				</div>
				
				<div class="features_one non_boder_features_one">
				   <input '.(($category['typeCategory']==0) ? 'checked="checked"' : '').' type="checkbox" name="holiday_category" id="holiday_category" style="display: inline-block;margin-left: 10px;"><label for="holiday_category" class="checkbox_desc">Праздничная категория</label>
                </div>
				
				<div class="features_one non_boder_features_one">
						<div class="features_one_label">Использовать свойства</div>
						<div class="features_one_input">'.$this->getToMultiSelectFeatures($category['features_categories'], 'features_change').'</div>
				</div>
				<div class="features_one non_boder_features_one">
						<div class="features_one_label">Использовать акции</div>
						<div class="features_one_input">'.$this->getToMultiSelectActions($category['actions_categories'], 'actions_change').'</div>
				</div>
				<div class="features_one non_boder_features_one">				
					<div class="features_one_label">Заголовок описания</div>
						<div class="br"></div>				
						<div class="view_order_details" style="width:800px">
							<div class="features_one_input"><input style="width:800px" class="category_field"  type="text" name="label_description" id="label_description__'.$category['id'].'" value="'.$category['label_description'].'"></div>
						</div>	
				</div>
				<div class="features_one non_boder_features_one">	
					<div class="features_one_label">Описание</div>
					<div class="br"></div>				
					<div class="view_order_details" style="width:800px;">
						<div class="category_text" id="description_'.$category['id'].'" name="description"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$category['description'].'</div>
					</div>			
				</div>
				<div class="block_label"><span class="show_seo green_d">Поисковое продвижение</span></div>
				<div class="seo_input_block seo_category">
						<div class="features_one non_boder_features_one">
							<div class="features_one_label">Адрес страницы</div>
							<div class="features_one_input"><input class="category_field" name="meta_uri" id="uri__'.$category['id'].'" type="text" value="'.$category['uri'].'" ></div>
						</div>

						<div class="features_one">
								<div class="features_one_label">Тайтл</div>
								<div class="features_one_input"><input class="category_field" type="text" name="meta_title" id="meta_title__'.$category['id'].'" value="'.$category['meta_title'].'"></div>
						</div>

						<div class="features_one">
								<div class="features_one_label">Заголовок на странице (h1)</div>
								<div class="features_one_input"><input class="category_field" type="text" name="page_title" id="page_title__'.$category['id'].'" value="'.$category['page_title'].'"></div>
						</div>
						
						<div class="features_one">
								<div class="features_one_label">Подзаголовок на странице</div>
								<div class="features_one_input"><input class="category_field" type="text" name="subtitle" id="subtitle__'.$category['id'].'" value="'.$category['subtitle'].'"></div>
						</div>

						<div class="features_one">
								<div class="features_one_label">Кейвордс</div>
								<div class="features_one_input"><input class="category_field" type="text" name="meta_keywords" id="meta_keywords__'.$category['id'].'" value="'.$category['meta_keywords'].'"></div>
						</div>
						<div class="features_one non_boder_features_one">
								<div class="features_one_label ">Дескрипшен</div>
								<div class="features_one_input"><textarea class="category_field"   name="meta_description" id="meta_description__'.$category['id'].'"  >'.$category['meta_description'].'</textarea></div>
						</div>						
				</div>
				<div style="width:920px; height:1px;background-color:#ddd; margin:25px 0px 25px -40px;"></div>					
				<span class="red_btn btn_def delete_category">Удалить</span>
				<span style="margin-left:17px;" class="gray_btn btn_def show_category '.(($category['visibly'] == 0) ? 'no_visibly' : '').'">'.(($category['visibly'] == 0) ? 'Показать' : 'Скрыть').' </span>
			';

	}


    public function getSubCategorySelect($ARR, $cat_id, $category) {

        $option = '';
        foreach($ARR as $cat) {
            if ($cat['parent_id']==0) {
                $option .= '<option '.(($cat['id'] == $category['parent_id']) ? 'selected="selected"' : '' ).' value="'.$cat['id'].'">'.$cat['name'].'</option>';
            }
        }

        $option = '<option value="0">нет</option>'.$option;

        return '
				<div class="feature_one_price row_product_price">
                    <select class="w120 feature_price_value _category-select" data-category-id="'.$category['id'].'" data-placeholder=" " id="change_subcategory">'.$option.'</select>
                    <div class="del"><img src="/images/del.png"></div>
				</div>
			';
    }









	public function getToMultiSelectFeatures($ARRselect, $id) {
		$option = '';
		foreach ($this->ARRFeatures as $K => $V) {
			$select = '';
			foreach($ARRselect as $V2){
				if ($V['id'] == $V2['feature_id'] &&  $V2['visibly'] == 1) {
					$select ='selected="selected"';
				}
			}
			if ($V['tocart'] != 1) $option .= '<option  '.$select.' value="'.$V['id'].'">'.$V['name'].'</option>';
		}

 		return  '<select class="multiselect" data-placeholder=" "  multiple="true" name="" id="'.$id.'">'.$option.'</select>
 				';
	}
	public function getToMultiSelectActions($ARRselect, $id) {
		$option = '';
		foreach ($this->ARRActions as $K => $V) {
			$select = '';
			foreach($ARRselect as $V2){
				if ($V['id'] == $V2['action_id'] &&  $V2['visibly'] == 1) {
					$select ='selected="selected"';
				}
			}
			$option .= '<option  '.$select.' value="'.$V['id'].'">'.$V['name'].'</option>';
		}

		return  '<select class="multiselect" data-placeholder=" "  multiple="true" name="" id="'.$id.'">'.$option.'</select>
 				';
	}

	public function getSectionSelect($ARR) {
		$option = '';
		$check = false;

		foreach ($ARR as $K => $V) {
			$select = '';
			if ($V['id'] == $this->ARRCategory['section_id']) {
				$select ='selected="selected"';
				$check = true;
			}
			$option .= '<option  '.$select.' value="section_id__'.$V['id'].'">'.$V['name'].'</option>';
		}

		if (!$check) {
			return  '<select  type="lastcat_'.$this->ARRCategory['section_id'].'" data-placeholder="Выберите Секцию" name="" id="change_section">
						<option selected="selected" value="section_id__'.$this->ARRCategory['section_id'].'" >нет</option>
					'.$option.'
					</select>
				';
		} else {
			return  '<select  type="lastcat_'.$this->ARRCategory['section_id'].'" data-placeholder="Выберите Секцию" name="" id="change_section">'.$option.'</select>
				';
		}

	}


}


//