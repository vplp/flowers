<?php

class Listing extends CWidget
{

    public $ARRitems = array();
    public $ARRfields = array();
    public $id_table = '';
    public $table_label = '';
    public $class_table = '';
    public $field_sort = false;
    public $tr_sort = false;
    public $empty_message = '';
    public $panel = true;
    public $count_labels = array('элемент', 'элемента', 'элементов');
    public $new_label = '';

    public function init()
    {
        $route = $this->getController()->getRoute();
        //	$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
    }

    /**
     * Calls {@link renderMenu} to render the menu.
     */
    public function run()
    {
        echo '<div class="listing">';
        echo '<div class="count_all_listing"><span>' . $this->getCount(count($this->ARRitems), $this->count_labels) . '</span></div>';
        if ($this->new_label != '') {
            echo '<div class="add_new"><a class="green_btn btn_def2" href="/admin/' . $this->id_table . '/new">' . $this->new_label . '</a></div>';
            // echo '<a href="/admin/'.$this->id_table.'/new" class="green_btn btn_def2">'.$this->new_label.'</a><br><br>';
        } elseif ($this->id_table == 'prices') {
            echo '<a href="/admin/prices/new/" class="green_btn btn_def2">Добавить цену</a><br><br>';
        }

        if ($this->id_table == 'categories')
            echo $this->RenderRowCat();
        else
            echo $this->RenderRow();

        echo '</div>';
    }

