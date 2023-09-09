(function() {
    const horas = document.querySelector('#horas');
    if(horas) {

        const categoria_id = document.querySelector('[name="categoria_id"]');
        const dias = document.querySelectorAll('[name="dia"]');
        const inputHiddenDia = document.querySelector('#inputHiddenDia');
        const inputHiddenHora = document.querySelector('#inputHiddenHora');

        categoria_id.addEventListener('change', terminoBusqueda);
        dias.forEach(dia => {
            dia.addEventListener('change', terminoBusqueda);
        })


        let busqueda = {
            categoria_id: +categoria_id.value || '',
            dia: +inputHiddenDia.value || ''
        }

        
        if(!Object.values(busqueda).includes('')) {

            async function editarHoras() {
                await buscarEventos();

                //resaltar la hora que pertenece a un evento en editar
                const id = inputHiddenHora.value;
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);
    
                horaSeleccionada.classList.remove('horas__hora--deshabilitada');
                horaSeleccionada.classList.add('horas__hora--seleccionada');

                horaSeleccionada.onclick = seleccionarHora;
            }

            editarHoras();
        }



        function terminoBusqueda(e) {
            busqueda[e.target.name] = e.target.value;

            //reiniciar los campos ocultas y el selector de horas
            inputHiddenHora.value = '';
            inputHiddenDia.value = '';
            const horaSeleccionada = document.querySelector('.horas__hora--seleccionada');
            if(horaSeleccionada) {
                horaSeleccionada.classList.remove('horas__hora--seleccionada');
            }


            if(Object.values(busqueda).includes('')) {
                return;
            }

            buscarEventos();
        }



        async function buscarEventos() {
            const { dia, categoria_id} = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;

            const resultado = await fetch(url);
            const eventos = await resultado.json();


            obtenerHorasDisponibles(eventos);

        }


        function obtenerHorasDisponibles(eventos) {
            //reiniciar la clase de horas
            const listadoHoras = document.querySelectorAll('#horas li'); //listadoHoras no es un arreglo, es un NodeList. Porlo que no se puede usar filter
            listadoHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'));

            //comprobar dias y horas ya ocupadas
            const horasTomadas = eventos.map(evento => evento.hora_id);
   
            const listadoHorasArray = Array.from(listadoHoras);

            //ahora si se puede usar filter:
            const resultados = listadoHorasArray.filter( li => !horasTomadas.includes(li.dataset.horaId));
            resultados.forEach(li => {
                li.classList.remove('horas__hora--deshabilitada');
            })

            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
            horasDisponibles.forEach(hora => hora.addEventListener('click', seleccionarHora));
        }

        function seleccionarHora(e) {
            //evitar que el usuario pueda seleccionar multiples horas (en el caso de los estilos)
            const horaSeleccionada = document.querySelector('.horas__hora--seleccionada');
            if(horaSeleccionada) {
                horaSeleccionada.classList.remove('horas__hora--seleccionada');
            }


            //agregar clase de seleccionado
            e.target.classList.toggle('horas__hora--seleccionada');
            inputHiddenHora.value = e.target.dataset.horaId;

            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        }
    }
})();