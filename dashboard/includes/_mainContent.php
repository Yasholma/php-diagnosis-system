<!-- Main content -->
<div class="container">
	<div class="row">
		<div class="col-md-8 mx-auto">
			<div class="card">
				<?php foreach (!empty($user->getAllNews()) ? $user->getAllNews() : [] as $ns): ?>
					<div class="card-body">
						<?php echo $ns->news; ?> <hr>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>
