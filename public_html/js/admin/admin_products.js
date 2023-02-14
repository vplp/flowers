$(function(){
//	
	
/// ///////////////////////////////// ------------PRODUCT LIST --------------------------------------------------	
	$("select").chosen();
	
	
	$('#products tbody').sortable({
		revert: 100,
		update: function(){
				var sort = 1;
		  		var sort_line = '';
				 $( "#products tbody tr" ).each(function(index){
					 if(index == 0){
						return;
					 }
					 var id = $(this).attr('id').split('_')[1];
					 sort_line = sort_line+'|'+id+'-'+sort;
					 sort++;
				 })
				 $.ajax({
					  url: '/admin/update',
					  type: 'POST',
					  data: 'stat=sort&sort_line='+sort_line+'&f=products',
					  success: function(data){
					  }
				});				
		}
	});
	
	$('#products tbody tr').disableSelection();
	
	
/// ///////////////////////////////// ------------ ONE PRODUCT --------------------------------------------------	

	$( document ).ready(function() {
		$('input#monobyket').on('click', function (e) {
			var isMono;
			var id = +$(e.target).data('id');
			if ($(e.target).attr('checked'))
				isMono = 1;
			else
				isMono = 0;

			$(e.target).attr('data-selected', isMono);

			$.ajax({
				url: '/admin/update',
				type: 'POST',
				data: 'stat=check_mono_byket&id='+id+'&isMono='+isMono,
				success: function(data){
				}
			});
		})
	});
	
	$("#add_feature_price").click(function(){
		var id = new Date().getTime();
		var data = $(".feature_one_price.tmp").html();
		$('.feature_one_price.tmp').before('<div class="feature_one_price  new">'+data+'</div>');
		$('.feature_one_price.new .chzn-container').remove();
		$('.feature_one_price.new select').removeClass('chzn-done').attr('id', 'DD'+id).chosen();
		$('.feature_one_price.new').removeClass('new');
		$('.feature_one_price .feature_price_rose').attr('data-via-id', '');

	})

	$("body").on("click", ".row_feature_one_price .del:not(.del-rose)", function(){
			$(this).parents(".row_feature_one_price").remove();
			UPdateFeatureProductPrice();
	})

	$("#add_product_price").click(function(){
		var id = new Date().getTime();
		var data = $(".product_price.tmp").html();
		$('.product_price.tmp').before('<div class="feature_one_price  row_product_price new">'+data+'</div>');
		$('.feature_one_price.new .chzn-container').remove();
		$('.feature_one_price.new select').removeClass('chzn-done').attr('id', 'DD'+id).chosen();
		$('.feature_one_price.new').removeClass('new');
		
	})
	
	$("body").on("click", ".feature_one_price .del", function(){
		if (!$(this).hasClass('del-rose')){
			$(this).parent(".feature_one_price").remove();
			console.log('del');

			UpdateProductPrices();
		}

	})

	$("body").on("click", ".feature_one_price .del-rose", function(){
		$(this).parent(".feature_one_price").remove();
		var feature_id = 12;
		var flowerID = $('.row_product_price select').attr('data-id');
		console.log('del');

		$.ajax({
			url: '/admin/update',
			type: 'POST',
			data: 'stat=product_feature_rose_del&id='+$(this).data('id')+'&feature_id='+feature_id+'&flowerID='+flowerID,
			success: function(data){

			}
		});
	})

	$("body").on("change", ".feature_price_rose", function(){
		if ($(this).hasClass('tmp-select'))
			return;

		// UPdateFeaturePriceRose();
		var value = $(this).val();
		var via = $(this).data('via-id');
		// var cost = $(this).data('cost');
		// console.log($(this));

		var id = $('h1').attr('id').split('product_')[1];
		var feature_id = 12;
		var ArrPrices = new Array();
		var i = 1;
		$('.feature_product_price .feature_one_price:not(.tmp):not(.border)').each(function(){
			var price = $(this).find('input.feature_price').val();
			var value = $(this).find('select.feature_price_value').val();
			if (price != '') {
				ArrPrices[i] = value+':'+price;
				i++;
			}
		})
		var linePrice = ArrPrices.join('|');

		$.ajax({
			context: this,
			url: '/admin/update',
			type: 'POST',
			data: 'stat=product_feature_rose&product_id='+$(this).data('id')+'&value='+value+'&via_id='+via+'&feature_id='+feature_id+'&line_price='+linePrice,
			success: function(data){
				let res = JSON.parse(data);

				// if (cost){
				// 	$(this).closest('.rose_parent').siblings('input').val(cost);
				// }

				if (res.id){
					$(this).attr('data-via-id', res.id);
					$(this).closest('.rose_parent').siblings('.del.del-rose').attr('data-id', res.id);
				}
				if (res.cost){
					$(this).closest('.rose_parent').siblings('input').val(res.cost);
				}
			}
		});
	})
			
	$("body").on("change", ".feature_product_price input, .feature_product_price select", function(){
		if (!$(this).hasClass('feature_price_rose')) {
			UPdateFeatureProductPrice();
		}
	})

	$('body').on('change', '[data-show-roza]', function() {
		let checked = 0;
		if ($(this).attr('checked') != undefined)
			checked = 1;

		console.log(checked);
		$.ajax({
			url: '/admin/update',
			type: 'POST',
			data: 'stat=product_rose&product_id='+$(this).data('id')+'&checked='+checked,
			success: function(data){}
		});
	})

	function UPdateFeatureProductPrice() {
		var id = $('h1').attr('id').split('product_')[1];
		var feature_id = $('.feature_product_price').attr('id').split('__')[1];
		var ArrPrices = new Array();
		var i = 1;
		$('.feature_product_price .feature_one_price:not(.tmp):not(.border)').each(function(){
			var price = $(this).find('input.feature_price').val();
			var value = $(this).find('select.feature_price_value').val();
			if (price != '') {
				ArrPrices[i] = value+':'+price;
				i++;
			}
		})
		var linePrice = ArrPrices.join('|');
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=edit_feature_product_price&id='+id+'&feature_id='+feature_id+'&line_price='+linePrice,
			  success: function(data){
			  }
		});
	}
	
	$("body").on("change", ".products_prices input, .products_prices select", function(){
		console.log('ааааа');
		if (!$(this).hasClass('_category-select'))
			UpdateProductPrices();
	})

	function UpdateProductPrices() {
		var id = $('h1').attr('id').split('product_')[1];
		var price_id = $('.products_prices').attr('id').split('__')[1];
		var ArrPrices = new Array();
		var namesFlowers = new Array();
		var i = 1;
		$('.products_prices .feature_one_price:not(.tmp):not(.border)').each(function(){
			var quantity = $(this).find('input.feature_price').val();
			var price = $(this).find('select.feature_price_value').val();
			if (price != '' && quantity > 0) {
				ArrPrices[i] = price+':'+quantity;
				i++;
			}
		})

		$('.prices_list .row_product_price').each(function(){
			var nameFlower = $(this).find('div a span').text().trim();
			if (nameFlower.length > 0) {
				namesFlowers.push(nameFlower);
			}
		})

		console.log('namesFlowers', namesFlowers);

		var data = ArrPrices.join('|');
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=edit_products_prices&product_id='+id+'&data='+data+'&names_flowers='+namesFlowers,
			  success: function(data){
			  }
		});
	}

	
	$('.show_seo').click(function(){
		
		$('.seo_input_block').toggleClass('show');
	})
	
	$('#hot_checkbox').change(function(){
		var id = $('h1').attr('id').split('product_')[1];
		if ($(this).hasClass('check_on')){ 
			var value = 0;
			$(this).removeClass('check_on')
		} else{
			var value = 1;
			$(this).addClass('check_on')
		}
		 $.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&f=products&field=hot&value='+value+'&id='+id,
			  success: function(data){
			  }
		});
	})	
	
	
