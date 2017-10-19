<script type="text/javascript">
	function sortBy(sort){
		window.location.href = "<?=base_url()?>_admin_console/dentists/manage_files/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete File</h1><p>Are you sure you want to delete this file?</p>',{onComplete: 
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
	<label class="page_header" >Manage Dentist Files</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
