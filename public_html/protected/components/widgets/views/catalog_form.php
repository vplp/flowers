
<div class="flower_order_form_wrap d-flex">
	
	<div id="flower_order" class="flower_order_form_bg d-flex">
			<div class="form-overlay"></div>
			<div class="flower_order_form_desc">
				<h2>Хотите заказать оригинальный букет?</h2>
				<p>Заполните форму, и мы сделаем букет специально для вас по пожеланиям из свежих цветов в наличии</p>
				<div class="flower_order_form_btn d-flex" data-href="#flower_order_form_form">
					Да, соберите букет для меня
				</div>
			</div>
	</div>

	<div class="flower_order_form_form" id="flower_order_form_form">
		<div class="form-overlay"></div>
		<div class="form-arrow"></div>
		<div class="form-title">
			<span>Доставим в течение двух часов!</span>
		</div>	

		<form action="/orderapply" id="order_apply" method="post">
		
			<input type="text" name="user-name" id="user-name-protect-desc" value="" style="display:none">
			<div class="form-row">

				<label class="field_budget-label">
					Бюджет заказа в ₽
					<input name="Order[budget]" class="form-input" type="text" id="field_budget" autocomplete="no">
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
					
					<textarea name="Order[color_gamma]" class="form-input" type="text" id="field_color-gamma" autocomplete="no"></textarea>
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
					<textarea name="Order[sostav_buketa]" class="form-input" type="text" id="field_sostav-buketa" autocomplete="no"></textarea>
				</label>

			</div>
			<div class="form-row">

			<label class="field_adress-label">
					Когда и куда доставить
					<textarea class="form-input" type="text" id="field_adress" name="Order[delivery_address]" autocomplete="no"></textarea>
				</label>

				<label class="field_text-otkritki-label">
					<div>
						<span>Текст открытки</span>
						<span>Добавим к заказу бесплатно!</span>
					</div>
					
					<textarea class="form-input" type="text" id="field_text-otkritki" name="Order[postcard]" autocomplete="no"></textarea>
					<span>Добавим к заказу бесплатно!</span>
				</label>

			</div>
			<div class="form-row">

				<label class="field_zakazchik-name-label">
					Имя заказчика
					<input class="form-input" type="text" id="field_zakazchik-name" name="Order[name]" autocomplete="no">
				</label>

				<label class="field_poluchatel-name-label">
					Имя получателя
					<input class="form-input" type="text" id="field_poluchatel-name" name="Order[name_to]" autocomplete="no">
				</label>

			</div>
			<div class="form-row">
				
				<label class="field_zakazchik-phone-label">
					Телефон заказчика
					<input class="form-input" type="tel" id="field_zakazchik-phone" placeholder="+7 (___) ___ __ __" name="Order[phone]" autocomplete="new-paas" autocomplete="no">
				</label>

				<label class="field_poluchatel-phone-label">
					Телефон получателя
					<input class="form-input" type="tel" id="field_poluchatel-phone" placeholder="+7 (___) ___ __ __" name="Order[phone_to]" autocomplete="new-paas" autocomplete="no">
				</label>

			</div>
			<input class="form-input fake" type="text" name="recaptcha_token" autocomplete="no">
			<button type="button" class="form-btn confirm_btn confirm_apply_btn">Отправить</button>
		</form>
        <div class="agree_wrap">
            <input class="form-input" type="hidden" id="agree" checked="true" required>
            <div class="checkbox_pseudo">
                <label for="agree">Принимаю условия <a class="white" href="/policy">политики обработки персональных данных</a></label>
            </div>
        </div>
	</div>

</div>


<!-- <div class="collections_buketi-wrap d-flex">
	<div class="collections_buketi-content">
		<div class="collections_buketi-title d-flex">
			<h2>Коллекция сборных букетов</h2>
			<h3>при заказе за 7 дней или более</h3>
		</div>
	<div class="collections_buketi-desc">
		<p>
			Мы можем собрать любой букет по вашему желанию из нашего каталога ниже или по фото из интернета.  Чтобы гарантировать, что все наименования из состава букета в наличии и свежие, на сборные букеты мы принимаем за неделю.
		</p>
		<p>
			Для заказа сборного букета на ближайшее время <a href="#flower_order" class="handler-form">воспользуйтесь формой</a> или приходите в наш цветочный салон «Дом цветов» по адресу город <a href="#map" class="fakeLink">Кинель, улица Орджоникидзе, дом 76</a>.
		</p>
	</div>
	</div>
</div> -->