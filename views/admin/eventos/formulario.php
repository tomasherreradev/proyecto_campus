<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Evento</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input 
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre del Evento"
            value="<?php echo $evento->nombre ?>"
            >
    </div>


    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea 
            class="formulario__input"
            id="descripcion"
            name="descripcion"
            placeholder="Descripcion del Evento"
            rows="9"
            ><?php echo $evento->descripcion ?></textarea>
    </div>

    <div class="formulario__campo">
        <label for="categorias" class="formulario__label">Categorías</label>
        <select 
            id="categorias" 
            class="formulario__select" 
            name="categoria_id"
            >
                <option selected value="">Seleccionar</option>
                <?php foreach($categorias as $categoria): ?>
                    <option <?php echo ($evento->categoria_id === $categoria->id) ?'selected' :'' ?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
                <?php endforeach; ?>
        </select>
    </div>


    <div class="formulario__campo">
        <label for="" class="formulario__label">Seleccionar dia</label>
        <div class="formulario__radio">
            <?php foreach($dias as $dia): ?>
                <div>
                    <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre; ?></label>
                    <input 
                        type="radio"
                        id="<?php echo strtolower($dia->nombre); ?>"
                        name="dia"
                        value="<?php echo $dia->id; ?>"
                        <?php echo ($evento->dia_id === $dia->id) ? 'checked' : ''; ?>
                        >
                </div>
            <?php endforeach; ?>
        </div>            
            <input id="inputHiddenDia" type="hidden" name="dia_id" value="<?php echo $evento->dia_id; ?>">
    </div>


    <div class="formulario__campo" id="horas">
        <label for="" class="formulario__label">Seleccionar hora</label>

        <ul id="horas" class="horas">
                <?php foreach($horas as $hora): ?>
                    <li data-hora-id="<?php echo $hora->id; ?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora; ?></li>
                <?php endforeach ?>
        </ul>

        <input id="inputHiddenHora" type="hidden" name="hora_id" value="<?php echo $evento->hora_id; ?>">
    </div>
</fieldset>


<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información extra</legend>

    
    <div class="formulario__campo">
        <label for="ponentes" class="formulario__label">Ponentes</label>
        <input 
            type="text"
            class="formulario__input"
            id="ponentes"
            placeholder="Buscar ponente"
            >

        <ul id="listado-ponentes" class="listado-ponentes">
            <!-- codigo de js -->
        </ul>


        <input type="hidden" name="ponente_id" value="<?php echo $evento->ponente_id; ?>">
    </div>


    <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Lugares disponibles</label>
        <input 
            type="number"
            min="1"
            class="formulario__input"
            id="disponibles"
            name="disponibles"
            placeholder="Ej: 20"
            value="<?php echo $evento->disponibles; ?>"
            >
    </div>
</fieldset>