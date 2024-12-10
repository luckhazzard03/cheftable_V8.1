<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--CSS-->
	<?php require_once('../app/Views/assets/css/css.php') ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<!--Title-->
	<title><?= $title ?></title>
</head>

<body>
	<main>
	<!--Preload-->
	<?php require_once('../app/Views/preload/preload.php') ?>
	<!-- END Preload-->
	<!--navBar-->
	<?php require_once('../app/Views/nav/navbar.php') ?>
	<!-- END NavBar-->

	<!--container-->
	<div class="container-fluid">
		<div class="row">
			<!--navBar Slider-->
			<?php require_once('../app/Views/navSlider/navSlider.php') ?>
			<!-- END NavBar Slider-->
			<div class="col">
				<h3><?= $title ?></h3>
				<button type="button" class="btn btn-primary btn-actions" title="Button new User Status" onclick="add()" style="font-size: 0.5rem;"><i class="bi bi-plus-circle-fill"></i></button>
				<!--Container Table-->
				<?php require_once('../app/Views/comanda/table.php') ?>
				<!--END container Table-->
			</div>
		</div>
	</div>
	<!--END container-->
	<!--FOOTER-->
	<?php require_once('../app/Views/footer/footer.php') ?>
	<!--END FOOTER-->


	<!--MODAL-->
	<div class="modal fade" id="my-modal" tabindex="-1" aria-labelledby="my-modalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="my-modalLabel"><?= $title ?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<!--FORM-->
					<?php require_once('../app/Views/comanda/form.php') ?>
					<!--END FORM-->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" form="my-form" id="btnSubmit" class="btn btn-primary">Send Data</button>
				</div>
			</div>
		</div>
	</div>
	<!--END MODAL-->


	<!--JS BOOTSTRAP-->
	<?php require_once('../app/Views/assets/js/js.php') ?>
	<?php require_once('../app/Views/assets/js/dataTable.php') ?>
	
	<!--JS CONTROLLER-->
	<script src="../controllers/comanda/comanda.js"></script>
	</main>
</body>

</html>