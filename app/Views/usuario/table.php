<div class="cards">
	<div class="card-single">
		<div>
			<h2>ADMIN</h2>
			<span>ROL ID</span>
			<h1>1</h1>
		</div>
		<div>
			<i class="fa-solid fa-upload" style="color: #141b2f;"></i>
		</div>
	</div>

	<div class="card-single">
		<div>
			<h2>CHEF</h2>
			<span>ROL ID</span>
			<h1>2</h1>
		</div>
		<div>
			<i class="fa-solid fa-arrow-down" style="color: #141b2f;"></i>
		</div>
	</div>

	<div class="card-single">
		<div>
			<h1>MESERO</h1>
			<span>ROL ID</span>
			<h1>3</h1>

		</div>
		<div>
			<i class="fa-solid fa-bars-progress" style="color: #141b2f;"></i>
		</div>
	</div>

</div>

</div>

<div class="table-responsive mx-auto">
	<table class="table table-hover" id="table-index">
		<thead class="table-dark">
			<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Nombre</th>
				
				<th scope="col">Email</th>
				<th scope="col">Telefono</th>
				<th scope="col">Rol</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php if ($usuario) : ?>
				<?php foreach ($usuario as $obj) : ?>
					<tr class="text-center">
						<td>
							<?php echo $obj['idUsuario']; ?>
						</td>
						<td>
							<?php echo $obj['Nombre']; ?>
						</td>
						
						<td>
							<?php echo $obj['Email']; ?>
						</td>
						<td>
							<?php echo $obj['Telefono']; ?>
						</td>
						<td>
							<?php echo $obj['Rol']; ?>
						</td>


						<td>
							<div class="btn-group" role="group" aria-label="Basic mixed styles example">
								<button type="button" title="Button show User Status" onclick="show(<?php echo $obj['idUsuario']; ?>)" class="btn btn-success btn-actions"><i class="bi bi-eye-fill"></i></button>
								<button type="button" title="Button edit User Status" onclick="edit(<?php echo $obj['idUsuario']; ?>)" class="btn btn-warning btn-actions"><i class="bi bi-pencil-square" style="color:white"></i></button>
								<button type="button" title="Button delete User Status" onclick="delete_(<?php echo $obj['idUsuario']; ?>)" class="btn btn-danger btn-actions"><i class="bi bi-trash-fill"></i></button>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
		<tfoot class="table-dark">
			<tr class="text-center">
				<th scope="col">#</th>
				<th scope="col">Nombre</th>
				
				<th scope="col">Email</th>
				<th scope="col">Telefono</th>
				<th scope="col">Rol</th>
				<th scope="col">Actions</th>
			</tr>
		</tfoot>
	</table>
</div>