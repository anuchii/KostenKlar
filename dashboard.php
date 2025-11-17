<!DOCTYPE html>
<!--weil die Seite auf Deutsch ist für den User, das hilft dem Browser für zb. die Autokorrektur-->
<html lang="de">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
	<div class="container-fluid">

		<!--row" style="height: 100vh-->
		<div class="row min-vh-100">

			<?php include 'sidebar.php'; ?>

			<div class="col-12 col-lg-10 p-0">
				<?php include 'header.php'; ?>

				<header class="py-4 border-bottom p-3">
					<h2>Willkommen, Benutzer!</h2>
				</header>

				<section class="py-4 p-3">
					<h4>Buchungsübersicht</h4>
				</section>
				<!--Monat-Jahr Auswahl-->
				<div class="row g-2">
					<div class="col-auto p-3">
						<select class="form-select" id="month" name="month" style="width: auto;">
							<option value="">Monat auswählen …</option>
							<option value="01">Januar </option>
							<option value="02">Februar </option>
							<option value="03">März </option>
							<option value="04">April </option>
							<option value="05">Mai </option>
							<option value="06">Juni </option>
							<option value="07">Juli </option>
							<option value="08">August </option>
							<option value="09">September </option>
							<option value="10">Oktober </option>
							<option value="11">November </option>
							<option value="12">Dezember </option>
						</select>
					</div>
					<div class="col-auto p-3">
						<select class="form-select" id="year" name="year">
							<option value="">Jahr wählen</option>
							<?php
							$currentYear = date("Y");
							for ($i = $currentYear; $i >= $currentYear - 3; $i--) {
								echo "<option value='$i'>$i</option>";
							}
							?>
						</select>
					</div>
				</div>

				<!--Tabelle: Buchungsübersicht-->
				<div class="mb-3 p-3 mx-auto">
					<table class="table table-hover ">
						<thead class="table-light">
							<tr>
								<th scope="col">Datum</th>
								<th scope="col">Bezeichnung</th>
								<th scope="col">Betrag</th>
								<th scope="col">Kategorie</th>
								<th scope="col">Notiz</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>30.10.2025</td>
								<td>Gehalt</td>
								<td class="text-success fw-semibold">1545,00</td>
								<td>Gehalt</td>
								<td>Oktober 2025</td>
							</tr>
							<tr>
								<td>30.10.2025</td>
								<td>Einkauf</td>
								<td class="text-danger fw-semibold">-22,54</td>
								<td>Lebensmittel</td>
								<td>Billa</td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- Button trigger modal -->
				<div class="mb-3 p-3">
					<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#new-modal">
						<i class="bi bi-plus-circle text-black"></i>
					</button>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="new-modal" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h1 class="modal-title fs-5" id="exampleModalLabel">Neue Buchung</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
							</div>
							<div class="modal-body">
								<form>
									<div class="mb-3">
										<label for="transaction-date" class="col-form-label">Datum</label>
										<input type="date" class="form-control" id="transaction-date">
									</div>
									<div class="mb-3">
										<label for="transaction-title" class="col-form-label">Bezeichnung</label>
										<input type="text" class="form-control" id="transaction-title"></textarea>
									</div>
									<div class="mb-3">
										<label for="transaction-amount" class="col-form-label">Betrag</label>
										<input type="number" class="form-control" id="transaction-amount" step="0.01" min="0" placeholder="0,00"></textarea>
									</div>

									<div class="mb-3">
										<label for="transaction-note" class="col-form-label">Notiz</label>
										<textarea class="form-control" id="transaction-note"></textarea>
									</div>

									<div class="mb-3">
										<div class="form-group">
											<label for="category" class="col-form-label">Kategorie</label>
											<select class="form-select" id="category">
												<option>Lebensmittel</option>
												<option>Mobilität</option>
												<option>Haushalt</option>
												<option>Wohnen</option>
											</select>
										</div>
									</div>

									<div class="mb-3">
										<label class="form-label">Buchungstyp</label>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="transaction-type" id="expense" value="option1" checked>
											<label class="form-check-label" for="expense">Ausgabe</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="transaction-type" id="income" value="option2">
											<label class="form-check-label" for="income">Einnahme</label>
										</div>

									</div>

								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
								<button type="button" class="btn btn-secondary">Speichern</button>
							</div>
						</div>
					</div>
				</div>
				<!--Zusammenfassung: Gesamntübersicht-->
				<section class="py-3 p-3">
					<h4>Gesamtübersicht</h4>
				</section>
				<div class="d-sm-flex flex-sm-row gap-3">
					<div class="my-3 p-3">
						<div class="card pd-3" style="width: 18rem;">
							<div class="card-body">
								<h6 class="card-subtitle mb-2 text-body-secondary text-success fw-semibold">Einnahmen</h5>
									<h5 class="card-title text-success">EUR 1545,00
								</h6>
							</div>
						</div>
					</div>
					<div class="my-3 p-3">
						<div class="card " style="width: 18rem;">
							<div class="card-body">
								<h6 class="card-subtitle mb-2 text-body-secondary text-danger fw-semibold">Ausgaben</h5>
									<h5 class="card-title text-danger">EUR 22,54
								</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.php'; ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>