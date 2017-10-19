		<script type="text/javascript">
			$(document).ready(function() {
				$('#mycarousel').jcarousel();
				$(".image_preview").fancybox({
					'titleShow'     : false,
					'transitionIn'	: 'elastic',
					'transitionOut'	: 'elastic'
				})
				$("#rateStars").stars({ 
					split: 2,
					cancelShow: false,
					starWidth: 28,
					inputType: "select",
					captionEl: $("#starsCap")
				});
				$('input#review_butt').click(function(){
					process_form('input#review_butt','SEND REVIEW','div#review_form_messages',false,'form#review_form','dentist/review',false,'add_testimonial');
				});
				$('#toggle_direction').click(function() {
					$('#panel_holder').slideToggle('slow','swing', function() {
						// Animation complete.
					});
				});
			});
			function add_testimonial(data){
				var testi = '<li>'
								+'<span class="stars">'+data.stars+'</span> <label class="stars_label">('+data.rating+' Stars)</label><br/>'
								+'<p>'+data.comment+' <label class="signature">~ '+data.name+'</label></p>'
							+'</li>';
				$('ul#dentist_testimonials').append(testi);
				$('span#dentist_white_rating').empty();
				$('span#dentist_white_rating').append(data.new_rating);
				$('ul#dentist_testimonials p.testi_empty').remove();
				$('ul#dentist_testimonials div.empty').remove();
			}
			function prepare_print(){
				$("#print_map_directions").html($('#panel_holder').html());
				$('#print_text').css('background','url("'+base_url+'/assets/images/ajax-loader-min.gif") no-repeat scroll 0 3px transparent');
			//	$('#print_text').text('preparing...');
				$('#print_text').text('please wait');
				create_static_map();
			}
			function print_a_map(){
				$('#print_text').css('background','url("'+base_url+'/assets/themes/default/images/ico-print.gif") no-repeat scroll 0 0 transparent'); 
				$('#print_text').text('print a map');
				$('#print_map_holder').printArea();
			}
			function open_promotionals(id){
				$('.tab_small').css('display','none');
				$('#tab-2').css('display','block');
				$('#bio_tab_button').attr('class','tab');
				$('#promo_tab_button').attr('class','tab active');
				$('html,body').animate({ scrollTop: $('#'+id+'').position().top },500);
			}
		</script>
		<?=$map['js']?>
		<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/routeboxer/src/RouteBoxer.js" type="text/javascript"></script>
		
		<div id="main">
			<div class="two-columns">
				<div class="aside">
					<div class="heading"><h2>CONTACT</h2></div><!-- /heading end -->
					<ul class="info">
						<li>
							<strong>Address:</strong>
							<div class="holder">
								<span class="company-name">
									<a>
										<?=alt_echo(company_output($first_name,$last_name,$company_name),'','',' :')?> 
										<?=$first_name?> <?=$last_name?> 
										<?=$post_nominal?>
									</a>
								</span>
								<address>
									<span><?=alt_echo($address,'')?></span> 
									<span><?=alt_echo($city,'','',',')?> <?=$state?></span>
								</address>
							</div><!-- /holder end -->
						</li>
						<li>
							<strong>Telephone:</strong>
							<div class="holder"><?=alt_echo($dsusa_telephone,$telephone)?></div><!-- /holder end -->
						</li>
						<li>
							<strong>Email:</strong>
							<div class="holder">
								<a href="#"><?=alt_echo($company_email,'N/A')?></a>
							</div><!-- /holder end -->
						</li>
						<li>
							<strong>Website:</strong>
							<div class="holder">
								<?=alt_echo($website,'N/A','<a href="http://'.$website.'" target="_blank">','</a>')?>
							</div><!-- /holder end -->
						</li>
					</ul><!-- /info end -->
					<div class="heading">
						<a class="open-popup" href="#lbox05">make an appointment</a>
						<h2>OFFICE HOURS</h2>
					</div><!-- /heading end -->
					<table class="hours-table">
						<thead>
							<tr>
								<th class="first">MON.</th>
								<th>TUE.</th>
								<th>WED.</th>
								<th>TRU.</th>
								<th>FRI.</th>
								<th>SAT.</th>
								<th>SUN.</th>
							</tr>
						</thead>
						<tbody>
							<tr>	
							<?php $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
							foreach($days as $day):
								if($day=="Monday"){
									$cls = 'class="first"';
								}else{
									$cls = '';
								}
								$sched = $this->Event_scheduler_model->get_scheds($pid, $day); ?>
								<td <?=$cls?>>
									<?php 
									if(count($sched)>0){
										echo $sched[0]['login'];
										if($sched[0]['break_out']!="-"){
											echo "-";
										}
										echo $sched[0]['break_out'];
									} ?>
								</td>
							<?php endforeach; ?>
							</tr>
							
							<tr>	
							<?php 
							foreach($days as $day):
								if($day=="Monday"){
									$cls = 'class="first"';
								}else{
									$cls = '';
								}
								$sched = $this->Event_scheduler_model->get_scheds($pid, $day); ?>
								<td <?=$cls?>>
									<?php 
									if(count($sched)>0){
										echo $sched[0]['break_in'];
										if($sched[0]['logout']!="-"){
											echo "-";
										}
										echo $sched[0]['logout'];
									} ?>
								</td>
							<?php endforeach; ?>
							</tr>
	
						</tbody>
					</table><!-- /hours-table end -->
					<div class="heading">
						<ul class="map-menu">
								<li><input type="text" value="Enter your location here" id="directions_input" class="hide-text-inputs"/></li>
								<li><a class="dir" id="get_direction_text" style="cursor:pointer;" onclick="route()" title="DENTIST PROFILE: Get directions">get directions</a></li>
						<!--	<li><a class="open-popup" href="#lbox08" title="DENTIST PROFILE: Get directions">get directions</a></li> -->
							<li><a id="print_text" class="print" onclick="prepare_print()" style="cursor:pointer;">print a map</a></li>
						</ul>
						
					</div><!-- /heading end -->
					<div class="map-holder">
						<div id="map_container_profile"></div>
						<div id="panel_holder"></div>
						<div id="toggle_direction"><a>TOGGLE DIRECTION DETAILS</a> </div>
					</div><!-- /map-holder end -->
					<?php if($certifications){ ?>
					<div class="heading"><h2>CERTIFICATION AND LICENCES</h2></div><!-- /heading end -->
					<div class="gallery">
					<!--	<a href="#" class="btn-prev">prev</a>  -->
						<div>
							<ul id="mycarousel">
								<?php foreach($certifications AS $certification): ?>
									<li><a rel="tab_certs" class="image_preview" href="/assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/certifications/<?=$certification['path']?>&width=800&height=600"><img src="/assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/certifications/<?=$certification['path']?>&width=42&height=43" alt="image" width="42" height="43" /></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<!--	<a href="#" class="btn-next">next</a> -->
					</div><!-- /gallery end -->
					<?php } ?>
				</div><!-- /aside end -->
				<div id="content">
					<div class="heading">
						<span class="stars" id="dentist_white_rating"><?=get_star_rating($rating,true,'white')?></span>
						<h2>
							<?=alt_echo($company_name,'','',' :')?> 
							<?=$first_name?> <?=$last_name?> 
							<?=$post_nominal?>
						</h2>
					</div><!-- /heading end -->
					<div class="video-hold">
						<?php if ($prof_pic) {
								$dir = ($pid < 100 ? 'zero' : round($pid, -2));
								$picvid = explode(".",$prof_pic);
								if ($picvid[count($picvid)-1]=="flv") {	?>
								<a href="<?=base_url()?>user_assets/prof_images/<?=$dir?>/<?=$pid?>/<?=$prof_pic?>" rel="shadowbox;width=600;height=450"><img src="<?=base_url()?>user_assets/prof_images/playvid_large.gif" alt="image" width="546" height="314" /></a>
						<?php } else { ?>
								<img src="<?=base_url()?>user_assets/prof_images/<?=$dir?>/<?=$pid?>/<?=$prof_pic?>" alt="image" />
						<?php } } else { ?>
								<img src="/assets/themes/default/images/no_photo_big.png" alt="image" width="546" height="314" />
						<?php } ?>
					</div><!-- /video-hold end -->
					<ul class="tabset">
						<li><a href="#tab-1" class="tab active" id="bio_tab_button">Bio</a></li>
						<li><a href="#tab-2" class="tab" id="promo_tab_button">Promotional</a></li>
						<li><a href="#tab-3" class="tab">Gallery</a></li>
						<li><a href="#tab-4" class="tab">Attached Files</a></li>
						<li><a href="#tab-5" class="tab">Testimonials</a></li>
						<li><a href="#tab-6" class="tab">Review</a></li>
					</ul><!-- /tabset end -->
					<div class="tab-content" id="tab_preloader">
						<img src="<?=base_url()?>assets/images/ajax-loader.gif" />
					</div>
					<div class="tab-content tab_small" id="tab-1">
						<?php if($promotionals){ ?>
							<div id="bio_promo_container">
								<label>Available Promo/s</label>
								<ul>
									<?php foreach($promotionals AS $promo): ?>
										<li><a onclick="open_promotionals('promo_scroll_<?=$promo['id']?>')" title="click me for more info"><?=$promo['name']?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php } ?>
						<?=alt_echo($bio,'<div class="empty">No bio available.</div>','<div>','</div>')?>
						<?php if($specialties): ?>
							<br/>
							<label>SPECIALTIES: </label><br/>
							<div class="specialties_box profile_specialties">
								<?php foreach($specialties AS $spec): ?>
									<label><?=$spec['specialty_title']?></label>
									<?=alt_echo($spec['specialty_text'],'','<p>','</p>')?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div><!-- /tab-1 end -->
					<div class="tab-content tab_small" id="tab-2">
						<?php if(!$promotionals){ ?>
							<div class="empty">No promotional available.</div>
						<?php }else{ 
								foreach($promotionals AS $promo){
									$type = explode('.',$promo['file_path']);
									$type = '.'.end($type);
						?>			<div class="promotionals_container">
										<label class="promo_name" id="promo_scroll_<?=$promo['id']?>"><?=$promo['name']?></label><br/>
										<?php if($promo['code']){ ?>
											<label class="promo_code_label">Promo Code: </label><label class="promo_code"><?=$promo['code']?></label><br/>
										<?php } ?>
										<?php if($promo['file']){ ?>
											<img src="<?=base_url()?>assets/themes/default/images/ico<?=$type?>.gif"/> <a class="promo_file" title="Download" href="<?=base_url()?>dashboard/download_promo_file/<?=$promo['id']?>"><?=$promo['file']?></a><br/>
										<?php } ?><br/>
										<div>
											<?=$promo['description']?>
										</div>
									</div>
						<?php 
								}
							}
						?>
					</div><!-- /tab-2 end -->
					<div class="tab-content tab_small" id="tab-3">
						<p><?=$dashboard['gallery_intro']?></p>
						<?php
							if(count($images)<1){
								echo '<p><div class="empty">No gallery available.</div></p>';
							}
						?>
						<div class="img-gallery">
							<ul>
								<?php foreach($images AS $image): ?>
									<li><a rel="tab_images" class="image_preview" href="/assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/images/<?=$image['path']?>&width=800&height=600"><img src="/assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/images/<?=$image['path']?>&width=200&height=200" alt="image" /></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div><!-- /tab-3 end -->
					<div class="tab-content tab_small" id="tab-4">
						<p><?=$dashboard['documents_intro']?></p>
						<?php
							if(count($files)<1){
								echo '<p><div class="empty">No files available.</div></p>';
							}
						?>
						<?php foreach($file_groups AS $file_group): ?>
							<h3><?=$file_group['group']?>:</h3>
							<ul class="services-list">
								<?php foreach($files AS $file): ?>
									<?php if($file_group['group'] == $file['group']){ ?>
										<li>
											<img src="<?=base_url()?>assets/themes/default/images/ico<?=$file['type']?>.gif" alt="image" width="23" height="23" />
											<div>
												<strong class="ttl"><a href="<?=base_url()?>dentist/download_document_file/<?=$file['id']?>"><?=$file['filename']?></a></strong><!-- /ttl end -->
												<?php
													switch($file['type']){
														case '.doc':
														case '.docx':
															echo '<p>Microsoft word document</p>';
														break;
														case '.ppt':
														case '.pptx':
															echo '<p>Microsoft Power Point Presentation</p>';
														break;
														case '.xls':
														case '.xlsx':
															echo '<p>Microsoft Excel Spreadshet</p>';
														break;
														case '.pdf':
															echo '<p>PDF file</p>';
														break;
													}
												?>	
											</div>
										</li>
									<?php } ?>
								<?php endforeach; ?>
							</ul><!-- /services-list end -->
						<?php endforeach; ?>
					</div>
					<div class="tab-content tab_small" id="tab-5">
						<ul class="testimonials" id="dentist_testimonials">
							<?php
								if(count($testimonials)<1){
									echo '<p class="testi_empty"><div class="empty">No testimonials available.</div></p>';
								}
							?>
							<?php foreach($testimonials AS $testi): ?>
							<li>
								<span class="stars"><?=get_star_rating($testi['rating'],true)?></span> <label class="stars_label">(<?=$testi['rating']?> Stars)</label><br/>
								<p><?=$testi['message']?> <label class="signature">~ <?=$testi['name']?></label></p>
							</li>
							<?php endforeach; ?>
						</ul><!-- /testimonials end -->
					</div><!-- /tab-5 end -->
					<div class="tab-content tab_small" id="tab-6">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						<div id="review_form_messages" class="form_messages"></div>
						<div class="review-form">
							<form id="review_form" action="#">
								<fieldset>
									<div class="row">
										<div class="col">
											<label for="lb30">Name:</label>
											<input id="lb30" name="name" class="txt" type="text" />
										</div>
										<div class="col alignright">
											<label for="lb31">Email Address:</label>
											<input name="email" id="lb31" class="txt" type="text" />
										</div>
									</div><!-- /row end -->
									<div class="row">
										<label for="lb32">Website ( optional ) :</label>
										<input name="website" id="lb32" class="txt1" type="text" />
									</div><!-- /row end -->
									<div class="edit-area">
										<label for="lb33">Message:</label>
										<textarea name="message" id="lb33" class="area" cols="30" rows="10"></textarea>
									</div><!-- /edit-area end -->
									<div class="btn-holder">
										<input id="review_butt" class="btn02" type="button" value="SEND REVIEW" />
										<input class="btn03" type="reset" value="RESET" />
										<div class="score">
											<strong>Your overall score:</strong>
											<div id="rateStars">
											<select name="rate">
												<option <?=select_star($rating,0.5)?> value=".5">(0.5 Star out of 5)</option>
												<option <?=select_star($rating,1.0)?> value="1">(1 Star out of 5)</option>
												<option <?=select_star($rating,1.5)?> value="1.5">(1.5 Stars out of 5)</option>
												<option <?=select_star($rating,2.0)?> value="2">(2 Stars out of 5)</option>
												<option <?=select_star($rating,2.5)?> value="2.5">(2.5 Stars out of 5)</option>
												<option <?=select_star($rating,3.0)?> value="3">(3 Stars out of 5)</option>
												<option <?=select_star($rating,3.5)?> value="3.5">(3.5 Stars out of 5)</option>
												<option <?=select_star($rating,4.0)?> value="4">(4 Stars out of 5)</option>
												<option <?=select_star($rating,4.5)?> value="4.5">(4.5 Stars out of 5)</option>
												<option <?=select_star($rating,5.0)?> value="5">(5 Stars out of 5)</option>
											</select>
											<input name="user_id" type="hidden" value="<?=$pid?>">
										</div>
										<span class="commonControlLabelItalic" id="starsCap"></span>
										</div><!-- /score end -->
									</div><!-- /btn-holder end -->
								</fieldset>
							</form>
						</div>
					</div><!-- /tab-6 end -->
				</div><!-- /content end -->
			</div><!-- /two-columns end -->
		</div><!-- /main end -->
		<div id="print_map_holder">
			<div id="print_map_logo">
				<img src="<?=base_url()?>assets/themes/default/images/dsusa_get_directions.png">
			</div>
			<div style="text-align:center;">
				<img id="print_map_holder_img" src="" onload="print_a_map()"/>
			</div>
			<div id="print_map_directions"></div>
		</div>
		