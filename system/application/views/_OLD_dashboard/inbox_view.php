<script type="text/javascript">

$(document).ready(function() {

	var inbox_msgs = <?=$total_apps?>;
	
	$(".viewGuidelines").fancybox({
		'titleShow'     : false,
		'transitionIn' : 'elastic',
		'transitionOut' : 'elastic'
		});
	$('.viewGuidelines').click(function(){
		var i_id = $(this).attr("id");
		var this_class = $('#inbox_row_'+i_id).attr("class");
		$.ajax({
			type: "POST",
			url: base_url+'dashboard/is_read/'+i_id,
			cache: false,
			success : function(html){
				//$("#r_1.bold_row").removeClass();inbox_unread
				
				if(this_class=="inbox_unread"){
					var inboxmsgs = inbox_msgs - 1;
					inbox_msgs = inboxmsgs;
					if(inbox_msgs>0){
						inbox_msgs = "<b>"+inbox_msgs+"</b>";
					}else{
						inbox_msgs = 0;
					}
					var new_inbox = '<a href="#tab-7" class="tab">messages ('+inbox_msgs+')</a>';
					$('#inbox_row_'+i_id).removeClass();
					$('#inbox_msgs').html('');
					$('#inbox_msgs').append(new_inbox);
				}

				//$('#inbox_row_'+i_id).css({'display':'table-row'});
			}
		});
		return false;
	});
});

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
	<h4 class="default">Inbox</h4>
	<table class="grid_table" id="gallery_grid_table">
		<tr id="gallery_row_header" class="header <?php if(!$appointments){ echo 'hide';} ?>">
			<td width="6%">Date</td>
			<td width="12%">Time</td>
			<td width="40%">Appointment</td>
			<td width="16%">Mobile</td>
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
							<td style="font-weight:bold;">Patients Age:</td>
							<td><?=$app['age'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Patients' Oral Health:</td>
							<td><?=$app['oral_health'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Patients' last visit to a dentist:</td>
							<td><?=$app['last_visit'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Preffered appointement date:</td>
							<td><?=$app['app_date'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Preffered appointement time:</td>
							<td><?=$app['app_time'];?></td>
						</tr>
						<tr>
							<td style="font-weight:bold;">Email Address:</td>
							<td><?=$app['email'];?></td>
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
					<img alt="download" class="icons" src="<?=base_url()?>assets/themes/default/images/page_white_magnify.png" />
				</a>
				<!-- <a class="image_preview" href=""></a> -->
				<img style="cursor:pointer;" onclick="delete_app(this,<?=$app['id']?>)" alt="delete" class="icons" src="<?=base_url()?>assets/themes/default/images/cross.png" />
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>