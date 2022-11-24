<div class="scroll">
    <div class="flower_order_form_wrap form-quick d-flex">

        <div id="flower_order" class="flower_order_form_bg d-flex">
                <div class="flower_order_form-close">&times;</div>
                <div class="flower_order_form_desc">
                    <h2>Хотите заказать оригинальный букет?</h2>
                    <p>Заполните форму, и мы сделаем букет специально для вас по пожеланиям из свежих цветов в наличии</p>
                </div>
        </div>

        <div class="flower_order_form_form active" id="flower_order_form_form">
            <div class="form-overlay"></div>
            <div class="form-arrow"></div>
            <div class="form-title">
                <span>Доставим в течение двух часов!</span>
            </div>	

            <form action="/orderapply" id="order_apply_popup" method="post">
                <input type="text" name="user-name" id="user-name-protect-popup" value="" style="display:none"/>
                <div class="form-row">

                    <label class="field_budget-label">
                        Бюджет заказа в ₽
                        <input name="Order[budget]" class="form-input" type="text" id="field_budget" autocomplete="new-password">
                    </label>

                    <!-- <label class="field_pay-type-label">
                        Способ оплаты
                        <select name="Order[pay_type]" id="field_pay-type">
                            <option value="Наличными при получении">Наличные</option>
                            <option value="Переводом на карту">Карта</option>
                        </select>
                    </label> -->

                    <label class="field_color-gamma-label">
                        <div class="d-flex">
                            <div>Цветовая гамма</div>
                            <div class="primer-popup-handler">Пример</div>
                            <div class="color-gamma-primer-popup primer-popup">
                                <div class="primer-popup-close">&times;</div>
                            <ul>
                                    <li><span>Яркий, но без желтого</span></li>
                                    <li><span>Нежный, бело-розовый</span></li>
                                    <li><span>Желто-оранжевый</span></li>
                                    <li><span>С преобладанием розовых цветов</span></li>
                                    <li><span>Все равно, для подруги, стильный</span></li>
                                </ul>
                            </div>
                        </div>
                        
                        <textarea name="Order[color_gamma]" class="form-input" type="text" id="field_color-gamma" autocomplete="new-password"></textarea>
                    </label>

                </div>
                <div class="form-row">

                    <label class="field_sostav-buketa-label">
                        
                        <div class="d-flex">
                            <div>Состав букета</div>
                            <div class="primer-popup-handler">Пример</div>
                            <div class="sostav-buketa-primer-popup primer-popup">
                            <div class="primer-popup-close">&times;</div>
                                <ul>
                                    <li><span>Побольше роз и что-то еще</span></li>
                                    <li><span>Хочется что-то экзотичное, необычное</span></li>
                                    <li><span>Хризантемы и красивую упаковку</span></li>
                                    <li><span>Чтобы долго стоял, любимой бабушке</span></li>
                                    <li><span>На ваше усмотрение в рамках бюджета</span></li>
                                    <li><span>Похожий на 662 из вашего каталога</span></li>
                                    <li><span>35 розовых роз в белой упаковке и большой медведь до 2000<span class="b-rub">₽</span></span></li>
                                </ul>
                            </div>
                        </div>
                        <textarea name="Order[sostav_buketa]" class="form-input" type="text" id="field_sostav-buketa" autocomplete="new-password"></textarea>
                    </label>

                </div>
                <div class="form-row">

                <label class="field_adress-label">
                        Когда и куда доставить
                        <textarea class="form-input" type="text" id="field_adress" name="Order[delivery_address]" autocomplete="new-password"></textarea>
                    </label>

                    <label class="field_text-otkritki-label">
                        <div>
                            <span>Текст открытки</span>
                            <span>Добавим к заказу бесплатно!</span>
                        </div>
                        
                        <textarea class="form-input" type="text" id="field_text-otkritki" name="Order[postcard]" autocomplete="new-password"></textarea>
                        <span>Добавим к заказу бесплатно!</span>
                    </label>

                </div>
                <div class="form-row">

                    <label class="field_zakazchik-name-label">
                        Имя заказчика
                        <input class="form-input" type="text" id="field_zakazchik-name" name="Order[name]" autocomplete="new-password">
                    </label>

                    <label class="field_poluchatel-name-label">
                        Имя получателя
                        <input class="form-input" type="text" id="field_poluchatel-name" name="Order[name_to]" autocomplete="new-password">
                    </label>

                </div>
                <div class="form-row">
                    
                    <label class="field_zakazchik-phone-label">
                        Телефон заказчика
                        <input class="form-input" type="tel" id="field_zakazchik-phone" placeholder="+7 (___) ___ __ __" name="Order[phone]" autocomplete="new-password">
                    </label>

                    <label class="field_poluchatel-phone-label">
                        Телефон получателя
                        <input class="form-input" type="tel" id="field_poluchatel-phone" placeholder="+7 (___) ___ __ __" name="Order[phone_to]" autocomplete="new-password">
                    </label>

                </div>

                <button type="button" class="form-btn confirm_apply_btn">Отправить</button>
            </form>

        </div>

    </div>
</div>