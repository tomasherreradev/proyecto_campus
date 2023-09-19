//importar librerias 
import Swal from "sweetalert2";


(function(){
    let eventos = [];
    const resumen = document.querySelector('#registro__resumen');

    if(resumen){
        const eventosBoton = document.querySelectorAll('.evento__agregar');
        eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));
        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit', enviarFormulario);


        mostrarEventos(); //se manda a llamar temprano, para que detecte que no hay eventos y salte el mensaje de la linea 69


        function seleccionarEvento(e) {

            if(eventos.length < 5) {
                eventos = [...eventos, {
                    id: e.target.dataset.id,
                    titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }]
        
                //deshabilitar el evento para que el usuario no lo seleccione multiples veces
                e.target.disabled = true;
                mostrarEventos();
            } else {
                Swal.fire({
                    title:'Error',
                    text:'Máximo de 5 eventos.',
                    icon:'error',
                    confirmButtonText: 'Ok'
                })
            }

        }


        function mostrarEventos() {
            //reinicia el html para que no se repitan los eventos
            limpiarEventos()

            if(eventos.length > 0) {
                eventos.forEach(evento =>{
                    const eventoDOM = document.createElement('DIV')
                    eventoDOM.classList.add('registro__evento')

                    const titulo = document.createElement('H3')
                    titulo.classList.add('registro__nombre')
                    titulo.textContent = evento.titulo

                    const botonEliminar = document.createElement('BUTTON')
                    botonEliminar.classList.add('registro__eliminar')
                    botonEliminar.innerHTML = '<i class="fa-solid fa-trash"></i>'
                    botonEliminar.onclick = function() {
                        eliminarEvento(evento.id)
                    }

                    //mostrar en html
                    eventoDOM.appendChild(titulo)
                    eventoDOM.appendChild(botonEliminar)
                    resumen.appendChild(eventoDOM)
                })
            } else {
                const noRegistro = document.createElement('P');
                noRegistro.textContent = 'Añade hasta 5 eventos desde la izquierda.';
                noRegistro.classList.add('registro__texto');
                
                resumen.append(noRegistro);
            }
        }

        function eliminarEvento(id) {
            eventos = eventos.filter( evento => evento.id !== id);
            const botonAgregar = document.querySelector(`[data-id="${id}"]`)
            botonAgregar.disabled = false
            mostrarEventos();
        }



        async function enviarFormulario(e) {
            e.preventDefault();

            //obtener regalo
            const regaloId = document.querySelector('#regalo').value
            const eventosId = eventos.map(evento => evento.id)

            if(eventosId.length === 0 || regaloId === '') {
                Swal.fire({
                    title:'Error',
                    text:'Asegúrate de seleccionar al menos un evento y un regalo.',
                    icon:'error',
                    confirmButtonText: 'Ok'
                })
                return;
            }


            //objeto de formdata()
            const datos = new FormData();
            datos.append('eventos', eventosId),
            datos.append('regalo_id', regaloId)

            const url = '/finalizar-registro/conferencias';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            if(resultado.resultado) {
                Swal.fire(
                    'Registro Correcto',
                    'Tus eventos se han almacenado, te esperamos en DevWebCamp.',
                    'success'
                ).then( ()=> location.href = `/boleto?id=${resultado.token}` );
            } else {
                Swal.fire({
                    title:'Error',
                    text:'Ha ocurrido un error, por favor intenta de nuevo.',
                    icon:'error',
                    confirmButtonText: 'Ok'
                }).then ( ()=> location.reload() );
            }
        }


        function limpiarEventos() {
            while(resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }
    }
})();