$('.show_action_category input').change(function(){
	
	var id = $(this).attr('id').split('__')[1];
	
	if ($(this).hasClass('enable_show')) {
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&id='+id+'&f=actions_category_product&value=0&field=visibly',
			  success: function(data){
			  }
		});
		$(this).removeClass('enable_show');
	}else {
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&id='+id+'&f=actions_category_product&value=1&field=visibly',
			  success: function(data){ 
			  }
		});
		$(this).addClass('enable_show');
	}
})

	$('#new_change_category').change(function(){
		var id = $('h1').attr('id').split('product_')[1];
		value = $(this).val();
		// var last_category = $(this).attr('type').split('lastcat_')[1];
		$.ajax({
			url: '/admin/update',
			type: 'POST',
			data: 'stat=editfield&id='+id+'&f=products&value='+value+'&field=newcat_id',
			success: function(data){
				console.log('value',value)
				console.log(data)
				//location.reload();
			}
		});
	});

	$('#change_holiday').change(function(){
		var id = $('h1').attr('id').split('product_')[1];
		value = $(this).val();
		var last_holiday= $(this).attr('type').split('lasthol_')[1];
		$.ajax({
			url: '/admin/update',
			type: 'POST',
			data: 'stat=editfield&id='+id+'&f=products&value='+value+'&field=holiday_id&last_value='+last_holiday,
			success: function(data){
				console.log('value',value)
				console.log(data)
				//location.reload();
			}
		});
	});

	$('#change_category').change(function(){
	var id = $('h1').attr('id').split('product_')[1];	
	value = $(this).val();
	var last_category = $(this).attr('type').split('lastcat_')[1];
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&id='+id+'&f=products&value='+value+'&field=cat_id&last_value='+last_category,
		  success: function(data){
			  console.log('value',value)
			  console.log(data)
			  //location.reload(); 
		  }
	});
});	

