<form id="my-form" class="">
    <input type="hidden" class="form-control" id="idUsuario" name="idUsuario" value=null>
    <input type="hidden" class="form-control" id="update_at" name="update_at" value=null>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Name" required>
        <label for="Nombre">Nombre</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="Password" name="Password" placeholder="Password" required>
        <label for="Password">Password</label>
    </div>

    <div class="form-floating mb-3">
        <input type="email" class="form-control" id="Email" name="Email" placeholder="Email" required>
        <label for="Email">Email</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Telefono" name="Telefono" placeholder="Telefono" required>
        <label for="Telefono">Telefono</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-control" id="idRoles_fk" name="idRoles_fk" required>
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
        <label for="idRoles_fk">Roles</label>
    </div>
</form>
