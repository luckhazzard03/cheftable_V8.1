<form id="my-form" class="">

	<input type="hidden" class="form-control" id="idRoles" name="idRoles" value="">
	<input type="hidden" class="form-control" id="update_at" name="update_at" value="">
	<div class="form-floating mb-3">
        <select class="form-control" id="Rol" name="Rol" required>
            <option value="" disabled selected>Select role</option>
            <option value="1">Admin</option>
            <option value="2">Chef</option>
            <option value="3">Mesero</option>
            <option value="4">Mesero2</option>
            <option value="5">Mesero3</option>
            <option value="6">Mesero4</option>
            <option value="7">Mesero5</option>
            <option value="8">Mesero6</option>
        </select>
        <label for="Rol">Roles</label>
    </div>

	<div class="form-floating mb-3">
		<input type="text" class="form-control" id="Descripcion" name="Descripcion" required>
		<label for="Descripcion">Descripcion</label>
	</div>
</form>