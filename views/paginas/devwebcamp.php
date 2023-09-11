<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>
    <p class="devwebcamp__descripcion">Conoce la conferencia más importante de Latinoamérica</p>

    <div class="devwebcamp__grid">
        <div data-aos="<?php aosAnimation(); ?>" class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img src="build/img/sobre_devwebcamp.jpg" loading="lazy" alt="sobre devwebcamp" width="200" height="300">
            </picture>
        </div>

        <div class="devwebcamp__contenido">
            <p data-aos="<?php aosAnimation(); ?>" class="devwebcamp__texto">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Tortor aliquam nulla facilisi cras.  Urna et pharetra pharetra massa massa ultricies mi quis. Velit dignissim sodales ut eu. Egestas fringilla phasellus faucibus scelerisque eleifend. Egestas purus viverra accumsan in nisl nisi.
            </p>

            <p data-aos="<?php aosAnimation(); ?>" class="devwebcamp__texto">
                Donec massa sapien faucibus et molestie ac feugiat sed. Tempus urna et pharetra pharetra massa massa ultricies mi quis. Et malesuada fames ac turpis egestas integer eget.Sit amet volutpat consequat mauris nunc congue nisi vitae suscipit. Bibendum at varius vel pharetra vel turpis nunc. Id diam vel quam elementum pulvinar etiam non quam.
            </p>
        </div>
    </div>
</main>