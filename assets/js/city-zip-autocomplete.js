function searchAll(key){
	limit = 250; //get 250 matches
	$('#more_matches img').css('display','inline');
	$(auto_target).autocomplete("search",key);
}
function reposition_box(e){
	data = $(e.target).metadata();
	if(data.autoc_width){
		$('.ui-autocomplete').css({
			width: data.autoc_width+'px'
		});
	}
	if(data.autoc_top){
		$('.ui-autocomplete').css({
			top: data.autoc_top+'px'
		});
	}
}
function init_autocomplete(){
	limit = 10;
	auto_target = null;
	$("input.city_zip_autocomplete").autocomplete({
		open: reposition_box,
		search: function(e){
			auto_target = e.target;
			data = $(e.target).metadata();
			switch(data.autoc_type){
				case 'zip':
					autoc_url = 'locations/auto_complete/zip';
				break;
				case 'city_name':
					autoc_url = 'locations/auto_complete/city_name';
				break;
				case 'city':
					autoc_url = 'locations/auto_complete/city';
				break;
				case 'state':
					autoc_url = 'locations/auto_complete/state';
				break;
				default:
					autoc_url = 'locations/auto_complete';
				break;
			}
		},
		source: function(param,response){
			$.ajax({
				url: base_url+autoc_url,
				type: 'POST',
				dataType: 'json',
				data: {key:param.term,limit:limit},
				success: function(data){
					if(data){
						response($.map(data, function(item) {
							return {
								value: item.value,
								label: item.label
							};
						}))
						$('label.ui_auto_match_gray').parent().css('background-color','#eeeeee');
						if(data.length == 10){
							$('ul.ui-autocomplete').append('<li id="more_matches"><a onclick="searchAll(\''+param.term+'\');"><img src="'+base_url+'assets/themes/default/images/ajax-loader.gif" style="display:none;padding-right:2px;"> See more results for "'+param.term+'"</a></li>');
						}else if(data.length > 10){
							$('ul.ui-autocomplete').append('<li id="more_matches_note"><a onclick="$(\'input.city_zip_autocomplete\').focus()">More results? Please type more characters</a></li>');
						}
					}
					limit = 10; //reset limit
				}
			})
		},
		select: function(e,ui){
			data = $(e.target).metadata();
			if(!data.autoc_type){
				e.target.value = ui.item.value;
				if(!search_page){
					search_value(ui.item);
				}else{
					change_results();
				}
			}
		}
	});
}
$(document).ready(function(){
	init_autocomplete();
});