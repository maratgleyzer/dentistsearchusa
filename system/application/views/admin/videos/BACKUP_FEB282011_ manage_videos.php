<script type="text/javascript">Shadowbox.init();</script>
<script type="text/javascript">
	function successDelete(){
		message = '<?=$message?>';
		if(message == 'deleted'){
			Sexy.info('<h1>Delete Video</h1><p>Video successfully deleted.</p>');
		}
	}
	function sortBy(sort){
		window.location.href = "<?=base_url()?>_admin_console/videos/manage_videos/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Video</h1><p>Are you sure you want to delete this video?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'_admin_console/videos/delete/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
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
	<label class="page_header" >Manage Videos</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$allnews){echo 'disabled';}?> >
				<option <?php if($sort == 'date'){echo 'selected';} ?> value="date">
					Publish Date
				</option>
				<option <?php if($sort == 'title'){echo 'selected';} ?> value="title">
					Title
				</option>
			</select>&nbsp;&nbsp;
			<a href="#">
				<img src="<?=base_url()?>assets/images/admin/page_white_add.png"> Add Video
			</a>
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
