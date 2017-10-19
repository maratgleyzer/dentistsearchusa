<script type="text/javascript">
	$(function(){
		$('input#btn_specialty').click(function(){
			process_form('input#btn_specialty','SAVE','div#specialty_form_messages',true,'form#dentist_specialty','dashboard/save_specialties');
		});
	})
</script>
<div class="tab-content" id="tab-3">
	<div id="specialty_form_messages" class="form_messages"></div>
	<h4 class="default">Specialties:</h4>
	<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed urna libero, dapibus at consequat eu.
	</p>
	<form id="dentist_specialty" action="#">
		<div class="specialties_box">
			<?php 
				foreach($specialties AS $specialty):
					$checked = NULL;
					foreach($user_specialties AS $user_spec):
						if($specialty['id'] == $user_spec['specialty_id']){
							$checked = 'checked';
						}
					endforeach;
			?>
				<div>
					<input <?=$checked?> type="checkbox" name="specialties[]" value="<?=$specialty['id']?>"/> <label><?=$specialty['specialty_title']?></label>
					<p><?=$specialty['description']?></p>
				</div>
			<?php 
				endforeach; ?>
			
		</div>
		<div class="btn-holder">
			<input id="btn_specialty" class="btn02" type="button" value="SAVE" />
			<input class="btn03" type="reset" value="RESET" />
		</div><!-- /btn-holder end -->
	</form>
</div>