    public function RenderRow()
    {

//        echo '<pre>';
//        print_r($this->ARRfields);
//        die();

        if (count($this->ARRitems) > 0) {
            $header_line = '';
            $i = 0;
            $line_tr = '';
            $line_td_num = '';
            $line_tr .= '<tr>';
            foreach ($this->ARRfields as $k => $field) {
                $line_tr .= '<td class="th' . $k . '" >' . $field['label'] . '</td>';
            }
            $line_tr .= '</tr>';
            foreach ($this->ARRitems as $item) {
                $i++;
                $td_line = '';
                $line_td_num .= '<tr><td>' . $i . '</td></tr>';

                foreach ($this->ARRfields as $k => $field) {
                    if ($i == 1) $header_line .= '<th class="th' . $k . '" >' . $field['label'] . '</th>';

                    if (isset($field['replace'])) $item[$field['name']] = str_replace($field['replace'][0], $field['replace'][1], $item[$field['name']]);

                    if (isset($field['style'])) $style_td = $field['style']; else  $style_td = '';

                    if ($field['name'] == 'name' && $this->id_table == 'banners' && $item[$field['name']] == '')
                        $item[$field['name']] = 'Баннер номер ' . $item['id'];

                    if ($field['name'] == 'name' && $this->id_table == 'prices')
                        $item[$field['name']] .= ' ' . $item['title'];

                    if ($field['name'] == 'img') {
                        $ARR_img = explode('|', $item[$field['name']]);
                        $ARR_img = array_diff($ARR_img, array(''));

//                        echo '<pre>';
//                        print_r(current($ARR_img));

                        $td_line .= '<td style="' . $style_td . '" class="th' . $k . ' image_td" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '"><a class="non" href="/admin/' . $this->id_table . '/edit/' . $item['id'] . '"><img width="36" height="36" src="/uploads/81x84' . current($ARR_img) . '"</a></td>';
                    } else if ($field['name'] == 'price') {
                        $product_price = $item['price_update'] > 0 ? number_format(($item[$field['name']]), 0, ',', ' ') : 0;
                        $td_line .= '<td style="' . $style_td . '" class="th' . $k . ' price_td" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '">' . $product_price . ' рублей</td>';
                    } else if ($field['name'] == 'feature_price') {
                        $td_line .= '<td style="' . $style_td . '" class="th' . $k . ' price_td" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '">' . $item[$field['name']] . ' рублей</td>';
                    } else if ($field['name'] == 'cost') {
                        $td_line .= '<td style="' . $style_td . '" class="th' . $k . ' cost_td" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '"><input id="' . $this->id_table . '_' . $item['id'] . '_cost" type="text name="cost" class="listing_cost_edit" value="' . number_format($item[$field['name']], 0, ',', ' ') . '"> рублей</td>';

                    } else {

                        if ($field['name'] == 'datetime' && $item[$field['name']] == '0000-00-00 00:00:00') {
                            $item[$field['name']] = 'бессрочно';
                        }


                        if (isset($field['link'])) {
                            if ($field['link']) {
                                $td_line .= '<td style="' . $style_td . '" class="th' . $k . '" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '"><a href="/admin/' . $this->id_table . '/edit/' . $item['id'] . '">' . $item[$field['name']] . '</a></td>';
                            } else {
                                $td_line .= '<td style="' . $style_td . '" class="th' . $k . '" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '">' . $item[$field['name']] . ' ' . (($this->id_table == 'actions' && $field['name'] == 'value') ? '%' : '') . '</td>';
                            }


                        } else {

                            if (in_array($field['name'], ['paid', 'season', 'order'])) {
                                $td_line .= '<td style="' . $style_td . '" class="th' . $k . '" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '"><input class="' . $this->id_table . '_' . $field['name'] . (($item[$field['name']] == 1) ? ' active' : '') . '" name="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '" type="checkbox" ' . (($item[$field['name']] == 1) ? 'checked' : '') . '/></td>';
                            } else {
                                $td_line .= '<td style="' . $style_td . '" class="th' . $k . '" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '">' . $item[$field['name']] . ' ' . (($this->id_table == 'actions' && $field['name'] == 'value') ? '%' : '') . '</td>';
                            }
                        }

                    }
                }
                if ($this->panel) {
                    $td_line .= '
						<td class="panel_td" style="">
						' . (($this->id_table == 'products') ? '<span class="panel_hot ' . (($item['hot'] == 1) ? 'active' : '') . '" id="' . $this->id_table . '_' . $item['id'] . '_hot"></span>' : '') . '
						<span class="panel_show ' . (($item['visibly'] == 0) ? 'panel_hide' : '') . '" id="' . $this->id_table . '_' . $item['id'] . '_show" title="' . (($item['visibly'] == 0) ? 'Показать' : 'Скрыть') . '"></span>
						<span class="panel_delete" id="' . $this->id_table . '_' . $item['id'] . '_delete"></span>
						</td>';
                }
                $line_tr .= '<tr id="' . $this->id_table . '_' . $item['id'] . '_tr" >' . $td_line . '</tr>';
            }

            if ($this->panel) {
                $header_line .= '<th style="width:60px;"></th>';
            } else {
                $header_line .= '';
            }
            $table = '
							<table cellpadding="0" cellspacing="0" id="' . $this->id_table . '" class="' . $this->class_table . '" ><tbody>' . $line_tr . '</tbody></table>
						';

            $script = '<script>
								$(function(){
								' . (($this->field_sort) ? '$("table#' . $this->id_table . '").tablesorter({sortInitialOrder:"desc", sortMultisortKey:"ctrlKey"});' : '') . '
									
									$(".panel_td .panel_show").click(function(){
										if ($(this).hasClass("panel_hide")) {
												var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=visibly&value=1&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});
												$(this).removeClass("panel_hide");
										} else {
												var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=visibly&value=0&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});
												$(this).addClass("panel_hide");
										}
									})

