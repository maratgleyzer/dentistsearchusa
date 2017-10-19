		<?=@$map['js']?>
		<script type="text/javascript">
			request = null;
			the_sort = 'the_distance';
			total_rows = <?=$total_rows?>;
			limit_per_page = <?=$limit_per_page?>;
			pagination_request = null;
			post_search = <?=$post_search?>;
			the_current_page = <?=$current_page?>
			
			function search_option(el,val){
				if(typeof el != 'undefined'){
					parent.location.hash = 'hello';
				}
				$('#search_field').val(val);
				change_results(5);
				$("#search_bar_miles").val(5);
				$("#slider-range-min").slider('value',5);
				$('html,body').animate({ scrollTop: $('#search_bar_miles').position().top },500);
			}
			function change_zoom_level(dist){
				switch(true){
					case (dist <= 5):
						zoom_level = 12;
					break;
					case (dist <= 10):
						zoom_level = 11;
					break;
					case (dist <= 30):
						zoom_level = 10;
					break;
					case (dist <= 50):
						zoom_level = 9;
					break;
					case (dist <= 100):
						zoom_level = 8;
					break;
					case (dist <= 150):
						zoom_level = 7;
					break;
					default:
						zoom_level = 12;
					break;
				}
				map.setZoom(zoom_level);
			}
			function change_radius(dist){
				the_radius = (dist * 1.609344) * 1000;
				googlemap_circle.set('radius', the_radius);
			}
			function change_markers(i,marker){
				inc = i+1;
				var markerLatlng = new google.maps.LatLng(marker.position[0],marker.position[1]);		
				var the_marker = new google.maps.Marker({
					position: markerLatlng,
					icon: marker.icon,
				});
				the_marker.set("content", marker.details);
				the_marker.setMap(map);  
				google.maps.event.addListener(the_marker, "click", function() {
					iw.setContent(this.get("content"));
					iw.open(map, this);
				});
				markers.push(the_marker);
				lat_longs.push(the_marker.getPosition());
			}
			function sort_results(el,sort){
				var dist = $("#search_bar_miles").val();
				change_results(dist,sort,0,limit_per_page);
				$('a.sort_heading,a.sort_heading_current').css({'color':'#ffffff'});
				$(el).css({'color':'#bc0303'});
				the_sort = sort;
			}
			function change_page_limit(el,val){
				var dist = $("#search_bar_miles").val();
				change_results(dist,the_sort,0,val);
				limit_per_page = val;
				
				selected_class = $(el).attr('class');
				$('.select_limit').removeClass('selected');
				$('.limit_'+val).addClass('selected');
				
				return false;
			}
			function manual_miles(el){
				var dist = $(el).val();
				if(dist > 150){
					$(el).val(150);
					dist = 150;
				}
				$("#slider-range-min").slider('value',dist);
				change_zoom_level(dist);
				change_radius(dist);
				change_results();
			}
			function change_results(dist,sort,page_start,page_limit){
				if(!dist){
					var dist = $("#search_bar_miles").val();
				}
				if(!sort){
					var sort = the_sort;
				}
				if(!page_start){
					page_start = 0;
				}
				if(!page_limit){
					page_limit = limit_per_page;
				}
				search = $('#search_field').val();
				$('.dentist_pagination').css('display','none');
				$('.distance').css('background','url('+base_url+'assets/images/ajax-loader-min.gif) no-repeat scroll 0 6px transparent');
				$('.offices-list-wrapp').empty();
				$('.offices-list-wrapp').css('min-height',$('#map_fixed_container').outerHeight());
				$('.offices-list-wrapp').append('<img id="search_preloader" src="'+base_url+'assets/images/ajax-loader.gif"/>');
				$('.preloader').show();
				if(request){ //kills previous ajax query
					request.abort();
				}
				request = $.ajax({
					url: base_url+'dentist/ajax_search',
					dataType: 'json',
					type: 'POST',
					data: {'search':search,'distance':dist,'sort':sort,'page_start':page_start,'page_limit':page_limit},
					timeout: 60000,
					success: function(data){
						if(data){	
							$('.offices-list-wrapp').empty();
							$('.distance').css('background','url('+base_url+'assets/themes/default/images/ico-auto.gif) no-repeat scroll 0 6px transparent');
							var radiusLatLng = new google.maps.LatLng(data.lat,data.long);
							
							if(data.success){
								$('.offices-list-wrapp').append(data.content);
								Shadowbox.setup("a.flv_player"); 
								clearBoxes();
								$('#search_option_container').empty();
								
								if(data.markers){
									$.each(data.markers, function(i,val){
										change_markers(i,val);
									});
									var centerLatlng = new google.maps.LatLng(data.markers[data.total_featured].position[0],data.markers[data.total_featured].position[1]);
								}else{
									var centerLatlng = radiusLatLng;
								}
								if(data.type == 'invalid' || data.type == 'state'){
									$("#search_bar_miles").attr('disabled', 'disabled');
									$("#slider-range-min").slider('disable');
								}else{
									$("#search_bar_miles").attr('disabled', '');
									$("#slider-range-min").slider('enable');
								}
								if(data.type != 'invalid'){
									$('#search_option_container').append(data.search_option);
								}
								change_radius(data.distance);
								map.setZoom(data.zoom);
								map.setCenter(centerLatlng);
								googlemap_circle.set('center', radiusLatLng);
								$('#search_h2_label').text(data.h2_label);
								$('#h3_search_result_text').text(data.search_result_text);
								$('#other_city_container').empty();
								$('#other_city_container').html(data.other_cities);
								$('#more_footer_cities').empty();
								$("#more_footer_cities").css('height', '1px');
								$('#more_footer_cities').empty();
								$('#more_link_area').hide();
								$('.preloader').hide();

								if (data.has_cities == true) {
									$('#more_link_area').show();
									$('#more_city_state_abbr').val(data.active_state);
								}

								if(data.total_rows_count > 10){
									if(page_start == 0){
										pagination_request = null;
										create_pagination(data.total_rows_count,page_limit);
										the_current_page = 0;
									}
									$('.dentist_pagination').css('display','block');
								}else{
									$('.dentist_pagination').css('display','none');
								}
							}
						}
					},
					error: function(){
						$('.offices-list-wrapp').empty();
						$('.distance').css('background','url('+base_url+'assets/themes/default/images/ico-auto.gif) no-repeat scroll 0 6px transparent');
						$('.offices-list-wrapp').append('<div id="error_results">We\'re sorry, but there appears to be a problem processing your request. Please try again.</div>');
					}
				});
			}
			function pagination_click(page){
				var page_start = page * limit_per_page; 
				var dist = $("#search_bar_miles").val();
				if(pagination_request == null && page == the_current_page){
					return false; //skip first load
				}else{
					change_results(dist,the_sort,page_start,limit_per_page);
					pagination_request = true;
				}
				return false;
			}
			function scroll_map(){
			//	$('#map_fixed_container').css('top', $(this).scrollTop() + "px");
			//	centerHeight  = ($(document).scrollTop() + ($(window).height() - $('#map_fixed_container').outerHeight()) / 2);
				scroll_height  = $(document).scrollTop() + 43;
				content_height = $('#content').outerHeight();
				map_cont_height = $('#map_fixed_container').outerHeight();
				limit_height = content_height - map_cont_height;
				if(scroll_height < 300){
					scroll_height = 43;
				}else if(scroll_height > limit_height){
					scroll_height = limit_height + 30;
				}else{
					scroll_height = scroll_height - 200;
				}
				$('#map_fixed_container').animate({top: (scroll_height)},{
					duration  : 420
				});
			}
			function create_pagination(rows,limit){
				var dist = $("#search_bar_miles").val();
				if(!post_search){
					pagination_link = base_url+'<?=$seo_search_key?>/'+dist+'-miles/index-__id__-limit-'+limit;
				}else{
					pagination_link = '';
				}
				$(".dentist_pagination_cont").pagination(rows,{
					items_per_page: limit,
					callback: pagination_click,
					num_edge_entries: 2,
					num_display_entries: 5,
					next_text: '>>',
					prev_text: '<<',
					prev_show_always: false,
					next_show_always: false,
					link_to: pagination_link,
					current_page: the_current_page
				});	
			}
			$(document).ready(function(){
				if(total_rows > 10){
					create_pagination(total_rows,limit_per_page);
					$('.dentist_pagination').css('display','block');
				}else{
					$('.dentist_pagination').css('display','none');
				}
				$('.limit_'+limit_per_page).addClass('selected');
				$('.offices-list-wrapp').css('min-height',$('#map_fixed_container').outerHeight());
				
			});
			$(window).scroll($.throttle(1000,scroll_map));
		</script>
		<div id="main">
			<div class="two-columns">
				<div class="google-map">
					<div class="heading">
						<div class="sort">
							<form action="#">
								<fieldset id="search_option_container">
									<?php if($search_type == 'zip'){ ?>
										<label ><a style="cursor:pointer;" onclick="search_option('<?=cap_first_letter($search_option['city_name']).', '.$search_option['state_abbr']?>')">Show all dentists in <?=cap_first_letter($search_option['city_name']).', '.$search_option['state_long']?></a></label>
									<?php }else{ ?>
										<label for="lb10">by zip code:</label>
										<select onchange="search_option(this.value)" id="lb10" class="sel">
											<option>- - Select - -</option>
											<?php foreach($search_option AS $zip): ?>
												<option><?=$zip['zip_code']?></option>
											<?php endforeach; ?>
										</select>
									<?php } ?>
								</fieldset>
							</form>
						</div><!-- /sort end -->
						<h2>GOOGLE MAP</h2>
					</div><!-- /heading end -->
					<div id="map_fixed_container">
						<div class="map-holder">
							<div id="map_container"></div>
						</div><!-- /map-holder end -->
						<h3 id="h3_search_result_text" ><?=$search_result_text?></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.</p>
					</div>
				</div><!-- /google-map end -->
				<div id="content">
					<div class="heading">
						<div class="sort-by">
							<strong>sort by:</strong>
							<ul>
								<li><a onclick="sort_results(this,'the_rating')" class="sort_heading">rating</a></li>
								<li><a onclick="sort_results(this, 'city_name')" class="sort_heading">city</a></li>
								<li><a onclick="sort_results(this, 'the_distance')" class="sort_heading" style="color:#bc0303;">distance</a></li>
							</ul>
						</div><!-- /sort-by end -->
						<h2 id="search_h2_label"><?php if($search_type == 'state'){ echo strtoupper($search_option[0]['state_long']); }else if($search_type == 'zip'){ echo $search_option['city_name'];}else if($search_type == 'city'){ echo $search_option[0]['city_name']; }?> DENTISTS</h2>
					</div><!-- /heading end -->
					<div class="dentist_pagination">
						<div class="dentist_pagination_cont"></div>
						<div class="page_limit">
							<strong>show: </strong>
							<a href="<?=base_url().$seo_search_key?>/<?php if($distance > 150){ echo 150; }else{ echo $distance; } ?>-miles/index-0-limit-10" onclick="return change_page_limit(this,10);" class="select_limit limit_10">10</a>
							<a href="<?=base_url().$seo_search_key?>/<?php if($distance > 150){ echo 150; }else{ echo $distance; } ?>-miles/index-0-limit-20" onclick="return change_page_limit(this,20);" class="select_limit limit_20">20</a>
							<a href="<?=base_url().$seo_search_key?>/<?php if($distance > 150){ echo 150; }else{ echo $distance; } ?>-miles/index-0-limit-50" onclick="return change_page_limit(this,50);" class="select_limit limit_50">50</a>
							<a href="<?=base_url().$seo_search_key?>/<?php if($distance > 150){ echo 150; }else{ echo $distance; } ?>-miles/index-0-limit-100" onclick="return change_page_limit(this,100);" class="select_limit limit_100">100</a>
						</div><!-- /sort-by end -->
					</div>
					<div class="offices-list-wrapp">
						<?php if($dentists_featured > 0){ ?>
							<?php if($featured){ ?>
							<div id="featured_dentists_header">FEATURED DENTISTS</div>
							<ul class="offices-list" style="min-height:20px;">
								<?php 
									$i=1;
									foreach($featured AS $dentist): 
								?>
									<li>
										<div class="photo">
										<div class="featured_flag">&nbsp;</div>
											<?php
												$prof_pic = $dentist['prof_pic'];
												if($prof_pic){
													$picvid = explode(".",$prof_pic);
													if($picvid[1]=="flv"){
											?>
													<a href="<?=base_url()?>user_assets/prof_images/<?=$prof_pic?>" rel="shadowbox;width=600;height=450">
														<img src="<?=base_url()?>user_assets/prof_images/playvid_small.gif" alt="image" width="85" height="85" />
													</a>
											<?php	}else{ ?>
												<img src="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/prof_images/<?=$prof_pic?>&width=85&height=85" alt="image" />
											<?php 
													} 
												}else{
											?>
												<img src="<?=base_url()?>assets/themes/default/images/no_photo_small.png" alt="image" width="85" height="85" />
											<?php } ?>
										</div><!-- /photo end -->
										<div class="info-holder">
											<div class="text-hold">
												<span class="number"><img alt="<?=$i?>" src="<?=base_url()?>dentist/featured_marker_label/<?=$i?>" /></span>
												<div class="text">
													<h3 class="ttl"><a href="/<?=prep_seo_url($dentist['city'])?>-<?=prep_seo_url($dentist['state'])?>-dentists/<?=prep_seo_url($dentist['first_name'])?>-<?=prep_seo_url($dentist['last_name'])?>-<?=$dentist['id']?>"><?=alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :')?><?="{$dentist['first_name']} {$dentist['last_name']} {$dentist['post_nominal']}"?></a></h3>
													<address>
														<span><?="{$dentist['address']}"?></span>
														<span><?="{$dentist['city']}, {$dentist['state']} {$dentist['zip']}"?></span>
													</address>
													<div class="rate"><span class="stars"><?=get_star_rating($dentist['the_rating'],true)?></span></div>
												</div>
											</div><!-- /text-hold end -->
											<div class="info-b">
												<ul class="menu">
													<li><a onclick="center_location('<?="{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}"?>')" style="cursor:pointer;">view on map</a></li>
													<li><a href="/<?=prep_seo_url($dentist['city'])?>-<?=prep_seo_url($dentist['state'])?>-dentists/<?=prep_seo_url($dentist['first_name'])?>-<?=prep_seo_url($dentist['last_name'])?>-<?=$dentist['id']?>">view profile</a></li>
												</ul><!-- /menu end -->
												<dl>
													<dt>Tel:</dt>
													<dd><?=alt_echo($dentist['dsusa_telephone'],$dentist['telephone'])?></dd>
												</dl>
											</div><!-- /info-b end -->
										</div><!-- /info-holder end -->
									</li>
								<?php 
									$i++;
									endforeach;
								?>
							</ul><!-- /offices-list end -->
							<div id="other_dentists_header">OTHER DENTISTS</div>
						<?php }else{ ?>
								<div id="featured_dentists_header">FEATURED DENTISTS</div><div id='no_results'>No Results Found for <label><?=$search?></label></div><div id="other_dentists_header">OTHER DENTISTS</div>
						<?php }} ?>
						<?php if($dentists){ ?>
							<ul class="offices-list">
								<?php 
									$i=1; 
									foreach($dentists AS $dentist): 
								?>
									<li>
										<div class="photo">
											<?php
												$prof_pic = $dentist['prof_pic'];
												if($prof_pic){
													$picvid = explode(".",$prof_pic);
													if($picvid[1]=="flv"){
											?>
													<a href="<?=base_url()?>user_assets/prof_images/<?=$prof_pic?>" rel="shadowbox;width=600;height=450">
														<img src="<?=base_url()?>user_assets/prof_images/playvid_small.gif" alt="image" width="85" height="85" />
													</a>
											<?php	}else{ ?>
												<img src="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/prof_images/<?=$prof_pic?>&width=85&height=85" alt="image" />
											<?php 
													} 
												}else{
											?>
												<img src="<?=base_url()?>assets/themes/default/images/no_photo_small.png" alt="image" width="85" height="85" />
											<?php } ?>
										</div><!-- /photo end -->
										<div class="info-holder">
											<div class="text-hold">
												<span class="number"><img alt="<?=$i?>" src="<?=base_url()?>dentist/marker_label/<?=$i?>" /></span>
												<div class="text">
													<h3 class="ttl"><a href="/<?=prep_seo_url($dentist['city'])?>-<?=prep_seo_url($dentist['state'])?>-dentists/<?=prep_seo_url($dentist['first_name'])?>-<?=prep_seo_url($dentist['last_name'])?>-<?=$dentist['id']?>"><?=alt_echo(company_output($dentist['first_name'],$dentist['last_name'],$dentist['company_name']),'','',' :')?><?="{$dentist['first_name']} {$dentist['last_name']} {$dentist['post_nominal']}"?></a></h3>
													<address>
														<span><?="{$dentist['address']}"?></span>
														<span><?="{$dentist['city']}, {$dentist['state']} {$dentist['zip']}"?></span>
													</address>
													<div class="rate"><span class="stars"><?=get_star_rating($dentist['the_rating'],true)?></span></div>
												</div>
											</div><!-- /text-hold end -->
											<div class="info-b">
												<ul class="menu">
													<li><a onclick="center_location('<?="{$dentist['address']}, {$dentist['city']}, {$dentist['state']} {$dentist['zip']}"?>')" style="cursor:pointer;">view on map</a></li>
													<li><a href="/<?=prep_seo_url($dentist['city'])?>-<?=prep_seo_url($dentist['state'])?>-dentists/<?=prep_seo_url($dentist['first_name'])?>-<?=prep_seo_url($dentist['last_name'])?>-<?=$dentist['id']?>">view profile</a></li>
												</ul><!-- /menu end -->
												<dl>
													<dt>Tel:</dt>
													<dd><?=alt_echo($dentist['dsusa_telephone'],$dentist['telephone'])?></dd>
												</dl>
											</div><!-- /info-b end -->
										</div><!-- /info-holder end -->
									</li>
								<?php 
									$i++;
									endforeach;
								?>
							</ul><!-- /offices-list end -->
						<?php }else{ ?>
								<div id="other_dentists_header">OTHER DENTISTS</div><div id='no_results'>No Results Found for <label><?=$search?></label></div>
						<?php } ?>
					</div><!-- /offices-list-wrapp end -->
					<div class="dentist_pagination">
						<div class="dentist_pagination_cont"></div>
						<div class="page_limit">
							<strong>show: </strong>
							<a href="<?=base_url().$seo_search_key?>/<?php if($distance > 150){ echo 150; }else{ echo $distance; } ?>-miles/index-0-limit-10" onclick="return change_page_limit(this,10);" class="select_limit limit_10">10</a>
							<a href="<?=base_url().$seo_search_key?>/<?php if($distance > 150){ echo 150; }else{ echo $distance; } ?>-miles/index-0-limit-20" onclick="return change_page_limit(this,20);" class="select_limit limit_20">20</a>
							<a href="<?=base_url().$seo_search_key?>/<?php if($distance > 150){ echo 150; }else{ echo $distance; } ?>-miles/index-0-limit-50" onclick="return change_page_limit(this,50);" class="select_limit limit_50">50</a>
							<a href="<?=base_url().$seo_search_key?>/<?php if($distance > 150){ echo 150; }else{ echo $distance; } ?>-miles/index-0-limit-100" onclick="return change_page_limit(this,100);" class="select_limit limit_100">100</a>
						</div><!-- /sort-by end -->
					</div>
				</div><!-- /content end -->
			</div><!-- /two-columns end -->
		</div><!-- /main end -->