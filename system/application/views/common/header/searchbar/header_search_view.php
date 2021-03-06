			<script type="text/javascript">
				function search_value(data){
					search_distance = $("#search_bar_miles").val();
					search = $('#search_field').val();
					if(search == 'CITY NAME or ZIP CODE'){
						return false;
					}
					if(isNaN(search)){
						search = search.split(', ');
						window.location.replace(base_url+search[0].toLowerCase().replace(' ','-')+'-'+search[1].toLowerCase()+'-dentists/'+search_distance+'-miles');
					}else{
						label = data.label;
						start_sub = label.search('match_label');
						start_sub = start_sub + 13;
						city_label = label.substr(start_sub);
						city_label = city_label.replace('</label>','');
						city_label = city_label.split(', ');
						window.location.replace(base_url+city_label[0].toLowerCase().replace(' ','-')+'-'+city_label[1].toLowerCase()+'-'+search+'-dentists/'+search_distance+'-miles');
					}
				}
				$(function(){
					$("#slider-range-min").slider({
						range: "min",
						value: <?php if(isset($distance)){ echo $distance; }else{ echo 5; }?>,
						min: 1,
						max: 150,
						slide: function(event, ui){
							var miles = ui.value;
							$("#search_bar_miles").val(miles);
							<?php if(isset($search_page)){ ?>
								change_zoom_level(miles);
								change_radius(miles);
							<?php } ?>
						},
						change: function(event, ui){
							<?php if(isset($search_page)){ ?>
								var miles = ui.value;
								change_results(miles);
							<?php } ?>
						}
					});
					$("#slider-range-min").css('width', '163px');
					$("#search_bar_miles").val($("#slider-range-min").slider("value"));
					
					<?php 
						if(isset($search_page)){ 
							if($search_type == 'state' || $search_type == 'invalid'){
					?>
								$("#search_bar_miles").attr('disabled', 'disabled');
								$("#slider-range-min").slider('disable');
					<?php 	
							}
						}
					?>
				});
				

			</script>
			<div class="search-section">
				<div class="blog-search-city">
					<form action="<?=base_url()?>dentist-search" method="post">
						<fieldset style="width: 940px; float:left; margin-right:8px;">
							<label >Search City or ZIP:</label>
							<div class="text04">
								<input class="city_zip_autocomplete hide-text-inputs {autoc_width:356,autoc_top:161}" name="search_value" id="search_field" type="text" value="<?php if(isset($search))echo $search;?>" />
							</div><!-- /text04 end -->
							<div id="distance_search" class="distance">
								<div class="hold">
									<strong>DISTANCE YOU ARE WILLING TO DRIVE</strong>
									<div id="slider-range-min"></div>
								</div>
								<strong class="miles"><input <?php if(isset($search_page)){ ?> onchange="manual_miles(this)" <?php } ?> type="text" name="search_distance" id="search_bar_miles" /> miles</strong>
							</div><!-- /distance end -->
	
							<input id="search_bar_btn" class="btn-search" <?php if(isset($search_page)){ ?> onclick="change_results();return false;" <?php } ?> type="submit" value="SEARCH" /><!-- /btn-search end -->
						</fieldset>
					</form>
				</div><!-- /blog-search-city end -->
			</div><!-- /search-section end -->