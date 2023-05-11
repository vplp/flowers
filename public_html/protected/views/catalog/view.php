<style>
    .wrap_block .any_bield {
        /* position: absolute;  */
        margin: 0 !important;
    }

    .wrap_block.other_block .any_bield {
        position: static;
        margin: 0 !important;
    }
</style>

<?php
//    echo '<pre>';
//    print_r($product);
//    die();
?>

<div class="wrap_sizes wrap_item" style="position:relative;overflow: hidden;">
    <div class="navigation_item active">
        <?php if (isset($prev['id'])) :
            $Arrimg = explode('|', $prev['img']);
            $Arrimg = array_diff($Arrimg, array(''));
            ?>

            <div id="nav_prev_<?php echo $product['id'] ?>" class="prev_item nav_item">
                <!--<a class="preview_item prev non" href="/catalog/<?php //echo $prev['cat_uri']
                ?>/<?php //echo
                //$prev['id']
                ?>">-->
                <a class="preview_item prev non" href="/catalog/<?php echo $prev['id'] ?>">

                    <img src="/uploads/81x84/<?php echo current($Arrimg); ?>" width="50">
                    <span class="preview_item_name"><?php echo str_replace(' ', '&nbsp;', trim($prev['name'])) ?></span>
                    <div class="preview_item_name_overlay"></div>
                    <div class="preview_item_price item_price"><?php echo number_format($prev['price'], 0, ',', ' '); ?>
                        <span class="b-rub">Р</span></div>
                    <div class="item_prev">←</div>
                    <div class="krutilka"></div>
                    <div class="message_nav">Удобнее листать стрелками клавиатуры</div>
                </a>
            </div>
        <?php endif; ?>
        <?php if (isset($next['id'])) :
            $Arrimg = explode('|', $next['img']);
            $Arrimg = array_diff($Arrimg, array(''));
            ?>
            <div id="nav_next_<?php echo $product['id'] ?>" class="next_item nav_item">
                <!--<a class="preview_item next non" href="/catalog/<?php //echo $next['cat_uri']
                ?>/<?php //echo
                // $next['id']
                ?>">-->
                <a class="preview_item next non" href="/catalog/<?php echo $next['id'] ?>">
                    <img src="/uploads/81x84/<?php echo current($Arrimg); ?>" width="50">
                    <span class="preview_item_name"><?php echo str_replace(' ', '&nbsp;', trim($next['name'])) ?></span>
                    <div class="preview_item_name_overlay"></div>
                    <div class="preview_item_price item_price"><?php echo number_format($next['price'], 0, ',', ' '); ?>
                        <span class="b-rub">Р</span></div>
                    <div class="item_next">→</div>
                    <div class="krutilka"></div>
                    <div class="message_nav right">Удобнее листать стрелками клавиатуры</div>
                </a>
            </div>
        <?php endif; ?>
        <div class="br"></div>
    </div>
    <?php
    $swipe = (string)Yii::app()->request->cookies['swipe'];
    if ((int)$swipe != 1) {
        echo '<div class="nav_item_mobile disable">Товары можно листать влево-вправо</div>';
    }
    ?>

    <div id="content_item_<?php echo $product['id'] ?>"
         class="content_item <?php if (!Yii::app()->request->isPostRequest) echo 'item_def' ?> 	"
         data-href="/catalog/<?php echo $product['id'] ?>"
         data-title="<?php if (isset($product['meta_title']) && $product['meta_title'] != '') echo $product['meta_title']; else echo $product['name']; ?>">
        <?php
        $Arrimg = explode('|', $product['img']);
        $Arrimg = array_diff($Arrimg, array(''));
        $big = '';
        $sm = '';
        $i = 1;
        foreach ($Arrimg as $img) {
            $big .= '<div class="' . (($i == 1) ? 'select ' . ((Yii::app()->request->isPostRequest) ? 'aloading' : '') . '' : '') . '"><img id="big_' . $i . '" class="' . (($i == 1) ? 'select ' : '') . '" src="/uploads_water_new/460x460/' . str_replace('.jpg', '.webp', $img) . '" width="460"></div>';
            if (count($Arrimg) > 1)
                $sm .= '<div id="sm_' . $i . '" class="sm_one ' . (($i == 1) ? 'select ' . ((Yii::app()->request->isPostRequest) ? '' : '') . '' : '') . '"><img src="/uploads/100x100/' . $img . '" width="98"></div>';
            $i++;
        }

        //сохраняем неотсортированный массив, чтобы сохранить порядок вывода цветов в составе (item_feature)
        $old_product_prices = $product['prices'];

        //сортируем массив, для того чтобы росстовка шла по возрастанию
        function value_function_asc($a, $b)
        {
            return ($a['price'] > $b['price']);
        }

        function prices_function_asc($a, $b)
        {
            return ($a['cost'] > $b['cost']);
        }

        function value_function_desc($a, $b)
        {
            return ($a['price'] < $b['price']);
        }

        usort($product['features_price'], value_function_asc);
        usort($product['prices'], prices_function_asc);

        $def_price = $product['price'];
        $line_feature_price = '';
        $lfp_is_empty = 1;
        $fid = '';
        $select = 'select';

