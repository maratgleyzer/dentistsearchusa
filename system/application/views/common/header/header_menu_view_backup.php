			<div class="top-section">
				<?php if(!isset($home_page)){ ?>
					<h1 class="logo">
						<a href="<?=base_url()?>home/">Dentist Search U.S.A.</a>
						<span class="slogan">Find the best dentists in your area.</span>
					</h1><!-- /logo end -->
				<?php } ?>
				<!--
				<div class="phone">
					<span>OPEN 24 HOURS A DAY</span>
					<strong>1-888-494-1346</strong>
				</div><!-- /phone end
				-->
				<ul id="nav">
					<?php if(!$logged_in){ ?>
							<li class="sep"><a class="open-popup" href="#lbox02">dentist login</a></li>
							<li class="sep"><a class="open-popup" href="#lbox03">register</a></li>
					<?php }else{ ?>
							<li class="sep"><a href="<?=base_url()?>dentist/logout">logout</a></li>
							<li class="sep"><a href="<?=base_url()?>dashboard/">my account</a></li>
					<?php } ?>
					<li class="sep"><a class="open-popup" href="#lbox04">contact</a></li>
					<li class="sep"><a href="<?=base_url()?>about_us/">about us</a></li>
					<li class="sep"><a href="<?=base_url()?>dental-videos/">videos</a></li>
					<!-- class="active" --><li class="sep">  <a href="<?=base_url()?>dental-articles/">articles</a></li>
					<li ><a href="<?=base_url()?>home/">dentist search U.S.A.</a></li>
				</ul><!-- /nav end -->
			</div><!-- /top-section end -->
			
			<div style="display:none; position: absolute; top: -5000px;">
				<img src="<?=base_url()?>assets/themes/default/images/ajax-loader.gif"/>
				<img src="<?=base_url()?>assets/themes/default/images/bg-light-box-b.png"/>
				<img src="<?=base_url()?>assets/themes/default/images/bg-light-box-t.png"/>
			</div><!-- preload popup bg -->