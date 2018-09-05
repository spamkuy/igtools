<!-- <h4 class="c-sidebar__title">Halaman</h4> -->

<li class="c-sidebar__item">
	<a class="c-sidebar__link dashboard" href="./">
		<i class="fa fa-home u-mr-xsmall"></i>Dashboard
	</a>
</li>

<?php if (!empty($_SESSION['masuk'])): ?>	
<!-- 	<li class="c-sidebar__item">
		<a class="c-sidebar__link" href="?module=multiplefollowing">
			<i class="fa fa-send u-mr-xsmall"></i>
			Multiple Following
		</a>
	</li> -->
	<li class="c-sidebar__item">
		<a class="c-sidebar__link" href="?module=multipleunfollow">
			<i class="fa fa-send u-mr-xsmall"></i>
			Multiple Unfollow
		</a>
	</li> 		
	<li class="c-sidebar__item">
		<a class="c-sidebar__link" href="?module=multipleuploadphoto">
			<i class="fa fa-send u-mr-xsmall"></i>
			Multiple Upload Photo
		</a>
	</li> 			
	<li class="c-sidebar__item">
		<a class="c-sidebar__link" href="?module=multipledeletepost">
			<i class="fa fa-send u-mr-xsmall"></i>
			Multiple Delete Post
		</a>
	</li> 			
	<li class="c-sidebar__item">
		<a class="c-sidebar__link" href="?module=botlike">
			<i class="fa fa-send u-mr-xsmall"></i>
			Bot Like
		</a>
	</li> 
<?php endif ?>

<?php if (empty($_SESSION['masuk'])): ?>
	<li class="c-sidebar__item">
		<a class="c-sidebar__link" href="?module=masuk">
			<i class="fa fa-sign-in u-mr-xsmall"></i>Masuk
		</a>
	</li>
<?php else: ?>

	<li class="c-sidebar__item">
		<a class="c-sidebar__link" href="?module=laporan">
			<i class="fa fa-clock-o u-mr-xsmall"></i>Table Laporan
		</a>
	</li>

<?php endif ?>

<li class="c-sidebar__item">
	<a class="c-sidebar__link" href="?module=changelog">
		<i class="fa fa-bug u-mr-xsmall"></i>Changelog
	</a>
</li>

<li class="c-sidebar__item">
	<a class="c-sidebar__link" href="?module=tentangaplikasi">
		<i class="fa fa-info-circle u-mr-xsmall"></i>Tentang Aplikasi
	</a>
</li>