$('#action_products').change(function(){
	var id = $('h1').attr('id').split('product_')[1];	
	value = $(this).val();
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editaction_toproduct&id='+id+'&&value='+value,
		  success: function(data){
		  }
	});
})


$('.one_feature_category input, .one_feature_category select, .one_feature_category textarea').change(function(){
	var id = $(this).attr('id').split('features_products_')[1];
	var value = $(this).val();
	if ($(this).hasClass('multiselect')){

		if ($(this).val() != null)
			value = value.toString().split(',').join('|');
		else
			value = '';
	} 
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field=value&id='+id+'&value='+value+'&f=features_products',
		  success: function(data){}
	});
	
})	
	
$('input, textarea, select').click(function(){
	if (($(this).attr('type') && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') || !$(this).attr('type') )
		$(this).addClass('input_selected_click');
})

$('input, textarea, select').focusout(function(){
		$(this).removeClass('input_selected_click');
});


	$('.delete_product').click(function(){
		if (confirm("Вы действительно хотите удалить этот товар")) {
		
		} else {
			return true;
		}

		var id = $('h1').attr('id').split('product_')[1];	
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=delete&id='+id+'&f=products',
			  success: function(data){
			  }
		});
		setTimeout(function(){window.location = "/admin/products/list/"},500)
	})
