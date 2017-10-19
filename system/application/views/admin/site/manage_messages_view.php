<script type="text/javascript">
	function sortBy(sort){
		window.location.href = "<?=base_url()?>_admin_console/home/contact_us_messages/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Message</h1><p>Are you sure you want to delete this message?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'_admin_console/home/delete_message/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						}
					});
				}
			}
        });
	}
	$(document).ready(function(){
		$("a.message_box").fancybox({
			'titleShow'     : false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
		})
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >Manage Contact Us Messages</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$messages){echo 'disabled';}?> >
				<option <?php if($sort == 'name'){echo 'selected';} ?> value="name">
					Name
				</option>
				<option <?php if($sort == 'is_dentist'){echo 'selected';} ?> value="is_dentist">
					User
				</option>
				<option <?php if($sort == 'date'){echo 'selected';} ?> value="date">
					Date
				</option>
				<option <?php if($sort == 'email'){echo 'selected';} ?> value="email">
					Email
				</option>
			</select>&nbsp;&nbsp;
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
