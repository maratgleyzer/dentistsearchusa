<script type="text/javascript">
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Category</h1><p>Are you sure you want to delete this category?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'admin/articles/delete_category/'+id,
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
	<label class="page_header" >Manage Article Categories</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			<a href="<?=base_url()?>admin/articles/add_category">
				<img src="<?=base_url()?>assets/images/admin/page_white_add.png"> Add Category
			</a>
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
