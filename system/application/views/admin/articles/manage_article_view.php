<script type="text/javascript">
	function successDelete(){
		message = '<?=$message?>';
		if(message == 'deleted'){
			Sexy.info('<h1>Delete Article</h1><p>Article successfully deleted.</p>');
		}
	}
	function sortBy(sort){
		window.location.href = "<?=base_url()?>admin/articles/manage_articles/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Article</h1><p>Are you sure you want to delete this article?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'_admin_console/articles/delete/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						},
						error: function(data) {
							alert(data.responseText);
						}
					});
				}
			}
        });
	}
	window.onload = function(){
		successDelete();
	}
</script>
<div>
	<br/><br/>
	<label class="page_header" >Manage Articles</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$allarticle){echo 'disabled';}?> >
				<option <?php if($sort == 'author'){echo 'selected';} ?> value="author">
					Author
				</option>
				<option <?php if($sort == 'category_title'){echo 'selected';} ?> value="category_title">
					Category
				</option>
				<option <?php if($sort == 'date'){echo 'selected';} ?> value="date">
					Publish Date
				</option>
				<option <?php if($sort == 'title'){echo 'selected';} ?> value="title">
					Title
				</option>
			</select>&nbsp;&nbsp;
			<a href="<?=base_url()?>_admin_console/articles/add_article">
				<img src="<?=base_url()?>assets/images/admin/page_white_add.png"> Add Article
			</a>
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
