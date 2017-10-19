<script type="text/javascript">Shadowbox.init();</script>
<script type="text/javascript">
	function sortBy(sort){
		$('#dentist_search').submit();
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Dentist</h1><p>This will delete all information/data related to this dentist.Are you sure you want to delete this dentist?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'_admin_console/dentists/delete/'+id,
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
	<label class="page_header" >Manage Dentists</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<form id="dentist_search" method="post" action="<?=base_url()?>_admin_console/dentists/manage_dentists">
		<div id="manage_table_top_menu">
			Sort By : 
			<select name="sort" id="sort" onChange="sortBy(this.value)" <?php if(!$alldents){echo 'disabled';}?> >
				<option <?php if($sort == 'date'){echo 'selected';} ?> value="date">
					Registration Date
				</option>
				<option <?php if($sort == 'last_name'){echo 'selected';} ?> value="last_name">
					Last Name
				</option>
				<option <?php if($sort == 'post_nominal'){echo 'selected';} ?> value="post_nominal">
					Specialty
				</option>
				<option <?php if($sort == 'the_rating'){echo 'selected';} ?> value="the_rating">
					Rating
				</option>
				<option <?php if($sort == 'zip'){echo 'selected';} ?> value="zip">
					Zip Code
				</option>
				<option <?php if($sort == 'city'){echo 'selected';} ?> value="city">
					City
				</option>
				<option <?php if($sort == 'state'){echo 'selected';} ?> value="state">
					State
				</option>
			</select>&nbsp;&nbsp; |&nbsp;&nbsp;
			Search By City/Zip:
			<input name="city_zip" id="city_zip" class="city_zip_autocomplete hide-text-inputs {autoc_width:250,autoc_top:322}" type="text" value="<?=$city_zip?>" />
			&nbsp;and/or&nbsp; Search By First/Last Name:
			<input name="first_last" id="first_last" class="first_last_autocomplete hide-text-inputs {autoc_width:250,autoc_top:322}" type="text" value="<?=$first_last?>" />
			&nbsp;&nbsp;<input type="submit" value="SEARCH" />
		</div>
		</form>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div class="pagination_links">
			<?=$paging?>
		</div>
		<div id="manage_table_footer"></div>
	</div>
</div>
