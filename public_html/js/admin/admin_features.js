$(function(){
	
	
	$('input, textarea, select').click(function(){
		if (($(this).attr('type') && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') || !$(this).attr('type') )
			$(this).addClass('input_selected_click');
	})

	$('input, textarea, select').focusout(function(){
			$(this).removeClass('input_selected_click');
	});

	if ($('#type_shoce').val() == 'text' || $('#type_shoce').val() == 'textarea') {
		$('.values_for_type').hide();
	}

	$('body').on('click', '.one_type_values_line span img', function(e){
		// console.log($(e.target).attr('data-close-flower'));

		$.ajax({
			url: '/admin/update',
			type: 'POST',
			data: 'stat=delflower&value='+$(e.target).attr('data-close-flower'),
			success: function(data){
			}
		});

	})

	$('body').on('click', '.one_type_values_line span img', function(){
		$(this).parent('span').parent('div').slideUp(200, function(){
			$(this).remove();
			UpdateValuesTypes();
			console.log('123');
		})
	})
	
	$('#type_shoce').change(function(){
		
		var id = $('h1').attr('id').split('feature_')[1];
		var value = $(this).val();
		
		 $.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=editfield&f=features&field=type&value='+value+'&id='+id,
			  success: function(data){
			  }
		});
		 
		UpdateValuesTypes();
		
		if( $(this).val() == 'text' || $(this).val() == 'textarea' ) {
			$('.values_for_type').slideUp(200);	
		} else {
			$('.values_for_type').slideDown(200);
		}
		
		if ($(this).val() == 'multiselect') {
			$('.tocart_checkbox_faetures').slideDown(200);
		} else {
			$('.tocart_checkbox_faetures').slideUp(200);
			UpdateValuesTocart(false);
			$('#tocart_checkbox').removeAttr("checked");
			$('#tocart_checkbox').removeClass("check_on");
		}
	})
	
	$('.feature_field').change(function(){
		ChachgeField($(this));
	});
	
	$('#admin_checkbox').change(function(){
		var id = $('h1').attr('id').split('feature_')[1];
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
			  data: 'stat=editfield&f=features&field=admin&value='+value+'&id='+id,
			  success: function(data){
			  }
		});
	})
	
	
	$('#tocart_checkbox').change(function(){
		var id = $('h1').attr('id').split('feature_')[1];
		if ($(this).hasClass('check_on')){ 
			UpdateValuesTocart(false);
			$(this).removeClass('check_on')
		} else{
			var value = 1;
			$(this).addClass('check_on')
			UpdateValuesTocart(true);
		}
	})
	
	$('.add_values_option').click(function(){
		var div_input = $('<div class="one_value" style="display:none" />').appendTo($('.one_type_values_line'));
		var input = $('<input class="values_select_option" type="text" placeholder="Вариант значения">&nbsp;&nbsp;').appendTo(div_input);
		var span_input = $('<span style="padding-left:10px;"><span>').appendTo(div_input);
		var img_input = $('<img src="/images/del.png">').appendTo(span_input);
		
		div_input.slideDown(200);
		
		
	})
	
	
	$('body').on('change', '.one_type_values_line input', function(e){
		if (!$(e.target).attr('name')) {
			console.log(e.target);
			UpdateValuesTypes();
		}
	})
	
	
	$('#features_categories').change(function(){
		var id = $('h1').attr('id').split('feature_')[1];
		var value = $(this).val();
		var type = $('input[name="chose_type_feature"]:checked').val();
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=edit_feachers_categories&field=categories&value='+value+'&id='+id+'&name='+$('h1 input').val()+'&type='+type,
			  success: function(data){
			  }
		});
	})
	
	
	$('.delete_feature').click(function(){
		
		if (confirm("Вы действительно хотите удалить это свойство")) {
			
		} else {
			return true;
		}
		
		var id = $('h1').attr('id').split('feature_')[1];	
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  data: 'stat=delete&id='+id+'&f=features',
			  success: function(data){
			  }
		});
		setTimeout(function(){window.location = "/admin/features/list/"},500)
	})
		
	$('.show_feature').click(function(){
		if ($(this).hasClass('no_visibly')) {
			var id = $('h1').attr('id').split('feature_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=1&id='+id+'&f=features',	    
				  success: function(data){
				  }
			});
			$(this).html('Скрыть').removeClass('no_visibly');
		}else {
			var id = $('h1').attr('id').split('feature_')[1];	
			$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field=visibly&value=0&id='+id+'&f=features',	    
				  success: function(data){
				  }
			});
			$(this).html('Показать').addClass('no_visibly');
		}
		
	})
	
})


$( document ).ready(function() {
	$('input[name="visible_in_filter"]').on('click', function (e) {
		var isVisible;
		var id = +$(e.target).attr('id');
		if ($(e.target).attr('checked'))
			isVisible = 1;
		else
			isVisible = 0;

		$(e.target).attr('data-selected', isVisible);

		$.ajax({
			url: '/admin/update',
			type: 'POST',
			data: 'stat=editcheckbox&id='+id+'&isVisible='+isVisible,
			success: function(data){
			}
		});
	})
});

$( document ).ready(function() {
	$('input[name="flowers_with_seo"]').on('click', function (e) {
		var haveSEO;
		// var name = $(e.target).prev().prev().prev().prev().val();
		var uri = $(e.target).attr('data-uri');
		var id = $(e.target).attr('id');

		if (isNaN(id)) {
			id = +id.replace(/[^\d]/g, '');
		}

		if ($(e.target).attr('checked'))
			haveSEO = 1;
		else
			haveSEO = 0;

		$(e.target).attr('data-selected', haveSEO);

		$.ajax({
			url: '/admin/update',
			type: 'POST',
			data: 'stat=editcheckbox_sef&id='+id+'&haveSEO='+haveSEO+'&uri='+uri,
			success: function(data){
			}
		});
	})
});



function UpdateValuesTocart(check) { 
	if (check) var val = 1;
	else var val = 0;
	var id = $('h1').attr('id').split('feature_')[1];
	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&f=features&field=tocart&value='+val+'&id='+id,
		  success: function(data){
		  }
	});
}


function UpdateValuesTypes() {
	
	
	if ($('input[name="chose_type_feature"]:checked').val() == 'text' | $('input[name="chose_type_feature"]:checked').val() == 'textarea') {
		var value_type = '';
	} else {
		var Arrval = new Array();
		var i = 0;
		$('.one_type_values_line .values_select_option').each(function(){
			if ($(this).val() != ''){
				Arrval[i] = $(this).val();
				i++;
			}
		})
		
		var value_type = Arrval.join('|');
	}
	
	var id = $('h1').attr('id').split('feature_')[1];
	var old_uri = $('.input_selected_click').data('uri');
	var name = $('.input_selected_click').val();

	$.ajax({
		  url: '/admin/update',
		  type: 'POST',
		  data: 'stat=editfield&f=features&field=variants&value='+value_type+'&id='+id+'&old_uri='+old_uri+'&name='+name,
		  success: function(data){
		  }
	});
}


function ChachgeField(el) {
	
	var id = el.attr('id').split('__')[1];
	var field = el.attr('id').split('__')[0];
	if (id != '' && id != 'new'){
		var value = el.val();

		$.ajax({
				  url: '/admin/update',
				  type: 'POST',
				  data: 'stat=editfield&field='+field+'&id='+id+'&value='+value+'&f=features',
				  success: function(data){}
			});
	}
}