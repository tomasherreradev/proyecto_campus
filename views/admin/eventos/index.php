<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>


<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/eventos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir ponente
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($eventos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr class="table__tr">
                    <th scope="col" class="table__th">Evento</th>
                    <th scope="col" class="table__th">Categoría</th>
                    <th scope="col" class="table__th">Dia y Hora</th>
                    <th scope="col" class="table__th">Ponente</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($eventos as $evento): ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $evento->nombre; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $evento->categoria->nombre; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $evento->dia->nombre . '/ ' .  $evento->hora->hora; ?>
                        </td>

                        
                        <td class="table__td">
                            <?php echo $evento->ponente->nombre . ' ' .  $evento->ponente->apellido; ?>
                        </td>


                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/eventos/editar?id=<?php echo $evento->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>
                            
                            <form class="table__formulario" method="POST" action="/admin/eventos/eliminar">
                                <input type="hidden" name="id" value="<?php echo $evento->id; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


    <?php } else{ ?>
        <p class="text-center">Aún no hay eventos</p>
    <?php } ?>
</div>

    <?php
        echo $paginacion;
    ?>