    <?php
$url = Yii::app()->request->url;

//    echo '<pre>';
//    print_r($Catalog);
//    die();

?>

<div class="header_menu d-flex">
    <div class="header-menu-desctop-hide">
        <div class="contacts-geo d-flex">
            <div class="contacts-icon">
                <img src="/images/header-geo.svg" alt="geo">
            </div>
            <div class="contacts-desc header-geo-js" data-href="#map">Кинель: ул. Орджоникидзе, д.76 (6:40-23:00)</div>
        </div>
        <div class="toggle-wrap-btn d-flex">
            <button class="toggle-popup-handler">Заказать букет на мой бюджет</button>
        </div>
    </div>

    <div class="geo">
        <div class="contacts-geo d-flex">
            <div class="contacts-icon">
                <img src="/images/header-geo.svg" alt="geo">
            </div>
            <div class="contacts-desc header-geo-js" data-href="#map">Кинель: ул. Орджоникидзе, д.76 (6:40-23:00)</div>
        </div>
        <div class="toggle-wrap-btn d-flex">
            <button class="toggle-popup-handler">Заказать букет на мой бюджет</button>
        </div>
    </div>


    <?php
    $db = Yii::app()->db;
    $parent_ids = $db->createCommand('SELECT parent_id FROM categories')->queryAll();
    $flowersInFilter = $db->createCommand('select * from flowers where have_sef=1')->queryAll();
    $menu_item_arr = $db->createCommand('select id from categories where parent_id = 0 and typeCategory != 0 order by orders asc ')->queryAll();
    $have_mono_byket = $db->createCommand('select count(id) as count from products where is_mono_byket=1')->queryScalar();
    $mono_byket = $db->createCommand('select * from pages where is_mono_byket=1')->queryRow();

    $flowers_availability = $db->createCommand('select * from pages where id=30 or id=31')->queryAll();


    $fp = $db->createCommand("select fp.value as val, fp.cat_id
                             FROM features_products as fp, products as p, products_category as pc 
                             WHERE fp.feature_id = 10 and fp.value != '' and fp.product_id = p.id and p.visibly = 1 and fp.product_id = pc.product_id and pc.category_id = 84")->queryAll();

    $tmp = [];
    foreach ($fp as $arr){
        $new_arr = explode('|', $arr['val']);
        foreach ($new_arr as $n){
            $tmp[trim($n)] = trim($n);
        }
    }

    $flowerInMenu = $db->createCommand("SELECT * FROM flowers as f WHERE f.visible_in_menu = 1 LIMIT 1")->queryRow();
    $flowers_is_not_ready = $db->createCommand("SELECT id, name, COUNT(name) as name_count, SUM(`order`) as order_sum FROM `prices` GROUP BY name HAVING order_sum > 0 and name_count = order_sum;")->queryAll();

    $flowersInFilter = array_filter($flowersInFilter, function ($data) use ($tmp, $flowers_is_not_ready){
        $bool = true;

        foreach ($flowers_is_not_ready as $item)
            if ($data['name'] == $item['name']){
                $bool = false;
                break;
            }

        if ($bool == true)
            foreach ($tmp as $item) {
                $pos = strpos($item, $data['name']);
                if ($pos !== false)
                    return $data['name'];
            }
    });

//    echo '<pre>';
//    echo implode('|', $tmp);
//    print_r($mono_byket);
//    die();

    ?>

    <div class="menu-item red-item">
        <a href="/catalog/byketi/<?php echo $flowerInMenu['uri']; ?>" class="gray red-item"><?php echo $flowerInMenu['name']; ?></a>
    </div>

    <?php foreach ($Catalog as $cat) {

//        $menu_item_arr = ['73', '74', '75', '83', '84'];

        $red_menu_item = '';
        $a = array_filter($menu_item_arr, function ($data) use($cat){
           return $cat['id'] == $data['id'];
        });

        if (empty($a)) {
            $red_menu_item = 'red-item';
        }

//        echo '<pre>';
//        print_r($cat['submenu']);
//        die();

        $isSubMenu = !empty($cat['submenu']) ? true : false;
        ?>

        <?php if (preg_match('/' . $cat['uri'] . '$/', $url)) {?>

            <div class="menu-item <?php $isSubMenu ? ' menu-item-sub' : ''; ?>">
                <?php if ($isSubMenu || ($cat['uri'] == 'byketi')) { ?>
                    <details>
                        <summary class="red-item">
                            <span class="gray red-item">
                                <?php echo $cat['name']; ?>
                            </span>
                        </summary>

                        <?php if ($cat['uri'] == 'byketi') { ?>

                            <div class="header_submenu header_submenu_byketi">

                                <?php if($have_mono_byket) {?>
                                    <div class="monobyket">
                                        <a href="/catalog/byketi/<?php echo $mono_byket['uri'];?>">
                                            <li class="submenu-item <?= Yii::app()->params['cat_uri'] == $mono_byket['uri'] ? 'active_item' : '' ?>">Монобукеты</li>
                                        </a>
                                    </div>
                                <?php }?>

                                <div class="flowers">
                                    <p class="flowers-title">По цветам</p>
                                    <ul class="submenu-list">


                                        <a href="/catalog/<?php echo $cat['uri']; ?>">
                                            <li class="submenu-item">Все</li>
                                        </a>
                                        <?php foreach ($flowersInFilter as $flower) { ?>
                                            <a href="/catalog/byketi/<?php echo $flower['uri']; ?>">
                                                <li class="submenu-item <?= Yii::app()->params['cat_uri'] == $flower['uri'] ? 'active_item' : '' ?>"><?php echo $flower['name']; ?></li>
                                            </a>
                                        <?php } ?>
                                    </ul>
                                </div>

                                <div class="availability">
                                    <p class="availability-title">Наличие</p>
                                    <ul class="availability-list">
                                        <?php foreach ($flowers_availability as $item) { ?>
                                            <a href="/catalog/byketi/<?php echo $item['uri'];?>"><li class="availability-item"><?php echo $item['name'];?></li></a>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="header_submenu">
                                <ul class="submenu-list">
                                    <a href="/catalog/<?php echo $cat['uri']; ?>"><li class="submenu-item">Все</li></a>
                                    <?php foreach ($cat['submenu'] as $cat_item) { ?>
                                        <?php if($cat_item['count_products']>0) {?>
                                            <a href="/catalog/<?php echo $cat_item['uri']; ?>">
                                                <li class="submenu-item"><?php echo $cat_item['name']; ?></li>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </details>
                <?php } else { ?>
                    <a class="gray red-item"
                       href="/catalog/<?php echo $cat['uri']; ?>">
                        <?php echo $cat['name']; ?>
                    </a>
                <?php } ?>
            </div>

        <?php } elseif (preg_match('/' . $cat['uri'] . '.+/', $url)) { ?>

            <div class="menu-item <?php $isSubMenu ? ' menu-item-sub' : ''; ?>">
                <?php if ($cat['uri'] == 'rozy'){ ?>
                    <a class="gray <?php echo $red_menu_item; ?>"
                       href="/catalog/<?php echo $cat['uri']; ?>">
                        <?php echo $cat['name']; ?>
                    </a>
                <?php }else{ ?>
                     <details>
                    <summary>
                            <span class="gray">
                                <?php echo $cat['name']; ?>
                            </span>
                    </summary>

                    <?php if ($cat['uri'] == 'byketi') { ?>

                        <div class="header_submenu header_submenu_byketi">
                            <?php if($have_mono_byket) {?>
                                <div class="monobyket">
                                    <a href="/catalog/byketi/<?php echo $mono_byket['uri'];?>">
                                        <li class="submenu-item <?= Yii::app()->params['cat_uri'] == $mono_byket['uri'] ? 'active_item' : '' ?>">Монобукеты</li>
                                    </a>
                                </div>
                            <?php }?>

                            <div class="flowers">
                                <p class="flowers-title">По цветам</p>
                                <ul class="submenu-list">


                                    <a href="/catalog/<?php echo $cat['uri']; ?>">
                                        <li class="submenu-item">Все</li>
                                    </a>
                                    <?php foreach ($flowersInFilter as $flower) { ?>
                                        <a href="/catalog/byketi/<?php echo $flower['uri']; ?>">
                                            <li class="submenu-item <?= Yii::app()->params['cat_uri'] == $flower['uri'] ? 'active_item' : '' ?>"><?php echo $flower['name']; ?></li>
                                        </a>
                                    <?php } ?>
                                </ul>
                            </div>

                            <div class="availability">
                                <p class="availability-title">Наличие</p>
                                <ul class="availability-list">
                                    <?php foreach ($flowers_availability as $item) { ?>
                                        <a href="/catalog/byketi/<?php echo $item['uri'];?>"><li class="availability-item <?= Yii::app()->params['cat_uri'] == $item["uri"] ? 'active_item' : '' ?>"><?php echo $item['name'];?></li></a>
                                    <?php } ?>
                                </ul>
                            </div>

                        </div>

                    <?php } else { ?>
                        <?php if ($cat['uri'] != 'rozy') { ?>
                        <div class="header_submenu">
                            <ul class="submenu-list">
                                <a href="/catalog/<?php echo $cat['uri']; ?>"><li class="submenu-item">Все</li></a>
                                <?php foreach ($cat['submenu'] as $cat_item) { ?>
                                    <?php if($cat_item['count_products']>0) {?>
                                        <a href="/catalog/<?php echo $cat_item['uri']; ?>">
                                            <li class="submenu-item"><?php echo $cat_item['name']; ?></li>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </details>
                <?php } ?>
            </div>

        <?php } else { ?>

            <div class="menu-item <?php $isSubMenu ? 'menu-item-sub' : ''; ?>">
                <?php if ($isSubMenu || ($cat['uri'] == 'byketi')) { ?>
                    <details>
                        <summary class="<?php echo $red_menu_item; ?>">
                            <span class="gray <?php echo $red_menu_item; ?>">
                                <?php echo $cat['name']; ?>
                            </span>
                        </summary>

                        <?php if ($cat['uri'] == 'byketi') { ?>

                            <div class="header_submenu header_submenu_byketi">
                                <?php if($have_mono_byket) {?>
                                    <div class="monobyket">
                                        <a href="/catalog/byketi/<?php echo $mono_byket['uri'];?>">
                                            <li class="submenu-item <?= Yii::app()->params['cat_uri'] == $mono_byket['uri'] ? 'active_item' : '' ?>">Монобукеты</li>
                                        </a>
                                    </div>
                                <?php }?>

                                <div class="flowers">
                                    <p class="flowers-title">По цветам</p>
                                    <ul class="submenu-list">
                                        <a href="/catalog/<?php echo $cat['uri']; ?>">
                                            <li class="submenu-item">Все</li>
                                        </a>
                                        <?php foreach ($flowersInFilter as $flower) { ?>
                                            <a href="/catalog/byketi/<?php echo $flower['uri']; ?>">
                                                <li class="submenu-item"><?php echo $flower['name']; ?></li>
                                            </a>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="availability">
                                    <p class="availability-title">Наличие</p>
                                    <ul class="availability-list">
                                        <?php foreach ($flowers_availability as $item) { ?>
                                            <a href="/catalog/byketi/<?php echo $item['uri'];?>"><li class="availability-item"><?php echo $item['name'];?></li></a>
                                        <?php } ?>
                                    </ul>
                                </div>

                            </div>

                        <?php } else { ?>
                            <div class="header_submenu">
                                <ul class="submenu-list">
                                    <a href="/catalog/<?php echo $cat['uri']; ?>">
                                        <li class="submenu-item">Все</li>
                                    </a>
                                    <?php foreach ($cat['submenu'] as $cat_item) { ?>
                                        <?php if($cat_item['count_products']>0) {?>
                                            <a href="/catalog/<?php echo $cat_item['uri']; ?>">
                                                <li class="submenu-item"><?php echo $cat_item['name']; ?></li>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </details>
                <?php } else { ?>
                    <a class="gray <?php echo $red_menu_item; ?>"
                       href="/catalog/<?php echo $cat['uri']; ?>">
                        <?php echo $cat['name']; ?>
                    </a>
                <?php } ?>
            </div>

        <?php } ?>

    <?php } ?>

    <?php foreach ($pages as $page): ?>
        <?php if (preg_match('/' . $page['uri'] . '/', $url)): ?>
            <span class="gray select"><?php echo $page['name']; ?></span>
        <?php else: ?>
            <a class="gray contacts-link"
               href="<?php echo ($page['uri'] != '/' ? '/' : '') . $page['uri']; ?>"><?php echo $page['name']; ?></a>
        <?php endif; ?>
    <?php endforeach; ?>


    <div class="header_menu-mobile-sub-menu">
        <div class="extra-header-menu_links">
            <ul class="d-flex">
                <li><a href="/dostavka">Оплата и Доставка</a></li>
                <li><a href="/contacts">Контакты</a></li>
            </ul>
        </div>
        <iframe src="https://yandex.ru/sprav/widget/rating-badge/129741371697" width="150" height="50"
                frameborder="0"></iframe>
    </div>
</div>

