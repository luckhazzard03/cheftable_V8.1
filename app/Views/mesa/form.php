<form id="my-form" class="">

    <input type="hidden" class="form-control" id="idMesa" name="idMesa" value=null>
    <input type="hidden" class="form-control" id="update_at" name="update_at" value=null>
    
    
    <div class="form-floating mb-3">
        <select class="form-control" id="Estado" name="Estado" required>
            <option value="" disabled selected>Seleccione un estado</option>
            <option value="Ocupado">Ocupado</option>
            <option value="Disponible">Disponible</option>
        </select>
        <label for="Estado">Estado</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Capacidad" name="Capacidad" placeholder="Capacidad" required>
        <label for="Capacidad">Capacidad</label>
    </div>
    
</form>
