<form class='formtablecheckbox' method="post">
	<div class="alert alert-info alert-dismissible" role="alert">
		<strong>Mass Following alat untuk memfollow semua user yang telah memfollow anda atau istilahnya Follow Back</strong>.
	</div>
	<div class="form-group">
		<label>List Followers : </label>
		<table class="tablecheckbox_asc">
			<thead>
				<tr>
					<th></th>
					<th>Username</th>
					<th>Privasi</th>
					<th>URL</th>
				</tr>
			</thead>
			<tbody>
				<?php  
				$cekfoll = instagram(1, $_SESSION['useragent'], 'friendships/'.$_SESSION['userid'].'/followers/', $_SESSION['cookies']);
				$result = json_decode($cekfoll[1]);

				foreach ($result->users as $row) {     

					if ($row->is_private == false) {
						$privasi = "<span class='badge badge-info'>No Private</span>";
					}else {
						$privasi = "<span class='badge badge-danger'>Private</span>";
					}

					echo "
					<tr>
						<td style='width:5%'>".$row->pk."</td>
						<td><img width='50px' src='".$row->profile_pic_url."' title='".$row->username."'/> ".truncate($row->username, 100)."</td>
						<td>".@$privasi."</td>
						<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://instagram.com/".$row->username."'>Kunjungi</a></td>
					</tr>
					";

				}

				while (!empty(@$result->next_max_id)) {
					$cekfoll = instagram(1, $_SESSION['useragent'], 'friendships/'.$_SESSION['userid'].'/followers/?max_id='.$result->next_max_id, $_SESSION['cookies']);
					$result = json_decode($cekfoll[1]);

					foreach ($result->users as $row) {     

						if ($row->is_private == false) {
							$privasi = "<span class='badge badge-info'>No Private</span>";
						}else {
							$privasi = "<span class='badge badge-danger'>Private</span>";
						}

						echo "
						<tr>
							<td style='width:5%'>".$row->pk."</td>
							<td><img width='50px' src='".$row->profile_pic_url."' title='".$row->username."'/> ".truncate($row->username, 100)."</td>
							<td>".@$privasi."</td>
							<td><a class='btn btn-success waves-effect btn-sm' target='_blank' href='https://instagram.com/".$row->username."'>Kunjungi</a></td>
						</tr>
						";
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Submit">
	</div>
</form>

<div class="progress" style="display: none;">
	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0;background-color: #3f51b5!important">
		<span id="fullResponse"></span>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.formtablecheckbox').on('submit', function(e){
			e.preventDefault();
			var btn = $("input[type='submit']");
			var hidden = $("input[type='hidden']");
			var progressbar = $('.progress');

			var form=this,rows_selected=table_asc.column(0).checkboxes.selected();$.each(rows_selected,function(e,t){
				$(form).append($("<input>").attr("type","hidden").attr("name","target[]").val(t))
			});

			btn.prop('disabled',true);
			btn.val('On Progress...');

			var lastResponseLength = false;
			var ajaxRequest = $.ajax({
				type: 'post',
				url : 'massfollowing',
				data : $(".formtablecheckbox").serialize(),
				dataType: 'json',
				processData: false,
				xhrFields: {
					onprogress: function(e)
					{
						progressbar.fadeIn();
						var response = event.currentTarget.response;
						if(lastResponseLength == false)
						{
							progressResponse = response;
							lastResponseLength = response.length;
						}
						else
						{
							progressResponse = response.substring(lastResponseLength);
							lastResponseLength = response.length;
						}
						var parsedResponse = JSON.parse(progressResponse);
						if (parsedResponse.message == 'error') {
							$('#fullResponse').text(parsedResponse.message);
							sweetAlert('Ehmm', parsedResponse.code , 'error');
							btn.prop('disabled',false);
							btn.val('Submit');
						}else if (parsedResponse.message == 'Complete') {
							$('#fullResponse').text(parsedResponse.message);
							sweetAlert('Berhasil Memproses Permintaan!', 'Sukses : ' + parsedResponse.success + ' | Gagal : ' + parsedResponse.error , 'success').then(function()  {window.location = './?module=<?= $_GET['module'] ?>'; });
						}else{							
							$('#fullResponse').text(parsedResponse.message);
						}
						$('.progress-bar').css('width', parsedResponse.progress + '%');
					}
				}
			});

		})
	})
</script>