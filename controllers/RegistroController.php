<?php

namespace Controllers;
use Model\Dia;
use MVC\Router;
use Model\Horas;
use Model\Regalo;
use Model\Eventos;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\EventosRegistros;

class RegistroController {



    public static function crear (Router $router) {
        if(!isAuth()) {
            header('Location: /');
        }

        //verificar q el usuario haya elegido un plan
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if(isset($registro) && $registro->paquete_id === '3') {
            header('Location: /boleto?id=' . urlencode($registro->token));
        }

        if($registro->paquete_id === '1') {
            header('Location: /finalizar-registro/conferencias');            
        }

        $router->render('/registro/crear', [
            'titulo' => 'Finalizar registro'
        ]);
    }


    
    public static function gratis () {

       if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!isAuth()) {
                header('Location: /login');
            }

            if(isset($registro) && $registro->paquete_id === '3') {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }

            $token = substr(md5(uniqid(rand(), true)), 0 , 8);
            
            //crear registro
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];


            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado) {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }
            
       }
    }

    public static function boleto (Router $router) {

        //verificar que exista el boleto
        $id = $_GET['id'];
        if(!$id || !strlen($id) === 8) {
            header('Location: /');
        }

        $registro = Registro::where('token', $id);
        if(!$registro) {
            header('Location: /');
        }

        //llenar los datos del boleto:
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);



        $router->render('/registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }



    public static function pagar () {
        //vid 783
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
             if(!isAuth()) {
                 header('Location: /login');
             }
             
             if(empty($_POST)){
                echo json_encode([]);
                return;
             }

             //crear registro
             $datos = $_POST;
             $datos['token'] = substr(md5(uniqid(rand(), true)), 0 , 8);
             $datos['usuario_id'] = $_SESSION['id'];

            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
             
        }
     }




     public static function conferencias (Router $router) {

        if(!isAuth()) {
            header('Location: /');
        }

        //validar que le usuario haya adquirido el plan presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);

        if($registro->paquete_id !== '1') {
            header('Location: /');
        }

        //redireccionar en caso de que el usuario ya se haya registrado 
        if(isset($registro->regalo_id)) {
            header('Location: /boleto?id=' . urlencode($registro->token));
        }


        $eventos = Eventos::ordenar('hora_id', 'ASC');
        $eventos_formateados = [];

        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Horas::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            if($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_v'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_s'][] = $evento;
            }

            if($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_v'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_s'][] = $evento;
            }
        }

        $regalos = Regalo::all('ASC');


        //manejar el registro con post
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Revisar q el usuario esté autenticado
            if(!isAuth()) {
                header('Location: /');
            }

            $eventos = explode(',', $_POST['eventos']);
            if(empty($eventos)) {
                echo json_encode(['resultado' => false]);
                return;
            }

            //obtener el registro del usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(!isset($registro) || $registro->paquete_id !== '1') {
                echo json_encode(['resultado' => false]);
                return;
            }


            $eventos_array = [];
            //validar la cantidad de lugares de los eventos seleccionados
            foreach($eventos as $evento_id) {
                $evento = Eventos::find($evento_id);

                //comprobar que el evento exista
                if(!isset($evento) || $evento->disponibles === '0') {
                    echo json_encode(['resultado' => false]);
                    return;
                }

                $eventos_array[] = $evento;
            }

            //otro foreach para comprobar los lugares disponibles
            foreach($eventos_array as $evento) {
                //restar lugares al evento
                $evento->disponibles -= 1;
                $evento->guardar();
                
                //almacenar el registro
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                $registro_eventos = new EventosRegistros($datos);
                $registro_eventos->guardar();
            }

            //almacenar un regalo por registro
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();

            if($resultado) {
                echo json_encode([
                    'resultado' => true,
                    'token' => $registro->token
                ]);
            } else {
                echo json_encode(['resultado' => false]);
            }

            return;
        }


        $router->render('/registro/conferencias', [
            'titulo' => 'Elige tus Workshops Y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos
        ]);
    }



}