<script type="text/javascript">

$(document).ready(function() {

	var inbox_msgs = <?=$total_apps?>;
	var unread_app = <?=$unread_app?>;
	var unread_testi = <?=$unread_testi?>;
	
	$(".viewGuidelines,.viewTesti").fancybox({
		'titleShow'     : false,
		'transitionIn' : 'elastic',
		'transitionOut' : 'elastic'
	});
	$('.viewTesti').click(function(){
		var i_id = $(this).attr("id");
		var this_class = $('#inbox_row_testi_'+i_id).attr("class");
		$.ajax({
			type: "POST",
			url: base_url+'dashboard/is_read_testi/'+i_id,
			cache: false,
			success : function(html){
				if(this_class=="inbox_unread"){
					var inboxmsgs = inbox_msgs - 1;
					inbox_msgs = inboxmsgs;
					if(inbox_msgs>0){
						$('.notification_label').text(inbox_msgs);
					}else{
						$('.notifications').css('display','none');
					}
					$('#inbox_row_testi_'+i_id).removeClass();
					
					unread_testi = unread_testi -1;
					if(unread_testi>0){
						$('#testimonials_count').text(unread_testi);
					}else{
						$('#testimonials_count').css('display','none');
					}
				}
			}
		});
		return false;
	});
	$('.viewGuidelines').click(function(){
		var i_id = $(this).attr("id");
		var this_class = $('#inbox_row_'+i_id).attr("class");
		$.ajax({
			type: "POST",
			url: base_url+'dashboard/is_read/'+i_id,
			cache: false,
			success : function(html){
				if(this_class=="inbox_unread"){
					var inboxmsgs = inbox_msgs - 1;
					inbox_msgs = inboxmsgs;
					if(inbox_msgs>0){
						$('.notification_label').text(inbox_msgs);
					}else{
						$('.notifications').css('display','none');
					}
					$('#inbox_row_'+i_id).removeClass();
					
					unread_app = unread_app -1;
					if(unread_app>0){
						$('#appointments_count').text(unread_app);
					}else{
						$('#appointments_count').css('display','none');
					}
				}
			}
		});
		return false;
	});
});

