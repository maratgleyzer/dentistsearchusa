<script type="text/javascript">Shadowbox.init();</script>
<script type="text/javascript">
	function sortBy(sort){
		window.location.href = "<?=base_url()?>_admin_console/dentists/manage_pre_registered/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Registration</h1><p>Are you sure you want to delete this registration?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'_admin_console/dentists/delete_registration/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						}
					}); 
				}
			}
        });
	}
	function confirmResendEmail(el,email){
		Sexy.confirm('<h1>Resend Pre-Registration Email</h1><p>Are you sure you want to resend the pre-registration email to this user?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'_admin_console/dentists/resend_pre_registration/',
						data: {'email':email,'name':$(el).attr('the_name')},
						type: 'POST',
						success: function(data) {
							Sexy.alert('<h1>Email Sent</h1><p>The pre-registration email has been sent successfully.</p>');
						}
					}); 
				}
			}
        });
	}
</script>
<div>
	<br/><br/>
	<label class="page_header" >Manage Pre-Registered Dentists</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$alluser){echo 'disabled';}?> >
				<option <?php if($sort == 'status'){echo 'selected';} ?> value="status">
					Status
				</option>
				<option <?php if($sort == 'name'){echo 'selected';} ?> value="name">
					Name
				</option>
				<option <?php if($sort == 'email'){echo 'selected';} ?> value="email">
					Email
				</option>
				<option <?php if($sort == 'id'){echo 'selected';} ?> value="id">
					Added
				</option>
			</select>&nbsp;&nbsp;
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
