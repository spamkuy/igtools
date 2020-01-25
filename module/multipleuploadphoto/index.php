<div class="col-md-12">
	<div class="c-card c-card--responsive u-mb-medium">
		<div class="c-card__header c-card__header--transparent o-line">
			<h5 class="c-card__title">Upload Foto Sekaligus (Bukan Album)</h5>
		</div>
		<div class="c-card__body">

			<form class='formfileupload' method="post" enctype="multipart/form-data">			
				<div class="c-field u-mb-small">
					<label class="c-field__label">Image File (format : png,jpg,jpeg)</label>
					<input multiple="" required="" type="file" class="c-input" name="file[]" data-placeholder="No Image">
				</div>
				<div class="c-field u-mb-small">
					<textarea required="" name="caption" placeholder="Caption..." rows="5" class="c-input"></textarea>
				</div>
				<div class="c-field u-mb-small">
					<input data-post='multipleuploadphoto' class="c-btn c-btn--info" type="submit" value="Submit">
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