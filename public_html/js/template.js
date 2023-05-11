/*
 Krutilka (Spinner) Jquery Plugin, v 0.1
 Author: Artem Polikarpov | http://artpolikarpov.ru/
 */

$(function() {

    if ($(window).width() >= 1093) {
        $('details').on('mouseover', function (e) {
            $('details').attr('open', false);
            $('details').closest('.menu-item').removeClass('hover-menu-item');
            $(this).attr('open', 'open');
            $(this).closest('.menu-item').addClass('hover-menu-item');
        })
        $('details').on('mouseleave', function (e) {
            if (!$(e.target).find('.submenu-item').length == 0) {
                $('details').attr('open', false);
                $('details').closest('.menu-item').removeClass('hover-menu-item');
            }
        })
        $('.menu-item').on('mouseleave', function (e) {
            if (!$(e.target).find('.submenu-item').length == 0) {
                $('details').attr('open', false);
                $('details').closest('.menu-item').removeClass('hover-menu-item');
            }
        })

        $('details').on('click', function(e) {
            let link_item = $(this).find('.submenu-list a:first');
            if (link_item) {
                let link = link_item.attr('href');
                window.location.href = link;
            }
        })
    }
});

(function ($) {
    var ns = 'http://www.w3.org/2000/svg';
    var svgTest = function () {
        // Поддерживается ли СВГ
        var div = document.createElement('div');
        div.innerHTML = '<svg/>';
        return (div.firstChild && div.firstChild.namespaceURI) == ns;
    };

    var svgFLAG = svgTest();


    var makeSVG = function (tag, attrs) {
        var el = document.createElementNS(ns, tag);
        for (var k in attrs) {
            el.setAttribute(k, attrs[k]);
        }
        return el;
    };

    var krutilka = function (el, options) {
        el.data('initialized', true);

        var svg = $(makeSVG('svg', {
            width: options.size,
            height: options.size,
            style: 'background: ' + options.background + ''
        })).appendTo(el);
        var g = makeSVG('g', {fill: 'none', stroke: options.color, 'stroke-width': options.petalWidth});
        var $g = $(g).appendTo(svg);

        var x = options.size / 2;
        var y = options.size / 2;

        // Строим крутилку
        for (var _i = 0; _i < options.petals; _i++) {
            // Угол в градусах
            var a = 360 / options.petals * (options.petals - _i);
            // Прозрачность
            var opacity = Math.max(1 - 1 / options.petals * _i, .25);
            // Создаём линию
            $(makeSVG('line', {
                x1: options.size / 2,
                y1: options.petalOffset,
                x2: options.size / 2,
                y2: options.petalOffset + options.petalLength,
                transform: 'rotate(' + a + ' ' + x + ' ' + y + ')',
                opacity: opacity
            })).appendTo($g);
        }

        // Крутим крутилку
        var frame = 0;
        var animationInterval;
        var animation = function () {
            var a = 360 / options.petals * frame;
            g.setAttribute('transform', 'rotate(' + a + ' ' + x + ' ' + y + ')');

            frame++;
            if (frame >= options.petals) {
                frame = 0;
            }
        };

        el.bind('show', function (e, time) {
            // Показываем и запускаем крутилку
            el.stop().fadeTo('fast', 1);
            clearInterval(animationInterval);
            animation();
            animationInterval = setInterval(animation, (time ? time : options.time) / options.petals);
        });

        el.bind('hide', function () {
            // Скрываем и останавливаем крутилку
            el.stop().fadeTo('fast', 0, function () {
                clearInterval(animationInterval);
            });
        });

        el.trigger('show');
    };

    $.fn.krutilka = function (o) {
        var options = {
            size: 32, // Ширина и высота блока с крутилкой
            petals: 15, // Сколько лепестков у крутилки
            petalWidth: 2, // Толщина лепестка
            petalLength: 8, // Длина лепестка
            petalOffset: 1, // Внутреннее поле блока с крутилкой (расстояние до кончика лепестка)
            time: 1000, // Время прохода круга в миллисекундах
            color: '#808080', // Цвет лепестков
            background: 'none' // Фон крутилки
        };

        $.extend(options, o);

        this.each(function () {
            var el = $(this);
            if (!el.data('initialized') && svgFLAG) {
                // Если ещё не инициализировано
                krutilka(el, options);
            }
        });

        // Чейнабилити
        return this;
    };
})(jQuery);

$(document).ready(function () {
    jQuery(function ($) {
        $(document).mouseup(function (e) { // событие клика по веб-документу
            var div = $('details[open]');
            if (!div.is(e.target) && div.has(e.target).length === 0) { // если клик был не по нашему блоку и не по его дочерним элементам
                if ($('details[open]')[0]) {
                    $('details[open]')[0]['open'] = false;
                    $('details').closest('.menu-item').removeClass('hover-menu-item');
                }
            }
        });
    });
});


