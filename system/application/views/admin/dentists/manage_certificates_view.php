<script type="text/javascript">
	function sortBy(sort){
		window.location.href = "<?=base_url()?>_admin_console/certificates/manage_certificates/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Certificate</h1><p>Are you sure you want to delete this certificate?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
				/*	$.ajax({
						url: base_url+'_admin_console/certificates/delete/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						}
					}); */
				}
			}
        });
	}
	$(document).ready(function() {
		$("a.previewImage").fancybox({
			'titleShow'     : false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		})
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >Manage Dentist Certificates</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
