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
						value: 5,
						min: 0,
						max: 150,
						slide: function(event, ui){
							$("#search_bar_miles").val(ui.value);
						}
					});
					$("#slider-range-min").css('width', '163px');
					$("#search_bar_miles").val($("#slider-range-min").slider("value"));
				});

			</script>
			<div class="search-section">
				<div class="blog-search-city">
					<form action="<?=base_url()?>dentist-search" method="post">
						<fieldset style="width:700px;">
							<label for="lb02">Search City or ZIP:</label>
							<div class="text03">
								<input class="city_zip_autocomplete hide-text-inputs {autoc_width:240,autoc_top:161}" name="search_value" id="search_field" />
							</div><!-- /text03 end -->
							<div id="distance_blog" class="distance">
								<div class="hold">
									<strong>DISTANCE YOU ARE WILLING TO DRIVE</strong>
									<div id="slider-range-min"></div>
								</div>
								<strong class="miles"><input type="text" name="search_distance" id="search_bar_miles" /> miles</strong>
							</div><!-- /distance end -->
							<input id="search_bar_btn" class="btn-search" type="submit" value="SEARCH" /><!-- /btn-search end -->
						</fieldset>
					</form>
				</div><!-- /blog-search-city end -->
				<div class="blog-search">
					<form action="<?=base_url()?>article-video-search" method="post">
						<fieldset style="width: 248px;">
							<div class="text02">
								<input id="lb01" name="keyword" class="hide-text-inputs" type="text" value="Article and video search..." />
							</div>
							<input class="btn-search" type="submit" value="SEARCH" />
						</fieldset>
					</form>
				</div><!-- /blog-search end -->
			</div><!-- /search-section end -->