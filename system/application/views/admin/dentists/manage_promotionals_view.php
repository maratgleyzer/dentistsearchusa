<script type="text/javascript">Shadowbox.init();</script>
<script type="text/javascript">
	function sortBy(sort){
		window.location.href = "<?=base_url()?>_admin_console/dentists/manage_promotionals/"+sort+'/<?=$id?>';
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Promo</h1><p>Are you sure you want to delete this promo?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'_admin_console/dentists/delete_promo/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						}
					}); 
				}
			}
        });
	}
</script>
<div>
	<br/><br/>
	<label class="page_header" >Manage Dentist Promotionals</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$allpromo){echo 'disabled';}?> >
				<option <?php if($sort == 'last_name'){echo 'selected';} ?> value="last_name">
					Dentist
				</option>
				<option <?php if($sort == 'name'){echo 'selected';} ?> value="name">
					Promo Name
				</option>
				<option <?php if($sort == 'id'){echo 'selected';} ?> value="id">
					Created
				</option>
			</select>&nbsp;&nbsp;
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
