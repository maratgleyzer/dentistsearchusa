		<div id="main">
			<div id="sidebar">
				<div class="heading"><h2>CATEGORIES</h2></div><!-- /heading end -->
				<ul class="side-list">
					<?php foreach($categories as $category): ?>
					<li><img src="<?=base_url();?>assets/themes/default/images/bullet_white.png"> <a href="<?=base_url();?>video/category/<?=$category['id'];?>/"><?=$category['category_title'];?></a></li>
					<?php endforeach; ?>
				</ul><!-- /side-list end -->
				<div class="heading">
					<h2>ADVERTISING</h2>
				</div><!-- /heading end -->
				<?php if($sidebar_ads[0]['links']){ echo '<a href="'.$sidebar_ads[0]['links'].'" target="_blank" title="'.$sidebar_ads[0]['text'].'">'; }else{ echo '<a>';} ?>
					<?php if($sidebar_ads[0]['image']){ ?>
						<img src="<?=base_url()?>assets/images/advertisements/<?=$sidebar_ads[0]['image']?>" alt="image" width="259" height="215" />
					<?php }else{ ?>
						<img src="<?=base_url()?>assets/images/advertisements/no_sidebar_ads_big.png" alt="image" width="259" height="215" />
					<?php } ?>
				<?php  echo '</a>'; ?>
				<div style="height: 8px;"></div>
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
				<div class="heading"><h2>DENTAL VIDEOS</h2></div><!-- /heading end -->
				<div class="post-list">
					<?php if($videos){ ?>
					<ul>
						<?php foreach($videos as $video): ?>
						<li>
							
							<div class="img-holder">
								<?php if($video['type'] == 'flv'){ ?>
									<a href="<?=base_url();?>content_assets/videos/<?=$video['filename'];?>" rel="shadowbox;width=600;height=450;">
										<img class="video_play_image" src="<?=base_url();?>assets/themes/default/images/video_play.png">
									</a>
									<div style="overflow:hidden; width:294px; height: 167px;">
										<img src="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url();?>content_assets/images/<?=$video['image'];?>&width=294&height=300" alt="image" />
									</div>
								<?php }else{ ?>
									<a href="<?=$video['filename'];?>" rel="shadowbox;width=600;height=450;">
										<img class="video_play_image" src="<?=base_url();?>assets/themes/default/images/video_play.png">
									</a>
									<div style="overflow:hidden; width:294px; height: 167px;">
										<img src="<?=base_url()?>assets/phpthumb/resize.php?src=<?=$video['image']?>&width=294&height=300" alt="image"/>
									</div>
								<?php } ?>
								<div class="text-holder">
									<strong title="<?=$video['title']?>" class="ttl ttl_article_video"><?=character_limiter($video['title'],35);?></strong>
									<!--<a href="#">click here</a>-->
									<em class="author">Added: <?=$video['date'];?></em>
								</div>
							</div><!-- /img-holder end -->
							<div class="post-c">
								<p><?=$video['summary'];?></p>
							</div><!-- /post-c end -->
						</li>
						<?php endforeach; ?>
					</ul>
					<?php }else{ ?>
						<div class='no_results' style="width: 680px;" >No Available Videos</div>
					<?php } ?>
				</div><!-- /post-list end -->
				<?php if($num_pge>1): ?>
				<div class="pages">
					<div>
						<ul>
							<?php for($x=1; $x<=$num_pge; $x++): ?>
							<li <?php if($x==$p) echo "class='active'"; ?>><a href="<?=base_url();?>video/p/<?=$cat;?>/<?=$x;?>"><?=$x;?></a></li>
							<?php endfor; ?>
						</ul>
					</div>
				</div><!-- /pages end -->
				<?php endif; ?>
			</div><!-- /content end -->
		</div><!-- /main end -->