<script type="text/javascript">
	$(function(){
		$('input#btn_personal_info').click(function(){
			process_form('input#btn_personal_info','SAVE','div#personal_form_messages',true,'form#personal_info','dashboard/save_personal_info',false,'restore_tabs');
		});
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
<div class="tab-content personal_info" id="tab-2">
	<div id="personal_form_messages" class="form_messages"></div>
	<form id="personal_info" action="#">
		<div id="personal_info_col_left">
			<h4>Company / Clinic information:</h4>
			<?php if(isset($is_admin)){ ?>
			<div class="row">
				<label>Disabled? &nbsp; <input type="checkbox" name="status" value="1"<?=($status > 0 ? '' : ' checked')?> /></label>
			</div>
			<div class="row">
				<label>Featured? &nbsp; <input type="checkbox" name="featured" value="1"<?=($featured > 0 ? ' checked' : '')?> /></label>
			</div>
			<div class="row">
				<label>Payment Plan:</label>
				<?=form_dropdown('payment_plan', $payment_plans, $plan_id)?>
			</div>
			<?php } ?>
			<div class="row">
				<label><span class="required_asterisk">*</span> Company / Clinic Name:</label>
				<input class="txt" type="text" name="company_name" value="<?=form_prep($company_name)?>"/>
			</div><!-- /row end -->
			<div class="row">
				<label><span class="required_asterisk">*</span> Address:</label>
				<input class="txt" type="text" name="address" value="<?=form_prep($address)?>"/>
			</div><!-- /row end -->
			<div class="row">
				<label><span class="required_asterisk">*</span> City:</label>
				<input class="txt city_zip_autocomplete {autoc_width:262,autoc_type:'city_name'}" type="text" name="city" value="<?=form_prep($city)?>"/>
			</div><!-- /row end -->
			<div class="row">
				<label><span class="required_asterisk">*</span> State:</label>
				<input class="txt city_zip_autocomplete {autoc_width:262,autoc_type:'state'}" type="text" name="state" value="<?=form_prep($state)?>"/>
			</div><!-- /row end -->
			<div class="row">
				<label><span class="required_asterisk">*</span> Zip:</label>
				<input class="txt city_zip_autocomplete {autoc_width:262,autoc_type:'zip'}" type="text" name="zip" value="<?=form_prep($zip)?>" />
			</div><!-- /row end -->
			<?php if(isset($is_admin)){ ?>
			<div class="row">
				<label>DSUSA Telephone Number:</label>
				<input  class="txt" type="text" name="dsusa_telephone" value="<?=form_prep($dsusa_telephone)?>" />
			</div><!-- /row end -->
			<?php } ?>
			<div class="row">
				<label><span class="required_asterisk">*</span> Telephone Number:</label>
				<input class="txt" type="text" name="telephone" value="<?=form_prep($telephone)?>"/>
			</div><!-- /row end -->
			<div class="row">
				<label>Website:</label>
				<input class="txt" type="text" name="website" value="<?=form_prep($website)?>" />
			</div><!-- /row end -->
			<div class="row">
				<label><span class="required_asterisk">*</span> Email Address:</label>
				<input class="txt" type="text" name="company_email" value="<?=form_prep($company_email)?>"/>
			</div><!-- /row end -->
		</div>
		<div id="personal_info_col_right">
			<h4>Personal information:</h4>
			<div class="row">
				<label>Post-Nominal: <span class="label_note">(e.g. DDS, DMD, Etc.)</span></label>
				<input class="txt" type="text" name="post_nominal" value="<?=form_prep($post_nominal)?>"/>
			</div><!-- /row end -->
			<div class="row">
				<label><span class="required_asterisk">*</span> First Name:</label>
				<input class="txt" type="text" name="first_name" value="<?=form_prep($first_name)?>"/>
			</div><!-- /row end -->
			<div class="row">
				<label><span class="required_asterisk">*</span> Last Name:</label>
				<input class="txt" type="text" name="last_name" value="<?=form_prep($last_name)?>"/>
			</div><!-- /row end -->
			<div class="row">
				<label>Mobile Number:</label>
				<input class="txt" type="text" name="mobile_number" value="<?=form_prep($mobile_number)?>"/>
			</div><!-- /row end -->
			<h4>Account information:</h4>
			<div class="row">
				<label>Email Address: <span class="label_note">(Username)</span></label>
				<input class="txt" type="text" disabled="disabled" name="email" value="<?=form_prep($email)?>"/>
			</div><!-- /row end -->
			<?php if(isset($is_admin)){ ?>
				<div class="row">
					<div style="margin-bottom: 4px;"><input type="checkbox" name="change_pass"/><label style="display:inline;font-weight: normal;"> Check to change password</label></div>
					<input type="hidden" name="is_admin" value="1"/>
					<label>New Password: <span class="label_note" style="color: #05887b; cursor:pointer;" onclick="generate_pass()">generate password</span></label>
					<input id="password_field" class="txt" type="text" name="new_password"/>
				</div><!-- /row end -->
			<?php }else{ ?>
				<div class="row">
					<div style="margin-bottom: 4px;"><input type="checkbox" name="change_pass"/><label style="display:inline;font-weight: normal;"> Check to change password</label></div>
					<label>Old Password: </label>
					<input id="password_field" class="txt" type="password" name="old_password"/>
				</div><!-- /row end -->
				<div class="row">
					<label>New Password: </label>
					<input id="password_field" class="txt" type="password" name="new_password"/>
				</div><!-- /row end -->
				<div class="row">
					<label>Confirm Password: </label>
					<input id="password_field" class="txt" type="password" name="confirm_password"/>
				</div><!-- /row end -->
			<?php } ?>
		</div>
		<div class="clear_both"></div>
		<div id="personal_info_col_bottom">
			<h4 class="clear_bottom">Bio / Description:</h4>
			<textarea rows="4" cols="71" class="wysiwyg_text" name="bio"><?=form_prep($bio)?></textarea>			
			<div class="btn-holder">
				<input id="btn_personal_info" class="btn02" type="button" value="SAVE" />
				
			</div><!-- /btn-holder end -->
		</div>
		<div class="clear_both"></div>
	</form>
</div><!-- /tab-2 end -->