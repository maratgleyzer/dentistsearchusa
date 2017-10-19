<script type="text/javascript">	
	function save_success(){
		
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#payment_form_messages',true,'form#payment_form','_admin_console/payment/save_payment_plan',false,'save_success');
		});
		show_payments($('#payment_type'));
	})
	function show_payments(el){
		var val = $(el).val();
		if(val == 2){
			$('#initial_amount').val('');
			$('#initial_amount').attr('disabled','');
			$('#recurring_amount').val('');
			$('#recurring_amount').attr('disabled',true);
			$('#recurring_container').css('display','none');
			$('#initial_container').css('display','block');
		}else if(val == 3|| val==4){
			$('#initial_amount').val('');
			$('#recurring_amount').val('');
			$('#initial_amount').attr('disabled','');
			$('#recurring_amount').attr('disabled','');
			$('#recurring_container').css('display','block');
			$('#initial_container').css('display','block');
		}else{
			$('#initial_amount').val('');
			$('#recurring_amount').val('');
			$('#initial_amount').attr('disabled',true);
			$('#recurring_amount').attr('disabled',true);
			$('#recurring_container').css('display','none');
			$('#initial_container').css('display','none');
		}
	}
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Add Payment Plan
	</label><br/><br/>
	<div id="payment_form_messages" class="form_messages"></div>
	<form id="payment_form">
		Payment Plan Type<br/>
		<select id="payment_type" onchange="show_payments(this)" class="medium_input_text" name="type" >
			<option value="">- - - - - - - - Select Type - - - - - - - - </option>
			<?php foreach($plan_type AS $type): ?>
				<option value="<?=$type['id']?>"><?=$type['name']?></option>
			<?php endforeach; ?>
		</select><br/><br/>
		<div id="initial_container" style="display:none;">
			Initial Payment<br/>
			<input id="initial_amount" disabled="disabled" type="text" class="medium_input_text" name="initial_amount" /><br/><br/>
		</div>
		<div id="recurring_container" style="display:none;">
			Recurring Payment<br/>
			<input id="recurring_amount" disabled="disabled" type="text" class="medium_input_text" name="recurring_amount" /><br/><br/>
		</div>
		Payment Plan Name<br/>	
		<input type="text" class="wide_input_text" name="name" /><br/><br/>
		Description/Details<br/>
		<textarea name="description" cols="57" rows="10"></textarea>
		<br/><br><br>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>