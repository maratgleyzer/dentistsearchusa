<script type="text/javascript" src="<?=min_file('assets/js/jquery.wysiwyg.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/default/css/jquery.wysiwyg.css')?>" />
<script type="text/javascript">
	function save_success(){
	/*	$('form :input').each(function(){
	        switch(this.type) {
	            case 'password':
	            case 'select-multiple':
	            case 'select-one':
	            case 'text':
	            case 'textarea':
	                $(this).val('');
	                break;
	            case 'checkbox':
	            case 'radio':
	                this.checked = false;
	        }
	    });
		idContentoEdit1.document.body.innerHTML = "";
	*/
	}
	$(function(){
		$('input#btn_personal_info').click(function(){
			process_form('input#btn_personal_info','SAVE','div#personal_form_messages',true,'form#personal_info','_admin_console/dentists/save_dentist/');
		});
		$('.wysiwyg_text').wysiwyg();
	})
	function generate_pass(){
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for( var i=0; i < 8; i++ ){
			text += possible.charAt(Math.floor(Math.random() * possible.length));
		}
		Sexy.alert('<h2>Generate Password</h2><p><label style="color:#05887b;font-weight:bold;">'+text+'</label> Make sure to copy and paste this generated password</p>');
		$('#password_field').val(text);
	}
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Add Dentist
	</label><br/><br/>
	<div class="tab-content personal_info" id="tab-2">
		<div id="personal_form_messages" class="form_messages"></div>
		<form id="personal_info" action="#">
			<input type="hidden" name="payment_plan" value="7"/>
			<div id="personal_info_col_left">
				<h4>Account information:</h4>
				<div class="row">
					<label>Email Address: <span class="label_note">(Username)</span></label><br/>
					<input class="txt medium_input_text" type="text" name="email" />
				</div><!-- /row end -->
				<div class="row">
					<label>Password:</label><br/>
					<input class="medium_input_text txt" type="text" id="password_field" name="password" />
					<a style="cursor:pointer;color:#05887b;" onclick="generate_pass()">Generate Password</a>
				</div><!-- /row end -->
				<h4>Company / Clinic information:</h4>
				<div class="row">
					<label>Featured?</label>&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="featured" value="1" />
				</div>
				<div class="row">
					<label>Payment Plan:</label>&nbsp;&nbsp;&nbsp;
					<?=form_dropdown('payment_plan', $payment_plans)?>
				</div>
				<div class="row">
					<label>Company / Clinic Name:</label><br/>
					<input class="txt wide_input_text" type="text" name="company_name" />
				</div><!-- /row end --><br>
				<div class="row">
					<label>Address:</label><br/>
					<input class="txt wide_input_text" type="text" name="address" />
				</div><!-- /row end --><br>
				<div class="row">
					<label>City:</label><br/>
					<input class="wide_input_text txt city_zip_autocomplete {autoc_width:262,autoc_type:'city_name'}" type="text" name="city"/>
				</div><!-- /row end --><br>
				<div class="row">
					<label>State:</label><br/>
					<input class="wide_input_text txt city_zip_autocomplete {autoc_width:262,autoc_type:'state'}" type="text" name="state" />
				</div><!-- /row end --><br>
				<div class="row">
					<label>Zip:</label><br/>
					<input class="wide_input_text txt city_zip_autocomplete {autoc_width:262,autoc_type:'zip'}" type="text" name="zip" />
				</div><!-- /row end --><br>
				<div class="row">
					<label>Telephone Number:</label><br/>
					<input class="wide_input_text txt" type="text" name="telephone" />
				</div><!-- /row end --><br>
				<div class="row">
					<label>Company Email Address:</label><br/>
					<input class="wide_input_text txt" type="text" name="company_email" />
				</div><!-- /row end -->
			</div>
			<div id="personal_info_col_right">
				<h4>Personal information:</h4>
				<div class="row">
					<label>First Name:</label><br/>
					<input class="txt wide_input_text" type="text" name="first_name" />
				</div><!-- /row end --><br>
				<div class="row">
					<label>Last Name:</label><br/>
					<input class="txt wide_input_text" type="text" name="last_name" />
				</div><!-- /row end --><br>
			</div>
			<div class="clear_both"></div>
			<div id="personal_info_col_bottom">
				<div class="btn-holder">
				<!--	<input class="btn03" type="reset" value="RESET" /> -->
					<input style="margin-left:0px;" id="btn_personal_info" class="btn02" type="button" value="SAVE" />
				</div><!-- /btn-holder end -->
			</div>
			<div class="clear_both"></div>
		</form>
	</div><!-- /tab-2 end -->
</div>