$(function () {
    if (!jQuery || !window.jQuery) return false;
    else $(".ias_pager").hide();

    /* global functions */
    var _OS = CheckOS();

    initktutilka();
    UpdatePositionBasket();
    $(window).resize(function () {
        UpdatePositionBasket()
    })
    ScrollingMenu();
    $(window).scroll(function () {
        ScrollingMenu();
    });


    /* ALoading */
    function ALoading(element, callback) {
        element.each(function () {
            $(this).attr('data-pos', parseInt($(this).offset().top));
            if ($(this).hasClass('h_fotorama')) {
                $(this).on('fotorama:ready', function (e, fotorama) {
                    $(this).addClass('a_end')
                });
            }
        })
        element.find('img, embed').each(function () {
            $(this).addClass('i_load');
            $(this).bindImageLoad(function () {
                $(this).removeClass('i_load').addClass('i_end');
            });
        })
        var interval = setInterval(function () {
            LoadingElement(element, callback)
        }, 100)

        function LoadingElement(element, callback) {
            var i = 0;
            element.each(function () {
                if (!$(this).hasClass('a_end')) {
                    i++;
                    var check = true;
                    if (!$(this).parents('.no_prog_load').length) {
                        var pos = parseInt($(this).attr('data-pos'));
                        element.each(function () {
                            if (!$(this).hasClass('a_end')) {

                                if (pos > parseInt($(this).attr('data-pos'))) {
                                    check = false;

                                }
                            }
                        })
                    }
                    if (check) {
                        if (!$(this).hasClass('h_fotorama')) {
                            if (!$(this).find('img.i_load:not(i_end)').length) {
                                var el = $(this);
                                el.parents('.a_load_block').addClass('show');
                                el.addClass('a_end')
                                if (!el.hasClass('pass'))
                                    el.find('.any_bield').addClass('scale0');

                            } else {

                            }
                        }
                    } else {
                    }
                }
            })
            if (i == 0) {
                clearTimeout(interval);
                if (callback) callback();
            }
        }
    }


    ;
    (function ($) {
        $.fn.bindImageLoad = function (callback) {
            function isImageLoaded(img) {

                if (!img.complete) {
                    return false;
                }
                if (typeof img.naturalWidth !== "undefined" && img.naturalWidth === 0) {
                    return false;
                }
                return true;
            }

            return this.each(function () {
                var ele = $(this);
                if (ele.is("img") && $.isFunction(callback)) {
                    ele.one("load", callback);
                    if (isImageLoaded(this)) {
                        ele.trigger("load");
                    }
                }
            });
        };
    })(jQuery);

    /*  LOGIN */
    var show = false;
    $('.footer_login').css('left', ($(window).width() - 370) / 2 + 'px');

    $('#login').click(function () {

        show = true;
        var el = $('#login_input');
        $('.footer_login').animate({"top": "0"}, 200, function () {
            document.getElementById("login_input").focus();
        })


        el.keydown(function (e) {
            if (e.which == 13) {
                ToLogin()
            }

        });
        el.keyup(function (e) {
        });
        $('body').click(function () {
            if (!$('.footer_login').is(':hover') && show && !$('#login').is(':hover')) {
                $('.footer_login').animate({"top": "-90px"}, 200)
            }
        });
        return false;
    })
    $('#logout').click(function () {
        $.ajax({
            url: '/logout',
            type: 'POST',
            data: 'stat=logout',
            success: function (data) {
                if (data) {
                    window.location = data;
                }
            }
        });
        return false;
    });

    function ToLogin() {
        var pass = $('#login_input').val()
        $.ajax({
            url: '/login',
            type: 'POST',
            data: 'stat=login&pass=' + pass,
            success: function (data) {
                if (data) {
                    window.location = data;
                } else {
                    $('.footer_login').animate({"left": "+=5px"}, 50)
                        .animate({"left": "-=8px"}, 50)
                        .animate({"left": "+=6px"}, 50)
                        .animate({"left": "-=4px"}, 50)
                        .animate({"left": "+=1px"}, 50);
                }
            }
        });
    }


    /*   ANIMATE ITEMS  */
    var Ani = '';
    var Animate = function (el) {
        var newPos = $(el).parent().position()
        newPos = {
            'left': newPos.left + eval(($(el).parent().css('margin-left').split('px')[0])) + 'px',
            'top': (newPos.top + 25) + 'px'
        }
        $(el).css(newPos)
    }
    var ItemsCentered = function (el) {
        var itemwidth = (el.find('.item:not(.hide)').width() + 20);
        var count = Math.floor((el.width()) / (itemwidth));

        if (el.find('.index').length > 0) {
            var elemLength = el.find('.item:not(.hide)').length;
            if (count >= elemLength) {
                el.find('.item').each(function () {
                    if ($(this).index() < count - 1) {
                        $(this).removeClass('hide');
                    }
                })
            } else {
                el.find('.item:not(.hide)').each(function () {
                    if ($(this).index() >= count - 1 && $(this).index() < elemLength - 1) {
                        $(this).addClass('hide');
                    }
                })
            }

        }
        if (count > el.find('.item:not(.hide):not(.pass)').length)
            count = el.find('.item:not(.hide):not(.pass)').length;

        var PadWidth = (el.width()) - (el.find('.item:not(.hide)').width() * count);
        var padding = Math.floor((PadWidth / count) / 2) - 1;

        el.find('.item:not(.hide)').css({'margin-left': padding + 'px', 'margin-right': padding + 'px'})

        if (!$('body.body_edit').length)
            HandlerAimate(el.find('.any_bield'));
    }
    initSortable();
    ALoading($('.aloading'), function () {
    });

    if (!$('body.body_edit .wrap_block.sortable').length) {
        AddAniBield();
    }

    HandlerAimate(Ani);
    HandlerCentered($('.wrap_block:not(.other_block)'));
    setTimeout(function () {

        HandlerCentered($('.wrap_block:not(.other_block)'));
    }, 600)

    $(window).resize(function () {
        setTimeout(function () {
            HandlerCentered(false);
        })
    })


    function detachForm(countBlocks) {

        if ($('.item')[0] && $('.catalog-page'))  {
            let widthContent = $('.catalog-page').width();
            let widthItem = $('.item').width();
            let marginItem = parseInt($('.item')[0].style.marginLeft) * 2;

            if ($('body').width() < 425)
                marginItem = 0;

            widthItem = widthItem + marginItem;

            let countItemsInRow = Math.floor(widthContent / widthItem);
            let countItemsBeforeForm = countItemsInRow * 3;

            countBlocks = {
                mobile: countItemsBeforeForm,
                planshet: countItemsBeforeForm,
                desctopsm: countItemsBeforeForm,
                desctopxl: countItemsBeforeForm
            };

        }

        // console.log('countItemsInRow', countItemsInRow);

        // if ($('.s_sm_img').hasClass('select')) {
        //     countBlocks = {
        //         mobile: 6,
        //         planshet: 12,
        //         desctopsm: 15,
        //         desctopxl: 21
        //     };
        // } else {
        //     countBlocks = {
        //         mobile: 6,
        //         planshet: 9,
        //         desctopsm: 12,
        //         desctopxl: 15
        //     };
        // }

        const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
        let form = $('.products_line .flower_order_form_wrap').detach();
        $(form).addClass('loaded');
        let collectionsBuketi = $('.collections_buketi-wrap').detach();
        let items = $('.catalog-page .item:not(.hide)');

        if (items.length < countBlocks.mobile || items.length < countBlocks.planshet || items.length < countBlocks.desctopsm || items.length < countBlocks.desctopxl) {
            $('.catalog-page').append(form);
            $('.catalog-page').append(collectionsBuketi);
            return false;
        }

        if (!$('.catalog-page').hasClass('index')) {
            $(items).each(function (i) {
                if ((vw >= 320 && vw < 1024) && i + 1 == countBlocks.mobile) {
                    $(this).after(form);
                    $(form).after(collectionsBuketi);
                }
                if ((vw >= 1024 && vw < 1366) && i + 1 == countBlocks.planshet) {
                    $(this).after(form);
                    $(form).after(collectionsBuketi);
                }
                if ((vw >= 1366 && vw < 1920) && i + 1 == countBlocks.desctopsm) {
                    $(this).after(form);
                    $(form).after(collectionsBuketi);
                }
                if ((vw >= 1920) && i + 1 == countBlocks.desctopxl) {
                    $(this).after(form);
                    $(form).after(collectionsBuketi);
                }
            });
        }

    }


    $('.sm_big_chahge div').click(function () {
        if (!$(this).hasClass('select')) {
            $(this).parents('.resize_block').toggleClass('big_block');
            $(this).parents('.resize_block').find('.sm_big_chahge div').toggleClass('select');
            HandlerCentered($('.wrap_block:not(.other_block)'));
            SetCickokieSort();
        }

        if ($(this).hasClass('s_big_img')) {
            detachForm({
                mobile: 6,
                planshet: 9,
                desctopsm: 12,
                desctopxl: 15
            });
        } else {
            detachForm({
                mobile: 6,
                planshet: 12,
                desctopsm: 15,
                desctopxl: 21
            });
        }

    })

    function SetCickokieSort() {

        var type = 'Все';
        var subtype = '';
        if ($('#sort_type a.select').length) {
            type = $('#sort_type a.select').html()
            subtype = $('#sort_type a.select').data('subtype')
        }

        var price = '';
        price = $('#sort_price a.select').attr('data-price');

        var sort = '';
        if ($('#sort_sort a.select').length)
            sort = $('#sort_sort a.select').attr('data-sort');

        var smbig = 'sm';
        if ($('.sm_big_chahge .select').hasClass('s_big_img ')) {
            smbig = 'big';
        }
        var data = {
            type: type,
            subtype: subtype,
            price: price,
            sort: sort,
            smbig: smbig
        }

        $.ajax({
            url: '/catalog/sort',
            type: 'POST',
            data: data,
            success: function (data) {
            }
        });
    }

    function HandlerAimate(any) {
        $.each(any, function (index, el) {
            Animate(el)
        })
    }

    function HandlerCentered(Bck) {
        if (!Bck) {
            $('.wrap_block:not(.other_block)').each(function () {
                ItemsCentered($(this))
            })
        } else {
            Bck.each(function () {
                ItemsCentered($(this))
            })
        }
    }

    function AddAniBield() {
        $('.ani_box:not(.any_add)').wrapInner('<div class="any_bield" />')
        Ani = $('.ani_box:not(.any_add) .any_bield');
        $('.ani_box:not(.any_add)').addClass('any_add')
        setTimeout(function () {
            Ani.addClass('ani_animated_box');
            Ani.addClass('scale0');
        }, 333)

    }


    /* ADD TO CART */
    var EnterEnable = false;

    $('body').on('click', '.buy_order:not(.confirm_btn)', function (e) {
        e.preventDefault();
        var el = $(this);
        el.parents('.basket').addClass('confirm_basket')
        EnterEnable = true;
        //return false;
    })

    $('body').on('click', '.addtocart', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        AddToCart(href, $(this));
        EnterEnable = false;
        if (typeof $(this).data('fastorder') !== 'undefined') {
            step = $(this).data('fastorder');
        } else {
            step = 1;
        }
        basketStep.changeStep(step);
    })

    $('body').on('click', '.basket_item_del', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var elem = $(this).closest('.cart-item-wrapper');
        DeleteToCart(href, elem);
    })

    $('body').on('click', '.basket_clear', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        EnterEnable = false;
        $.ajax({
            type: 'POST',
            url: href,
            success: function (response) {
                data = $.parseJSON(response);
                if (data.error == 0) {
                    basketStep.$basket.find('.basket_step').removeClass('_active')
                    $(".basket_poduct .preview_item").remove();
                    UpdateBasket();
                    $('.basket').removeClass('confirm_basket').removeClass('sended')
                }
            }
        });
    })

    function AddToCart(href, el) {
        var data = '';
        if (el.parents('.item_block').find('.one_product_price_desc_input_count input.number').length){
            var count = parseInt(String(el.parents('.item_block').find('.one_product_price_desc_input_count input.number').val()).replace(/\s+/g, ''), 10);
            var current_price = el.parents('.item_block').find('.item_block_price span').html();
        }

        if (el.parents('.item').find('.item_price').length){
            var current_price = parseInt(String(el.parents('.item').find('.item_price').text()).replace(/\s+/g, ''), 10);
            var count = 1;

            console.log('current_price', current_price)
        }

        if (el.parents('.cart-item').find('.cart-item-price').length){
            var current_price = parseInt(String(el.parents('.cart-item').find('.cart-item-price span').text()).replace(/\s+/g, ''), 10);
            var count = 1;
        }

        console.log('current_price2', current_price);
        // console.log(count);

        data = {
            count: count,
            current_price
        }

        $.ajax({
            type: 'POST',
            url: href,
            data: data,
            success: function (response) {

                data = $.parseJSON(response);
                if (data.error == 0) {
                    el.closest('.item_add_to_cart').find('.addtocart').addClass('in_cart');
                    el.closest('.item_add_to_cart').find('.addtocart')
                        .html('В корзине')
                        .attr('href', '/cart')
                        .removeClass('addtocart');

                    el.parents('.item_block').find('.one_product_price_desc_input_count input.number').val(1);
                    $('.basket').removeClass('confirm_basket').removeClass('sended')
                    UpdateBasket();
                    if (!$('.basket #pr' + data.id).length) {
                        $(".basket_poduct .br").before('<div class="preview_item " id="pr' + data.id + '">' + data.preview + '</div>');
                    } else {

                        $('.basket #pr' + data.id).html(data.preview);
                    }
                    UpdatePositionBasket();
                    // $('html, body').animate({
                    //   	scrollTop: 0
                    // }, 200);
                    yaCounter24162886.reachGoal('addtocart');
                }
            }
        });
    }

    function DeleteToCart(href, el) {
        $.ajax({
            type: 'POST',
            url: href,
            success: function (response) {
                data = $.parseJSON(response);
                if (data.error == 0 && data.check) {
                    el.remove();
                    UpdateBasket($(el).find('.cart-item').attr('id'));
                    UpdatePositionBasket();
                } else {
                    UpdateBasket();
                    UpdatePositionBasket();
                }
            }
        });
    }

    function UpdateBasket(el = '', delprice) {
        var allprice = 0;
        var allpriceNum = 0;
        var count = 0;
        var allCount = 0;
        let deliveryPrice = delprice ? delprice : 0;
        if (getCookie('cart')) {
            $Arrcoockie = getCookie('cart').split('|');
            for (var i = 0; i < $Arrcoockie.length; i++) {
                var Arrone = $Arrcoockie[i].split(':');
                if ($Arrcoockie[i] != '') {
                    var Arrone = $Arrcoockie[i].split(':');
                    count = count + 1;
                    allCount += parseInt(Arrone[2]);
                    allprice += (parseInt(Arrone[1]) * parseInt(Arrone[2]));
                    allpriceNum += (parseInt(Arrone[1]) * parseInt(Arrone[2]));
                }
            }
            var allprice_correct_str = get_correct_str(allprice, 'рубль', 'рубля', 'рублей');
            allprice = allprice.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1&nbsp;');

        } else {
            var item = '0 товаров';
            allprice = 0;
            allpriceNum = 0;
        }
        if (count == 0) {

            $('.mini-cart-count').remove();
            $('.cart-total-wrap ').remove();
            $('.cart-item-list').html('Корзина пуста');
            $('.mini-cart-text').html('Корзина пуста');
        } else {
            allpriceNum += deliveryPrice;
            allpriceNum = allpriceNum.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1&nbsp;');

            $('.mini-cart-icon').html(
                `<a href="/cart">
					<img src="/images/mini-cart-icon.svg" alt="mini-cart">
				</a>
				<div class="mini-cart-count">${allCount}</div>`
            );
            $('.mini-cart-text').html(
                `<a href="/cart" class="d-flex">
					<span class="mini-cart-price">${allprice} ${allprice_correct_str}</span>
					<span class="mini-cart-link">Оформить заказ</span>
				</a>`
            );

            $('.cart-total').html('<span>Итого </span><span>' + allprice + ' ₽</span>');
            $('.cart-order-total').html(
                `<span>Итого с учетом доставки</span>
				 <span>${(deliveryPrice != 'individual' && deliveryPrice != 'samovivoz') ? allpriceNum : allprice} ₽</span>`
            );

            let individualString;

            if (deliveryPrice == 'individual' || deliveryPrice == 0) {
                individualString = 'расчет по запросу';
            } else if (deliveryPrice == 'samovivoz') {
                individualString = 'Бесплатно';
            } else {
                individualString = deliveryPrice + ' ₽';
            }

            $('.cart-order-delivery').html(
                `<span>Доставка</span>
				<span>
				${individualString} 
				</span>`
            )

            $('.cart-order-list li').each(function (i) {
                if ($(this).attr('id') == el) {
                    $(this).remove();
                }
            });
        }


    }

    function selectBox() {
        // Элемент select, который будет замещаться:
        var select = $('.cart-contact-info-content select');

        var selectBoxContainer = $('<div>', {
            width: select.outerWidth(),
            class: 'tz-select',
            html: '<div class="select-box"></div>'
        });

        var dropDown = $('<ul>', {
            class: 'dropdown'
        });
        var selectBox = selectBoxContainer.find('.select-box');

        // Цикл по оригинальному элементу select

        select.find('option').each(function (i) {

            var option = $(this);

            // if (i == select.attr('selectedIndex')) {
            //     selectBox.html(option.text());
            // }


            // Создаем выпадающий пункт в соответствии
            // с иконкой данных и атрибутами HTML5 данных:

            // var li;

            var li = $('<li>', {
                html: '<span data-delivery="' + option.data('delivery') + '">' + option.text() + '</span>'
            });

            // if (option.data('delivery')==0) {
            //     li = $('<li style="height: 56px;">', {
            //         html: '<span data-delivery="' + option.data('delivery') + '">' + option.text() + '</span>'
            //     });
            // } else {
            //     li = $('<li>', {
            //         html: '<span data-delivery="' + option.data('delivery') + '">' + option.text() + '</span>'
            //     });
            // }

            li.click(function () {

                selectBox.html(option.text());
                dropDown.trigger('hide');

                // Когда происходит событие click, мы также отражаем
                // изменения в оригинальном элементе select:
                select.val(option.val());
                UpdateBasket('', $(this).find('span').data('delivery'));
                localStorage.setItem('delivery', $(this).find('span').data('delivery'));
                return false;
            });

            if (i == 0) {
                dropDown.append('<li><input type="text" placeholder="Поиск"></li>');
                dropDown.append(li);
            } else {
                dropDown.append(li);
            }

        });

        selectBoxContainer.append(dropDown.hide());
        select.hide().after(selectBoxContainer);

        // Привязываем пользовательские события show и hide к элементу dropDown:

        dropDown.bind('show', function () {

            if (dropDown.is(':animated')) {
                return false;
            }

            selectBox.addClass('expanded');
            dropDown.slideDown();

        }).bind('hide', function () {

            if (dropDown.is(':animated')) {
                return false;
            }

            selectBox.removeClass('expanded');
            dropDown.slideUp();

        }).bind('toggle', function () {
            if (selectBox.hasClass('expanded')) {
                dropDown.trigger('hide');
            } else dropDown.trigger('show');
        });

        selectBox.click(function () {
            dropDown.trigger('toggle');

            return false;
        });

        // Если нажать кнопку мыши где-нибудь на странице при открытом элементе dropDown,
        // он будет спрятан:

        $(document).click(function (e) {
            if ($(e.target).closest('li').find('input').length == 0) {
                dropDown.trigger('hide');
            }
        });
    }

    localStorage.setItem('delivery', 0);

    selectBox();

    function UpdatePositionBasket() {
        /*
        if ($(window).width() < 1500) {
        	$('.basket_poduct').css('width', ($('.basket .wrap_sizes').width() - 380)+'px')
        	var count_item_line = Math.floor(( $('.basket_poduct').width()) / 225);
        } else {
        	$('.basket_poduct').css('width', ($('.basket .wrap_sizes').width() - 380 - 150)+'px')
        	var count_item_line = Math.floor(( $('.basket_poduct').width() - 120) / 225);
        }
		
        if (count_item_line > $('.basket_poduct .preview_item').length)
        	count_item_line = $('.basket_poduct .preview_item').length;
		
        var margin = (count_item_line  * 240)   ;
        if ($(window).width() > 1500) {
        	margin += 75
        }
        if (count_item_line < 2){
        	$('.confirm_form').addClass('sm')
        } else {
        	$('.confirm_form').removeClass('sm')
        }
		
		
        $('.basket_order').css({'right': 'auto', 'left': margin+'px'})
        */
    }

    function get_correct_str(num, str1, str2, str3) {
        var val = eval(num);
        if (val > 10 && val < 20) {
            return '&nbsp;' + str3;
        } else {
            val = eval(num) % 10;
            if (val == 1) {
                return '&nbsp;' + str1;
            } else if (val > 1 && val < 5) {
                return '&nbsp;' + str2;
            } else {
                return '&nbsp;' + str3;
            }
        }
    }

    function getCookie(name) {
        var cookie = " " + document.cookie;
        var search = " " + name + "=";
        var setStr = null;
        var offset = 0;
        var end = 0;
        if (cookie.length > 0) {
            offset = cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                end = cookie.indexOf(";", offset)
                if (end == -1) {
                    end = cookie.length;
                }
                setStr = unescape(cookie.substring(offset, end));
            }
        }
        return (setStr);
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";" + expires + '; path=/';
    }

    /* AJAX LOAD CATALOG  */

    var href = location.href;
    var ajaxContentHandler = function (el, href) {
        var body = $('body');
        if (body.data('ajaxContent') == 1) return false;

        var get = '';
        if ($('#sort_price a.select').length) {
            get += '?price=' + $('#sort_price a.select').html()
        }
        if ($('#sort_type a.select').length) {
            if (get != '') var sep = '&';
            else var sep = '?';
            get += sep + 'type=' + $('#sort_type a.select').html()
        }
        if ($('#sort_sort a.select').length) {
            if (get != '') var sep = '&';
            else var sep = '?';
            get += sep + 'sort=' + $('#sort_sort a.select').attr('data-sort')
        }
        if (el.attr('href') != '' && el.attr('href') != '#')
            href = el.attr('href');
        // $('.products_line .ani_animated_box').removeClass('scale0');

        $.ajax({
            type: 'POST',
            url: href + get,
            beforeSend: function () {
                body.data('ajaxContent', 1);
            },
            success: function (data) {
                setTimeout(function () {
                    $('#products_line').html(data);
                    AddAniBield();
                    HandlerCentered($('.wrap_block:not(.other_block)'));
                    ALoading($('.aloading'));
                    initAjaxScroll();
                }, 100)

            },
            complete: function () {
                body.data('ajaxContent', 0);
            }
        });
        return href;

    };

    $(document).ready(function () {
        // $('.products_line .ani_animated_box').addClass('scale0');
        jQuery(function ($) {
            var type = $('.header_submenu').find('.active_item').html();
            var type_availability = '';

            // console.log('type', type);
            // console.log('type_availability', type_availability);

            if (!type) {
                type = $('#sort_type a.select').html();
            }

            type = type=='Все' ? '' : type;

            if (type) {
                type = type.slice(0,-1);
            }

            var type_availability = $('.availability').find('.active_item').html();
            if (type_availability)
                type_availability = type_availability.slice(0, -1);

            $('.one_sort_label_variants').find('.blue').each(function () {
                if ($(this).html() == type){
                    $(this).addClass('select');
                }
            });

            $('#sort_status').find('.blue').each(function () {
                if ($(this).html() == type_availability){
                    $(this).addClass('select');
                }
            });


            // if ($('#sort_status a.select').length) {
            //     currentStatus = $('#sort_status a.select').data('value');
            //     var typeStatus = $('#sort_status a.select').html();
            // }
            //
            // console.log('typeStatus', typeStatus);

            if ($('.catalog-page .item').length==0) {
                $('.catalog_empty').addClass('show');
            }

            if (!type) {
                type = $('.one_sort_type a.select').html();
            }

            console.log(type);
            console.log(type_availability);

            if ($('.one_sort_type a.select').data('subtype')=='flowertype') {
                $('.item').each(function () {
                    var check = true;
                    if ($('input.sorttype').length)
                        var i_type = $(this).find('input.sorttype').val();
                    else
                        var i_type = '';

                    // var new_i_type = i_type.split('|');
                    //
                    // for (let i=0; i<new_i_type.length; i++) {
                    //     new_i_type[i] = new_i_type[i].slice(0, -1);
                    // }
                    //
                    // i_type = new_i_type.join('|');

                    if (type) {
                        if (type != '' && !i_type.match(type))
                            check = false;
                    }

                    if (type_availability) {
                        if (type_availability != '' && !i_type.match(type_availability))
                            check = false;
                    }


                    // if (!i_type.match(typeStatus))
                    //     check = false;


                    if (check) {
                        $(this).removeClass('pass')
                    } else {
                        $(this).addClass('pass');
                        // $(this).find('.any_bield').removeClass('scale0');
                    }

                    $('.item.pass').addClass('hide');
                    $('.item:not(.pass)').removeClass('hide');

                    setTimeout(function () {
                        $('.item:not(.pass) .any_bield').addClass('scale0');
                        if (!$('.item:not(.pass) .any_bield').length)
                            $('.catalog_empty').addClass('show');
                        return true;
                    }, 600)


                    if (!$('.resize_block').hasClass('big_block')) {

                        detachForm({
                            mobile: 6,
                            planshet: 12,
                            desctopsm: 15,
                            desctopxl: 21
                        });
                    } else {

                        detachForm({
                            mobile: 6,
                            planshet: 9,
                            desctopsm: 12,
                            desctopxl: 15
                        });
                    }
                })
            } else {
                setTimeout(function () {
                    $('.item:not(.pass) .any_bield').addClass('scale0');
                    if (!$('.item:not(.pass) .any_bield').length)
                        $('.catalog_empty').addClass('show');
                    return true;
                }, 600)
            }
        });
    });

    function liveSort(callback) {
        //		if (!$('#sort_price').length) {
        //				
        //			if (callback) callback();
        //			return true;
        //		}
        //$('.description_block').css('opacity','0');
        var type = '';

        if (type)
            type = type.slice(0,-1);

        var subtype = '';
        var currentCategory = '';

        var type_availability = $('#sort_status').find('.blue.select').html();
        if (type_availability)
            type_availability = type_availability.slice(0,-1);

        if ($('#sort_type a.select').length) {
            if ($('#sort_type a.select').html() != 'Все') {
                subtype = $('#sort_type a.select').attr('data-subtype');
                currentCategory = $('#sort_type a.select').data('value');
                if (subtype == 'flowertype') {
                    type = $('#sort_type a.select').html();

                    if (type)
                        type = type.slice(0,-1);
                }
            }
        }

        searchText = $('[name=searchByName]').val().toLowerCase();

        var price = '';
        if ($('#sort_price a.select').length && $('#sort_price a.select').html() != 'Любая')
            price = $('#sort_price a.select').attr('data-price');


        $('.catalog_empty').removeClass('show');
        $('.item').each(function () {
            var check = true;
            if ($('input.sorttype').length) {
                var i_type = $(this).find('input.sorttype').val();
                console.log($(this));
            } else {
                var i_type = '';
            }

            // var new_i_type = i_type.split('|');
            //
            // for (let i=0; i<new_i_type.length; i++) {
            //     new_i_type[i] = new_i_type[i].slice(0, -1);
            // }
            //
            // i_type = new_i_type.join('|');

            var i_price = $(this).find('input.sortprice').val();

            console.log('i_type', i_type);

            if (type && i_type ) {
                if (type != '' && !i_type.match(type))
                    check = false;
            }

            if (type_availability && i_type) {
                if (type_availability != '' && !i_type.match(type_availability))
                    check = false;
            }


            let sortTypeArr = i_type.split('|');

            for (let i = 0; i < sortTypeArr.length; i++) {
                let searchByName = $(this).find('.item_desc-name a').text();

                if (!sortTypeArr[i].toLowerCase().match(searchText) && !searchByName.toLowerCase().match(searchText)) {
                    check = false;
                }
            }

            itemCategory = $(this).find('input[data-sort=category]').val();
            if (subtype == 'cat' && itemCategory != currentCategory) {
                check = false;
            }

            if (price != '') {
                var priceArr = price.split('-');
                if ((!priceArr[1] && parseInt(i_price) <= parseInt(price)) || (priceArr[1] && parseInt(i_price) >= parseInt(priceArr[0]) && parseInt(i_price) <= parseInt(priceArr[1]))) {
                } else {
                    check = false;
                }
            }

            if (check) {
                $(this).removeClass('pass')
            } else {
                $(this).addClass('pass');
                // $(this).find('.any_bield').removeClass('scale0');
            }


        });


        $('.item.pass').addClass('hide');
        $('.item:not(.pass)').removeClass('hide');


        setTimeout(function () {

            HandlerCentered($('.wrap_block:not(.other_block)'));
            $('.products_line').css('min-height', '300px');

            if (!$('.description_block').length) {
                // $('.products_line').css('min-height', ($('.footer').offset().top - ($('.products_line').offset().top)) + 'px')
            }

        }, 400)
        setTimeout(function () {
            $('.item:not(.pass) .any_bield').addClass('scale0');
            if (!$('.item:not(.pass) .any_bield').length)
                $('.catalog_empty').addClass('show');

            if (!$('.catalog-page .item'))
                $('.catalog_empty').addClass('show');

            if (callback) callback();
            return true;
        }, 600)


        if (!$('.resize_block').hasClass('big_block')) {

            detachForm({
                mobile: 6,
                planshet: 12,
                desctopsm: 15,
                desctopxl: 21
            });
        } else {

            detachForm({
                mobile: 6,
                planshet: 9,
                desctopsm: 12,
                desctopxl: 15
            });
        }
    }


    function reInitIAS() {
        if ($.ias || $.fn.ias) {
            $(window).off('scroll');
            $.ias({
                container: '.ias_parent',
                item: '.ias_child',
                pagination: '.ias_pager',
                next: '.next:not(.hidden) a',
                loader: '',
                history: false,
                trigger: 'Загрузить еще',

                onRenderComplete: function (items) {
                    AddAniBield();
                    HandlerCentered(Bck);
                    ALoading($('.aloading'));
                }
            });
            $('.ias_pager a').each(function () {
                var el = $(this);
                if (el.attr('href').search(/\?/) !== -1)
                    el.attr('href', el.attr('href') + '&ajax=1');
                else
                    el.attr('href', el.attr('href') + '?ajax=1');
            });
        }
        ;
    };


    /*   SORTABLE ITEM   */

    function initSortable() {

        if ($('body.body_edit .wrap_block.sortable').length) {

            $('body.body_edit .wrap_block.sortable .products_line .ias_parent').css('position', '').sortable({

                revert: 100,
                cancel: '.flower_order_form_wrap',
                tolerance: 'intersect',

                update: function (event, ui) {

                    var sort = 1;
                    var sort_line = '';
                    $(".wrap_block.sortable .products_line .item").each(function () {
                        var id = $(this).attr('id').split('_')[1];
                        sort_line = sort_line + '|' + id + '-' + sort;
                        sort++;
                    })
                    $.ajax({
                        url: '/edit',
                        type: 'GET',
                        data: 'stat=sort&sort_line=' + sort_line,
                        success: function (data) {
                        }
                    });

                    if (!$('.resize_block').hasClass('big_block')) {
                        detachForm({
                            mobile: 6,
                            planshet: 12,
                            desctopsm: 15,
                            desctopxl: 21
                        });
                    } else {
                        detachForm({
                            mobile: 6,
                            planshet: 9,
                            desctopsm: 12,
                            desctopxl: 15
                        });
                    }
                }
            });

            $('body.body_edit .sortable .products_line .ias_parent .item').disableSelection();
        }
    }

    function initktutilka() {

        $('.krutilka:not(.init)').krutilka({
            size: 50, // Ширина и высота блока с крутилкой
            petals: 15, // Сколько лепестков у крутилки
            petalWidth: 2, // Толщина лепестка
            petalLength: 12, // Длинна лепестка
            petalOffset: 1, // Внутреннее поле блока с крутилкой
            time: 1000, // Время прохода круга в миллисекундах
            color: '#808080', // Цвет лепестков
            background: 'none' // Фон крутилки
        });
        $('.krutilka:not(.init)').addClass('init')
    }


    function initAjaxScroll() {
        $.ias({
            container: '.ias_parent',
            item: '.ias_child',
            pagination: '.ias_pager',
            next: '.next:not(.hidden) a',
            loader: '',
            history: false,
            /* evil force */
            trigger: 'Загрузить еще',
            triggerPageThreshold: 3,
            beforePageChange: function () {
                $('.wrap_block .krutilka').addClass('show')
            },
            onRenderComplete: function (items) {
                AddAniBield();
                HandlerCentered($('.wrap_block:not(.other_block)'));
                ALoading($('.aloading'));
                $('.wrap_block .krutilka').removeClass('show')
            }
        });
        $('.ias_pager a').each(function () {
            var el = $(this);
            if (el.attr('href').search(/\?/) !== -1)
                el.attr('href', el.attr('href') + '&ajax=1&os=' + _OS);
            else
                el.attr('href', el.attr('href') + '?ajax=1&os=' + _OS);
        });
    }

    function ScrollingMenu() {

        if (CheckOS() == 'anyone') {
            var scroll = $(window).scrollTop();
            var extraHeaderMenuBg = $('.extra-header-menu_bg')[1];
            var pos = 15;


            if (scroll < $(extraHeaderMenuBg).height()) {
                $('.wrap_header').removeClass('fixed');
                $('body').css('marginTop', '0')

            } else {
                $('.wrap_header').addClass('fixed');
                $('body').css('marginTop', '173px')
            }

        }
    }

    function CheckOS() {

        var OS = '';
        if (navigator.userAgent.match(/Android/i)) OS = 'android';
        else if (navigator.userAgent.match(/BlackBerry/i)) OS = 'blackberry';
        else if (navigator.userAgent.match(/iPhone|iPod/i)) OS = 'iphone';
        else if (navigator.userAgent.match(/iPad/i)) OS = 'ipad';
        else if (navigator.userAgent.match(/IEMobile/i)) OS = 'iemobile';
        else OS = 'anyone';

        return OS;

    }

    function is_touch_device() {
        return !!('ontouchstart' in window);
    }

    $( document ).ready(function() {
        let flowers = $('#sort_type .one_sort_label_variants a');
        $('#sort_type .one_sort_label_variants a').each(function () {
            if ($(this).attr('href') == window.location.pathname)
                $(this).addClass('select');
        });
    });

    $( document ).ready(function() {
        let sub_cats = $('.submenu-list a');
        $('.submenu-list a').each(function () {
            if ($(this).attr('href') == window.location.pathname)
                $(this).find('li').addClass('green_btn_menu');
        });
    });

    /* YEONOPE */
    yepnope.Timeout = 1500;
    var loadIAS = typeof (window.loadIAS) == 'undefined' ? false : window.loadIAS;
    var loadInputMask = typeof (window.loadInputMask) == 'undefined' ? false : window.loadInputMask;

    yepnope([

        { /* infinite Home Fotorama */
            test: $('.h_fotorama').length,
            yep: ['/js/fotorama4.js', '/css/fotorama4.css'],
            complete: function () {
                if (!$('.h_fotorama').length) return true;

                $('.h_fotorama').fotorama({
                    click: false,
                });

            }
        },
        { /* infinite ajax scroll */
            test: $('.ias_parent').length || loadIAS,
            yep: ['/js/jquery-ias.min.js', '/js/tinysort.js'],
            complete: function () {
                if (!($.ias || $.fn.ias || loadIAS)) return true;
                $(function () {


                    $("#sort_type  a.blue, #sort_price  a.blue").click(function (e) {
                        e.preventDefault()

                        let href = $(e.target).attr('href');
                        let cat_id = $(e.target).attr('data-cat-id');

                        if (href && cat_id==84)
                            window.location.href = href;

                        if (!$(this).hasClass('select')) {

                            $(this).parents('.one_sort').find('a').removeClass('select');
                            $(this).addClass('select');

                            if (cat_id!=84) {
                                liveSort();
                                SetCickokieSort();
                            } else {
                                window.onload = function() {
                                    liveSort();
                                    SetCickokieSort();
                                };
                            }


                            var el = $(this)
                            //									setTimeout(function(){
                            //										if (el.parents('.one_sort').attr('id') == 'sort_type')
                            //											DisableEmptySort(el, $('#sort_price'));
                            //										else
                            //											DisableEmptySort(el, $('#sort_type'));
                            //									},0)
                        }

                        if (!$('.resize_block').hasClass('big_block')) {
                            detachForm({
                                mobile: 6,
                                planshet: 12,
                                desctopsm: 15,
                                desctopxl: 21
                            });
                        } else {
                            detachForm({
                                mobile: 6,
                                planshet: 9,
                                desctopsm: 12,
                                desctopxl: 15
                            });
                        }
                        return false;
                    });
                    $("#sort_sort  a.blue").click(function (e) {
                        e.preventDefault()

                        let href = $(e.target).attr('href');
                        if (href)
                            window.location.href = href;

                        if (!$(this).hasClass('select')) {
                            $(this).parents('.one_sort').find('a').removeClass('select');
                            $(this).addClass('select');
                            var data_sort = $(this).attr('data-sort');
                            $('.ias_parent>.item').tsort('.sortprice', {order: '' + data_sort + '', attr: 'value'});
                        } else {
                            $(this).parents('.one_sort').find('a').removeClass('select');
                            $('.ias_parent>.item').tsort('.sortorder', {order: 'asc', attr: 'value'});
                        }

                        if (!$('.resize_block').hasClass('big_block')) {
                            detachForm({
                                mobile: 6,
                                planshet: 12,
                                desctopsm: 15,
                                desctopxl: 21
                            });
                        } else {
                            detachForm({
                                mobile: 6,
                                planshet: 9,
                                desctopsm: 12,
                                desctopxl: 15
                            });
                        }

                        HandlerCentered($('.wrap_block:not(.other_block)'));
                        SetCickokieSort();
                        return false;
                    })
                    timerId = false;
                    $('[name=searchByName]').on('keyup', function () {
                        if (timerId) {
                            clearTimeout(timerId);
                        }
                        timerId = setTimeout(function () {
                            liveSort();
                        }, 500);
                    })
                    $('.searchByName').on('submit', function (e) {
                        e.preventDefault();
                        liveSort();
                    })
                    initAjaxScroll();


                    //							function DisableEmptySort(el, block) {
                    //								block.find('a.blue:not(.select)').each(function(){
                    //									if (block.attr('id') == 'sort-type')
                    //										var val = $(this).html();
                    //									else if (block.attr('id') == 'sort_price') 
                    //										var val = $(this).attr('data-price');
                    //									
                    //									if (val != '' && val != 'Все') {
                    //										var check = false;
                    //										$('#products_line .item').each(function(){
                    //											if (block.attr('id') == 'sort-type'){
                    //												if ($(this).find('.sorttype').val() == val)
                    //													check = true;
                    //											} else if (block.attr('id') == 'sort_price'){
                    //												var item_val = $(this).find('.sortprice').val();
                    //												var priceArr = val.split('-');
                    //												if ( (!priceArr[1] && parseInt(item_val) <= parseInt(val) ) || ( priceArr[1]  && parseInt(item_val) >= parseInt(priceArr[0]) && parseInt(item_val) <= parseInt(priceArr[1]) )) {				
                    //													check = true;
                    //												}
                    //											}
                    //										})
                    //										
                    //										if (!check) {
                    //											$(this).addClass('disable')
                    //										} else {
                    //											$(this).removeClass('disable')
                    //										}
                    //									}
                    //								})
                    //							}
                });
            }
        },
        { /* For Item page*/
            test: $('.wrap_item').length,
            yep: '',
            complete: function () {
                if (!$('.wrap_item').length) return true;

                $(function () {
                    var checkMousewheel = true;
                    if (_OS != 'anyone') {
                        $('.message_nav').addClass('disable');
                    }

                    $('body').on('click', '.count_minus', function () {
                        var count = parseInt($(this).parents('.item_feature').find('input.number').val());
                        if (count > 1) {
                            count--;
                            var input = $(this).parents('.item_feature').find('input.number');
                            input.val(count);

                        }
                    })

                    $('body').on('click', '.item_feature .count_plus', function () {
                        var input = $(this).parents('.item_feature').find('input.number');
                        var count = parseInt(input.val());

                        if (count < 999) {
                            count++;

                            input.val(count);
                        }

                    })
                    $('body').on('change', '.one_product_price_desc_input_count input.number', function () {
                        if (parseInt($(this).val()) > 999)
                            $(this).val(999);
                    })

                    $('body').on('click', '.item_block .item_feature .fprice:not(.select)', function () {
                        $(this).parents('.item_block').find('.item_block_price span').html($(this).attr('data-price'))
                        $(this).parents('.item_block').find('.item_feature .select').removeClass('select')
                        $(this).addClass('select');
                        var fid = $(this).attr('id').split('fprice_')[1];
                        var href = $(this).parents('.item_block').find('.addtocart').attr('href');
                        var RegExp = /\?/
                        var link = '';
                        if (RegExp.test(href))
                            var link = href.split('?')[0]
                        else
                            link = href;

                        $(this).parents('.item_block').find('.addtocart').attr('href', link + '?fid=' + fid);

                    });

                    // $(document).ready(function(){
                    //     let firstElem = $('.item_block .item_feature .fprice')[0];

                    //     $(firstElem).trigger('click');
                    // });


                    var check = true;
                    $('.item_def').addClass('item_active')
                    setTimeout(function () {
                        ResizeItemBlock()
                    }, 200)
                    $('.wrap_item').css('height', ($('.item_active').height() + 40))
                    $(window).resize(function () {
                        setTimeout(function () {
                            ResizeItemBlock()
                        }, 600)
                    })

                    $('body').on('click', '.galery_sm .sm_one:not(select)', function () {
                        ChangeGalery($(this))
                    })


                    $('body').on('click', '.wrap_nav:not(.disable)', function () {
                        if ($(this).hasClass('left'))
                            ChangeGalery($(this).parents('.content_item').find('.sm_one.select').prev('.sm_one'))
                        else
                            ChangeGalery($(this).parents('.content_item').find('.sm_one.select').next('.sm_one'))

                    })

                    function ChangeGalery(el) {
                        var id = el.attr('id').split('_')[1];
                        el.parents('.content_item').find('.galery_big img, .sm_one').removeClass('select');
                        el.addClass('select');
                        el.parents('.content_item').find('.galery_big #big_' + id).addClass('select');
                        if (el.prev('.sm_one').length)
                            el.parents('.content_item').find('.wrap_nav.left').removeClass('disable')
                        else
                            el.parents('.content_item').find('.wrap_nav.left').addClass('disable')

                        if (el.next('.sm_one').length)
                            el.parents('.content_item').find('.wrap_nav.right').removeClass('disable')
                        else
                            el.parents('.content_item').find('.wrap_nav.right').addClass('disable')
                    }

                    $('body').on('click', '.prev_item a, .next_item a', function (event) {
                        event.preventDefault()
                        if (check) {
                            check = false;
                            HadlerNewItemLoader($(this))

                        }
                    })

                    yepnope([{
                        test: $('.wrap_item').length && is_touch_device(),
                        yep: '/js/jquery.mobile.mousewheel.custom.min.js',
                        complete: function () {
                            if (!$('.wrap_item').length || !is_touch_device()) {
                                return true;
                            }

                            if (is_touch_device() && getCookie('swipe') != 1) {

                                $('.nav_item_mobile').removeClass('disable');
                                $('.nav_item_mobile').delay(3000).fadeOut();
                            }
                            var first = true;

                            /* moble touch */
                            $.event.special.swipe.horizontalDistanceThreshold = 80
                            $(window).on("swipe", function (event) {
                                var onSwipe = false;

                                start = event.swipestart;
                                stop = event.swipestop;
                                if (Math.abs(start.coords[0] - stop.coords[0]) > 30) {
                                    if (start.coords[0] > stop.coords[0]) {
                                        if (check && $('.next_item:not(.hide) a').length) {
                                            var el = $('.next_item:not(.hide) a');
                                            el.addClass('active')
                                            setTimeout(function () {
                                                el.removeClass('active');
                                                HadlerNewItemLoader(el)
                                            }, 100)
                                            check = false;

                                            if (!$('.nav_item_mobile').hasClass('disable')) {

                                                $('.nav_item_mobile').addClass('disable')
                                            }

                                            onSwipe = true;

                                        }
                                    } else {
                                        if (check && $('.prev_item:not(.hide) a').length) {
                                            var el = $('.prev_item:not(.hide) a');
                                            el.addClass('active')
                                            setTimeout(function () {
                                                el.removeClass('active');
                                                HadlerNewItemLoader(el)
                                            }, 100)
                                            check = false;
                                            if (!$('.nav_item_mobile').hasClass('disable')) {

                                                $('.nav_item_mobile').addClass('disable')
                                            }

                                            onSwipe = true;
                                        }

                                    }
                                }

                                if (onSwipe && first) {
                                    if (is_touch_device() && getCookie('swipe') != 1) {
                                        setCookie('swipe', 1, 3600)
                                    }
                                    first = false;
                                }


                            });

                            /* mac  multitouch 
											$(window).mousewheel(function(event, delta) {
						                        
						                       
						                        if (event.deltaX == 1){
						                        	if (check && $('.prev_item:not(.hide) a').length && checkMousewheel){
						                        		checkMousewheel = false;
														var el =$('.prev_item:not(.hide) a');
														el.addClass('active')
														setTimeout(function(){
															el.removeClass('active');
															HadlerNewItemLoader(el)
														},100)
														check = false;
														setTimeout(function(){
															checkMousewheel = true;
														},600)
														if (!$('.navigation_item').hasClass('active')){
															$('.navigation_item').addClass('active')
															$('.nav_item_mobile').addClass('disable')
														}
														
													}
						                        } else if (event.deltaX == -1){
						                        	if (check && $('.next_item:not(.hide) a').length && checkMousewheel){
						                        		checkMousewheel = false;
														var el =$('.next_item:not(.hide) a');
														el.addClass('active')
														setTimeout(function(){
															el.removeClass('active');
															HadlerNewItemLoader(el)
															},100)
														check = false;
														setTimeout(function(){
															checkMousewheel = true;
														},600)
														if (!$('.navigation_item').hasClass('active')){
															$('.navigation_item').addClass('active')
															$('.nav_item_mobile').addClass('disable')
														}
													}

						                        }
						                       
						                    });
						                    
											*/

                            $(window).bind("popstate", function (e) {
                                var id = location.pathname.split('/')[3];
                                if ($('.item_def').attr('id') != 'content_item_' + id)
                                    location.reload();
                                return false;
                            });
                        }
                    }])


                    $('body').on('keydown', function (e) {

                        if ($('input').is(":focus"))
                            return true;

                        if (e.which == 39) {
                            if (check && $('.next_item:not(.hide) a').length) {
                                var el = $('.next_item:not(.hide) a');
                                el.addClass('active')
                                setTimeout(function () {
                                    el.removeClass('active');
                                    HadlerNewItemLoader(el)
                                }, 100)
                                check = false;
                            }
                            return true;
                        } else if (e.which == 37) {
                            if (check && $('.prev_item:not(.hide) a').length) {
                                var el = $('.prev_item:not(.hide) a');
                                el.addClass('active')
                                setTimeout(function () {
                                    el.removeClass('active');
                                    HadlerNewItemLoader(el)
                                }, 100)
                                check = false;
                            }
                            return true;
                        }
                    })

                    /*
							var posX = -1;
							var move = false;
							$('body').on('mousedown', '.wrap_item', function(e){
								posX = e.clientX;
								move = true;
							})
					
							$('body').on('mouseup', function(e){
								
								if ( (e.clientX - posX) >= 100) {
									HadlerNewItemLoader($('.next_item:not(.hide) a'))
								} else if ( (posX - e.clientX ) >= 100) {
									HadlerNewItemLoader($('.prev_item:not(.hide) a'))
								}	
								move = false;
								 $('body .content_item.item_active').removeClass('move').css('left', 'auto')

							})
							$('body').on('mousleave', '.wrap_item', function(e){
								move = false;
								 $('body .content_item.item_active').removeClass('move').css('left', 'auto')

							})
							$('body').on('mousemove', function(e){
								if (!move) return true;
								

								var posMove = posX - e.clientX;
//								 $('body .content_item.item_active').css({
//									 '-webkit-transition':'ease all 0.3s !important',
//									 '-webkit-transform':'translate(1000px,0px) !important'
//	
//								 })
								
								 $('body .content_item.item_active').addClass('move').css({
								 '-webkit-transition-duration':'0s',
									 'left': -(posMove)+'px',

								 })
								
							});
							*/

                    function HadlerNewItemLoader(el) {
                        if (!el.length) return false;


                        var new_el = '';
                        var now_el = '';
                        var load = true;
                        var new_element = '';
                        var href = el.attr('href');

                        if (el.hasClass('prev')) {
                            new_el = 'prev';
                            now_el = 'next';
                            new_element = $('.item_active').prev('.content_item');
                        } else if (el.hasClass('next')) {
                            new_el = 'next';
                            now_el = 'prev';
                            new_element = $('.item_active').next('.content_item');
                        }

                        if (!new_element.length) {
                            LoadNewElement(href, el, new_el, now_el, function () {
                            })
                        } else {
                            var new_item = new_element;
                            var bottom_products = new_item.find('.bottom_products');

                            LoadItemNext(new_item, now_el, new_el, function () {
                                $('.wrap_item').css('height', ($('.item_active').height() + 40))
                                HandlerCentered(bottom_products);
                                setTimeout(function () {
                                    ResizeItemBlock()
                                }, 300)
                            })
                        }
                    }


                    function LoadNewElement(href, el, new_el, now_el, callback) {
                        $.ajax({
                            type: 'POST',
                            url: href,
                            beforeSend: function () {
                                el.addClass('loading')
                            },
                            success: function (data) {
                                var new_item = $(data).find('.content_item');

                                var bottom_products = new_item.find('.bottom_products');
                                //bottom_products.addClass('hide')
                                if (now_el == 'next') $('.item_active').before(new_item);
                                else if (now_el == 'prev') $('.item_active').after(new_item);
                                new_item.addClass('cont_item_' + new_el)
                                ResizeItemBlock();
                                AddAniBield();
                                ALoading(new_item.find('.item_block_galery .aloading'), function () {
                                    var nav = $(data).find('.navigation_item');
                                    $(nav.html()).appendTo($('.navigation_item'));
                                    if (_OS != 'anyone') {
                                        $('.message_nav').addClass('disable');
                                    }
                                    LoadItemNext(new_item, now_el, new_el, function () {
                                        ALoading(new_item.find('.other_block .aloading'), function () {
                                            ResizeItemBlock();
                                        });
                                        setTimeout(function () {
                                            ALoading(new_item.find('.aloading'), function () {
                                                setTimeout(function () {
                                                    ResizeItemBlock()
                                                }, 300)
                                            });

                                        }, 500)
                                        if (callback) callback();
                                    });
                                });
                                setTimeout(function () {
                                    HandlerCentered(bottom_products);
                                }, 200);
                                //bottom_products.removeClass('hide')
                            },
                            complete: function () {

                            }
                        });
                    }

                    function LoadItemNext(new_item, now_el, new_el, callback) {
                        $('.wrap_item .nav_item').addClass('hide');
                        var id = new_item.attr('id').split('content_item_')[1];
                        $('#nav_prev_' + id + ', #nav_next_' + id).removeClass('hide');

                        $('.item_active').find('.item_block').removeClass('aloading').removeClass('a_end')
                        $('.item_active').removeClass('item_def').removeClass('item_active').addClass('cont_item_' + now_el);
                        new_item.addClass('item_active').removeClass('cont_item_next').removeClass('cont_item_prev');

                        history.pushState(null, null, new_item.attr('data-href'))
                        document.title = new_item.attr('data-title');
                        $('.nav_item a').removeClass('loading');
                        if (callback) callback();
                        check = true;
                        initktutilka();
                    }

                });

                function ResizeItemBlock() {
                    $('.others_product').css('width', ($('.wrap_item').width() / 2) + 'px');

                    setTimeout(function () {
                        $('.wrap_item').css('height', ($('.item_active').height() + 40))
                    }, 300)

                }


            }
        },
        {
            test: $('input.mask_input').length,
            yep: '/js/inputmask.js',
            complete: function () {

                if (!$('input.mask_input').length)
                    return true;

                $('input.mask_input').each(function () {
                    if ($(this).hasClass('phone')) {
                        $(this).inputmask("+7 (999) 999-99-99");
                    }
                })
            }
        },
        {
            test: typeof window.ajaxSubmit == 'undefined',
            yep: '/js/jquery.form.min.js',
            complete: function () {
                if (!$('#order').length && !$('#call').length) return true;

                $(function () {
                    if ($('#order').length) {

                        $('body').on('click', '#resend', function () {
                            $('.basket').removeClass('sended');
                            EnterEnable = false;
                            return false;
                        })
                        $('body').on('click', '.return_cart', function () {
                            $('.basket').removeClass('sended').removeClass('confirm_basket');
                            EnterEnable = false;
                            return false;
                        })

                        $('body').on('keydown', function (e) {

                            if (EnterEnable && e.which == 13) {
                                SendOrder();
                            }
                        })


                        $('body').on('click', '.confirm_btn', function () {
                            SendOrder();
                            return false;
                        });


                        function SendOrder() {
                            form = $('#order');
                            var check = true;

                            form.find('.form-input').each(function () {

                                if ($(this).attr('id') !== 'field_text-otkritki') {
                                    if ($(this).val() == '' || ($(this).attr('type') == 'tel' && $(this).val().replace(/[_-]/g, '').length < 17)) {
                                        check = false;
                                        $(this).addClass('error')
                                    }
                                }

                                $(this).change(function () {
                                    if ($(this).val() != '') {
                                        $(this).removeClass('error')
                                    }
                                })
                            })

                            $('.sendalert').removeClass('show');
                            if (check) {
                                $('.progress_send').addClass('show');


                                form.ajaxSubmit({
                                    success: function (response) {
                                        data = $.parseJSON(response);
                                        if (data.error == 0) {
                                            form.find('input[type=text],textarea').val('');
                                            form.addClass('sended');
                                            UpdateBasket();

                                            basketStep.changeStep(0);

                                            yaCounter24162886.reachGoal('orderdone');
                                            yaCounter24162886.reachGoal('form_korzina');
                                        }

                                        let localStorageDelivery = localStorage.getItem('delivery');
                                        let deliveryStringCart;
                                        if (localStorageDelivery == 'individual' || localStorageDelivery == 0) {
                                            deliveryStringCart = 'Стоимость доставки будет рассчитана индивидуально';
                                        } else if (localStorageDelivery == 'samovivoz') {
                                            deliveryStringCart = 'Бесплатно';
                                        } else {
                                            deliveryStringCart = 'Доставка ' + localStorageDelivery + ' ₽';
                                        }


                                        $('.cart-page').html(
                                            `<div class="success-order-wrap">
												<div class="success-order-content">
													<div class="success-order-desc">
														<div class="desc-title">
															Ваш заказ оформлен!
														</div>
														<div class="desc-name">
															<span>Заказчик</span>
															<span>${data.data.order_name}</span>
															<span>${data.data.order_phone}</span>
														</div>
														<div class="desc-price">
															<span>Заказ</span>
															<span>Сумма заказа ${data.data.order_price.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1&nbsp;')} ₽</span>
															<span>
															${deliveryStringCart}
															</span>
														</div>
														<div class="desc-thankyou">
															<span>Свяжемся с вами в течение 30 минут</span>
															<span>Спасибо, что выбрали нас!</span>
														</div>
													</div>
												</div>
											</div>`
                                        );
                                        $('.cart-contact-info-wrap, .cart-order-list-wrap').hide()

                                    },
                                    error: function (response) {

                                        data = $.parseJSON(response);
                                        $('.cart-page').html(data.message);
                                    },
                                    complete: function () {
                                    }
                                })
                            }
                        }


                    }


                    if ($('#call').length) {
                        $('#call').on('click', '.green_btn', function () {
                            SendCall();
                            return false;
                        })

                        function SendCall() {
                            form = $('#call');
                            var check = true;

                            if (form.hasClass('sended'))
                                check = false;

                            form.find('input').each(function () {

                                if ($(this).val() == '') {
                                    check = false;
                                    $(this).addClass('error')
                                }

                                $(this).change(function () {
                                    if ($(this).val() != '') {
                                        $(this).removeClass('error')
                                    }
                                })
                            })

                            if (check) {
                                $('.call_progress').addClass('show');
                                form.ajaxSubmit({
                                    success: function (response) {
                                        data = $.parseJSON(response);
                                        if (data.error == 0) {
                                            form.find('input:not(.green_btn)').val('');
                                            form.addClass('sended');

                                        }
                                        $('.call_message').html(data.message);

                                    },
                                    error: function (response) {
                                        data = $.parseJSON(response);
                                        $('.success_form p').html(data.message);
                                        $('.basket').addClass('sended')
                                    },
                                    complete: function () {
                                        $('.call_progress').removeClass('show');
                                    }
                                })
                            }
                        }
                    }

                })
            }
        },


    ]);
    $('a[href^=#]').on('click', function (e) {
        e.preventDefault();

        var href = $(this).attr('href');

        $('html, body').animate({
            scrollTop: $(href).offset().top
        }, 500);
    });
    basketStep.init();


    $('.cookies_accept-btn').on('click', function () {
        setCookie('policy', 'accept', 90);

        $('.cookies_accept-wrap').remove();
    });

    $(document).ready(function () {

        let hasCookie = getCookie('policy');
        if (!hasCookie) {
            $('.cookies_accept-wrap').addClass('active');
        }

    });

    $(document).ready(function () {


        if (!$('.resize_block').hasClass('big_block')) {
            detachForm({
                mobile: 6,
                planshet: 12,
                desctopsm: 15,
                desctopxl: 21
            });
        } else {
            detachForm({
                mobile: 6,
                planshet: 9,
                desctopsm: 12,
                desctopxl: 15
            });
        }

    });

    $('.extra-header-menu-close').on('click', function () {
        setCookie('alert-banner-close', 'close', 1);
        $('.extra-header-menu_bg.alert-banner').remove();
        $('.extra-header-menu_bg.postcard').addClass('active');
    });

    $(document).ready(function () {

        let hasCookie = getCookie('alert-banner-close');
        if (!hasCookie) {
            $('.extra-header-menu_bg.alert-banner').addClass('active');
            $('.extra-header-menu_bg.postcard').removeClass('active');
        }

    });


})


