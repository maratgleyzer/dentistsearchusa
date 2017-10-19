		<div id="main">
			<div id="content">
				<div class="heading"><h2>RECENT VIDEOS</h2></div><!-- /heading end -->
				<div class="post-list">
					<ul>
						<?php foreach($videos as $video): ?>
						<li>
							<div class="img-holder">
								<a href="<?=base_url();?>content_assets/videos/<?=$video['filename'];?>" rel="shadowbox;width=600;height=450;">
									<img class="video_play_image" src="<?=base_url();?>assets/themes/default/images/video_play.png">
								</a>
								<img src="<?=base_url();?>content_assets/images/<?=$video['image'];?>" alt="image" width="294" height="167" />
								<div class="text-holder">
									<strong class="ttl"><?=$video['title'];?></strong>
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
				</div><!-- /post-list end -->
				<?php if($num_pge>1): ?>
				<div class="pages">
					<div>
						<ul>
							<?php for($x=1; $x<=$num_pge; $x++): ?>
							<li <?php if($x==$p) echo "class='active'"; ?>><a href="<?=base_url();?>video/p/<?=$x;?>"><?=$x;?></a></li>
							<?php endfor; ?>
						</ul>
					</div>
				</div><!-- /pages end -->
				<?php endif; ?>
			</div><!-- /content end -->
		</div><!-- /main end -->