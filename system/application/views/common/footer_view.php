		<?php if(isset($other_cities)) { ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#more_footer_cities_btn').click(function(){
				var state = $('#more_city_state_abbr').val();
				$('.preloader').show();
					$.ajax({
						type: "POST",
						url: base_url+'dentist/ajax_more_cities/state/'+state,
						cache: false,
						success : function(html){
							//html = '<div style="margin: 10px 0 0 0;font-weight: bold;text-decoration: underline;">In Alphabetical Order:</div>'+html;
							html = '<div style="clear: both;margin-bottom: 8px;height: 14px;border-bottom: 1px dashed #999;"></div>'+html;
							$("#more_footer_cities").html(html);
							$("#more_link_area").hide();
							$('.preloader').hide();
							$('#more_footer_cities').animate({ height: '380px' }, 1000);
							$('html, body').animate({ scrollTop: $(document).height() }, 2000);

						}
					});
					return false;
				});
			});
		</script>
		<?php } ?>
		<div id="footer">
			<div class="ad-list">
				<ul>
					<?php foreach($footer_ads AS $ad){ ?>
					<li>
					<?php if($ad['links']) { ?><a href="<?=$ad['links']?>" target="_blank" title="<?=$ad['title']?>"><?php } ?>
					<div style="<?php if($ad['links']) { ?>cursor: pointer;cursor: hand;<?php } ?>background: url(<?php if($ad['image']){ echo base_url(); ?>assets/images/advertisements/<?= $ad['image']; } else { echo base_url(); ?>assets/images/advertisements/no_footer_ads.png<?php } ?>) 0 0 no-repeat;">
					<span style="float: <?=($ad['align'] == 'right' ? 'right' : 'left'); ?>" class="ad_title"><?=$ad['title']?></span>
					<span style="float: <?=($ad['align'] == 'right' ? 'right' : 'left'); ?>" class="ad_text"><?=$ad['text']?></span>
					</div>
					<?php if($ad['links']){ ?></a><?php } ?>	
					</li>
					<?php } ?>
				</ul>
			</div><!-- /ad-list end -->
			<div class="footer-holder">
				<div class="frame">
					<div class="text-hold"><p>(c) DentistSearchU.S.A. - 2010 All rights reserved! </p></div><!-- /text-hold end -->
					<ul class="social-list">
						<?php foreach($allicons AS $icon): ?>
							<li><a href="<?=$icon['link']?>" class="soc01" title="<?=$icon['tooltip']?>"><img src="<?=base_url()?>assets/images/social_media_icons/<?=$icon['icon']?>"/></a></li>
						<?php endforeach; ?>
					</ul><!-- /social-list end -->
					<ul class="list">
						<li><a href="<?=base_url()?>about_us">about us</a></li>
						<li><a href="<?=base_url()?>help">help</a></li>
						<li><a href="<?=base_url()?>terms_and_conditions">terms and conditions</a></li>
						<?php if(!$logged_in){ ?>
							<li><a class="open-popup" href="#lbox03">register</a></li>
							<li><a class="open-popup" href="#lbox02">dentist login</a></li>
						<?php }else{ ?>
							<li><a href="<?=base_url()?>dashboard/">my account</a></li>
						<?php } ?>
					</ul><!-- /list end -->
				</div><!-- /frame end -->
			</div><!-- /footer-holder end -->
			<div class="text-block" id="other_city_container">
				<?php 
					if(isset($other_cities)){
						echo $other_cities;
					}elseif (isset($footer_tags)){
						echo $footer_tags;
					}
				?>
			</div>
			<?php if($has_cities) { ?>
			<div id="more_link_area" style="text-align: right;"><input type="hidden" name="more_city_state_abbr" id="more_city_state_abbr" value="<?php echo $active_state; ?>" /><a id="more_footer_cities_btn" href="javascript:" title="See More Cities">...more</a></div>
			<div class="preloader" style="display: none;"><img src="<?=base_url()?>assets/images/ajax-loader.gif" /></div>
			<div id="more_footer_cities" class="cities" style="height:1px;">
			</div><!-- /cities end -->
			<?php } ?>
			&nbsp;
		</div><!-- /footer end -->
	</div><!-- /wrapper hp end -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?=$analytics_id?>']);
		_gaq.push(['_trackPageview']);
		(function(){
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</body>
</html>