									$(".panel_td .panel_delete").click(function(){
											var ArrId = $(this).attr("id").split("_");
											$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=delete&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
											});
										$("#"+ArrId[0]+"_"+ArrId[1]+"_tr").fadeOut(function(){
											$(this).remove();			
										})
										$(".num_table tr:last").fadeOut(function(){
											$(this).remove();			
										})
									})

									$(".panel_td .panel_hot").click(function(){
										if ($(this).hasClass("active")) {
												var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=hot&value=0&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});
												$(this).removeClass("active");
										} else {
												var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=hot&value=1&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});
												$(this).addClass("active");
										}
									})	

									$(".prices_season").change(function(){
										pricesCheckboxes($(this), "season");
									});
									
									$(".prices_order").change(function(){
										pricesCheckboxes($(this), "order");
									});

									function pricesCheckboxes(elem, action){

										if ($(elem).hasClass("active")) {
											var ArrId = $(elem).attr("name").split("_");	
											$.ajax({
												  url: "/admin/update",
												  type: "POST",
												  data: "stat=editfield&field=" + action + "&value=0&id="+ArrId[1]+"&f="+ArrId[0],
												  success: function(data){
												  }
											});
											$(elem).removeClass("active");
										} else {
											var ArrId = $(elem).attr("name").split("_");	
											$.ajax({
												  url: "/admin/update",
												  type: "POST",
												  data: "stat=editfield&field=" + action + "&value=1&id="+ArrId[1]+"&f="+ArrId[0],
												  success: function(data){
												  }
											});
											$(elem).addClass("active");
										}
									}
										
									$(".listing_price_edit").change(function(){
										var val = $(this).val();
										var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=price&value="+val+"&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});

									})

									$(".listing_cost_edit").change(function(){
										var val = $(this).val();
										var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=cost&value="+val+"&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});

									})
										
								});
						</script>';

            return $table . $script;
        } else {
            return $this->empty_message;
        }


    }

    public function RenderRowCat()
    {

//        echo '<pre>';
//        print_r($this->ARRfields);
//        die();

        if (count($this->ARRitems) > 0) {
            $style_td = !empty($field['style']) ? $field['style'] : '';
            $header_line = '';
            $i = 0;
            $line_tr = '';
            $line_td_num = '';
            $line_tr .= '<tr>';
            foreach ($this->ARRfields as $k => $field)
                $line_tr .= '<td class="th' . $k . '" >' . $field['label'] . '</td>';

            $line_tr .= '</tr>';
            foreach ($this->ARRitems as $item) {
                $i++;
                $td_line = '';
                $line_td_num .= '<tr><td>' . $i . '</td></tr>';
                if ($item['parent_id'] == 0){
                    foreach ($this->ARRfields as $k => $field) {
                        if ($i == 1)
                            $header_line .= '<th class="th' . $k . '" >' . $field['label'] . '</th>';


                        if (isset($field['link'])) {
                            $td_line .= '<td style="' . $style_td . '" class="th' . $k . '" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '"><a href="/admin/' . $this->id_table . '/edit/' . $item['id'] . '">' . $item[$field['name']] . '</a></td>';
                        } else {
                            $td_line .= '<td style="' . $style_td . '" class="th' . $k . '" id="' . $this->id_table . '_' . $item['id'] . '_' . $field['name'] . '">' . $item[$field['name']] . ' ' . (($this->id_table == 'actions' && $field['name'] == 'value') ? '%' : '') . '</td>';
                        }
                    }

                    if ($this->panel) {
                        $td_line .= '
						<td class="panel_td" style="">
						' . (($this->id_table == 'products') ? '<span class="panel_hot ' . (($item['hot'] == 1) ? 'active' : '') . '" id="' . $this->id_table . '_' . $item['id'] . '_hot"></span>' : '') . '
						<span class="panel_show ' . (($item['visibly'] == 0) ? 'panel_hide' : '') . '" id="' . $this->id_table . '_' . $item['id'] . '_show" title="' . (($item['visibly'] == 0) ? 'Показать' : 'Скрыть') . '"></span>
						<span class="panel_delete" id="' . $this->id_table . '_' . $item['id'] . '_delete"></span>
						</td>';
                    }

                    $line_tr .= '<tr id="' . $this->id_table . '_' . $item['id'] . '_tr" >' . $td_line . '</tr>';

                    foreach ($this->ARRitems as $sub_item) {
                        if ($sub_item['parent_id'] == $item['id']){
                            $td_line = '';
                            foreach ($this->ARRfields as $k => $field) {
                                if (isset($field['link'])) {
                                    $td_line .= '<td style="padding-left:70px; background: cornsilk;' . $style_td . '" class="th' . $k . '" id="' . $this->id_table . '_' . $sub_item['id'] . '_' . $field['name'] . '"><a href="/admin/' . $this->id_table . '/edit/' . $sub_item['id'] . '">' . $sub_item[$field['name']] . '</a></td>';
                                } else {
                                    $td_line .= '<td style="background: cornsilk;' . $style_td . '" class="th' . $k . '" id="' . $this->id_table . '_' . $sub_item['id'] . '_' . $field['name'] . '">' . $sub_item[$field['name']] . ' ' . (($this->id_table == 'actions' && $field['name'] == 'value') ? '%' : '') . '</td>';
                                }
                            }

                            if ($this->panel) {
                                $td_line .= '
                                            <td class="panel_td" style="background: cornsilk">
                                                ' . (($this->id_table == 'products') ? '<span class="panel_hot ' . (($sub_item['hot'] == 1) ? 'active' : '') . '" id="' . $this->id_table . '_' . $sub_item['id'] . '_hot"></span>' : '') . '
                                                <span class="panel_show ' . (($sub_item['visibly'] == 0) ? 'panel_hide' : '') . '" id="' . $this->id_table . '_' . $sub_item['id'] . '_show" title="' . (($sub_item['visibly'] == 0) ? 'Показать' : 'Скрыть') . '"></span>
                                                <span class="panel_delete" id="' . $this->id_table . '_' . $sub_item['id'] . '_delete"></span>
                                            </td>';
                            }

                            $line_tr .= '<tr id="' . $this->id_table . '_' . $sub_item['id'] . '_tr" >' . $td_line . '</tr>';
                        }
                    }
                }

            }

            $header_line .= !empty($this->panel) ? '<th style="width:60px;"></th>' : '';

            $table = '<table cellpadding="0" cellspacing="0" id="' . $this->id_table . '" class="' . $this->class_table . '" ><tbody>' . $line_tr . '</tbody></table>';

            $script = '<script>
								$(function(){
								' . (($this->field_sort) ? '$("table#' . $this->id_table . '").tablesorter({sortInitialOrder:"desc", sortMultisortKey:"ctrlKey"});' : '') . '
									
									$(".panel_td .panel_show").click(function(){
										if ($(this).hasClass("panel_hide")) {
												var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=visibly&value=1&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});
												$(this).removeClass("panel_hide");
										} else {
												var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=visibly&value=0&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});
												$(this).addClass("panel_hide");
										}
									})

									$(".panel_td .panel_delete").click(function(){
											var ArrId = $(this).attr("id").split("_");
											$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=delete&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
											});
										$("#"+ArrId[0]+"_"+ArrId[1]+"_tr").fadeOut(function(){
											$(this).remove();			
										})
										$(".num_table tr:last").fadeOut(function(){
											$(this).remove();			
										})
									})

									$(".panel_td .panel_hot").click(function(){
										if ($(this).hasClass("active")) {
												var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=hot&value=0&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});
												$(this).removeClass("active");
										} else {
												var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=hot&value=1&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});
												$(this).addClass("active");
										}
									})	

									$(".prices_season").change(function(){
										pricesCheckboxes($(this), "season");
									});
									
									$(".prices_order").change(function(){
										pricesCheckboxes($(this), "order");
									});

									function pricesCheckboxes(elem, action){

										if ($(elem).hasClass("active")) {
											var ArrId = $(elem).attr("name").split("_");	
											$.ajax({
												  url: "/admin/update",
												  type: "POST",
												  data: "stat=editfield&field=" + action + "&value=0&id="+ArrId[1]+"&f="+ArrId[0],
												  success: function(data){
												  }
											});
											$(elem).removeClass("active");
										} else {
											var ArrId = $(elem).attr("name").split("_");	
											$.ajax({
												  url: "/admin/update",
												  type: "POST",
												  data: "stat=editfield&field=" + action + "&value=1&id="+ArrId[1]+"&f="+ArrId[0],
												  success: function(data){
												  }
											});
											$(elem).addClass("active");
										}
									}
										
									$(".listing_price_edit").change(function(){
										var val = $(this).val();
										var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=price&value="+val+"&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});

									})

									$(".listing_cost_edit").change(function(){
										var val = $(this).val();
										var ArrId = $(this).attr("id").split("_");	
												$.ajax({
													  url: "/admin/update",
													  type: "POST",
													  data: "stat=editfield&field=cost&value="+val+"&id="+ArrId[1]+"&f="+ArrId[0],
													  success: function(data){
													  }
												});

									})
										
								});
						</script>';

            return $table . $script;
        } else {
            return $this->empty_message;
        }


    }

    private function getCount($count, $labels)
    {

        $val = (int)$count;

        if ($val > 10 && $val < 20) {
            return $count . ' ' . $labels[2];
        } else {
            $val = (int)$count % 10;
            if ($val == 1) {
                return $count . ' ' . $labels[0];
            } elseif ($val == 0) {
                return $count . ' ' . $labels[2];
            } else if ($val > 1 && $val < 5) {
                return $count . ' ' . $labels[1];
            } else {
                return $count . ' ' . $labels[2];
            }
        }

    }


}


//