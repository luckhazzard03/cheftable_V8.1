<form id="my-form" class="">

	<input type="hidden" class="form-control" id="Menu_id" name="Menu_id" value=null>
	<input type="hidden" class="form-control" id="update_at" name="update_at" value=null>
	<div class="form-floating mb-3">
		<select class="form-select" id="Tipo_Menu" name="Tipo_Menu" aria-label="Tipo_Menu" required>
			<option value="">Selecciona la categoría</option>
			<option value="Corriente" <?php echo isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Corriente' ? 'selected' : ''; ?>>Corriente</option>
			<option value="Ejecutivo" <?php echo isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Ejecutivo' ? 'selected' : ''; ?>>Ejecutivo</option>
			<option value="Especial" <?php echo isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Especial' ? 'selected' : ''; ?>>Especial</option>
		</select>
		<label for="Tipo_Menu">Categoría</label>
	</div>

	<div class="form-floating mb-3">
		<input type="text" class="form-control" id="Precio_Menu" name="Precio_Menu" placeholder="Precio" required>
		<label for="Precio_Menu">Precio</label>
	</div>
</form>