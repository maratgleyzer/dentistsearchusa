	<script type="text/javascript">
		$(function(){
			$('input#btn_register2').click(function(){
				process_form(
					'input#btn_register2','REGISTER','div#reg_form_messages2',false,'form#reg_form2','dentist/registration','dashboard/');
			});
		//	$('#payment_desc_'+$('#payment_plan').val()).css('display','block');
			change_payment_desc($('#payment_plan'));
		})
		function change_payment_desc(el){
			$('.payment_plan_desc').css('display','none');
			$('#payment_desc_'+$(el).val()).css('display','block');
			
			if($("option:selected",el).attr('id') == 1){
				$("#creditcard_fields").css('display','none');
			}else{
				$("#creditcard_fields").css('display','block');
			}
		}
	</script>
	<div id="lbox06">
		<div class="lbox">
			<div class="lbox-h">
				<div class="box-heading">
					<a class="close" href="#">close</a>
					<strong class="ttl">SIGNUP: Dentist signup form</strong>
					<span class="ico03">&nbsp;</span>
				</div><!-- /box-heading end -->
				<div id="reg_form_messages2" class="form_messages"></div>
				<div class="columns">
					<form id="reg_form2" action="#">
						<fieldset>
							<div class="c-holder">
								<div class="column">
									<h4>Personal information:</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit </p>
									<div class="row">
										<label for="lb444"><span class="required_asterisk">* </span>First Name:</label>
										<input id="lb444" class="txt" type="text" name="fname" />
									</div><!-- /row end -->
									<div class="row">
										<label for="lb445"><span class="required_asterisk">* </span>Last Name:</label>
										<input id="lb445" class="txt" type="text" name="lname" />
									</div><!-- /row end -->
									<div class="row">
										<label for="lb475"><span class="required_asterisk">* </span>Phone:</label>
										<input id="lb475" class="txt" type="text" name="phone"/>
									</div><!-- /row end -->
									<div class="row">
										<label for="lb45"><span class="required_asterisk">* </span>Email Address: <span class="label_note">(Username)</span></label>
										<input id="lb45" class="txt" type="text" name="email"/>
									</div><!-- /row end -->
									<div class="row">
										<label for="lb46"><span class="required_asterisk">* </span>Confirm Email:</label>
										<input id="lb46" class="txt" type="text" name="emailconf"/>
									</div><!-- /row end -->
									<div class="row">
										<label for="lb47"><span class="required_asterisk">* </span>Password:</label>
										<input id="lb47" class="txt" type="password" name="password"/>
									</div><!-- /row end -->
									<div class="row">
										<label for="lb438"><span class="required_asterisk">* </span>Confirm Password:</label>
										<input id="lb438" class="txt" type="password" name="passconf"/>
									</div><!-- /row end -->
								</div><!-- /column end -->
								<div class="column alignright">
									<h4>Payment details:</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod </p>
									<div class="row">
										<label><span class="required_asterisk">* </span>Payment Plan:</label>
										<select id="payment_plan" name="payment_plan" class="sel" onchange="change_payment_desc(this)">
											<?php foreach($payment_plans AS $plan): ?>
												<option id="<?=$plan['type']?>" value="<?=$plan['id']?>"><?=$plan['name']?></option>
											<?php endforeach; ?>
										</select><br/><br/>
										<?php foreach($payment_plans AS $plan): ?>
											<p class="payment_plan_desc" id="payment_desc_<?=$plan['id']?>">
												<?=$plan['description']?>
											</p>
										<?php endforeach; ?>
									</div><!-- /row end -->
									<div id="creditcard_fields">
										<div class="row">
											<label for="lb48"><span class="required_asterisk">* </span>Payment method:</label>
											<select id="lb48" class="sel" name="card_type">
												<option type="Mastercard">Mastercard</option>
												<option type="Visa">Visa</option>
											</select>
										</div><!-- /row end -->
										<div class="row">
											<label for="lb49"><span class="required_asterisk">* </span>Credit card number:</label>
											<input id="lb49" name="card_no" class="txt" type="text" />
										</div><!-- /row end -->
										<div class="row">
											<div class="date">
												<label for="lb50"><span class="required_asterisk">* </span>Expiration date:</label>
												<div class="sel-holder">
													<select name="exp_month" id="lb50" class="sel1">
														<option value="01" >01</option>
														<option value="02">02</option>
														<option value="03">03</option>
														<option value="04">04</option>
														<option value="05">05</option>
														<option value="06">06</option>
														<option value="07">07</option>
														<option value="08">08</option>
														<option value="09">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
													</select>
													<select name="exp_year" class="sel1">
														<option value="2010">2010</option>
														<option value="2011">2011</option>
														<option value="2012">2012</option>
														<option value="2013">2013</option>
														<option value="2014">2014</option>
														<option value="2015">2015</option>
														<option value="2016">2016</option>
														<option value="2017">2017</option>
														<option value="2018">2018</option>
														<option value="2019">2019</option>
														<option value="2020">2020</option>
														<option value="2021">2021</option>
														<option value="2022">2022</option>
														<option value="2023">2023</option>
														<option value="2024">2024</option>
														<option value="2025">2025</option>
													</select>
												</div><!-- /sel-holder end -->
											</div><!-- /date end -->
											<div class="secur-number">
												<label>Security number:</label>
												<input name="ccv" class="txt1" type="text" />
											</div><!-- /secur-number end -->
										</div><!-- /row end -->
										<div class="row">
											<label for="lb491">Billing Address:</label>
											<input name="address" id="lb491" class="txt" type="text" />
										</div><!-- /row end -->
										<div class="row">
											<label for="lb492">City:</label>
											<input name="city" id="lb492" class="txt city_zip_autocomplete {autoc_width:210,autoc_type:'city_name'}" type="text" />
										</div><!-- /row end -->
										<div class="row">
											<label for="lb493">State:</label>
											<input name="state" id="lb493" class="txt city_zip_autocomplete {autoc_width:210,autoc_type:'state'}" type="text" />
										</div><!-- /row end -->
										<div class="row">
											<label for="lb494">Zip:</label>
											<input name="zip" id="lb494" class="txt city_zip_autocomplete {autoc_width:210,autoc_type:'zip'}" type="text" />
										</div><!-- /row end -->
									</div>	
								</div><!-- /column alignright end -->
							</div><!-- /c-holder end -->
							<div class="btn-holder">
							<!--	<input class="btn03 close" type="reset" value="CANCEL" /> -->
								<input class="btn02" id="btn_register2" type="button" value="REGISTER" />
								<a class="vsign" href="#">veri sign</a>
							</div><!-- /btn-holder end -->
						</fieldset>
					</form>
				</div><!-- /columns end -->
			</div><!-- /lbox-h end -->
		</div><!-- /lbox end -->
		<div class="lbox-b"></div><!-- /lbox-b end -->
	</div>