basketStep = {
    $basket: $('.basket'),
    curStep: 1,
    stepsNum: 1,
    init: function () {
        this.stepsNum = this.$basket.find('[data-step]').last().data('step');
        _this = this;
        $('[data-nav]').on('click', function (e) {
            e.preventDefault();
            _this.curStep = $(this).data('nav') == 'next' ? (_this.curStep == _this.stepsNum ? _this.stepsNum : _this.curStep + 1) : (_this.curStep == 1 ? 1 : _this.curStep - 1)
            //this.curStep = $(this).data('step')
            _this.changeStep();
        })
    },
    changeStep: function (step) {
        if (typeof step !== 'undefined') {
            this.curStep = step
        }
        this.$basket.find('.basket_step[data-step=' + this.curStep + ']').addClass('_active').siblings().removeClass('_active');
        if (this.curStep > 1) {
            $('.return_cart').addClass('_active')
        } else {
            $('.return_cart').removeClass('_active')
        }
    },
}

function customScroll(el, offset) {

    var elementClick = $(el).data("href");
    var destination = $(elementClick).offset().top;

    if (navigator.userAgent.indexOf("Safari") != -1) {
        $('html').animate({scrollTop: destination + offset}, 1100);
    } else {
        $('body').animate({scrollTop: destination + offset}, 1100);
    }
    return false;

}


