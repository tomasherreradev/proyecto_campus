<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">Elige tu plan</p>

    
    <div class="paquetes__grid">
        <div data-aos="<?php aosAnimation(); ?>" class="paquete">
            <h3 class="paquete__nombre">Pase gratuito</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento"> Acceso virtual a DevWebCamp</li>
            </ul>

            <p class="paquete__precio">$0</p>

            <form action="/finalizar-registro/gratis" method="POST">
                <input type="submit" class="paquetes__submit" value="Inscripción gratis">
            </form>
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

            
            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>

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



<!-- paypal -->
<script src="https://www.paypal.com/sdk/js?client-id=Aa9T-chgTk1U3YKFNNMrpWBGGpIonralOgHQeY3Vuva79xi6bvK1lBzw3LjxlgsgyAEC9ROBswzG7wTk&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
 
<script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":199}}]
          });
        },
 
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
 
            const datos = new FormData();
            datos.append('paquete_id', orderData.purchase_units[0].description);
            datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);
            
            fetch('/finalizar-registro/pagar', {
              method: 'POST',
              body: datos
            })
            .then( respuesta => respuesta.json())
            .then( resultado => {
                if(resultado.resultado) {
                  actions.redirect('http://localhost:3000/finalizar-registro/conferencias');
                }
              });


          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
 
  initPayPalButton();
</script>