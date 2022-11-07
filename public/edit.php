<?php
include "../bootstrap.php";
include "../src/Contact.php";


use CT275\Labs\Contact;
use CT275\Labs\phuong_xa;


$contact = new phuong_xa($PDO); 
$id = isset($_REQUEST['id']) ?
	filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
	echo $id;
if ($id < 0 || !($contact->find($id))) {
	redirect(BASE_URL_PATH);
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($contact->update($_POST)) {
		// Cập nhật dữ liệu thành công
		redirect(BASE_URL_PATH);
	}
	// Cập nhật dữ liệu không thành công
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
						<p class="wow fadeIn" data-wow-duration="2s">Update your contacts here.</p>
					</div>
				</div>

				<div class="inner-wrapper row">
					<div class="col-md-12">

						<form name="frm" id="frm" action="" method="post" class="col-md-6 col-md-offset-3">

							<input type="hidden" name="id" value="<?= htmlspecialchars($contact->getId()) ?>">

							<!-- Name -->
							<div class="form-group<?= isset($errors['px_ten']) ? ' has-error' : '' ?>">
								<label for="px_ten">Name</label>
								<input type="text" name="px_ten" class="form-control" maxlen="255" id="px_ten" placeholder="Enter Name" value="<?= htmlspecialchars($contact->px_ten) ?>" />

								<?php if (isset($errors['px_ten'])) : ?>
									<span class="help-block">
										<strong><?= htmlspecialchars($errors['px_ten']) ?></strong>
									</span>
								<?php endif ?>
							</div>
							<div class="form-group<?= isset($errors['qh_id']) ? ' has-error' : '' ?>">
								<label for="qh_id">Name</label>
								<input type="text" name="qh_id" class="form-control" maxlen="255" id="qh_id" placeholder="Enter Name" value="<?= htmlspecialchars($contact->qh_id) ?>" />

								<?php if (isset($errors['qh_id'])) : ?>
									<span class="help-block">
										<strong><?= htmlspecialchars($errors['qh_id']) ?></strong>
									</span>
								<?php endif ?>
							</div>

							
							

							<!-- Submit -->
							<button type="submit" name="submit" id="submit" class="btn btn-primary">Update Contact</button>
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