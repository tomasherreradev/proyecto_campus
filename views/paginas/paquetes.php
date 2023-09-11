<main class="paquetes">
    <h2 class="paquetes__heading">
        <?php echo $titulo; ?>
    </h2>

    <p class="paquetes__descripcion">Compara los paquetes de DevWebCamp</p>


    <div class="paquetes__grid">
        <div data-aos="<?php aosAnimation(); ?>" class="paquete">
            <h3 class="paquete__nombre">Pase gratuito</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento"> Acceso virtual a DevWebCamp</li>
            </ul>

            <p class="paquete__precio">$0</p>
        </div>

        <div data-aos="<?php aosAnimation(); ?>" class="paquete">
            <h3 class="paquete__nombre">Pase presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento"> Acceso presencial a DevWebCamp</li>
                <li class="paquete__elemento"> Pase por 2 días</li>
                <li class="paquete__elemento"> Acceso a talleres y conferencias</li>
                <li class="paquete__elemento"> Acceso a las grabaciones</li>
                <li class="paquete__elemento"> Remera del evento</li>
                <li class="paquete__elemento"> Comida y bedida</li>
            </ul>

            <p class="paquete__precio">$199</p>
        </div>

        <div data-aos="<?php aosAnimation(); ?>" class="paquete">
            <h3 class="paquete__nombre">Pase virtual</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento"> Acceso virtual a DevWebCamp</li>
                <li class="paquete__elemento"> Pase por 2 días</li>
                <li class="paquete__elemento"> Acceso a talleres y conferencias</li>
                <li class="paquete__elemento"> Acceso a las grabaciones</li>
            </ul>

            <p class="paquete__precio">$49</p>
        </div>
    </div>
</main>