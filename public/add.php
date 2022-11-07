<?php
include "../bootstrap.php";

use CT275\Labs\truong;

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$contact = new truong($PDO);
	$contact->fill($_POST);
	if ($contact->validate()) {
		$contact->save() && redirect(BASE_URL_PATH);
	}
	$errors = $contact->getValidationErrors();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Contacts</title>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= BASE_URL_PATH . "css/sticky-footer.css" ?>" rel=" stylesheet">
	<link href="<?= BASE_URL_PATH . "css/font-awesome.min.css" ?>" rel=" stylesheet">
	<link href="<?= BASE_URL_PATH . "css/animate.css" ?>" rel=" stylesheet">
</head>

<body>
	<?php include('../partials/navbar.php');
	include '../partials/db_connect.php';
	?>

	<!-- Main Page Content -->
	<div class="container">
		<section id="inner" class="inner-section section">
			<div class="container">

				<!-- SECTION HEADING -->
				<h2 class="section-heading text-center wow fadeIn" data-wow-duration="1s">Contacts</h2>
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center">
						<p class="wow fadeIn" data-wow-duration="2s">Add your contacts here.</p>
					</div>
				</div>

				<div class="inner-wrapper row">
					<div class="col-md-12">

						<form name="frm" id="frm" action="" method="post" class="col-md-6 col-md-offset-3">
							
							<div class="form-group<?= isset($errors['truong_ten']) ? ' has-error' : '' ?>">
								<label for="truong_ten">Tên loại:</label>
								<input type="text" name="truong_ten" class="form-control" maxlen="255" id="truong_ten" placeholder="Enter Name" value="<?= isset($_POST['truong_ten']) ? htmlspecialchars($_POST['truong_ten']) : '' ?>" />

								<?php if (isset($errors['truong_ten'])) : ?>
									<span class="help-block">
										<strong><?= htmlspecialchars($errors['truong_ten']) ?></strong>
									</span>
								<?php endif ?>
							</div>


							<!-- Submit -->
							<button type="submit" name="submit" id="submit" class="btn btn-primary">Add Contact</button>
						</form>

					</div>
				</div>

			</div>
		</section>
	</div>

	<?php include('../partials/footer.php') ?>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?= BASE_URL_PATH . "js/wow.min.js" ?>"></script>
	<script>
		$(document).ready(function() {
			new WOW().init();
		});
	</script>
</body>

</html>