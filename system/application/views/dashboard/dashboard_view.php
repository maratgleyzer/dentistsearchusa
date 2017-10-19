		<script type="text/javascript">
			function hide_show_browse(show){
				if(show){
					$('#edit_picvid_container').css('display','block');
				}else{
				//	$("#edit_picvid").uploadifySettings('hideButton',true);
					$("#edit_picvid").uploadifySettings('height',0);
				//	$("#edit_picvid").uploadifySettings('width',0);
				}
			}
			$(document).ready(function() {
				$(".viewpicvid").fancybox({
				'titleShow'     : false,
				'transitionIn' : 'elastic',
				'transitionOut' : 'elastic'
				});
				$("#edit_picvid").uploadify({
					'wmode': 'transparent',
					'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
					'script': '<?=base_url()?>dashboard/upload_picvid/',
					'cancelImg': '<?=base_url()?>assets/images/cancel.png',
					'queueID': 'picvid_fileQueue',
					'method': 'POST',
					'auto': true,
					'scriptData': {'up_key':"<?=$logged_key?>"},
					'multi': false,
					'fileDesc':'PNG; JPEG; FLV;',
					'fileExt': '*.png;*.jpeg;*.jpg;*.flv',
					'onSelect': function(){
						hide_show_browse();
					},
					'onComplete': function(e,q,o,r){
						res = jQuery.parseJSON(''+r+'');
						if(res.success){
							parent.$.fancybox.close();
							var dir = (<?=$logged_key?> < 100 ? 'zero' : <?=round($logged_key, -2)?>);
							var ext = res.file.file_name.split(".");
							if(ext[ext.length-1]=="flv"){
								var new_file = '<div id="old_picvid" class="photo"><a id="flv_player" href="'+base_url+'user_assets/prof_images/'+dir+'/<?=$logged_key?>/flash.flv?rand='+Math.random()+'" rel="shadowbox;width=600;height=450"><img src="'+base_url+'user_assets/prof_images/playvid.gif" alt="image" width="251" height="138" /></a></div>';
							}else{
								var new_file = '<div id="old_picvid" class="photo"><img src="'+base_url+'user_assets/prof_images/'+dir+'/<?=$logged_key?>/photo.jpg?rand='+Math.random()+'" alt="image" /></div>';
							}
							$('#old_picvid').remove();
							$('#p_picvid').append(new_file);
							Shadowbox.setup("a#flv_player"); 
						}else{
							Sexy.error('<h1>Upload error</h1>'+res.message);
							$("#edit_picvid").uploadifyCancel(q);
							$("#edit_picvid").uploadifyClearQueue();
						}
					}
				});
			});
			$(function(){
				$('input#btn_c').click(function(){
					process_form(
						'input#btn_c','SEND','div#c_form_messages',false,'form#c_form','contact','');
				});
				<?php
					if(!$company_email){
				?>
						$('.nonprio').each(function(i,val){
							var tab_href = $(val).attr('href');
							$(val).attr('href',tab_href+'::');
						});
						$('.nonprio').click(function(){
							Sexy.error('<h1>Account Tab Required</h1> <p>Before you can access the other tabs, please fill-out all required information in this tab first.</p>');
							return false;
						});
				<?php
					}
				?>
			})
			function restore_tabs(obj){
				$('.nonprio').each(function(i,val){
					var tab_href = $(val).attr('href');
					tab_href = tab_href.replace('::','');
					$(val).attr('href',tab_href);
					$('.nonprio').unbind();
					change_info_texts()
				});
			}
			function change_info_texts(){
				$('#text_company').html('<a href="#">'+$('input[name=company_name]').val()+': '+$('input[name=first_name]').val()+' '+$('input[name=last_name]').val()+' '+$('input[name=post_nominal]').val()+'</a>');
				$('#text_address').html('<span>'+$('input[name=address]').val()+'</span><span>'+$('input[name=city]').val()+' ,'+$('input[name=state]').val()+'</span>');
				$('#text_telephone').text($('input[name=telephone]').val());
				$('#text_company_email').text($('input[name=company_email]').val());
				if($('input[name=website]').val()){
					$('#text_website').text($('input[name=website]').val());
				}else{
					$('#text_website').html('<a class="needed_info tab" onclick="input_focus(\'website\')">Website (Optional)</a>');
				}
			}
			function input_focus(name){
				$('input[name='+name+']').focus();
			}
		</script>
		<div id="main">
			<div class="aside">
				<?php if($total_apps){ ?>
					<div class="notifications">
						<div class="notifications_arrow">
							<label class="notification_label"><?=$total_apps?></label>
							<img class="notifications_image" src="<?=base_url()?>assets/themes/default/images/notification_arrow.png"/>
						</div>
					</div>
				<?php } ?>
				<div class="heading">
					<div style="display:none;">
						<div class="editpicvid" id="edit_pic_vid" style="width:420px;height:215px;">
							<div style="text-align: left;" class="fancy_heading"> &nbsp; &nbsp;Edit Profile Picture/Video</div>
							<form action="#">
								<div class="row">
									<label><input type="radio" name="video_type" value="flv" checked /> Upload Image/Video <span style="color:gray;font-style:italic;">(Recommended size is 546 x 314 px):</span> </label><br/>
									<label><input type="radio" name="video_type" value="youtube"/> Use Youtube Video</label><br/><br/>
									<div id="profile_avatar_container">
										<div style="vertical-align:middle;display:table-cell;">
											<div id="edit_picvid_container">
												<input class="text" type="file" name="edit_picvid" id="edit_picvid" />
											</div>
											<div id="picvid_fileQueue"></div>
										</div>
									</div>
								</div>
							</form>
							<br/>
						</div>
					</div>
					<a class="viewpicvid" title="Upload profile image/video" href="#edit_pic_vid">edit profile picture/video</a>
					<h2>PROFILE</h2>
				</div><!-- /heading end -->
				<div id="p_picvid">
					<div id="old_picvid" class="photo" >
					<?php if ($prof_pic) {
							 $dir = ($logged_key < 100 ? 'zero' : round($logged_key, -2));
							 $picvid = explode(".",$prof_pic);
							 if ($picvid[count($picvid)-1]=="flv") { ?>
					<a href="<?=base_url()?>user_assets/prof_images/<?=$dir?>/<?=$logged_key?>/flash.flv" rel="shadowbox;width=600;height=450"><img src="<?=base_url()?>user_assets/prof_images/playvid.gif" alt="image" width="251" height="138" /></a>
					<?php } else { ?>
					<img src="<?=base_url()?>user_assets/prof_images/<?=$dir?>/<?=$logged_key?>/photo.jpg" alt="image" />
					<?php } } else { ?>
					<img src="<?=base_url()?>assets/themes/default/images/no_photo_medium.png" alt="image" width="251" height="138" />
					<?php } ?>
					</div><!-- /photo end -->
				</div>
				<ul class="info">
					<li>
						<span class="company-name" id="text_company">
							<a href="#">
								<?=alt_echo($company_name,'','',' :')?> 
								<?=$first_name?> <?=$last_name?> 
								<?=$post_nominal?> 
							</a>
						</span>
						<address id="text_address">
							<span><?=alt_echo($address,'<a class="needed_info" onclick="input_focus(\'address\')">Address Needed</a>')?></span> 
							<span><?=alt_echo($city,'','',',')?> <?=$state?></span>
						</address>
					</li>
					<li id="text_telephone"><?=alt_echo($telephone,'<a class="needed_info" onclick="input_focus(\'telephone\')">Telephone Needed</a>')?></li>
					<li id="text_company_email"><?=alt_echo($company_email,'<a class="needed_info" onclick="input_focus(\'company_email\')">Company Email Needed</a>')?></li>
					<li id="text_website"><?=alt_echo($website,'<a class="needed_info tab" onclick="input_focus(\'website\')">Website (Optional)</a>')?></li>
				</ul><!-- /info end -->
				<div class="heading"><h2>STATISTIC</h2></div><!-- /heading end -->
				<ul class="statistic">
					<li>
						<span class="qty"><?=$page_views?></span>
						<a href="#">Page views</a>
					</li>
					<!--
					<li>
						<span class="qty">87</span>
						<a href="#">Contacts</a>
					</li>
					<li>
						<span class="qty">2</span>
						<a href="#">Articles</a>
					</li>
					-->
					<li>
						<span class="qty"><?=$reviews_count?></span>
						<a href="#">Testimonials</a>
					</li>
					<li>
						<span class="stars"><?=get_star_rating($rating,true)?></span>
						<a href="#">Overall score</a>
					</li>
				</ul><!-- /statistic end -->
				<div class="heading">
					<h2>CONTACT US</h2>
				</div><!-- /heading end -->
				<div id="c_form_messages" class="form_messages"></div>
				<div class="msg-form">
					<form id="c_form" action="#">
						<fieldset>
							<div class="edit-area01">
								<textarea name="msg" class="area" cols="30" rows="10"></textarea>
							</div><!-- /edit-area01 end -->
							<div class="btn-holder">
								<input type="hidden" name="type_c" value="1" />
								<input type="hidden" value="<?=$first_name?>" name="fname" />
								<input type="hidden" value="<?=$last_name?>" name="lname" />
								<input type="hidden" value="<?=alt_echo($company_email,'N/A')?>" name="email" />
								<input class="btn02" id="btn_c" type="button" value="SEND MESSAGE" />
								
							</div><!-- /btn-holder end -->
						</fieldset>
					</form>
				</div><!-- /msg-form end -->
			</div><!-- /aside end -->
			<div class="dashboard-area">
				<ul class="tabset">
					<li><a href="#tab-1" class="nonprio tab<?php if($company_email){ echo ' active';}?>">Dashboard</a></li>
					<li><a href="#tab-2" class="tab<?php if(!$company_email){ echo ' active';}?>">Account</a></li>
					<li><a href="#tab-3" class="nonprio tab">Specialty</a></li>
					<li><a href="#tab-4" class="nonprio tab">Promo</a></li>
					<li><a href="#tab-5" class="nonprio tab">Files</a></li>
					<li><a href="#tab-6" class="nonprio tab">Gallery</a></li>
					<li><a href="#tab-7" class="nonprio tab">Certifications</a></li>
					<li><a href="#tab-8" class="nonprio tab">Inbox</a></li>
					<li class="help-link"><a href="#tab-9" class="tab">Help</a></li>
				</ul><!-- /tabset end -->
				<div class="tab-content" id="tab_preloader" style="min-height: 680px;">
					<img src="<?=base_url()?>assets/images/ajax-loader.gif" />
				</div>
				<?=$dashboard_tab?>
				<?=$personal_informations_tab?>
				<?=$specialty_tab?>
				<?=$promotional_tab?>
				<?=$documents_tab?>
				<?=$gallery_tab?>
				<?=$certifications_tab?>
				<?=$inbox_tab?>
				<?=$help_tab?>
			</div><!-- /dashboard-area end -->
		</div><!-- /main end -->