//		
	$('.show_product').click(function(){
		if ($(this).hasClass('no_visibly')) {
			var id = $('h1').attr('id').split('product_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=1&id='+id+'&f=products',	    
				  success: function(data){
				  }
			});
			$(this).html('Скрыть').removeClass('no_visibly');
		}else {
			var id = $('h1').attr('id').split('product_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=0&id='+id+'&f=products',	    
				  success: function(data){
				  }
			});
			$(this).html('Показать').addClass('no_visibly');
		}
		
	})
	
	$( ".product_img_block" ).sortable({
		revert: 100,
		update: function( event, ui ) { 
				AutoSaveImages($(".product_img_block"));
			}
		});
	
	$( ".product_others_block " ).sortable({
		revert: 100,
		update: function( event, ui ) {
				AutoSaveOtherProducts($('.product_others_block'));
			}	
		});
	$( ".one_preview_img_product, .one_preview_other_img_products"  ).disableSelection();
	
	
	$('.product_field').change(function(){
		ChachgeField($(this));
	});

	$('.button_add_img, #img_button_add_img').click(function(){
		fileBrowse();
	})	
	
	
	$('#add_img_input').change(function() {
		      displayFiles(this.files);
		      $('.product_img_block .message_img').remove();
	});
	
	$('html').bind({
		    
		    dragover: function(e) {
		    	e.stopPropagation();
			    e.preventDefault();
			    $('.button_add_img').addClass('drag')
			    
		    	 
		      return false;
		    },
		    drop: function(e) {
		    	e.stopPropagation();
			    e.preventDefault();
		    	var dt = e.originalEvent.dataTransfer;
		    	if (dt.files.length > 0){
		    		displayFiles(dt.files);
		    	}
		    	$('.button_add_img').removeClass('drag')
		    	
		    	
		      return false;
		    }
	});
	$('html').bind({	
		dragleave: function(e) {
		    e.stopPropagation();
		    e.preventDefault();
		    console.log('leave');
		    $('.button_add_img').removeClass('drag')
		}
	});
	
	var count_img = 1000;
	function displayFiles(files) {	
			    $.each(files, function(i, file) {
			    	count_img++;
			    	var reg = /\.(?:png|gif|jpe?g)$/i;
			    	if (!reg.test(file.name)) {
			    		//return true;
			    	} else {
			    		var li = $('<div class="one_preview_img_product float" id="img'+count_img+'" />');
	    				$('.button_add_img').before(li);
			    		var img_div =  $('<div class="one_preview_div_img preview'+count_img+'"  style="background:url(/img/ajax-loader.gif) no-repeat center center; background-size: 20px 20px; text-align:center;"/>').appendTo(li);
			    		var img = $('<img height="84" class="loading" style="display:none;" />').appendTo(img_div);
			    		var del = $('<span class="del" id="del'+count_img+'"></span>').appendTo(li);
			    		li.get(0).file = file;
			    		
			    		var reader = new FileReader();
			    		reader.onload = (function(aImg) {
				        return function(e) {
				        
				        	var path = $('h1').attr('type');
					        uploadFile(file, '/post_file.php?f='+path+'&flag=product', img, li);
					        			
				        };
				      })(img);
				      
				      reader.readAsDataURL(file);
			    	}
			    });	  	
	} 
