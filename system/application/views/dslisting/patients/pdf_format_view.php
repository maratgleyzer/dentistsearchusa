<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<style>
			table#container{
				font-family: helvetica;
				font-size: 9px;
				border-collapse: collapse;
				width: 586px;
			}
			table td div{
				padding: 2px;
				padding-left: 8px;
				color: gray;
			}
			tr td.headers div{
				font-weight: bold;
				background-color: #0d887c;
				font-size: 10px;
				color: white;
			}
			div#div_container{
				border: 1px solid #dadada;
				width: 586px;
				padding: 5px;
			}
			div.saved_values{
				color: #058b7f;
				padding: 0px;
			}
			td.alt_row{
				background-color: #f4f4f4;
			}
			div.notes_append{
				margin-top: 10px;
				padding: 4px;
				background-color: #f4f4f4;
				border: 1px dotted gray;
			}
			div.notes_append  label.append_header{
				font-style: italic;
				color: gray;
			}
			div.notes_append div{
				margin: 0px;
				padding: 0px;
			}
		</style>
	</head>
	<body>
		<div id="div_container">
			<table border="0" cellpadding="0" cellspacing="0" id="container">
				<tr>
					<td colspan="2">
						<div>
							<img src="<?=base_url()?>assets/themes/default/images/logo.gif"/>
						</div>
					</td>
				</tr>
				<tr>
					<td width="40%" class="headers"><div>Personal Information</div></td>
					<td width="60%" class="headers"><div>Notes</div></td>
				</tr>
				<tr>
					<td style="padding-top:20px;"><div>Caller Name: <div id="saved_" class="saved_values"><?=ucwords($caller_name)?></div></div></td>
					<td rowspan="15" style="vertical-align: top; padding-top: 20px;">
						<div style="margin-bottom: 10px;">
							<?=$notes?>
						</div>
					</td>
				</tr>
				<tr>
					<td class="alt_row"><div>Dental Emergency: <div id="saved_" class="saved_values"><?=echo_yes_no($dental_emergency)?></div></div></td>
				</tr>
				<tr>
					<td><div>Phone Number: <div id="saved_" class="saved_values"><?=$phone?></div></div></td>
				</tr>
				<tr>
					<td class="alt_row"><div>Pain Level (0-10): <div id="saved_" class="saved_values"><?=$pain_level?></div></div></td>
				</tr>
				<tr>
					<td><div>Patient Name: <div id="saved_" class="saved_values"><?=ucwords($patient_name)?></div></div></td>
				</tr>
				<tr>
					<td class="alt_row">
						<div>Dentist Assigned to: 
						<?php if(isset($dentist['last_name'])){ ?>
							<div id="saved_" class="saved_values">
								<label><?=@$dentist['last_name']?>, <?=@$dentist['first_name']?> <?=@$dentist['post_nominal']?></label><br/><br/>
								Phone: <label><?=@$dentist['telephone']?></label><br/>
								Email: <label><?=@$dentist['email']?></label><br/>
								Address: <label><?=@$dentist['address']?> <?=@$dentist['city']?>, <?=@$dentist['state']?> <?=@$dentist['zip']?></label><br/>
								<?php if(@$dentist['website']){ ?>Website: <label><?=@$dentist['website']?></label><br/> <?php } ?>
							</div>
							<br/>
							<br/>
							<table style="font-size:8px; width: 220px;" >
								<tr>
									<td width="24%"></td>
									<td width="19%">Login</td>
									<td width="19%">Break-Out</td>
									<td width="19%">Break-In</td>
									<td width="19%">Logout</td>
								</tr>
								<tr>
									<td>Monday</td>
									<td><?=@alt_echo($scheds['mon']['login'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['mon']['break_out'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['mon']['break_in'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['mon']['logout'],'- - - - - -');?></td>
								</tr>
								<tr>
									<td>Tuesday</td>
									<td><?=@alt_echo($scheds['tue']['login'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['tue']['break_out'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['tue']['break_in'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['tue']['logout'],'- - - - - -');?></td>
								</tr>
								<tr>
									<td>Wednesday</td>
									<td><?=@alt_echo($scheds['wed']['login'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['wed']['break_out'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['wed']['break_in'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['wed']['logout'],'- - - - - -');?></td>
								</tr>
								<tr>
									<td>Thursday</td>
									<td><?=@alt_echo($scheds['thu']['login'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['thu']['break_out'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['thu']['break_in'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['thu']['logout'],'- - - - - -');?></td>
								</tr>
								<tr>
									<td>Friday</td>
									<td><?=@alt_echo($scheds['fri']['login'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['fri']['break_out'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['fri']['break_in'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['fri']['logout'],'- - - - - -');?></td>
								</tr>
								<tr>
									<td>Saturday</td>
									<td><?=@alt_echo($scheds['sat']['login'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['sat']['break_out'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['sat']['break_in'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['sat']['logout'],'- - - - - -');?></td>
								</tr>
								<tr>
									<td>Sunday</td>
									<td><?=@alt_echo($scheds['sun']['login'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['sun']['break_out'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['sun']['break_in'],'- - - - - -');?></td>
									<td><?=@alt_echo($scheds['sun']['logout'],'- - - - - -');?></td>
								</tr>
							</table>
						<?php }else{ ?>
								<div id="saved_" class="saved_values">NONE</div>
						<?php } ?>
						</div>
					</td>
				</tr>
				<tr>
					<td><div>Fear of Dentist: <div id="saved_" class="saved_values"><?=echo_yes_no($fear_of_dentist)?></div></div></td>
				</tr>
				<tr>
					<td class="alt_row"><div>Last Appointment Date: <div id="saved_" class="saved_values"><?=$last_appointment_date?></div></div></td>
				</tr>
				<tr>
					<td><div>Date of Birth: <div id="saved_" class="saved_values"><?=$birth_day?></div></div></td>
				</tr>
				<tr>
					<td class="alt_row"><div>Address: <div id="saved_" class="saved_values"><?=$address?></div></div></td>
				</tr>
				<tr>
					<td><div>City: <div id="saved_" class="saved_values"><?=$city?></div></div></td>
				</tr>
				<tr>
					<td class="alt_row"><div>State: <div id="saved_" class="saved_values"><?=$state?></div></div></td>
				</tr>
				<tr>
					<td><div>Zip: <div id="saved_" class="saved_values"><?=$zip?></div></div></td>
				</tr>
				<tr>
					<td class="alt_row"><div>Email Address: <div id="saved_" class="saved_values"><?=$email?></div></div></td>
				</tr>
				<tr>
					<td><div>Office Contact: <div id="saved_" class="saved_values"><?=$office_contact?></div></div></td>
				</tr>
				<?php if($appointment_time){ ?>
					<tr>
						<td class="alt_row"><div>Appointment Date & Time: <div id="saved_" class="saved_values"><?=$appointment_date?> <?=$appointment_time?></div></div></td>
					</tr>
				<?php } ?>
			</table>
		</div>
	</body>
</html>