$(document).ready(function () {
    $('body').append('<div class="popup-overlay">');


    $('.header-geo-js').on('click', function () {
        customScroll('.header-geo-js', 0);
    });
	
	site_key = '6LcwSyAlAAAAAPnpz8q_gtA-j-iTcJMNswI4K6aS';
    $('.form-input').on('focus', function () {
		if (typeof(grecaptcha) == 'undefined') {
			console.log('init grecaptcha')
			var grecaptcha_s = document.createElement('script');
			grecaptcha_s.src = 'https://www.google.com/recaptcha/api.js?render='+site_key;
	
			var grecaptcha_h = document.getElementsByTagName('script')[0];
			grecaptcha_h.parentNode.insertBefore(grecaptcha_s,grecaptcha_h);
		}
	});		
    $('.flower_order_form_btn').on('click', function () {		
        $(this).closest('.flower_order_form_wrap').find('.flower_order_form_form').toggleClass('active');
        if ($('.flower_order_form_form').hasClass('active')) {
            customScroll('.flower_order_form_btn', -130);
        }

    });

    $.fn.setCursorPosition = function (pos) {
        if ($(this).get(0).setSelectionRange) {
            $(this).get(0).setSelectionRange(pos, pos);
        } else if ($(this).get(0).createTextRange) {
            var range = $(this).get(0).createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    };

    if ($('input[name="Order[phone_to]"]') || $('input[name="Order[phone]"]')) {
        $('input[name="Order[phone_to]"]').mask("+7(999) 999 99 99", {
            autoclear: false,
        });

        $('input[name="Order[phone]"]').mask("+7(999) 999 99 99", {
            autoclear: false,
        });

        if ($('input[name="Order[phone_to]"]').length !== 0) {
            $('input[name="Order[phone_to]"]').get(0).setSelectionRange(3, 3);
            $('input[name="Order[phone]"]').get(0).setSelectionRange(3, 3);
        }

    }

    function setPopupvariant(el) {
        let elText = $(el).text();
        let elInput = el.closest('label').find('textarea');
        elInput.val(elText);
        el.closest('.primer-popup').removeClass('active');
        el.closest('.d-flex').find('.primer-popup-handler').removeClass('active');
        $('.popup-overlay, .form-overlay').removeClass('active');
        $(el).closest('label').find('textarea').change();
    }

    $('.primer-popup-close').on('click', function () {
        $('.primer-popup, .primer-popup-handler, .popup-overlay, .form-overlay').removeClass('active');
    });

    $('.primer-popup-handler').on('click', function (e) {
        $(this).closest('.d-flex').find('.primer-popup').toggleClass('active');
        $(this).toggleClass('active');
        $('.popup-overlay, .form-overlay').toggleClass('active');

        $(this).closest('.d-flex').find('.primer-popup').find('li').on('click', function () {
            setPopupvariant($(this));
        });

    });

    $('.popup-overlay').on('click', function () {
        $(this).toggleClass('active');
        $('.primer-popup, .primer-popup-handler, .form-overlay', '.popup-success-pink-form-wrap').removeClass('active');
    });
    $('.form-overlay').on('click', function () {
        $('.form-overlay').toggleClass('active');
        $('.primer-popup, .primer-popup-handler, .popup-overlay').removeClass('active');
    });

    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["ru"]);
        $("#datepicker").datepicker({
            buttonImage: "/images/calendar.svg",
            showOn: "button",
            buttonImageOnly: true,
            buttonText: "Выбрать дату",
            firstDay: 1,
            prevText: "",
            nextText: "",
            minDate: 0,
            maxDate: "+1M +10D",
            constrainInput: false,
        });
    });

    $('.toggle-popup-handler').on('click', function () {
        $('.popup-header').toggleClass('active');

    });
    $('.flower_order_form-close').on('click', function () {
        $('.popup-header').removeClass('active');
    });
    $(window).on('resize', function () {
        if ($(window).width() >= 1092) {
            $('.popup-header').removeClass('active');
        }
    });


});