//	var count_img = 1000;
//	var minW = 300;
//	var minH = 300;
//	function displayFiles(files) {
//		
//		if (files[0]){
//			var file = files[0];
//			count_img++;
//			var reg = /\.(?:png|gif|jpe?g)$/i;
//	    	if (!reg.test(file.name)) {
//	    		$('#add_img_input').value('')
//	    		alert('Неверный формат файла (доступные форматы : PNG, GIF, JPG, JPEG)')
//	    	
//	    	} else {
//	    		
//	    		var sizeSelect;
//	    		var body = $('body');
//	    		var Cropbloc_bg= $('<div class="crop_blcok_bg"/>').appendTo(body);
//	    		var Cropblock= $('<div class="crop_blcok"/>').appendTo(body);
//	    		var Cropimg = $('<img class="crop_blcok_img"/>').appendTo(Cropblock);
//	    		var Cropbtn = $('<input class="crop_blcok_btn" type="submit" value="Сохранить" />').appendTo(Cropblock);
//	    		var Cropcansel = $('<input class="crop_blcok_cansel" type="submit" value="Отменить" />').appendTo(Cropblock);
//	    		var reader = new FileReader();
//	    		
//	    		reader.onload = (function(aImg) {
//	    			Cropimg.attr('src', reader.result);
//		    			
//	    			Cropimg.bindImageLoad(function(){
//		    			
//		    			var  imgW = Cropimg.width();
//		    			var  imgH = Cropimg.height();
//		    			if (imgW < minW || imgH < minH){
//		    				alert('Маленький размер ( минимальный размер: '+minW+'x'+minH+')')
//		    	    		return true;
//		    			}
//		    			var scrolltop = $(window).scrollTop();
//		    			body.addClass('fullscreen');
//		    			$('html').addClass('fullscreen');
//		    			Cropblock.css({'margin-left':'-'+300+'px', 'top': ($(window).scrollTop() + 100)+'px'})
//		    			var jcrop_api;
//		    			
//		    			var reW = (imgW - minW) / 2
//		    			var reH = (imgH - minH) / 2;
//		    			Cropimg.Jcrop(
//		    				{
//		    					setSelect: [reW,reH, minW + reW ,minH + reH],
//		    					aspectRatio:1,
//		    					minSize: [minW,minH],
//		    					onSelect: showCoords,
//		    			        onChange: showCoords,
//		    			        boxWidth: 600, 
//		    			        boxHeight: 600,
//		    			        trueSize: [imgW,imgH] 
//		    			        
//		    				},
//		    				function(){
//		    			  jcrop_api = this;
//		    			});
//		    			Cropcansel.click(function(){
//		    				body.removeClass('fullscreen')
//		    				$('html').removeClass('fullscreen');
//		    				$(window).scrollTop(scrolltop);
//		    				Cropbloc_bg.remove();
//		    				jcrop_api.destroy();
//		    				Cropblock.remove();
//		    			})
//		    			Cropbtn.click(function(){
//		    				console.log(jcrop_api.tellScaled())
//		    				console.log(jcrop_api.tellSelect())
//		    				console.log(sizeSelect)
//		    				body.removeClass('fullscreen')
//		    				$('html').removeClass('fullscreen');
//		    				$(window).scrollTop(scrolltop);
//		    				Cropbloc_bg.remove();
//		    				Cropblock.remove();
//		    				
//		    				var li = $('<div class="one_preview_img_product float" id="img'+count_img+'" />');
//		    				$('.button_add_img').before(li);
//		    	    		var img_div =  $('<div class="one_preview_div_img preview'+count_img+'"  style="background:url(/img/ajax-loader.gif) no-repeat center center; background-size: 20px 20px; text-align:center;"/>').appendTo(li);
//		    	    		var img = $('<img height="84" class="loading" style="display:none;" />').appendTo(img_div);
//		    	    		var del = $('<span class="del" id="del'+count_img+'"></span>').appendTo(li);
//		    	    		li.get(0).file = file;
//		    				
//		    				var path = $('h1').attr('type');
//					        uploadFile(file, '/post_file.php?f='+path+'&flag=product&x='+sizeSelect.x+'&y='+sizeSelect.y+'&x2='+sizeSelect.x2+'&y2='+sizeSelect.y2+'&w='+sizeSelect.w+'&h='+sizeSelect.h+'', img, li, sizeSelect);
//		    				
//		    				
//		    			})
//		    			function showCoords(c)
//		    			  {
//		    					sizeSelect = {'x':c.x, 'y':c.y, 'x2':c.x2, 'y2':c.y2, 'w':c.w, 'h':c.h}
//		    			  }
//		    			
//		    		})
//		    			
//	    		});
//	    		reader.readAsDataURL(file);
//		    	
//		    	
//	    	}
//	    	
//		}
//	}
	
	

	$(".one_preview_img_product , .one_preview_other_img_products ").mouseover(function(){
		$(this).find(".del").css("display", "block");
	})
	$(".one_preview_img_product , .one_preview_other_img_products ").mouseout(function(){
		$(this).find(".del").css("display", "none");
	})
	
	$('.one_preview_img_product ').find('.del').click(function(){
		$(this).parent(".one_preview_img_product").fadeOut(function(){
			$(this).remove();
			 AutoSaveImages($('.product_img_block'));
		});
	})
       
		
    $('.one_preview_other_img_products .del').click(function(){
		$(this).parent(".one_preview_other_img_products").fadeOut(function(){
			$(this).remove();
			AutoSaveOtherProducts($('.product_others_block'));
		});
	})
    
    
    
$('.button_add_other_product, #img_button_add_other_product').click(function() {
		
		$('.popup_wait').show();
		var opts = {
				  lines: 13, // The number of lines to draw
				  length: 7, // The length of each line
				  width: 4, // The line thickness
				  radius: 10, // The radius of the inner circle
				  corners: 1, // Corner roundness (0..1)
				  rotate: 0, // The rotation offset
				  color: '#000', // #rgb or #rrggbb
				  speed: 1, // Rounds per second
				  trail: 60, // Afterglow percentage
				  shadow: false, // Whether to render a shadow
				  hwaccel: false, // Whether to use hardware acceleration
				  className: 'spinner', // The CSS class to assign to the spinner
				  zIndex: 2e9, // The z-index (defaults to 2000000000)
				  top: 'auto', // Top position relative to parent in px
				  left: 'auto' // Left position relative to parent in px
				};
		var target = document.getElementById('popup_wait');
		var spinner = new Spinner(opts).spin(target);
		$.ajax({
			  url: '/admin/update/productpopup',
			  type: 'POST',
			  data: 'stat=start&cat=',
			  success: function(data){
				  if ($('.popup_content').html(data)){
						 $('.popup_wait').hide();
						 setOtherProduct();
						 
						 $('.popup_content .one_left_menu').click(function() {
							  var cat_id = $(this).attr('id');
								
							  $('.one_left_menu').removeClass('menu_select');
							  $(this).addClass('menu_select');
							  
							  $('.popup_content .popup_right').css('opacity', '0.5');
							  $('.popup_wait').show();
							  $.ajax({
								  url: '/admin/update/productpopup',
								  type: 'POST',
								  data: 'stat=update&cat_id='+cat_id,
								  success: function(data){
									  		
									  if ($('.popup_content .br').remove() && $('.popup_right').remove() && $(data).appendTo('.popup_content')){
											 $('.popup_wait').hide();
											 setOtherProduct();
									  } 
								  }
							  });
						  }); 
				  } 
			  }
		});
		
		$('#addimg_other_popup').fadeIn();
	});
	
	$('.popup_del').click(function() {
		$('#addimg_other_popup').fadeOut();
	});
	
	
})	


