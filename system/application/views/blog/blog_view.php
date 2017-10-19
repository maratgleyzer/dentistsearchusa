		<div id="main">
			<div id="sidebar">
				<div class="heading"><h2>CATEGORIES</h2></div><!-- /heading end -->
				<ul class="side-list">
					<?php foreach($categories as $category): ?>
					<li><img src="<?=base_url();?>assets/themes/default/images/bullet_white.png"> <a href="<?=base_url();?>dental-articles/<?=prep_seo_url($category['category_title']);?>-category-<?=$category['id'];?>"><?=$category['category_title'];?></a></li>
					<?php endforeach; ?>
					
					
				</ul><!-- /side-list end -->
				<?php if(isset($recent_video['filename'])){ ?>
					<div class="heading">
						<a href="<?=base_url();?>video">videos</a>
						<h2>RECENT VIDEO</h2>
					</div><!-- /heading end -->
					<div class="video-holder">
						<a class="flv_player" href="<?=base_url();?>content_assets/videos/<?=$recent_video['filename'];?>" rel="shadowbox;width=600;height=450">
							<img src="<?=base_url();?>assets/phpthumb/resize.php?src=<?=base_url();?>content_assets/images/<?=$recent_video['image'];?>&width=259&height=164" alt="image" />
						</a>
					</div><!-- /video-holder end -->
				<?php } ?>
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
				<div class="heading"><h2>DENTAL ARTICLES</h2></div><!-- /heading end -->
				<div class="post-list">
					<?php if($contents){ ?>
						<ul>
							<?php foreach($contents as $content): ?>
							<li>
								<div class="img-holder color01">
									<?php if($content['image']){ ?>
										<a href="<?=base_url();?>dental-articles/<?=prep_seo_url($content['title'])?>-<?=$content['id'];?>">
											<img src="<?=base_url();?>assets/phpthumb/resize.php?src=<?=base_url();?>content_assets/images/<?=$content['image'];?>&width=320&height=167" alt="image" width="320" height="167" />
										</a>
									<?php }else{ ?>
										<a href="<?=base_url();?>dental-articles/<?=prep_seo_url($content['title'])?>-<?=$content['id'];?>">
											<img src="<?=base_url();?>content_assets/images/no_image.jpg" alt="image" width="320" height="167" />
										</a>
									<?php } ?>
									<div class="text-holder">
										<a title="<?=$content['title']?>" href="<?=base_url();?>dental-articles/<?=prep_seo_url($content['title'])?>-<?=$content['id'];?>"><strong class="ttl ttl_article_video"><?=character_limiter($content['title'],35);?></strong></a>
										<!--<a href="#">click here</a>-->
										<em class="author">by: <?=$content['author'];?> - <?=$content['date'];?></em>
									</div>
								</div><!-- /img-holder end -->
								<div class="post-c">
									<p><?=substr(strip_tags($content['summary']),0,150);?>... <a href="<?=base_url();?>dental-articles/<?=prep_seo_url($content['title'])?>-<?=$content['id'];?>">read more>></a></p>
								</div><!-- /post-c end -->
							</li>
							<?php endforeach; ?>
					
						</ul>
					<?php }else{ ?>
						<div class='no_results' style="width: 680px;" >No Available Articles</div>
					<?php } ?>
				</div><!-- /post-list end -->
				<?php if($num_pge>1): ?>
				<div class="pages">
					<div>
						<ul>
							<?php for($x=1; $x<=$num_pge; $x++): ?>
							<li <?php if($x==$p) echo "class='active'"; ?>><a href="<?=base_url();?>article/p/<?=$cat;?>/<?=$x;?>"><?=$x;?></a></li>
							<?php endfor; ?>
						</ul>
					</div>
				</div><!-- /pages end -->
				<?php endif; ?>
			</div><!-- /content end -->
		</div><!-- /main end -->