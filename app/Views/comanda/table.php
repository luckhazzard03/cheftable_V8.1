<div class="table-responsive mx-auto">
    <table class="table table-hover" id="table-index">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Total Platos</th>
                <th scope="col">Precio Total</th>
                <th scope="col">Tipo Menu</th>
                <th scope="col">Adicionales</th>
                <th scope="col">Rol</th>
                <th scope="col">Mesa</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($comanda) : ?>
                <?php foreach ($comanda as $obj) : ?>
                    <tr class="text-center">
                        <td><?php echo $obj['Comanda_id']; ?></td>
                        <td><?php echo $obj['Fecha']; ?></td>
                        <td><?php echo $obj['Hora']; ?></td>
                        <td><?php echo $obj['Total_platos']; ?></td>
                        <td><?php echo $obj['Precio_Total']; ?></td>
                        <td><?php echo $obj['Tipo_Menu']; ?></td>
                        <td><?php echo $obj['Adicionales']; ?></td>
                        <td><?php echo $obj['Rol']; ?></td>
                        <td><?php echo $obj['idMesa_fk']; ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" title="Button show User Status" onclick="show(<?php echo $obj['Comanda_id']; ?>)" class="btn btn-success btn-actions"><i class="bi bi-eye-fill"></i></button>
                                <button type="button" title="Button edit User Status" onclick="edit(<?php echo $obj['Comanda_id']; ?>)" class="btn btn-warning btn-actions"><i class="bi bi-pencil-square" style="color:white"></i></button>
                                <button type="button" title="Button delete User Status" onclick="delete_(<?php echo $obj['Comanda_id']; ?>)" class="btn btn-danger btn-actions"><i class="bi bi-trash-fill"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
        <tfoot class="table-dark">
            <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Total Platos</th>
                <th scope="col">Precio Total</th>
                <th scope="col">Tipo Menu</th>
                <th scope="col">Adicionales</th>
                <th scope="col">Rol</th>
                <th scope="col">Mesa</th>
                <th scope="col">Actions</th>
            </tr>
        </tfoot>
    </table>
</div>


<!-- Botón para Generar Excel -->
<button type="button" onclick="exportTableToExcel('table-index', 'comanda')" class="btn btn-primary mb-3">
        Generar Excel
    </button>
<!-- Librería SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    function exportTableToExcel(tableID, filename = '') {
        const table = document.getElementById(tableID);
        const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
		filename = filename ? filename + '.xlsx' : 'excel_data.xlsx';
        XLSX.writeFile(workbook, filename);
    }
</script>