function ChachgeField(el) {
		
		var id = el.attr('id').split('__')[1];
		var field = el.attr('id').split('__')[0];
		if (id != '' && id != 'new'){
			var value = el.val();

			$.ajax({
					  url: '/admin/update',
					  type: 'POST',
					  data: 'stat=editfield&field='+field+'&id='+id+'&value='+value+'&f=products',
					  success: function(data){}
				});
		}
}
	
	
	
function PLtospace(str) {
		var VRegExp = new RegExp(/[\+]+/g);
		var VResult = str.replace(VRegExp, ' ');
		return VResult
}
function PLtoNonspace(str) {
		var VRegExp = new RegExp(/[\+]+/g);
		var VResult = str.replace(VRegExp, '');
		return VResult
}
function addSpace(str) {
		var VRegExp = new RegExp(/[ ]+/g);
		var VResult = str.replace(VRegExp, '');
		return VResult
}
	
	


function updateRating(val) {
	
	var id = $('.rating').attr('id').split('rating_')[1];

	$.ajax({
		  url: '/ajax/products',
		  type: 'POST',
		  data: 'stat=edit_field&field=rating&id='+id+'&value='+val,
		  success: function(data){
		  }
	});
	
	
	
}

function fileBrowse() {
    var browseField = document.getElementById("add_img_input");
    browseField.click();
}



function uploadFile(file, url,img, li) {
	  console.log(file);
	  var name = new Date().getTime()+'.jpg';
	  var reader = new FileReader();
	  reader.onload = function() {    
		
		var xhr = new XMLHttpRequest();    
	    
	    xhr.open("POST", url);
	    var boundary = "xxxxxxxxx";    
	    // Устанавливаем заголовки
	    xhr.setRequestHeader("Content-Type", "multipart/form-data, boundary="+boundary);
	    xhr.setRequestHeader("Cache-Control", "no-cache");    
	    // Формируем тело запроса
	    var body = "--" + boundary + "\r\n";
	    body += "Content-Disposition: form-data; name='myFile'; filename='" + name + "''\r\n";
	    body += "Content-Type: application/octet-stream\r\n\r\n";
	    body += reader.result + "\r\n"; 
	    body += "--" + boundary + "--\r\n"
	   
	    if(xhr.sendAsBinary) {
	    
	      // только для firefox
	      xhr.sendAsBinary(body);
	    } else {
	      // chrome (так гласит спецификация W3C)
	    	// chrome (так гласит спецификация W3C)
	    	var ui8a = new Uint8Array(body.length);
	        for (var i = 0; i < body.length; i++) {
	                  ui8a[i] = (body.charCodeAt(i) & 0xff);
	        }
	        xhr.send(ui8a.buffer);
	    }
	    
	   xhr.onreadystatechange = function () {
		   		
		      if (this.readyState == 4) {
		        if(this.status == 200) {
		         
		        	var img_src = this.responseText;
		        	
		        	//alert(img_src);
		        	if( img.attr('src', '/uploads/81x84/'+img_src)  && img.load() && img.show() && img.removeClass('loading')){      	
	        	    	
		        		img.parent('.one_preview_div_img').parent('.one_preview_img_product').mouseover(function(){
							$(this).find(".del").css("display", "block");
						})
						img.parent('.one_preview_div_img').parent('.one_preview_img_product').mouseout(function(){
							$(this).find(".del").css("display", "none");
						})
				          
						img.parent('.one_preview_div_img').parent('.one_preview_img_product').find('.del').click(function(){
							$(this).parent(".one_preview_img_product").fadeOut(function(){
								$(this).remove();
								 AutoSaveImages(line_preview);
							});
						})
				        var line_preview = $('.product_img_block');
				       if(line_preview.find('.one_preview_img_product div .loading').length == 0){ 
				    	   AutoSaveImages(line_preview); 
				       }
				    
	        	   }
		        } else {
		        	 li.remove()
		        }
		        	
		      }
		  };
	  };
	  // Читаем файл
	  reader.readAsBinaryString(file); 
}


