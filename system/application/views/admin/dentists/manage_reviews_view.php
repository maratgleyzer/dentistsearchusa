<script type="text/javascript">Shadowbox.init();</script>
<script type="text/javascript">
	function sortBy(sort){
		window.location.href = "<?=base_url()?>_admin_console/dentists/manage_reviews/"+sort+'/<?=$id?>';
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Review</h1><p>Are you sure you want to delete this review?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
				/*	$.ajax({
						url: base_url+'_admin_console/files/delete/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						}
					}); */
				}
			}
        });
	}
</script>
<div>
	<br/><br/>
	<label class="page_header" >Manage Dentist Reviews</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$alldents){echo 'disabled';}?> >
				<option <?php if($sort == 'date'){echo 'selected';} ?> value="date">
					Review Date
				</option>
				<option <?php if($sort == 'last_name'){echo 'selected';} ?> value="last_name">
					Dentist
				</option>
				<option <?php if($sort == 'email'){echo 'selected';} ?> value="email">
					Reviewer Email
				</option>
				<option <?php if($sort == 'rating'){echo 'selected';} ?> value="rating">
					Rating
				</option>
			</select>&nbsp;&nbsp;
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
