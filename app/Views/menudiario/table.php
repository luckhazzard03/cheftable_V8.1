<div class="table-responsive mx-auto">
	<table class="table table-hover" id="table-index">
		<thead class="table-dark">
			<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Día</th>
				<th scope="col">Descripción</th>
				<th scope="col">Tipo Menú</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php if ($menudiario) : ?>
				<?php foreach ($menudiario as $obj) : ?>
					<tr class="text-center">
						<td>
							<?php echo $obj['idDiario']; ?>
						</td>
						<td>
							<?php echo $obj['Dia']; ?>
						</td>
						<td>
							<?php echo $obj['Descripcion']; ?>
						</td>
						<td>
							<?php echo $obj['Menu']; ?>
						</td>
						

						<td>
							<div class="btn-group" role="group" aria-label="Basic mixed styles example">
								<button type="button" title="Button show User Status" onclick="show(<?php echo $obj['idDiario']; ?>)" class="btn btn-success btn-actions"><i class="bi bi-eye-fill"></i></button>
								<button type="button" title="Button edit User Status" onclick="edit(<?php echo $obj['idDiario']; ?>)" class="btn btn-warning btn-actions"><i class="bi bi-pencil-square" style="color:white"></i></button>
								<button type="button" title="Button delete User Status" onclick="delete_(<?php echo $obj['idDiario']; ?>)" class="btn btn-danger btn-actions"><i class="bi bi-trash-fill"></i></button>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
		<tfoot class="table-dark">
			<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Día</th>
				<th scope="col">Descripción</th>
				<th scope="col">Tipo Menú</th>
				<th scope="col">Actions</th>
			</tr>
		</tfoot>
	</table>
</div>