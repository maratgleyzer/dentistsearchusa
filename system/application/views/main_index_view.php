		<script type="text/javascript">
			function search_value(data){
				search = $('#search_field').val();
				if(search == 'CITY NAME or ZIP CODE'){
					return false;
				}
				if(isNaN(search)){
					search = search.split(', ');
					window.location.replace(base_url+search[0].toLowerCase().replace(' ','-')+'-'+search[1].toLowerCase()+'-dentists');
				}else{
					label = data.label;
					start_sub = label.search('match_label');
					start_sub = start_sub + 13;
					city_label = label.substr(start_sub);
					city_label = city_label.replace('</label>','');
					city_label = city_label.split(', ');
					window.location.replace(base_url+city_label[0].toLowerCase().replace(' ','-')+'-'+city_label[1].toLowerCase()+'-'+search+'-dentists');
				}
			}
		</script>
		<div id="main">
			<div class="logo-holder">
				<h1 class="logo">
					<a href="">Dentist Search U.S.A.</a>
					<span class="slogan">Find the best dentists in your area.</span>
				</h1><!-- /logo end -->
			</div><!-- /logo-holder end -->
			<div class="main-search">
				<form action="<?=base_url()?>dentist-search" method="post">
					<fieldset>
						<div class="text01"><input name="search_value" id="search_field" class="city_zip_autocomplete hide-text-inputs {autoc_width:291,autoc_top:290}" type="text" value="CITY NAME or ZIP CODE" /></div>
						<input class="btn-search01" type="submit" value="SEARCH FOR DENTIST" />
						<ul class="links">
							<!-- li><a href="#" class="open-popup" id="search_by_region_btn">Search By Region</a></li /-->
						</ul>
					</fieldset>
				</form>
			</div><!-- /main-search end -->
			<div id="search_by_region_id" class="regions">
<?php echo $city_list; ?>
			</div><!-- /regions end -->
		</div><!-- /main end -->