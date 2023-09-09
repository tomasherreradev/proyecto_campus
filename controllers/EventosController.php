<?php

namespace Controllers;

use Model\Dia;
use MVC\Router;
use Model\Horas;
use Model\Eventos;
use Model\Ponente;
use Model\Categoria;
use Classes\Paginacion;

class EventosController {

    public static function index (Router $router) {
        isAuth();
        if(!isAdmin()) {
            header('Location: /login');
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/eventos?page=1');
        }


        $eventos_por_pagina = 10;
        $total_registros = Eventos::count();

        $paginacion = new Paginacion($pagina_actual, $eventos_por_pagina, $total_registros);
        $eventos = Eventos::paginar($eventos_por_pagina, $paginacion->offset());

        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Horas::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }

        $router->render('/admin/eventos/index', [
            'titulo' => 'Eventos',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }


    public static function crear (Router $router) {
        isAuth();
        if(!isAdmin()) {
            header('Location: /login');
        }
        $alertas = [];

        $categorias = Categoria::all();
        $dias = Dia::all('ASC');
        $horas = Horas::all('ASC');
        $evento = new Eventos();

        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!isAdmin()) {
                header('Location: /login');
            }

            $evento->sincronizar($_POST);
            $alertas = $evento->validar();

            if(empty($alertas)) {
                $resultado = $evento->guardar();

                if($resultado) {
                    header('Location: /admin/eventos');
                }
            }
        }


        $router->render('/admin/eventos/crear', [
            'titulo' => 'Registrar evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }


    public static function editar (Router $router) {
        isAuth();
        if(!isAdmin()) {
            header('Location: /login');
        }
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/eventos');
        }

        $categorias = Categoria::all();
        $dias = Dia::all('ASC');
        $horas = Horas::all('ASC');
        $evento =  Eventos::find($id);

        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!isAdmin()) {
                header('Location: /login');
            }

            $evento->sincronizar($_POST);
            $alertas = $evento->validar();

            if(empty($alertas)) {
                $resultado = $evento->guardar();

                if($resultado) {
                    header('Location: /admin/eventos');
                }
            }
        }


        $router->render('/admin/eventos/editar', [
            'titulo' => 'Editar evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }



    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!isAdmin()) {
                header('Location: /login');
            }


            $evento = Eventos::where('id', $_POST['id']);

            if(!isset($evento)) {
                header('Location: /admin/eventos');
            }

            $resultado = $evento->eliminar();
            if($resultado) {
                header('Location: /admin/eventos');
            }

        }
    }
}