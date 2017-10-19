function loading_button(btn,load,func,btn_label,err_form,scroll_to,form,url,redirect,callback){
	if(load){
		$(btn).css({
			'background-image' : 'url('+base_url+'assets/themes/default/images/ajax-loader.gif)',
			'background-position' : 'center',
			'cursor' : 'default'
		});
		$(btn).val('');
		$(btn).unbind('click');
	}else{
		$(btn).css({
			'background' : 'url("'+base_url+'/assets/themes/default/images/btns-submit.gif") no-repeat scroll 0 0 transparent',
			'background-position' : '0 -32px',
			'cursor' : 'pointer'
		});
		$(btn).val(btn_label);
		$(btn).click(function(){
			window[func](btn,btn_label,err_form,scroll_to,form,url,redirect,callback);
		});
	}
}
function process_form(btn,btn_label,err_form,scroll_to,form,url,redirect,callback){
	loading_button(btn,true);
	values = $(form).serializeArray();
	$.ajax({
		type: 'POST',
		url: base_url+url,
		data: values,
		cache: false,
		dataType: 'json',
		success: function(data){
			$(err_form).css('display','block');
			$(err_form).empty();
			if(data){
				loading_button(btn,false,'process_form',btn_label,err_form,scroll_to,form,url,redirect,callback);
				$(err_form).append(data.message);
				if(scroll_to){
					$('html,body').animate({ scrollTop: $(err_form).position().top },500);
				}
				if(data.success){
					if(redirect){
						setTimeout(window.location.replace(base_url+redirect),3000);
					}
					if(callback){
						window[callback](data);
					}
				}
			}else{
				loading_button(btn,false,'process_form',btn_label,err_form,scroll_to,form,url);
				$(err_form).append('<div id="form_error"> We\'re sorry, but there appears to be a problem processing your request. Please try again.</div>');
			}
		},
		error: function(data){
			alert(data.responseText);
		}
	});
}