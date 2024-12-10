<div class="table-responsive mx-auto">
	<table class="table table-hover" id="table-index">
		<thead class="table-dark">
		<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Fecha</th>
				<th scope="col">Total Día</th>
				<th scope="col">Total Semana</th>
				<th scope="col">Total Mes</th>
				<th scope="col">Rol</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php if ($cierres) : ?>
				<?php foreach ($cierres as $obj) : ?>
					<tr class="text-center">
						<td>
							<?php echo $obj['idCierre']; ?>
						</td>
						<td>
							<?php echo $obj['Fecha']; ?>
						</td>
						<td>
							<?php echo $obj['Total_Dia']; ?>
						</td>
						<td>
							<?php echo $obj['Total_Semana']; ?>
						</td>
						<td>
							<?php echo $obj['Total_Mes']; ?>
						</td>
						<td>
							<?php echo $obj['Rol']; ?>
						</td>
						<td>
							<div class="btn-group" role="group" aria-label="Basic mixed styles example">
								<button type="button" title="Button show User Status" onclick="show(<?php echo $obj['idCierre']; ?>)" class="btn btn-success btn-actions"><i class="bi bi-eye-fill"></i></button>
								<button type="button" title="Button edit User Status" onclick="edit(<?php echo $obj['idCierre']; ?>)" class="btn btn-warning btn-actions"><i class="bi bi-pencil-square" style="color:white"></i></button>
								<button type="button" title="Button delete User Status" onclick="delete_(<?php echo $obj['idCierre']; ?>)" class="btn btn-danger btn-actions"><i class="bi bi-trash-fill"></i></button>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
		<tfoot class="table-dark">
		<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Fecha</th>
				<th scope="col">Total Día</th>
				<th scope="col">Total Semana</th>
				<th scope="col">Total Mes</th>
				<th scope="col">Rol</th>
				<th scope="col">Actions</th>
			</tr>
		</tfoot>
	</table>
</div>

<!-- Botón para Generar Excel -->
<button type="button" onclick="exportTableToExcel('table-index', 'cierres')" class="btn btn-primary mb-3">
        Generar Excel
    </button>
<!-- Librería SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    function exportTableToExcel(tableID, filename = '') {
        const table = document.getElementById(tableID);
        const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
		filename = filename ? filename + '.xlsx' : 'excel_data.xlsx';
        XLSX.writeFile(workbook, filename);
    }
</script>