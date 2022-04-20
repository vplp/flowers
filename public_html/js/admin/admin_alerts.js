$(function(){

	$('input, textarea, select').click(function(){
		if (($(this).attr('type') && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') || !$(this).attr('type') )
			$(this).addClass('input_selected_click');
	})

	$('input, textarea, select').focusout(function(){
		$(this).removeClass('input_selected_click');
	});

	$(function(){
		$(".alert_text").redactor({ 
			air: false,
			buttons:["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", "unorderedlist", "orderedlist", "outdent", "indent", "|", "fontcolor", "backcolor", '|', 'image'],
			formattingTags: ['h1', 'h2', 'h3', 'h4', 'h5'],
			imageUpload: "/admin/pages/saveimg", 
			uploadCrossDomain: false,
			lang: "ru",
			interval: 3,
			convertDivs: false,
			minHeight: 500
		});	
	});	

	$(".alert_text").focusout(function(){
		var id = $('h1').attr('id').split('alert_')[1]
		var text = $(this).getCode();
		var field = $(this).attr('id').split('__')[0];
		var sendInfo = { 
			stat: 'editfield',
			value: text,
			field: field,
			id:id,
			f: 'alerts'
		};
		
		$.ajax({
			url: '/admin/update',
			type: 'POST',
			dataType: "json",
			data: sendInfo,
			  	success: function(data){}
		});	
	});

	$(".page_text").focusout(function(){
		var id = $('h1').attr('id').split('alert_')[1]
		var text = $(this).val();
		var field = $(this).attr('id').split('__')[0];
		var sendInfo = { 
			stat: 'editfield',
			value: text,
			field: field,
			id:id,
			f: 'alerts'
		};
		
		$.ajax({
			url: '/admin/update',
			type: 'POST',
			dataType: "json",
			data: sendInfo,
			  	success: function(data){}
		});	
	});

	$('.alert_checkbox').change(function(){
		var id = $('h1').attr('id').split('alert_')[1];	
		var field = 'show';
		var value = $('input[name="'+$(this).attr('name')+'"]:checked').val();

		console.log(value);

		var sendInfo = { 
			stat: 'editfield',
			value: value,
			field: field,
			id:id,
			f: 'alerts'
		};
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  dataType: "json",
			  data: sendInfo,
			  success: function(data){}
		});
	});

	$('.alert_active').change(function(){
		var id = $('h1').attr('id').split('alert_')[1];	
		var field = 'active';
		var value = $('input[name="'+$(this).attr('name')+'"]:checked').val();

		console.log(value);

		var sendInfo = { 
			stat: 'editfield',
			value: value,
			field: field,
			id:id,
			f: 'alerts'
		};
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  dataType: "json",
			  data: sendInfo,
			  success: function(data){}
		});
	});

	$('.page_field').change(function(){
		var id = $('h1').attr('id').split('alert_')[1];
		var field =  $(this).attr('id').split('__')[0];
		var value = $(this).val();
		var sendInfo = { 
			stat: 'editfield',
			value: value,
			field: field,
			id:id,
			f: 'alerts'
		};
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  dataType: "json",
			  data: sendInfo,
			  success: function(data){}
		});
	});

});