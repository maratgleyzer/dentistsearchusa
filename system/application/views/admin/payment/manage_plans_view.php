<script type="text/javascript">
	function sortBy(sort){
		window.location.href = "<?=base_url()?>_admin_console/payment/manage_payment_plan/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Payment Plan</h1><p>Are you sure you want to delete this payment plan?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'_admin_console/payment/delete/'+id,
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
	<label class="page_header" >Manage Payment Plans</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$plans){echo 'disabled';}?> >
				<option <?php if($sort == 'type'){echo 'selected';} ?> value="type">
					Type
				</option>
				<option <?php if($sort == 'name'){echo 'selected';} ?> value="name">
					Plan Name
				</option>
			</select>&nbsp;&nbsp;
			<a href="<?=base_url()?>_admin_console/payment/add_payment_plan">
				<img src="<?=base_url()?>assets/images/admin/page_white_add.png"> Add Payment Plan
			</a>
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
</div>
