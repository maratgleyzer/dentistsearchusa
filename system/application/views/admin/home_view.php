				<label id="welcome">
					<br/><br/>Welcome Admin,<br/><br/>
				</label>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/group_key.png">
						<label>
							ADMIN MANAGEMENT
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/home/admin_account" >
							<img src="<?=base_url()?>assets/images/admin/user_red.png"> Admin Account
						</a>
						<a href="<?=base_url()?>_admin_console/home/add_sub__admin_console" >
							<img src="<?=base_url()?>assets/images/admin/user_orange_add.png"> Add Sub-Admin
						</a>
						<a href="<?=base_url()?>_admin_console/home/manage_sub__admin_console" >
							<img src="<?=base_url()?>assets/images/admin/user_orange.png"> Sub-Admin Management
						</a>
						<a href="<?=base_url()?>_admin_console/home/add_cms_user" >
							<img src="<?=base_url()?>assets/images/admin/user_green.png"> Add CMS User
						</a>
						<a href="<?=base_url()?>_admin_console/home/manage_cms_user" >
							<img src="<?=base_url()?>assets/images/admin/user_green_add.png"> CMS User Management
						</a>
					</div>
				</div>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/money.png">
						<label>
							PAYMENT PLAN MANAGEMENT
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/payment/add_payment_plan" >
							<img src="<?=base_url()?>assets/images/admin/money_add.png"> Add Payment Plan
						</a>
						<a href="<?=base_url()?>_admin_console/payment/manage_payment_plan" >
							<img src="<?=base_url()?>assets/images/admin/money.png"> Payment Plan Management
						</a>
					</div>
				</div>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/world.png">
						<label>
							SITE MANAGEMENT
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/home/add_social_media_icon" >
							<img src="<?=base_url()?>assets/images/admin/facebook_add.png"> Add Social Media Icon
						</a>
						<a href="<?=base_url()?>_admin_console/home/manage_social_media_icons" >
							<img src="<?=base_url()?>assets/images/admin/facebook.jpeg"> Manage Icons
						</a>
						<a href="<?=base_url()?>_admin_console/home/contact_us_messages" >
							<img src="<?=base_url()?>assets/images/admin/email_open.png"> Messages
						</a>
						<a href="<?=base_url()?>_admin_console/home/page_management" >
							<img src="<?=base_url()?>assets/images/admin/page.png"> Page Management
						</a>
						<a href="<?=base_url()?>_admin_console/home/search_result_text" >
							<img src="<?=base_url()?>assets/images/admin/map_magnify.png"> Search Result Text
						</a>
						<a href="<?=base_url()?>_admin_console/home/analytics" >
							<img src="<?=base_url()?>assets/images/admin/script_code_red.png"> Analytics Code ID
						</a><br /><br />
						<a href="<?=base_url()?>_admin_console/home/dentists_featured" >
							<img src="<?=base_url()?>assets/images/admin/group.png"> Dentists Featured
						</a>
						<a href="<?=base_url()?>_admin_console/home/footer_tags" >
							<img src="<?=base_url()?>assets/images/admin/page.png"> Footer Tags
						</a>
						<a href="<?=base_url()?>_admin_console/home/purge_php_cache" >
							<img src="<?=base_url()?>assets/images/admin/delete.png"> Purge PHP Cache (<?php echo count(scandir('/home/dentists/php_cache')); ?>)
						</a>
						<a href="<?=base_url()?>_admin_console/home/purge_mysql_cache" >
							<img src="<?=base_url()?>assets/images/admin/delete.png"> Purge MySQL Cache (<?php echo count(scandir('/home/dentists/mysql_cache')); ?>)
						</a>
					</div>
				</div>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/page_edit.png">
						<label>
							REGISTRATION MANAGEMENT
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/home/edit_tags/10" >
							<img src="<?=base_url()?>assets/images/admin/textfield.png"> Sign-up Form Text
						</a>
						<a href="<?=base_url()?>_admin_console/home/edit_tags/8" >
							<img src="<?=base_url()?>assets/images/admin/page.png"> Registration Page
						</a>
						<a href="<?=base_url()?>_admin_console/emails/edit_email_template">
							<img src="<?=base_url()?>assets/images/admin/email.png"> Registration Email
						</a>
						<a href="<?=base_url()?>_admin_console/home/add_dropdown_choice">
							<img src="<?=base_url()?>assets/images/admin/add_text_list_bullets.png"> Add Dropdown Choices
						</a>
						<a href="<?=base_url()?>_admin_console/home/dropdown_choices_management">
							<img src="<?=base_url()?>assets/images/admin/text_list_bullets.png"> Dropdown Choices
						</a>
						<a href="<?=base_url()?>_admin_console/home/edit_tags/9" >
							<img src="<?=base_url()?>assets/images/admin/page.png"> Affiliate Page
						</a>
					</div>
				</div>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/user.png">
						<label>
							DENTIST MANAGEMENT
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/dentists/add_dentist">
							<img src="<?=base_url()?>assets/images/admin/user_add.png"> Add Dentist
						</a>
						<a href="<?=base_url()?>_admin_console/dentists/manage_pre_registered">
							<img src="<?=base_url()?>assets/images/admin/page_edit.png"> Pre-Registered Dentists
						</a>
						<a href="<?=base_url()?>_admin_console/dentists/manage_dentists" >
							<img src="<?=base_url()?>assets/images/admin/group.png"> Manage Dentists
						</a>
						<a href="<?=base_url()?>_admin_console/dentists/add_specialty">
							<img src="<?=base_url()?>assets/images/admin/vcard_add.png"> Add Dentist Specialty
						</a>
						<a href="<?=base_url()?>_admin_console/dentists/manage_specialties">
							<img src="<?=base_url()?>assets/images/admin/vcard.png"> Manage Dentist Specialties
						</a>
					</div>
				</div>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/user_suit.png">
						<label>
							DENTIST ASSETS
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/dentists/manage_reviews/date">
							<img src="<?=base_url()?>assets/images/admin/star.png"> Manage Dentist Reviews
						</a>
						<a href="<?=base_url()?>_admin_console/dentists/manage_files">
							<img src="<?=base_url()?>assets/images/admin/page_white_word.png"> Manage Dentist Documents
						</a>
						<a href="<?=base_url()?>_admin_console/dentists/manage_certificates">
							<img src="<?=base_url()?>assets/images/admin/page_white_text.png"> Manage Dentist Certificates
						</a>
						<a href="<?=base_url()?>_admin_console/dentists/manage_images">
							<img src="<?=base_url()?>assets/images/admin/pictures.png"> Manage Dentist Images
						</a>
						<a href="<?=base_url()?>_admin_console/dentists/manage_promotionals">
							<img src="<?=base_url()?>assets/images/admin/bell.png"> Manage Dentist Promotionals
						</a>
					</div>
				</div>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/page_white.png">
						<label>
							ARTICLE MANAGEMENT
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/articles/add_article" >
							<img src="<?=base_url()?>assets/images/admin/page_white_add.png"> Add Article
						</a>
						<a href="<?=base_url()?>_admin_console/articles/manage_articles/date" >
							<img src="<?=base_url()?>assets/images/admin/page_white_copy.png"> Manage Articles
						</a>
						<a href="<?=base_url()?>_admin_console/articles/add_category" >
							<img src="<?=base_url()?>assets/images/admin/tag_blue_add.png"> Add Article Category
						</a>
						<a href="<?=base_url()?>_admin_console/articles/manage_categories" >
							<img src="<?=base_url()?>assets/images/admin/tag_blue.png"> Manage Article Categories
						</a>
					</div>
				</div>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/film.png">
						<label>
							VIDEO MANAGEMENT
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/videos/add_video" >
							<img src="<?=base_url()?>assets/images/admin/film_add.png"> Add Videos
						</a>
						<a href="<?=base_url()?>_admin_console/videos/manage_videos/date" >
							<img src="<?=base_url()?>assets/images/admin/film.png"> Manage Videos
						</a>
						<a href="<?=base_url()?>_admin_console/videos/add_category" >
							<img src="<?=base_url()?>assets/images/admin/tag_blue_add.png"> Add Video Category
						</a>
						<a href="<?=base_url()?>_admin_console/videos/manage_categories" >
							<img src="<?=base_url()?>assets/images/admin/tag_blue.png"> Manage Video Categories
						</a>
					</div>
				</div>
				<div class="home_menu_divs">
					<div class="home_menu_div_label">
						<img src="<?=base_url()?>assets/images/admin/layout_edit.png">
						<label>
							ADS MANAGEMENT
						</label>
					</div>
					<div class="links_container">
						<a href="<?=base_url()?>_admin_console/advertisements/manage_footer_ads" >
							<img src="<?=base_url()?>assets/images/admin/layout_content.png"> Manage Footer Ads
						</a>
						<a href="<?=base_url()?>_admin_console/advertisements/manage_sidebar_ads" >
							<img src="<?=base_url()?>assets/images/admin/layout_sidebar.png"> Manage Sidebar Ads
						</a>
					</div>
				</div>