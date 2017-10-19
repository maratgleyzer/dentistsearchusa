<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">	
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title> DSUSA - Admin Login </title>
	</head>
	<body style="background-image: url('<?=base_url()?>assets/themes/default/images/bg-body.gif'); background-repeat: repeat-x;">
		<div style="width: 340px; margin-left:auto; margin-right:auto; background-color:white; font-size:8px; font-family: arial; padding-left: 40px; border: 4px solid #f4f4f4; margin-top: 80px;">
				<!--<span style="font-weight: bold;">Login</span> -->
				<br>
				<img src="<?=base_url()?>assets/images/admin/logo.png"/>
				<p> 
				 <form method="post" action="<?=base_url()?>index.php/_admin_console/login">
				  <table cellspacing="1" cellpadding="5" border="0"> 
					<tbody> 
					  <tr>
						<td>
							<label style="font-size:12px; color:red; font-weight: bold;"><?=$message?></label>
						</td>
					  </tr>
					  <tr> 
						<td width="300">
							<input type="hidden" value="loginthisadmin" name="task" />
							<h2 style="font-size:12px; line-height:10px; margin:4px 0px;" >Username</h2>
							<input class="input_text" style="width:200px;" name="login" type="text" /><br/><br/>
							<h2 style="font-size:12px; line-height:10px;  margin:4px 0px;">Password</h2> 
							<input name="password" style="width:200px;" class="input_text" type="password" /> <br /><br /> 
							<input class="input_button" type="submit" value="Login" /> 
						</td> 
					  </tr> 
					</tbody> 
				  </table>
				  </form>
				</p>
				<div class="clear"></div>
				<br />
			</div>
			<div class="clear"></div>
			<br /><br /><br /><br /><br /><br />
		</div>
	</body>
</html>
    