function  setOtherProduct() {
	
	$('.one_preview_other_img_products').each(function() {
			 var selectId = $(this).attr('id').split('other_')[1]
			 $('.popup_right #'+selectId).addClass('product_select');
	});
	
	var img = '';
	$('.popup_one_products').click(function() {		
		if($(this).hasClass('product_select')){
			$(this).removeClass('product_select');
			var id = $(this).attr('id');
			$('#other_'+id).remove();
			AutoSaveOtherProducts($('.product_others_block'));
				
		}else {
			$(this).addClass('product_select')
			var id = $(this).attr('id');
			var img_src = $(this).find('img').attr('src');
			//var li = $('<div id ="other_'+id+'" class="one_preview_other_img_products" />').appendTo($('.product_others_block'));
			var li = $('<div id ="other_'+id+'" class="one_preview_other_img_products float" />');
			$('.button_add_other_product').before(li);
		    var div = $('<div class="one_preview_div_img" />').appendTo(li);
			var img = $('<img  width="81"/>').appendTo(div);
		    var del = $('<span id ="del_'+id+'" class="del"></span>').appendTo(li);
		    del.hide();
		    regex = /\/[^/]+\/[^/]+\.\w{3,4}/ ;
		    img.attr('src', '/uploads/81x84/'+regex.exec(img_src));
		    img_w = img.width();
			    
			li.mouseover(function(){
				var id = $(this).attr('id');
				var count_id = id.split('other_')[1];
				$('#del_'+count_id).css('display','block');
			});
			li.mouseout(function(){
			   	var id = $(this).attr('id');
				var count_id = id.split('other_')[1];
				$('#del_'+count_id).css('display','none');
			});
				
			del.click(function(){
				var id = $(this).attr('id');
				var count_id = id.split('del_')[1];
				$('#other_'+count_id).remove();
				AutoSaveOtherProducts($('.product_others_block'));
			});
			
			AutoSaveOtherProducts($('.product_others_block'));
		}
			
			 
			 
	});
	  
}


function AutoSaveImages(line_preview){
	
	var id = $('h1').attr('id').split('product_')[1];	
	var line_img = '';
	line_preview.find('.one_preview_img_product').each(function() {			
        	$(this).find('img').each(function() {
    			var img_src = $(this).attr('src')
    			regex = /\/[^/]+\/[^/]+\.\w{3,4}/ ;
    			line_img = line_img+'|'+ regex.exec(img_src);
    		});
	});
	
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field=img&value='+line_img+'&id='+id+'&f=products',	    
		  success: function(data){
		  }
	});
}


function AutoSaveOtherProducts(line_preview){
	
	var id = $('h1').attr('id').split('product_')[1];		
	var line_img_other = '';
	line_preview.find('.one_preview_other_img_products ').each(function() {			
        if (!$(this).hasClass('delete')){
        	$(this).each(function() {
    			var other_id = $(this).attr('id').split('other_')[1];			
    			var other_img_src = $(this).find('img').attr('src');
    			line_img_other = line_img_other+'|'+other_id+':'+other_img_src;
    		});
        }
	});
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field=others&value='+line_img_other+'&id='+id+'&f=others_products',	    
		  success: function(data){
		  }
	});
}

function updateRating(val) {
	
	var id = $('h1').attr('id').split('product_')[1];	

	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&field=rating&id='+id+'&value='+val+'&f=products',
		  success: function(data){
		  }
	})
}

;(function ($) {
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