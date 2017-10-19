		<script type="text/javascript" src="<?=min_file('assets/js/jquery.wysiwyg.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/swfobject.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery.uploadify.v2.1.0.min.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery.fancybox-1.3.0.js')?>"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".viewpicvid").fancybox({
				'titleShow'     : false,
				'transitionIn' : 'elastic',
				'transitionOut' : 'elastic'
				});
				$("#edit_picvid").uploadify({
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
					'onComplete': function(e,q,o,r){
						res = jQuery.parseJSON(''+r+'');
						if(res.success){
							parent.$.fancybox.close();
							
							var ext = res.file.file_name.split(".");
							if(ext[1]=="flv"){
								var new_file = '<div id="old_picvid" class="photo"><a id="flv_player" href="'+base_url+'user_assets/prof_images/'+res.file.file_name+'" rel="shadowbox;width=600;height=450"><img src="'+base_url+'user_assets/prof_images/playvid.gif" alt="image" width="251" height="138" /></a></div>';
							}else{
								var new_file = '<div id="old_picvid" class="photo"><img src="'+base_url+'assets/phpthumb/resize.php?src='+base_url+'user_assets/prof_images/'+res.file.file_name+'&width=251&height=500" alt="image" /></div>';
							
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
			})
		</script>
		<div id="main">
			<div class="aside">
				<div class="heading">
					<div style="display:none;">
						<div class="editpicvid" id="edit_pic_vid" style="text-align:center;width:385px;height:185px;">
							<div class="fancy_heading">Edit Profile Picture/Video</div>
							<form action="#">
								<div class="row">
									<label>Upload Image/video:</label><br/>
									<input class="text" type="file" name="edit_picvid" id="edit_picvid" />
								</div>
							</form>
							<div id="picvid_fileQueue"></div>
							<br/>
						</div>
					</div>
					<a class="viewpicvid" title="Upload profile image/video" href="#edit_pic_vid">edit profile picture/video</a>
					<h2>PROFILE</h2>
				</div><!-- /heading end -->
				<div id="p_picvid">
					<div id="old_picvid" class="photo" >
					<?php
						if($prof_pic){
							$picvid = explode(".",$prof_pic);
							if($picvid[1]=="flv"){
					?>
							<a href="<?=base_url()?>user_assets/prof_images/<?=$prof_pic?>" rel="shadowbox;width=600;height=450">
								<img src="<?=base_url()?>user_assets/prof_images/playvid.gif" alt="image" width="251" height="138" />
							</a>
					<?php	}else{ ?>
						<img src="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/prof_images/<?=$prof_pic?>&width=251&height=500" alt="image" />
					<?php 
							} 
						}else{
					?>
						<img src="<?=base_url()?>assets/themes/default/images/no_photo_medium.png" alt="image" width="251" height="138" />
					<?php } ?>
					
					</div><!-- /photo end -->
				</div>
				<ul class="info">
					<li>
						<span class="company-name">
							<a href="#">
								<?=alt_echo($company_name,'','',' :')?> 
								<?=$first_name?> <?=$last_name?> 
								<?=$post_nominal?> 
							</a>
						</span>
						<address>
							<span><?=alt_echo($address,'')?></span> 
							<span><?=alt_echo($city,'','',',')?> <?=$state?></span>
						</address>
					</li>
					<li><?=alt_echo($telephone,'N/A')?></li>
					<li><?=alt_echo($company_email,'N/A')?></li>
					<li><?=alt_echo($website,'N/A')?></li>
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
					<a href="#">view messages</a>
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
								<input class="btn03" type="reset" value="RESET" />
							</div><!-- /btn-holder end -->
						</fieldset>
					</form>
				</div><!-- /msg-form end -->
			</div><!-- /aside end -->
			<div class="dashboard-area">
				<ul class="tabset">
					<li><a href="#tab-1" class="tab active">Dashboard</a></li>
					<li><a href="#tab-2" class="tab">Account</a></li>
					<li><a href="#tab-3" class="tab">Specialty</a></li>
					<li><a href="#tab-4" class="tab">Promo</a></li>
					<li><a href="#tab-5" class="tab">Files</a></li>
					<li><a href="#tab-6" class="tab">Gallery</a></li>
					<li><a href="#tab-7" class="tab">Certifications</a></li>
					<li><a href="#tab-8" class="tab">Inbox</a></li>
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