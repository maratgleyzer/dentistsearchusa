		<div id="main">
			<div id="content">
				<div class="heading"><h2>ARTICLE RESULTS</h2></div><!-- /heading end -->
				<div class="post-list content_search_results">
					<ul>
						<?php if(!$contents): ?>
							<div class='no_results'>No articles found containing <label>"<?=$keyword?>"</label></div>
						<?php else: ?>
							<?php foreach($contents as $content): ?>
							<li>
								<div class="img-holder color01" style="width:321px;">
									<?php if($content['image']){ ?>
										<a href="<?=base_url();?>dental-articles/<?=prep_seo_url($content['title'])?>-<?=$content['id'];?>">
											<img src="<?=base_url();?>assets/phpthumb/resize.php?src=<?=base_url();?>content_assets/images/<?=$content['image'];?>&width=294&height=167" alt="image" width="294" height="167" />
										</a>
									<?php }else{ ?>
										<a href="<?=base_url();?>dental-articles/<?=prep_seo_url($content['title'])?>-<?=$content['id'];?>">
											<img src="<?=base_url();?>content_assets/images/no_image.jpg" alt="image" width="294" height="167" />
										</a>
									<?php } ?>
									<div class="text-holder">
										<a title="<?=$content['title']?>" href="<?=base_url();?>dental-articles/<?=prep_seo_url($content['title'])?>-<?=$content['id'];?>"><strong class="ttl ttl_article_video"><?=character_limiter($content['title'],35);?></strong></a>
										<!--<a href="#">click here</a>-->
										<em class="author"><?=$content['author'];?> - <?=$content['date'];?></em>
									</div>
								</div><!-- /img-holder end -->
								<div class="post-c">
									<p>
										<?=substr(strip_tags($content['content']),0,150);?>...
										<a href="<?=base_url();?>dental-articles/<?=prep_seo_url($content['title'])?>-<?=$content['id'];?>">read more>></a>
									</p>
									
								</div><!-- /post-c end -->
							</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div><!-- /post-list end -->
				<div class="heading"><h2>VIDEO RESULTS</h2></div><!-- /heading end -->
				<div class="post-list content_search_results">
					<ul>
						<?php if(!$videos): ?>
							<div class='no_results'>No videos found containing <label>"<?=$keyword?>"</label></div>
						<?php else: ?>
							<?php foreach($videos as $video): ?>
							<li>
								<div class="img-holder">
									<a href="<?=base_url();?>content_assets/videos/<?=$video['filename'];?>" rel="shadowbox;width=600;height=450">
										<img class="video_play_image" src="<?=base_url();?>assets/themes/default/images/video_play.png">
									</a>
									<img src="<?=base_url();?>content_assets/images/<?=$video['image'];?>" alt="image" width="294" height="167" />
									<div class="text-holder">
										<strong title="<?=$video['title']?>" class="ttl ttl_article_video"><?=character_limiter($video['title'],35);?></strong>
										<!--<a href="#">click here</a>-->
										<em class="author"><?=$video['date'];?></em>
									</div>
								</div><!-- /img-holder end -->
								<div class="post-c">
									<p><?=$video['summary'];?></p>
								</div><!-- /post-c end -->
							</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div><!-- /post-list end -->
			</div><!-- /content end -->
		</div><!-- /main end -->