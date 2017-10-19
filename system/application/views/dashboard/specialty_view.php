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
				$i = 1;
				foreach($specialties AS $specialty):
					$checked = NULL;
					$text = NULL;
					foreach($user_specialties AS $user_spec):
						if($specialty['id'] == $user_spec['specialty_id']){
							$checked = 'checked';
							$text = $user_spec['specialty_text'];
						}
					endforeach;
			?>
				<div>
					<input <?=$checked?> type="checkbox" name="specialties[]" value="<?=$specialty['id'].':'.$i?>"/> <label><?=$specialty['specialty_title']?></label><br/>
					<textarea class="<?php if(!$text){ ?>hide-text-inputs <?php } ?>specialty_text" name="specialty_text[<?=$i?>]"><?=alt_echo($text,'Please enter information about your qualifications in this category here');?></textarea>
				</div>
			<?php 
					$i++;
				endforeach;
			?>
			
		</div>	
		<div class="btn-holder">
			<input id="btn_specialty" class="btn02" type="button" value="SAVE" />
			
		</div><!-- /btn-holder end -->
	</form>
</div>