//                                echo '<pre>';
//                                print_r($product);
//                                die();


        //по умолчанию выбирается меньшая росстовка (первая)
//        foreach ($product['features_price'] as $K => $FP) {
//            $line_feature_price .= '<span data-price="' . number_format((int)$FP['price'], 0, ',', ' ') . '" id="fprice_' . $FP['id'] . '" class="blue fprice ' . $select . '">' . $FP['value'] . '</span>';
//            $select = '';
//        }

//        if ($product['id'] = 522) {
//
//            foreach ($product['prices'] as $item => $value) {
//                $db = Yii::app()->db;
//                $sql = 'INSERT  INTO  feature_product_price (product_id, feature_id, value, price) VALUES (\'' . $product['id'] . '\', \'' . 12 . '\',\'' . $item['height'] . '\',\'' . $item['cost'] . '\')';
//                $cmd = $db->createCommand($sql);
//                $cmd->execute();
//            }
//        }


//        foreach ($product['prices'] as $K => $FP) {
//            $line_feature_price .= '<span data-price="' . number_format((int)$FP['cost'], 0, ',', ' ') . '" id="fprice_' . $FP['price_id'] . '" class="blue fprice ' . $select . '">' . $FP['height'] . '</span>';
//            $select = '';
//        }

            $line_feature_price = '';
            $select = 'select';
            foreach ($product['features_price'] as $K => $FP) {

                if ($FP['value']!='')
                    $lfp_is_empty = 0;

                if (empty($fid))
                    $fid = $FP['id'];

//                if ($product['cat_uri']!='rozy' && $FP['feature_id']==12) {
//                    unset($product['features_price'][$K]);
//                }

                if (!($product['visible_in_roses']==1 && $FP['feature_id']==12)) {
                    $line_feature_price .= '<span data-price="' . number_format((int)$FP['price'], 0, ',', ' ') . '" id="fprice_' . $FP['id'] . '" class="blue fprice ' . $select . '">' . $FP['value'] . '</span>';
                    $select = '';
                }
            }

        ?>
        <div class="item_block <?php if (!Yii::app()->request->isPostRequest) echo 'aloading' ?> a_end">
            <div class="item_block_galery ">
                <div class="galery_big">
                    <?php echo $big ?>
                    <div class="wrap_nav left disable">
                        <div class="galery_nav l_nav"></div>
                    </div>
                    <div class="wrap_nav right <?php if ($sm == '') echo 'disable' ?>">
                        <div class="galery_nav r_nav"></div>
                    </div>
                </div>
                <div class="galery_sm">
                    <?php echo $sm ?>
                    <div class="br"></div>
                </div>
            </div>

            <div class="item_block_desc">
                <h1 class="item_block_name"><?php echo $product['name'] ?></h1>

                <?php

                $not_roses_features_price = [];
                foreach ($product['features_price'] as $item) {
                    if ($item['feature_id']!=12) {
                        $not_roses_features_price[] = $item;
                    }
                }

                if ($product['cat_id']!=73) {
                    $total_sum_prices = 0;
                    foreach ($product['prices'] as $price_item) {
                        $total_sum_prices += $price_item['quantity'] * $price_item['cost'];
                    }
                }
                ?>

                <?php

