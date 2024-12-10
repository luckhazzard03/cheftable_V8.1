<form id="my-form" class="">
    <input type="hidden" class="form-control" id="Comanda_id" name="Comanda_id" value="null">
    <input type="hidden" class="form-control" id="update_at" name="update_at" value="null">

    <div class="form-floating mb-3">
        <input type="date" class="form-control" id="Fecha" name="Fecha" placeholder="Fecha" required>
        <label for="Fecha">Fecha</label>
    </div>

    <div class="form-floating mb-3">
        <input type="time" class="form-control" id="Hora" name="Hora" placeholder="Hora" required>
        <label for="Hora">Hora</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select" id="Total_platos" name="Total_platos" aria-label="Total_platos" required onchange="calculateTotal()">
            <option value="">Selecciona la cantidad de platos</option>
            <!-- Opciones para Total_platos -->
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?= $i ?>" <?= isset($obj['Total_platos']) && $obj['Total_platos'] == $i ? 'selected' : ''; ?>><?= $i ?> Plato<?= $i > 1 ? 's' : '' ?></option>
            <?php endfor; ?>
        </select>
        <label for="Total_platos">Cantidad Platos</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Precio_Total" name="Precio_Total" placeholder="Precio Total" step="0.01" required>
        <label for="Precio_Total">Precio Total</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number" class="form-control" id="Adicionales" name="Adicionales" placeholder="Adicionales" step="0.01" required>
        <label for="Precio_Total">Adicionales</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select" id="Tipo_Menu" name="Tipo_Menu" aria-label="Tipo_Menu" required>
            <option value="">Selecciona el tipo de menú</option>
            <option value="Corriente" <?= isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Corriente' ? 'selected' : ''; ?>>Corriente</option>
            <option value="Ejecutivo" <?= isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Ejecutivo' ? 'selected' : ''; ?>>Ejecutivo</option>
            <option value="Especial" <?= isset($obj['Tipo_Menu']) && $obj['Tipo_Menu'] === 'Especial' ? 'selected' : ''; ?>>Especial</option>
        </select>
        <label for="Tipo_Menu">Tipo Menu</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select" id="idUsuario_fk" name="idUsuario_fk" required>
            <option value="" disabled selected>Seleccione un usuario</option>
            <!-- Opciones para usuarios -->
            <option value="3">Mesero</option>
            <option value="4">Mesero2</option>
            <option value="5">Mesero3</option>
            <option value="6">Mesero4</option>
            <option value="7">Mesero5</option>
            <option value="8">Mesero6</option>
        </select>
        <label for "idUsuario_fk">Rol</label>
    </div>

    <div class="form-floating mb-3">
        <input type="number"
               class ="form-control"
               id ="idMesa_fk"
               name ="idMesa_fk"
               placeholder ="Mesa #"
               required
               value="<?php echo isset($obj['idMesa_fk']) ? $obj['idMesa_fk'] : ''; ?>">
        <label for ="idMesa_fk">Mesa #</label>
    </div>

    <!-- Sección para Adicionales -->
<h5>Adicionales en Comanda (opcional)</h5>

<div class="adicionales-info">
    <p><strong>Opciones Disponibles:</strong></p>
    
    <div class="adicional">
        <span class="adicional-nombre">Porción de Papa</span>
        <span class="adicional-precio">- $4000</span>
    </div>

    <div class="adicional">
        <span class="adicional-nombre">Porción de Proteína</span>
        <span class="adicional-precio">- $6000</span>
    </div>

    <div class="adicional">
        <span class="adicional-nombre">Porción de Arroz</span>
        <span class="adicional-precio">- $3000</span>
    </div>

    <div class="adicional">
        <span class="adicional-nombre">Gaseosa</span>
        <span class="adicional-precio">- $3500</span>
    </div>

    <div class="adicional">
        <span class="adicional-nombre">Jugo Especial</span>
        <span class="adicional-precio">- $7000</span>
    </div>
</div>

</form>