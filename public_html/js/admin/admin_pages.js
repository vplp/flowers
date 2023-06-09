$(function(){
//	
	
/// ///////////////////////////////// -----------PAGES ONe --------------------------------------------------	
	
	$('.show_seo').click(function(){
		
		$('.seo_input_block').toggleClass('show');
	})
	
	$('input, textarea, select').click(function(){
		if (($(this).attr('type') && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') || !$(this).attr('type') )
			$(this).addClass('input_selected_click');
	})

	$('input, textarea, select').focusout(function(){
			$(this).removeClass('input_selected_click');
	});

	
	$(function(){
		$(".page_text").redactor({ 
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

	$(".page_text").focusout(function(){
		var id = $('h1').attr('id').split('page_')[1]
		var text = $(this).getCode();
		var field = $(this).attr('id').split('_')[0];
		 var sendInfo = { stat: 'editfield',
				 value: text,
				 field: field,
				 id:id,
				 f: 'pages'
		};
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  dataType: "json",
			  data: sendInfo,
			  success: function(data){

			  }
		});	
	})

	$(".label_desc").focusout(function(){
		var id = $('h1').attr('id').split('page_')[1]
		var text = $(this).find('input').val();
		// var field = $(this).attr('id').split('_')[0];
		var sendInfo = { stat: 'editfield',
			value: text,
			field: 'label_description',
			id:id,
			f: 'pages'
		};

		$.ajax({
			url: '/admin/update',
			type: 'POST',
			dataType: "json",
			data: sendInfo,
			success: function(data){

			}
		});
	})
	
	$('.page_field').change(function(){
		var id = $('h1').attr('id').split('page_')[1];
		var field =  $(this).attr('id').split('__')[0];
		var value = $(this).val();
		
		var sendInfo = { stat: 'editfield',
				 value: value,
				 field: field,
				 id:id,
				 f: 'pages'
		};
		
		$.ajax({
			  url: '/admin/update',
			  type: 'POST',
			  dataType: "json",
			  data: sendInfo,
			  success: function(data){}
		});
	});

	$('input#page_in_menu').change(function(e){
		var uri = $('.page_field_uri').val();

		var isVisible;
		if ($(e.target).attr('checked'))
			isVisible = 1;
		else
			isVisible = 0;

		$(e.target).attr('data-selected', isVisible);

		$.ajax({
			url: '/admin/update',
			type: 'POST',
			data: 'stat=change_page_in_menu&uri='+uri+'&isVisible='+isVisible,
			success: function(data){
			}
		});
	});

	$(function(){
		
		$('#regions-delivery-admin input').focusout(function(){
			let regionValue = $(this).val();
			let regionId = $(this).closest('tr').attr('id');
			let regionName = $(this).attr('name');

			$.ajax({
				url: "/admin/update",
				type: "POST",
				data: "stat=editfield&field=" + regionName + "&value=" + regionValue + "&id=" + regionId + "&f=delivery_regions",
				success: function(data){
				}
		  });
		});

		//Сортировка на стр. доставка
		$('#regions-delivery-admin tbody').sortable({
			revert: 100,
			update: function(){
					var sort = 1;
					  var sort_line = '';
					 $( "#regions-delivery-admin tbody tr" ).each(function(index){
						 if(index == 0){
							return;
						 }
						 var id = $(this).attr('id');
						 sort_line = sort_line+'|'+id+'-'+sort;
						 sort++;
					 })
					 $.ajax({
						  url: '/admin/update',
						  type: 'POST',
						  data: 'stat=sort&sort_line='+sort_line+'&f=delivery_regions',
						  success: function(data){
						  }
					});				
			}
		});
		
		$('#products tbody tr').disableSelection();

	});
	
});