// select 
$(document).ready(function () {


    $('body').on('click', function (e) {
        if ($(e.target).hasClass('confirm_apply_btn')) {
            let formId = $(e.target).closest('form').attr('id');
            SendOrderApply(formId);
            return false;
        }
    });

    $('.tz-select .dropdown input').on('input', function () {
        let inputVal = $(this).val().toLowerCase();
        let dropItems = $('.tz-select .dropdown li');

        $(dropItems).each(function () {
            let text = $(this).find('span').text().toLowerCase();

            if ($(this).find('input').length == 0 && !text.includes(inputVal)) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });

    });

    function SendOrderApply(formId) {

        let form = $('#' + formId);


        var check = true;

        form.find('.form-input').not('.fake').each(function () {

            if ($(this).attr('id') !== 'field_text-otkritki') {

                if ($(this).val() == '' || ($(this).attr('type') == 'tel' && $(this).val().replace(/[_-]/g, '').length < 17)) {
                    check = false;
                    $(this).addClass('error')
                }

            }

            $(this).change(function () {
                if ($(this).val() != '') {
                    $(this).removeClass('error')
                }
            })


        });

        if (check) {
            let protectInput = form.find("input[name='user-name']").val();
            if (protectInput && protectInput != '') {
                return false;
            }
			grecaptcha.ready(function() {
				grecaptcha.execute(site_key, {action: 'submit'}).then(function(token) {
					console.log('token', token)
					$('[name=recaptcha_token]').val(token)
					form.ajaxSubmit({
						success: function (response) {
							data = $.parseJSON(response);
							// console.log('data',data)
							if (data.error == 0) {
								form.find('input,textarea').val('');
								form.addClass('sended');
								yaCounter24162886.reachGoal('orderdone');

								if (formId == 'order_apply_popup') {
									$('.popup-header').removeClass('active');
									yaCounter24162886.reachGoal('form_mobile_header');

								} else {
									yaCounter24162886.reachGoal('form_listing');
								}

								$('.popup-success-pink-form-wrap').addClass('active');
								$('.popup-overlay, .form-overlay').addClass('active');

								$('.popup-success-pink-form-wrap').html(
									`<div class="order_form-thankyou-wrap">
								<div class="order_form-thankyou-content">
									<div class="order_form-thankyou-close">
										<img src="/images/close_big.svg" alt="">
									</div>
									<div class="order_form-thankyou-title">
										Спасибо за заказ!
									</div>
									<div class="order_form-thankyou-desc">
										${data.data.order_name}, мы получили ваш заказ, перезвоним вам
										в ближайшее время по номеру ${data.data.order_phone}
									</div>
								</div>
								</div>`
								);
							}


						},
						error: function (response) {
							data = $.parseJSON(response);
							$('.flower_order_form_form').append(`<p>${data.message}</p>`);
						},
						complete: function () {
							$('.flower_order_form_form_wrap').removeAttr("style");
						}
					});
				});
			});

        }


    }

    $('.popup-success-pink-form-wrap').on('click', function (e) {
        if ($(e.target).closest('.order_form-thankyou-close')) {
            $(this).removeClass('active');
            $('.popup-overlay, .form-overlay').removeClass('active');
        }
    });


    function scrollTopBtnWrap() {
        let scrollTopBtn = $('.scroll-top-btn-wrap');

        $(window).scroll(function () {
            if ($(window).scrollTop() > 300) {
                $(scrollTopBtn).addClass('active');
            } else {
                $(scrollTopBtn).removeClass('active');
            }
        });


        $(scrollTopBtn).on('click', function () {
            $('html, body').animate({
                scrollTop: 0,
                duration: 100
            }, 600);
            $(scrollTopBtn).removeClass('active');
            return false;
        });
    }


    scrollTopBtnWrap();


});

// CART 

$(document).ready(function () {

    function handlerCartBtnCount() {
        let cartCount = $('.cart-item').find('.count-input input').val();
        if (cartCount == 1) {
            $('.count-minus-wrap').find('path').css('fill-opacity', '0.4');
        } else {
            $('.count-minus-wrap').find('path').css('fill-opacity', '1');
        }
    }

    handlerCartBtnCount();

    $('.cart-item-list').on('click', function (e) {

        if ($(e.target).closest('.count-minus-wrap').find('a').hasClass('count-minus')) {
            let inputVal = +$(e.target).closest('.cart-item-count').find('input').val();
            let countInput = $(e.target).closest('.cart-item-count').find('input');
            if (inputVal != 1) {
                inputVal -= 1;
                countInput.val(inputVal);
            }
            handlerCartBtnCount();
        }

        if ($(e.target).closest('.count-plus-wrap').find('a').hasClass('count-plus')) {
            let inputVal = +$(e.target).closest('.cart-item-count').find('input').val();
            let countInput = $(e.target).closest('.cart-item-count').find('input');
            if (inputVal < 999) {
                inputVal += 1;
                countInput.val(inputVal);
            }
            handlerCartBtnCount();
        }
    });
});