//                                                echo '<pre>';
//                                                print_r($product);
//                                                die();
                ?>

                <?php if(!empty($product['features_price'])):?>
                    <?php if($product['cat_id']!='73'):?>
                        <?php if($product['features_price'][0]['feature_id']!='12' and $product['features_price'][0]['price']>0 and $product['features_price'][0]['value']!=''):?>
                            <div class="item_block_price">
                                <span><?php echo number_format(($product['features_price'][0]['price']), 0, ',', ' '); ?></span>
                                <?php echo Formats::getCountPrice($product['features_price'][0]['price']) ?>
                            </div>
                        <?php else:?>
                            <div class="item_block_price">
                                <span><?php echo number_format(($product['price']), 0, ',', ' '); ?></span>
                                <?php echo Formats::getCountPrice($product['price']) ?>
                            </div>
                        <?php endif;?>
                    <?php else:?>
                        <div class="item_block_price">
                            <span><?php echo number_format(($product['features_price'][0]['price']), 0, ',', ' '); ?></span>
                            <?php echo Formats::getCountPrice($product['features_price'][0]['price']) ?>
                        </div>
                        <div class="rose_subdesc">Цена указана за 1 розу</div>
                    <?php endif;?>

                <?php else:?>
                    <div class="item_block_price">
                        <span><?php echo number_format(($product['price']), 0, ',', ' '); ?></span>
                        <?php echo Formats::getCountPrice($product['price']) ?>
                    </div>
                <?php endif;?>


<!--                    --><?php //if(empty($product['prices'])):?>
<!--                    <div class="item_block_price">-->
<!--                        <span>--><?php //echo number_format(($product['price']), 0, ',', ' '); ?><!--</span>-->
<!--                        --><?php //echo Formats::getCountPrice($product['price']) ?>
<!--                    </div>-->
<!---->
<!--                    --><?php //elseif($product['prices'] && $product['cat_uri']!='rozy'):?>
<!--                    <div class="item_block_price">-->
<!--                        <span>--><?php //echo number_format(($product['price']), 0, ',', ' '); ?><!--</span>-->
<!--                        --><?php //echo Formats::getCountPrice($product['price']) ?>
<!--                    </div>-->
<!---->
<!--                    --><?php //else:?>
<!--                        --><?php //if($product['cat_uri']=='rozy'):?>
<!--                            <div class="item_block_price">-->
<!--                                <span>--><?php //echo number_format(($product['prices'][0]['cost']), 0, ',', ' '); ?><!--</span>-->
<!--                                --><?php //echo Formats::getCountPrice($product['prices'][0]['cost']) ?>
<!--                            </div>-->
<!--                            <div class="rose_subdesc">Цена указана за 1 розу</div>-->
<!--                        --><?php //endif;?>
<!--                --><?php //endif;?>

                <?php if(!($product['is_ready']==1 )) {?>
                    <div class="not_order">Недоступно для заказа</div>
                <?php }?>

                <?php if ($line_feature_price != '' && !$lfp_is_empty) : ?>
                    <div class="item_feature">
                        <div class="item_feature_label"><?php echo $product['features_price_name'] ?></div>
                        <?php echo $line_feature_price ?>
                    </div>

                <?php endif; ?>
                <?php

