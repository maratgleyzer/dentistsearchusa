<script type="text/javascript">
	$(function(){
		$("a#send_pdf_box_link").fancybox({
			'titleShow'     : false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
		})
		$('input#btn_send_pdf').click(function(){
			process_form('input#btn_send_pdf','SEND','div#send_pdf_form_messages',false,'form#send_pdf','dslisting/patients/send_pdf/',false,'save_success_pdf');
		});
	});
	function sortBy(sort){
		window.location.href = "<?=base_url()?>dslisting/patients/patient_list/"+sort;
	}
	function confirmDelete(el,id){
		Sexy.confirm('<h1>Delete Patient</h1><p>Are you sure you want to delete this patient?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'dslisting/patients/delete/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						}
					});
				}
			}
        });
	}
	function send_pdf(pdf_file){
		$('#pdf_download_link').attr('href',base_url+'dslisting/patients/download_patient_pdf/'+pdf_file);
		$('#pdf_download_link').html('<img src="'+base_url+'assets/images/admin/page_white_acrobat.png"/> '+pdf_file+'.pdf');
		$("a#send_pdf_box_link").fancybox().trigger('click');
	}
	
</script>
<div>
	<br/><br/>
	<label class="page_header" >Patient List</label>
	<br/><br/>
	<div id="manage_table">
		<div id="manage_table_header"></div><br/>
		<div id="manage_table_top_menu">
			Sort By : 
			<select onChange="sortBy(this.value)" <?php if(!$allpatients){echo 'disabled';}?> >
				<option <?php if($sort == 'patient_name'){echo 'selected';} ?> value="patient_name">
					Patient Name
				</option>
				<option <?php if($sort == 'phone'){echo 'selected';} ?> value="phone">
					Patient Phone
				</option>
				<option <?php if($sort == 'last_name'){echo 'selected';} ?> value="last_name">
					Customer Name
				</option>
				<option <?php if($sort == 'telephone'){echo 'selected';} ?> value="telephone">
					Customer Phone
				</option>
				<option <?php if($sort == 'office_contact'){echo 'selected';} ?> value="office_contact">
					Office Contact
				</option>
				<option <?php if($sort == 'added'){echo 'selected';} ?> value="added">
					Referral Date
				</option>
				<option <?php if($sort == 'name'){echo 'selected';} ?> value="name">
					Assigned To
				</option>
			</select>&nbsp;&nbsp;
			<a href="<?=base_url()?>dslisting/patients/add_patient">
				<img src="<?=base_url()?>assets/images/admin/page_white_add.png"> Add Patient
			</a>
		</div>
		<table id="manage_table">
			<?=$table?>
		</table>
		<div id="manage_table_footer"></div>
	</div>
	<div style="display:none;">
		<a id="send_pdf_box_link" style="display:none;" href="#send_pdf_box">send pdf box</a>
		<div id="send_pdf_box">
			<form id="send_pdf">
				<div class="row" style="min-height: 88px;" id="send_pdf_box_row">
					<div style="min-height:40px;">
						<div id="send_pdf_form_messages" class="form_messages" style="margin-bottom:10px;"></div>
					</div>
					<label>Recepients: </label><label class="note">(separate emails using a comma):</label><br/>
					<input type="text" name="emails" class="semi_wide_input_text txt"/>
					<a id="pdf_download_link" href="#"><img src="<?=base_url()?>assets/images/admin/page_white_acrobat.png"/> talpolano_patient_file_123345.pdf</a>
				</div><!-- /row end -->
				<div class="clear_both" style="clear:both;"></div>
			</form>
			<div class="btn_holder" style="position:absolute; bottom: 5px; right: 0px;">
				<input onclick="$.fancybox.close()" class="btn03" type="button" value="CANCEL" />
				<input id="btn_send_pdf" onclick="" class="btn02" type="button" value="SEND" />
			</div>
		</div>
	</div>
</div>
