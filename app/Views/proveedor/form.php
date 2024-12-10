<form id="my-form" class="">

    <input type="hidden" class="form-control" id="idProveedor" name="idProveedor" value=null>
    <input type="hidden" class="form-control" id="update_at" name="update_at" value=null>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Nombre" required>
        <label for="Nombre">Nombre</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="Direccion" name="Direccion" placeholder="Dirección" required>
        <label for="Direccion">Dirección</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Telefono" name="Telefono" placeholder="Telefono" required>
        <label for="Telefono">Telefono</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select" id="Tipo" name="Tipo" aria-label="Tipo" required>
            <option value="">Selecciona el tipo</option>
            <option value="Cárnicos" <?php echo isset($obj['Tipo']) && $obj['Tipo'] === 'Cárnicos' ? 'selected' : ''; ?>>Cárnicos</option>
            <option value="Lácteos" <?php echo isset($obj['Tipo']) && $obj['Tipo'] === 'Lácteos' ? 'selected' : ''; ?>>Lácteos</option>
            <option value="Legumbres" <?php echo isset($obj['Tipo']) && $obj['Tipo'] === 'Legumbres' ? 'selected' : ''; ?>>Legumbres</option>
            <option value="Granos" <?php echo isset($obj['Tipo']) && $obj['Tipo'] === 'Granos' ? 'selected' : ''; ?>>Granos</option>
            <option value="Aseo" <?php echo isset($obj['Tipo']) && $obj['Tipo'] === 'Aseo' ? 'selected' : ''; ?>>Aseo</option>
        </select>
        <label for="Tipo">Tipo</label>
    </div>



    <div class="form-floating mb-3">
        <select class="form-control" id="idUsuario_fk" name="idUsuario_fk" required>
            <option value="" disabled selected>Seleccione un usuario</option>
            <option value="1">Admin</option>
            <option value="2">Cheft</option>
            
        </select>
        <label for="idUsuario_fk">Rol</label>
    </div>

</form>