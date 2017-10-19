		<div id="main">
			<div id="sidebar">
				<div class="heading">
					<h2>ADVERTISING</h2>
				</div><!-- /heading end -->
				<?php if($sidebar_ads[0]['links']){ echo '<a href="'.$sidebar_ads[0]['links'].'" target="_blank" title="'.$sidebar_ads[0]['text'].'">'; } ?>
					<?php if($sidebar_ads[0]['image']){ ?>
						<img src="<?=base_url()?>assets/images/advertisements/<?=$sidebar_ads[0]['image']?>" alt="image" width="259" height="215" />
					<?php }else{ ?>
						<img src="<?=base_url()?>assets/images/advertisements/no_sidebar_ads_big.png" alt="image" width="259" height="215" />
					<?php } ?>
				<?php if($sidebar_ads[0]['links']){ echo '</a>'; }?>
				<div class="ad-list">
					<ul>
						<li>
							<?php if($sidebar_ads[1]['links']){ echo '<a href="'.$sidebar_ads[1]['links'].'" target="_blank" title="'.$sidebar_ads[1]['text'].'">'; } ?>
								<?php if($sidebar_ads[1]['image']){ ?>
									<img src="<?=base_url()?>assets/images/advertisements/<?=$sidebar_ads[1]['image']?>" alt="image" width="124" height="124" />
								<?php }else{ ?>
									<img src="<?=base_url()?>assets/images/advertisements/no_sidebar_ads_small.png" alt="image" width="124" height="124" />
								<?php } ?>
							<?php if($sidebar_ads[1]['links']){ echo '</a>'; }?>
						</li>
						<li>
							<?php if($sidebar_ads[2]['links']){ echo '<a href="'.$sidebar_ads[2]['links'].'" target="_blank" title="'.$sidebar_ads[2]['text'].'">'; } ?>
								<?php if($sidebar_ads[2]['image']){ ?>
									<img src="<?=base_url()?>assets/images/advertisements/<?=$sidebar_ads[2]['image']?>" alt="image" width="124" height="124" />
								<?php }else{ ?>
									<img src="<?=base_url()?>assets/images/advertisements/no_sidebar_ads_small.png" alt="image" width="124" height="124" />
								<?php } ?>
							<?php if($sidebar_ads[2]['links']){ echo '</a>'; }?>
						</li>
					</ul>
				</div><!-- /ad-list end -->
			</div><!-- /sidebar end -->
			<div id="content">
				<div class="heading"><h2>Dentist Search USA - Terms & Conditions</h2></div><!-- /heading end -->
				<?=$seo['content']?>
			</div><!-- /content end -->
		</div><!-- /main end -->