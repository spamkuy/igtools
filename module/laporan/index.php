<div class="col-md-12 u-mb-medium">
	<div class="c-table-responsive@desktop">
		<table class="c-table" id="datatable">
			<caption class="c-table__title">
				Laporan Bot
			</caption>

			<thead class="c-table__head c-table__head--slim">
				<tr class="c-table__row">
					<th class="c-table__cell c-table__cell--head">Tanggal</th>
					<th class="c-table__cell c-table__cell--head">Type Bot</th>
				</tr>
			</thead>

			<tbody>
				<?php
				$sql = "SELECT * FROM tb_laporan WHERE userid='$_SESSION[userid]'";
				$result = $mysql->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo '
						<tr class="c-table__row">
							<td class="c-table__cell">'.$row['tanggal'].'</td>
							<td class="c-table__cell">'.$row['type'].'</td>
						</tr>
						';
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>