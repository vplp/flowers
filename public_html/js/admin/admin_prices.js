$(function(){
	
	$("select.select-product-name").chosen();

		
	$('#prices tbody').sortable({
		revert: 100,
		update: function(){
				var sort = 1;
		  		var sort_line = '';
				 $( "#prices tbody tr" ).each(function(index){
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
					  data: 'stat=sort&sort_line='+sort_line+'&f=prices',
					  success: function(data){
					  }
				});				
		}
	});
	
	$('#prices tbody tr').disableSelection();

	
	$('input, textarea, select').click(function(){
		if (($(this).attr('type') && $(this).attr('type') != 'checkbox' && $(this).attr('type') != 'radio') || !$(this).attr('type') )
			$(this).addClass('input_selected_click');
	})

	$('input, textarea, select').focusout(function(){
		$(this).removeClass('input_selected_click');
	});
	
	$('.price_field').change(function(){
		var id = $('h1').attr('id').split('price_')[1];
		var field =  $(this).attr('id').split('__')[0];
		var value = $(this).val();
		
		var sendInfo = { stat: 'editfield',
				 value: value,
				 field: field,
				 id:id,
				 f: 'prices'
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