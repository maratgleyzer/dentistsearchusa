		<script type="text/javascript">
		function jaja(x){
			var msg  = $('#event_msg').attr('value');  
			var note  = $('#note').attr('value');  
			var start_date  = $('#start_date').attr('value');  
			var end_date  = $('#end_date').attr('value');  
			var new_file = ''
			+'<tr>'
				+'<td>'+note+'</td>'
				+'<td>'+start_date+'</td>'
				+'<td>'+end_date+'</td>'
				+'<td>'
					+'<div style="display:none;">'
					+'<div class="guidelineContents" id="eventContent_'+x.file.last_id+'" style="width:600px;">'
					+'<div class="fancy_heading">Event Details</div>'
					+'<div class="fancy_body">'
						+'<table border="0" width="100%">'
							+'<tr>'
								+'<td style="font-weight:bold;" width="25%">Event/Note Subject:</td>'
								+'<td>'+note+'</td>'
							+'</tr>'
							+'<tr>'
								+'<td style="font-weight:bold;">Start Date:</td>'
								+'<td>'+start_date+'</td>'
							+'</tr>'
							+'<tr>'
								+'<td style="font-weight:bold;">End Date:</td>'
								+'<td>'+end_date+'</td>'
							+'</tr>'
							+'<tr>'
								+'<td style="font-weight:bold;">Event Message:</td>'
								+'<td>'+msg+'</td>'
							+'</tr>'
						+'</table>'
					+'</div>'
					+'</div>'
					+'</div>'
					+'<a class="viewEvent" id="'+x.file.last_id+'" title="Event Details" href="#eventContent_'+x.file.last_id+'">'
						+'<img alt="download" class="icons" src="'+base_url+'assets/themes/default/images/page_white_magnify.png" />'
					+'</a>'
					+'<img style="cursor:pointer;" onclick="delete_app(this,'+x.file.last_id+')" alt="delete" class="icons" src="'+base_url+'assets/themes/default/images/cross.png" />'
				+'</td>'
			+'</tr>';
			$('#no_events').remove();
			$('#event_row_header').css({'display':'table-row'});
			$('#event_grid_table').append(new_file);
			$(".viewEvent").fancybox({
			'titleShow'     : false,
			'transitionIn' : 'elastic',
			'transitionOut' : 'elastic'
			});
			
		}
			
		$(document).ready(function() {
			$(".viewEvent").fancybox({
			'titleShow'     : false,
			'transitionIn' : 'elastic',
			'transitionOut' : 'elastic'
			});

			 $(function(){
				$('input#btn_dash').click(function(){
					process_form('input#btn_dash','SAVE','div#dash_form_messages',false,'form#events_form','event_scheduler',false,'jaja');
				});
			});
			
			$("#start_date").datepicker({
				dateFormat: 'yy-mm-dd',
				onSelect:function(theDate) {
					$("#end_date").datepicker('option','minDate',new Date(theDate))
				}
			})
			$("#end_date").datepicker({
				dateFormat: 'yy-mm-dd'
			})
			$(function(){
				$('input#btn_sched').click(function(){
					process_form('input#btn_sched','SAVE','div#sched_form_messages',false,'form#sched_form','event_scheduler/add_sched',false);
				});
			});
			
			
		});
		function delete_dash(el,id){
			Sexy.confirm('<h1>Delete Event?</h1><p>Are you sure you want to delete this event?</p>',{onComplete: 
				function(returnvalue) {
					if(returnvalue){
						$.ajax({
							url: base_url+'event_scheduler/delete_event/'+id,
							success: function(data) {
								$(el).parent().parent().remove();
							}
						});
					}
				}
			});
		};
		
		$(function(){
			//$('.d_fieldx').timepickr();
		});
		</script>
		<div class="tab-content dash_tab" id="tab-1">
			<div>
			<h4 class="default">Scheduler</h4>
			<div id="sched_form_messages" class="form_messages"></div>
			<form id="sched_form" method="post">
					<table border="0" width="100%">
						<tr>
							<td width="20%"></td>
							<td width="20%" class="d_tr"><label>Login:</label></td>
							<td width="20%" class="d_tr"><label>Break-out</label></td>
							<td width="20%" class="d_tr"><label>Break-in</label></td>
							<td width="20%" class="d_tr"><label>Logout</label></td>
						</tr>
						<?php
							$days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
							foreach($days as $day):
							$d_tr = $this->Event_scheduler_model->get_scheds($logged_key, $day);
							if(count($d_tr)>0){
								$login = $d_tr[0]['login'];
								$break_out = $d_tr[0]['break_out'];
								$break_in = $d_tr[0]['break_in'];
								$logout = $d_tr[0]['logout'];
							}else{
								$login = "";
								$break_in = "";
								$break_out = "";
								$logout = "";
							}
						?>
							<tr>
								<td><?=$day?></td>
								<td class="d_tr"><input class="d_field" type="text" name="<?=$day?>[]" value="<?=$login?>" /></td>
								<td class="d_tr"><input class="d_field" type="text" name="<?=$day?>[]" value="<?=$break_out?>" /></td>
								<td class="d_tr"><input class="d_field" type="text" name="<?=$day?>[]" value="<?=$break_in?>" /></td>
								<td class="d_tr"><input class="d_field" type="text" name="<?=$day?>[]" value="<?=$logout?>" /></td>
							</tr>
						<?php endforeach; ?>
						<tr>
							<td colspan="5">	
								<div style="text-align:right;"><br/>
								<input type="hidden" value="<?=$logged_key?>" id="user_id" name="user_id" />
								<input class="btn02" id="btn_sched" type="button" value="SAVE" />
								<input class="btn03" type="reset" value="RESET" />
								</div>
							</td>
						</tr>
					</table>
			</form>
			</div>
			<br/><div style="border-bottom:1px solid #E9EAEF;"></div><br/>
			<div>
				<h4 class="default">Add new event</h4>
				<div id="dash_form_messages" class="form_messages"></div>
				<form id="events_form" method="post">
				<table border="0" width="100%">
					<tr>
						<td width="60%">
							<label>Event Message</label><br/>
							<textarea id="event_msg" name="event_msg" cols="50" rows="8"></textarea>
						</td>
						<td>
							<div>
								<div><label>Event/Note Subject:</label><input type="text" name="note" id="note" style="width:253px;"></div><br/>
								<div style="float:left;"><label>Start Date:</label><br/>
								<img src="<?=base_url()?>assets/images/date_add.png" class="data_ico" />
								<input class="d_field" type="text" id="start_date" name="start_date" /></div>
								<div style="float:left;padding-left:5px;"><label>End Date:</label><br/>
								<img src="<?=base_url()?>assets/images/date_add.png" class="data_ico" />
								<input class="d_field" type="text" id="end_date" name="end_date"  /></div>
							</div><br/><br/>
							<div style="text-align:right;margin-top:20px;">
								<input type="hidden" value="<?=$logged_key?>" id="user_id" name="user_id" />
								<input id="btn_dash" class="btn02" type="button" value="SAVE" />
								<input class="btn03" type="reset" value="RESET" />
							</div>
						</td>
					</tr>
				</table>
				</form>
				<br/><br/>
				<h4 class="default">Events</h4>
				<table class="grid_table" id="event_grid_table">
					<tr id="event_row_header" class="header <?php if(!$events){ echo 'hide';} ?>">
						<td width="50%">Event/Note Subject</td>
						<td width="20%">Start Date</td>
						<td width="20%">End Date</td>
						<td width="10%">Actions</td>
					</tr>
					<?php if(!$events){ ?>
						<tr id="no_events">
							<td colspan="3"> Events is empty</td>
						</tr>
					<?php } ?>
					<?php foreach($events AS $event): ?>
					<tr>
						<td><?=$event['note'];?></td>
						<td><?=$event['start_date'];?></td>
						<td><?=$event['end_date'];?></td>
						<td>
							<div style="display:none;">
							<div class="guidelineContents" id="eventContent_<?=$event['id'];?>" style="width:600px;">
							<div class="fancy_heading">Event Details</div>
								<div class="fancy_body">
									<table border="0" width="100%">
										<tr>
											<td style="font-weight:bold;" width="25%">Event/Note Subject:</td>
											<td><?=$event['note'];?></td>
										</tr>
										<tr>
											<td style="font-weight:bold;">Start Date:</td>
											<td><?=$event['start_date'];?></td>
										</tr>
										<tr>
											<td style="font-weight:bold;">End Date:</td>
											<td><?=$event['end_date'];?></td>
										</tr>
										<tr>
											<td style="font-weight:bold;">Event Message:</td>
											<td><?=$event['message'];?></td>
										</tr>
									</table>
								</div>
							</div>
							</div>
							<a class="viewEvent" id="<?=$event['id'];?>" title="Event Details" href="#eventContent_<?=$event['id'];?>">
								<img alt="download" class="icons" src="<?=base_url()?>assets/themes/default/images/page_white_magnify.png" />
							</a>
							<!-- <a class="image_preview" href=""></a> -->
							<img style="cursor:pointer;" onclick="delete_dash(this,<?=$event['id']?>)" alt="delete" class="icons" src="<?=base_url()?>assets/themes/default/images/cross.png" />
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div><!-- /tab-1 end -->