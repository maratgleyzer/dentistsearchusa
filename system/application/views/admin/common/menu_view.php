			<div id="main_menu">
				<div id="homelink">
					<a href="<?=base_url()?>_admin_console" title="back to _admin home">
						<img id="home" src="<?=base_url()?>assets/images/admin/home.png"/>
					</a>
				</div>
				<ul id="jsddm">
					<li>
						<a href="<?=base_url()?>_admin_console/home/admin_account">
							Admin
						</a>						
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/home/admin_account">
									Admin Account
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/add_sub_admin_console">
									Add Sub-Admin
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/manage_sub_admin_console">
									Sub-Admin Management
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/add_cms_user">
									Add CMS User
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/manage_cms_user">
									CMS User Management
								</a>	
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
					<li>
						<a href="<?=base_url()?>_admin_console/home/admin_account">
							Payment Plans
						</a>						
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/payment/add_payment_plan">
									Add Payment Plan
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/payment/manage_payment_plan">
									Payment Plan Management
								</a>	
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
					<li>
						<a href="#">
							Site
						</a>						
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/home/purge_php_cache">
									Purge PHP Cache (<?php echo count(scandir('/home/dentists/php_cache')); ?>)
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/purge_mysql_cache">
									Purge MySQL Cache (<?php echo count(scandir('/home/dentists/mysql_cache')); ?>)
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/add_social_media_icon">
									Add Social Media Icon
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/manage_social_media_icons">
									Manage Social Media Icons
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/contact_us_messages">
									Contact Us Messages
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/page_management">
									Page Management
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/search_result_text">
									Search Result Text
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/analytics">
									Analytics Code ID
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/dentists_featured">
									Dentists Featured
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/footer_tags">
									Footer Tags
								</a>	
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
					<li>
						<a href="#">
							Registration
						</a>	
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/home/edit_tags/10" >
									Sign-up Form Text
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/edit_tags/8" >
									Registration Details Page
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/emails/edit_email_template" >
									Registration Email Template
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/add_dropdown_choice" >
									Add Dropdown Choice
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/dropdown_choices_management" >
									Dropdown Choices
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/home/edit_tags/9" >
									Affiliate Page
								</a>	
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
					<li>
						<a href="<?=base_url()?>_admin_console/dentists/manage_dentists">
							Dentist
						</a>	
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/add_dentist" >
									Add Dentist
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/manage_pre_registered" >
									Pre-Registered Dentists
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/manage_dentists">
									Manage Dentists
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/add_specialty" >
									Add Dentist Specialty
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/manage_specialties" >
									Manage Dentist Specialties
								</a>	
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
					<li>
						<a href="#">
							Dentist Assets
						</a>	
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/manage_reviews/date" >
									Manage Dentist Reviews
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/manage_files" >
									Manage Dentist Documents
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/manage_certificates" >
									Manage Dentist Certificates
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/manage_images" >
									Manage Dentist Images
								</a>	
							</li>
							<li>
								<a href="<?=base_url()?>_admin_console/dentists/manage_promotionals" >
									Manage Dentist Promotionals
								</a>	
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
					<li>
						<a href="<?=base_url()?>_admin_console/articles/manage_articles/date">
							Articles
						</a>	
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/articles/add_article">
									Add Article
								</a>
								<a href="<?=base_url()?>_admin_console/articles/manage_articles/date">
									Manage Articles
								</a>
								<a href="<?=base_url()?>_admin_console/articles/add_category">
									Add Article Category
								</a>
								<a href="<?=base_url()?>_admin_console/articles/manage_categories">
									Manage Article Categories
								</a>
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
					<li>
						<a href="<?=base_url()?>_admin_console/videos/manage_videos/date">
							Videos
						</a>	
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/videos/add_video">
									Add Video
								</a>
								<a href="<?=base_url()?>_admin_console/videos/manage_videos/date">
									Manage Videos
								</a>
								<a href="<?=base_url()?>_admin_console/videos/add_category">
									Add Video Category
								</a>
								<a href="<?=base_url()?>_admin_console/videos/manage_categories">
									Manage Video Categories
								</a>								
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
					<li>
						<a href="#">
							Ads
						</a>	
						<ul>
							<li>
								<a href="<?=base_url()?>_admin_console/advertisements/manage_footer_ads">
									Manage Footer Ads
								</a>
								<a href="<?=base_url()?>_admin_console/advertisements/manage_sidebar_ads">
									Manage Sidebar Ads
								</a>								
							</li>
							<img src="<?=base_url()?>assets/images/admin/dropdownbg_bottom.png" class="dropdownbg_bottom">
						</ul>
					</li>
				</ul>
			</div>
			<div id="admin_content">