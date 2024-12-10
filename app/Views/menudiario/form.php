<form id="my-form" class="">
    <input type="hidden" class="form-control" id="idDiario" name="idDiario" value=null>
    <input type="hidden" class="form-control" id="update_at" name="update_at" value=null>

    <div class="form-floating mb-3">
        <select class="form-select" id="Dia" name="Dia" aria-label="Dia" required>
            <option value="">Selecciona el día de la semana</option>
            <option value="Lunes" <?php echo isset($obj['Dia']) && $obj['Dia'] === 'Lunes' ? 'selected' : ''; ?>>Lunes</option>
            <option value="Martes" <?php echo isset($obj['Dia']) && $obj['Dia'] === 'Martes' ? 'selected' : ''; ?>>Martes</option>
            <option value="Miércoles" <?php echo isset($obj['Dia']) && $obj['Dia'] === 'Miércoles' ? 'selected' : ''; ?>>Miércoles</option>
            <option value="Jueves" <?php echo isset($obj['Dia']) && $obj['Dia'] === 'Jueves' ? 'selected' : ''; ?>>Jueves</option>
            <option value="Viernes" <?php echo isset($obj['Dia']) && $obj['Dia'] === 'Viernes' ? 'selected' : ''; ?>>Viernes</option>
            <option value="Sábado" <?php echo isset($obj['Dia']) && $obj['Dia'] === 'Sábado' ? 'selected' : ''; ?>>Sábado</option>
            <option value="Domingo" <?php echo isset($obj['Dia']) && $obj['Dia'] === 'Domingo' ? 'selected' : ''; ?>>Domingo</option>
        </select>
        <label for="Dia">Día</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="Descripcion" name="Descripcion" placeholder="Descripcion" required>
        <label for="Descripcion">Descripcion</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-control" id="Menu_id_fk" name="Menu_id_fk" required>
            <option value="" disabled selected>Seleccione un menú</option>
            <option value="1">Corriente</option>
            <option value="2">Ejecutivo</option>
            <option value="3">Especial</option>
        </select>
        <label for="Menu_id_fk">Menu ID</label>
    </div>
</form>