//                echo '<pre>';
//                print_r($product['features']);
//                die();

                foreach ($product['features'] as $fearure):?>
                    <?php

                    if ($fearure['price'] != 1){
                        if (($fearure['name'] == 'Состав' or $fearure['name'] == 'Размер') and $product['cat_uri'] == 'rozy')
                            continue;

                        //$old_product_prices это неотсортированный массив $product['prices']
                        //нужно для сохранения порядка вывода цветов в составе
                        $this->renderPartial('item_feature', array(
                            'feature' => $fearure,
                            'product_prices' => $old_product_prices
                        ));
                    }
                         ?>
                <?php endforeach; ?>

                <?php if($product['is_ready']==1 ) {?>
                    <div class="item_feature" style="position:relative;">
                        <div class="item_feature_label">Количество</div>
                        <div class="one_product_price_desc_input_count">
                            <div class="one_product_input_count_minus count_minus"> −</div>
                            <div class="one_product_input_count_input"><input class="number" style="padding:8px 0;"
                                                                              name="count" id="count_product" type="text"
                                                                              value="1"></div>
                            <div class="one_product_input_count_plus count_plus"> +</div>
                        </div>
                        <?php if ($CheckCount == 1) : ?>
                            <div class="item_helper">Чтобы букет хорошо смотрелся,<br>выберите не меньше 7 роз</div>
                        <?php endif ?>
                    </div>

                    <a class="addtocart green_btn"
                       href="/catalog/add/<?php echo $product['id'] ?><?php if ($fid != '') echo '?fid=' . $fid; ?>"><span>Добавить в корзину</span>
                    </a>
                <?php } ?>
                <!-- <a class="addtocart blue_btn" href="/catalog/add/<?php //echo $product['id']?><?php //if ($fid != '') echo '?fid='.$fid;?>" data-fastorder="2"><span>Заказ в один клик</span></a> -->

                <div class="payment_info hide">
                    <ul class="payment_info_list">
                        <li>Принимаем оплату картами <img src="/img/icon/cards_icon.svg" class="payment_info_icon"></li>
                        <li>Доставляем по Кинелю</li>
                        <li>Сделаем любой букет по фото на заказ</li>
                        <li>Наличие на сегодня по <a class="blue" href="tel:+79967414590">+7 (996) 741-45-90</a></li>
                    </ul>
                </div>
            </div>
            <div class="br"></div>
        </div>

        <div class="wrap_sizes recent_block <?php if (Yii::app()->request->isPostRequest) echo 'no_prog_load' ?> ">
            <?php if (1) : ?>

            <?php
                foreach ($products as $key => $item) {
                    if ($item['cat_id']==$product['cat_id'] ||  ($item['cat_parent_id']!=0 && $item['cat_parent_id']==$product['parent_id'])) {
                        if ($item['id']==$product['id'] or $item['is_ready'] == 0) {
                            unset($products[$key]);
                        } else {
                            continue;
                        }
                    } else {
                        unset($products[$key]);
                    }
                }
            ?>

                <?php if (count($products) > 0) : ?>
                    <div class="wrap_block resize_block bottom_products a_load_block fixed_height_one show">
                        <div class="block_label">За те же деньги</div>
                        <div id="products_line" class="products_line ">
                            <?php $this->renderPartial('../catalog/items_line', array(
                                'products' => $products,
                                'sort' => false,
                                'page' => 'product',
                                'is_view' => true,
                            )); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (count($product['others']) > 0) : ?>

                    <div class="wrap_block  resize_block  bottom_products a_load_block fixed_height_one show">
                        <div class="block_label">С этим товаром покупают</div>
                        <div id="products_line" class="products_line ">
                            <?php $this->renderPartial('../catalog/items_line', array(
                                'products' => $product['others'],
                                'sort' => false,
                                'page' => '',
                                'is_view' => true,
                            )); ?>
                        </div>
                        <div class="br"></div>
                    </div>

                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>

</div>