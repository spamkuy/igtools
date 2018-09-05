<?php if (!empty($_GET['type'])): ?>

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
									<th class="c-table__cell c-table__cell--head">Username</th>
									<th class="c-table__cell c-table__cell--head">Privasi</th>
									<th class="c-table__cell c-table__cell--head no-sort">URL</th>
								</tr>
							</thead>

							<tbody>
								<?php  
								$cekfoll = instagram(1, $_SESSION['useragent'], 'friendships/' . $_SESSION['userid'] . '/following/', $_SESSION['cookies']);
								$result = json_decode($cekfoll[1]);
								foreach ($result->users as $row) {     

									if ($row->is_private == false) {
										$privasi = "<span class='badge badge-info'>No Private</span>";
									}else {
										$privasi = "<span class='badge badge-danger'>Private</span>";
									}

									if ($_GET['type'] == 'followingnotfollowback') {
										$followyoucheck = instagram(1, $_SESSION['useragent'], 'friendships/show/' . $row->pk, $_SESSION['cookies']);
										$followyoucheck = json_decode($followyoucheck[1]);
										if ($followyoucheck->followed_by == false) {
											echo "
											<tr class='c-table__row odd'>	
												<td class='c-table__cell' style='width:5%'>".$row->pk."</td>
												<td class='c-table__cell'>
													<div class='o-media'>
														<div class='o-media__img u-mr-xsmall'>
															<div class='c-avatar c-avatar--xsmall'>
																<img class='c-avatar__img' src='".$row->profile_pic_url."' title='".$row->username."'>
															</div>
														</div>
														<div class='o-media__body'>
															". truncate($row->username, 50)."
														</div>
													</div>
												</td>
												<td class='c-table__cell'>".@$privasi."</td>
												<td class='c-table__cell'><a class='c-btn c-btn--success' target='_blank' href='https://instagram.com/".$row->username."'>Kunjungi</a></td>
											</tr>
											";
										}
									}elseif ($_GET['type'] == 'following') {
										echo "
										<tr class='c-table__row odd'>	
											<td class='c-table__cell' style='width:5%'>".$row->pk."</td>
											<td class='c-table__cell'>
												<div class='o-media'>
													<div class='o-media__img u-mr-xsmall'>
														<div class='c-avatar c-avatar--xsmall'>
															<img class='c-avatar__img' src='".$row->profile_pic_url."' title='".$row->username."'>
														</div>
													</div>
													<div class='o-media__body'>
														". truncate($row->username, 50)."
													</div>
												</div>
											</td>
											<td class='c-table__cell'>".@$privasi."</td>
											<td class='c-table__cell'><a class='c-btn c-btn--success' target='_blank' href='https://instagram.com/".$row->username."'>Kunjungi</a></td>
										</tr>
										";
									}
								}
								?>
							</tbody>
						</table>
					</div>

					<div class="c-field u-mt-small">
						<input data-post='multipleunfollow' class="c-btn c-btn--info" type="submit" value="Submit">
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
<?php else: ?>
	<div class="col-md-12">
		<div class="c-card c-card--responsive u-mb-medium">
			<div class="c-card__header c-card__header--transparent o-line">
				<h5 class="c-card__title">Fitur <?= $settings['title'] ?></h5>
			</div>
			<div class="c-card__body">

				<div class="row">

					<div class="col-sm-12 col-lg-6 col-xl-6">
						<a href="?module=multipleunfollow&type=following" class="c-state-card" data-mh="state-cards" style="height: 125px;">
							<div class="c-state-card__icon c-state-card__icon--info">
								<i class="fa fa-group"></i>
							</div>

							<div class="c-state-card__content">
								<h5 class="c-state-card__meta">Show List Following </h5>
							</div>
						</a>
					</div>
					<div class="col-sm-12 col-lg-6 col-xl-6">
						<a href="?module=multipleunfollow&type=followingnotfollowback" class="c-state-card" data-mh="state-cards" style="height: 125px;">
							<div class="c-state-card__icon c-state-card__icon--info">
								<i class="fa fa-group"></i>
							</div>

							<div class="c-state-card__content">
								<h5 class="c-state-card__meta">Show List Following Not Follow Back </h5>
							</div>
						</a>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php endif ?>