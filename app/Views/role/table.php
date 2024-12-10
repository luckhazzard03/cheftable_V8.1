<div class="table-responsive mx-auto">
	<table class="table table-hover" id="table-index">
		<thead class="table-dark">
			<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Rol</th>
				<th scope="col">Descripcion	</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php if ($roles) : ?>
				<?php foreach ($roles as $obj) : ?>
					<tr class="text-center">
						<td>
							<?php echo $obj['idRoles']; ?>
						</td>
						<td>
							<?php echo $obj['Rol']; ?>
						</td>
						<td>
							<?php echo $obj['Descripcion']; ?>
						</td>
						<td>
							<div class="btn-group" role="group" aria-label="Basic mixed styles example">
								<button type="button" title="Button show User Status" onclick="show(<?php echo $obj['idRoles']; ?>)" class="btn btn-success btn-actions"><i class="bi bi-eye-fill"></i></button>
								<button type="button" title="Button edit User Status" onclick="edit(<?php echo $obj['idRoles']; ?>)" class="btn btn-warning btn-actions"><i class="bi bi-pencil-square" style="color:white"></i></button>
								<button type="button" title="Button delete User Status" onclick="delete_(<?php echo $obj['idRoles']; ?>)" class="btn btn-danger btn-actions"><i class="bi bi-trash-fill"></i></button>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
		<tfoot class="table-dark">
		<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Rol</th>
				<th scope="col">Descripcion	</th>
				<th scope="col">Actions</th>
			</tr>
		</tfoot>
	</table>
</div>