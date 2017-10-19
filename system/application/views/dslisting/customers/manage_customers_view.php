<script type="text/javascript">Shadowbox.init();</script>
<script type="text/javascript">
	function successDelete(){
		message = '<?=$message?>';
		if(message == 'deleted'){
			Sexy.info('<h1>Delete Dentist</h1><p>Dentist successfully deleted.</p>');
		}
	}
	function sortBy(sort){
		window.location.href = "<?=base_url()?>admin/dentists/manage_dentists/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Dentist</h1><p>This will delete all information/data related to this dentist.Are you sure you want to delete this dentist?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'admin/dentists/delete/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						}
					});
				}
			}
        });
	}
	$(function(){
		$("a.hours_scheds").fancybox({
			'titleShow'     : false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
		})
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >Manage Dentists</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$allnews){echo 'disabled';}?> >
				<option <?php if($sort == 'date'){echo 'selected';} ?> value="date">
					Registration Date
				</option>
				<option <?php if($sort == 'last_name'){echo 'selected';} ?> value="last_name">
					Customer Name
				</option>
				<option <?php if($sort == 'telephone'){echo 'selected';} ?> value="telephone">
					Phone
				</option>
				<option <?php if($sort == 'address'){echo 'selected';} ?> value="address">
					Address
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
			</select>&nbsp;&nbsp;
		</div>
		<table id="manage_table">
			<?=$table['table']?>
		</table>
		<?=$table['scheds']?>
		<div id="manage_table_footer"></div>
	</div>
</div>
