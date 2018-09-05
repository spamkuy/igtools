<div class="col-md-12">
	<div class="c-card c-card--responsive u-mb-medium">
		<div class="c-card__header c-card__header--transparent o-line">            
			<h5 class="c-card__title">

				<?php if (@isset($_GET['type']) == 'following'): ?>
					Show Following
				<?php else: ?>
					Show Following Not Follow Back
				<?php endif ?>
			</h5>
		</div>
		<div class="c-card__body">	

			<form class='formtablecheckbox' method="post">

				<div class="c-table-responsive@desktop u-mb-medium" style="overflow: hidden">
					<table class="c-table datatablecheckbox">
						<caption class="c-table__title">							
						</caption>

						<thead class="c-table__head c-table__head--slim">
							<tr class="c-table__row">
								<th class="c-table__cell c-table__cell--head"></th>
								<th class="c-table__cell c-table__cell--head">Caption</th>
								<th class="c-table__cell c-table__cell--head">Type Media</th>
								<th class="c-table__cell c-table__cell--head no-sort">URL</th>
							</tr>
						</thead>

						<tbody>
							<?php  
							$getallpost = instagram(1, $_SESSION['useragent'], "feed/user/{$_SESSION['userid']}", $_SESSION['cookies']);
							$result = json_decode($getallpost[1]);
							foreach ($result->items as $media){
								$postid = explode('_', @$media->id);
								$postid = $postid[0];
								$mediatype = @$media->media_type;
								$caption = @$media->caption->text;

								if ($caption) {
									$caption = truncate($caption,100);
								}else {
									$caption = "<span class='badge badge-danger'>Tidak ada Caption</span>";
								}

								if ($mediatype == 8) { // Album
									$postimage_original = @$media->carousel_media[0]->image_versions2->candidates[0]->url;
									$postimage_small = @$media->carousel_media[0]->image_versions2->candidates[1]->url;
									$type = "<span class='badge badge-primary'>Album photo</span>";
								}elseif ($mediatype == 2) { // Video Type
									$postimage_original = @$media->image_versions2->candidates[0]->url;
									$postimage_small = @$media->image_versions2->candidates[1]->url;
									$type = "<span class='badge badge-info'>Single Video</span>";
								}elseif ($mediatype == 1) {// Single Photo
									$postimage_original = @$media->image_versions2->candidates[0]->url;
									$postimage_small = @$media->image_versions2->candidates[1]->url;
									$type = "<span class='badge badge-success'>Single photo</span>";
								}
								echo "
								<tr class='c-table__row odd'>	
									<td class='c-table__cell' style='width:5%'>".$postid."</td>
									<td class='c-table__cell'>
										<div class='o-media'>
											<div class='o-media__img u-mr-xsmall'>
												<div class='c-avatar c-avatar--xsmall'>
													<a target='_blank' href='".$postimage_original."'><img class='c-avatar__img' src='".$postimage_small."' title='".$caption."'></a>
												</div>
											</div>
											<div class='o-media__body'>
												". truncate($caption, 50)."
											</div>
										</div>
									</td>
									<td class='c-table__cell'>".@$type."</td>
									<td class='c-table__cell'><a class='c-btn c-btn--success' target='_blank' href='https://instagram.com/p/".$media->code."'>Kunjungi</a></td>
								</tr>
								";
							}
							?>
						</tbody>
					</table>
				</div>

				<div class="c-field u-mt-small">
					<input data-post='multipledeletepost' class="c-btn c-btn--info" type="submit" value="Submit">
				</div>

			</form>


			<div class="c-progress c-progress--info u-mt-medium" style="display: none; height: 40px;">
				<div class="c-progress__bar" style="width:0;">
					<div id="fullResponse" style="
					text-align: center;
					width: 100%;
					line-height: 40px;
					"></div>
				</div>
			</div>

		</div>
	</div>
</div>