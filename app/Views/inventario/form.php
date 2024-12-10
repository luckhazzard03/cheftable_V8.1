<form id="my-form" class="">
    <input type="hidden" class="form-control" id="idInventario" name="idInventario" value=null>
    <input type="hidden" class="form-control" id="update_at" name="update_at" value=null>
    
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="Producto" name="Producto" placeholder="Producto" required>
        <label for="Producto">Producto</label>
    </div>
    
    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Cantidad" name="Cantidad" placeholder="Cantidad" required>
        <label for="Cantidad">Cantidad</label>
    </div>
    
    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Cantidad_Minima" name="Cantidad_Minima" placeholder="Cantidad Mínima" required>
        <label for="Cantidad_Minima">Cantidad Mínima</label>
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