function delete_testi(el,id){
	Sexy.confirm('<h1>Delete Testimonial?</h1><p>Are you sure you want to delete this testimonial?</p>',{onComplete: 
		function(returnvalue) {
			if(returnvalue){
				$.ajax({
					url: base_url+'dashboard/delete_testi/'+id,
					success: function(data) {
						$(el).parent().parent().remove();
					}
				});
			}
		}
	});
}
function delete_app(el,id){
	Sexy.confirm('<h1>Delete Appointment?</h1><p>Are you sure you want to delete this appointment?</p>',{onComplete: 
		function(returnvalue) {
			if(returnvalue){
				$.ajax({
					url: base_url+'dashboard/delete_app/'+id,
					success: function(data) {
						$(el).parent().parent().remove();
					}
				});
			}
		}
	});
}
</script>
<div class="tab-content" id="tab-8">
	<h4 class="default">Appointments <?php if($unread_app){ ?><label class="unread_count" id="appointments_count"><?=$unread_app?></label><?php } ?></h4>
	<table class="grid_table" id="gallery_grid_table">
		<tr id="gallery_row_header" class="header <?php if(!$appointments){ echo 'hide';} ?>">
			<td width="12%">Date</td>
			<td width="10%">Time</td>
			<td width="32%">Appointment</td>
			<td width="20%">Mobile</td>
			<td width="16%">Telephone</td>
			<td width="10%">Actions</td>
		</tr>
		<?php if(!$appointments){ ?>
			<tr id="gallery_no_image">
				<td colspan="3"> Inbox is empty</td>
			</tr>
		<?php } ?>
		<?php foreach($appointments AS $app): 
			if($app['is_read']==0) $is_read = 'class="inbox_unread"';
			else $is_read = '';
		?>
			<tr id="inbox_row_<?=$app['id'];?>" <?=$is_read?>>
			<td><?=$app['app_date'];?></td>
			<td><?=$app['app_time'];?></td>
			<td><?=$app['appointment'];?></td>
			<td><?=$app['mobile'];?></td>
			<td><?=$app['telephone'];?></td>
			<td>
				<div style="display:none;">
				<div class="guidelineContents" id="guidelineContent_<?=$app['id'];?>" style="width:600px;">
				<div class="fancy_heading">Appointment Details</div>
					<div class="fancy_body">
					<table border="0" width="100%">
						<tr>
							<td style="font-weight:bold;" width="40%">Appointment for:</td>
							<td><?=$app['appointment'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Patient's Age:</td>
							<td><?=$app['age'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Patient's Name:</td>
							<td><?=$app['name'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Patient's Oral Health:</td>
							<td><?=$app['oral_health'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Patient's last visit to a dentist:</td>
							<td><?=$app['last_visit'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Preferred appointement date:</td>
							<td><?=$app['app_date'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Preferred appointement time:</td>
							<td><?=$app['app_time'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Email Address:</td>
							<td><a href="mailto:<?=$app['email'];?>"><?=$app['email'];?></a></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Telephone:</td>
							<td><?=$app['telephone'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Mobile Number:</td>
							<td><?=$app['mobile'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Additional comments:</td>
							<td><?=$app['comments'];?></td>
						</tr>
					</table>
					</div>
				</div>
				</div>
				<a class="viewGuidelines" id="<?=$app['id'];?>" title="Appointment Details" href="#guidelineContent_<?=$app['id'];?>">
					<img alt="view" class="icons" src="<?=base_url()?>assets/themes/default/images/page_white_magnify.png" />
				</a>
				<!-- <a class="image_preview" href=""></a> -->
				<img style="cursor:pointer;" onclick="delete_app(this,<?=$app['id']?>)" alt="delete" class="icons" src="<?=base_url()?>assets/themes/default/images/cross.png" />
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<br/><br/>
	<h4 class="default">Testimonials <?php if($unread_testi){ ?><label class="unread_count" id="testimonials_count"><?=$unread_testi?></label><?php } ?></h4>
	<table class="grid_table" id="gallery_grid_table">
		<tr id="gallery_row_header" class="header <?php if(!$reviews){ echo 'hide';} ?>">
			<td width="12%">Date</td>
			<td width="48%">Reviewer</td>
			<td width="20%">Email</td>
			<td width="10%">Rating</td>
			<td width="10%">Actions</td>
		</tr>
		<?php if(!$reviews){ ?>
			<tr id="gallery_no_image">
				<td colspan="3"> No testimonials yet</td>
			</tr>
		<?php } ?>
		<?php foreach($reviews AS $app): 
			if($app['is_read']==0) $is_read = 'class="inbox_unread"';
			else $is_read = '';
		?>
			<tr id="inbox_row_testi_<?=$app['id'];?>" <?=$is_read?>>
			<td><?=$app['date'];?></td>
			<td><?=$app['name'].' '.ret_alt_echo($app['website'],'','(',')')?></td>
			<td><a href="mailto:<?=$app['email'];?>"><?=$app['email'];?></a></td>
			<td><span class="stars"><?=get_star_rating($app['rating'],true)?></span></td>
			<td>
				<div style="display:none;">
					<div class="guidelineContents" id="testiContent_<?=$app['id'];?>" style="width:600px;min-height: 600px;" >
						<div class="fancy_heading">Testimonial Message</div>
						<div class="fancy_body">
							<p><?=$app['message'];?></p>
						</div>
					</div>
				</div>
				<a class="viewTesti" id="<?=$app['id'];?>" title="Testimonial Message" href="#testiContent_<?=$app['id'];?>">
					<img alt="view" class="icons" src="<?=base_url()?>assets/themes/default/images/page_white_magnify.png" />
				</a>
				<!-- <a class="image_preview" href=""></a> -->
				<img style="cursor:pointer;" onclick="delete_testi(this,<?=$app['id']?>)" alt="delete" class="icons" src="<?=base_url()?>assets/themes/default/images/cross.png" />
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>