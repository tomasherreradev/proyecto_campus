<?php

namespace Controllers;

use Model\Dia;
use MVC\Router;
use Model\Horas;
use Model\Eventos;
use Model\Ponente;
use Model\Categoria;

class PaginasController {


    public static function index (Router $router) {

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


        //obtener el total para cada bloque en la parte de resumen
        $ponentes_total = Ponente::count();
        $conferencias_total = Eventos::count('categoria_id', 1);
        $workshops_total = Eventos::count('categoria_id', 2);

        //todos los ponentes
        $ponentes = Ponente::all();


        $router->render('/paginas/index', [
            'titulo' => 'Home',
            'eventos' => $eventos_formateados,
            'ponentes_total' => $ponentes_total,
            'conferencias_total' => $conferencias_total,
            'workshops_total' => $workshops_total,
            'ponentes' => $ponentes
        ]);
    }


    public static function evento (Router $router) {

        $router->render('/paginas/devwebcamp', [
            'titulo' => 'Sobre nosotros'
        ]);
    }

    public static function paquetes (Router $router) {

        $router->render('/paginas/paquetes', [
            'titulo' => 'Paquetes WebDevCamp'
        ]);
    }


    public static function conferencias (Router $router) {

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


        $router->render('/paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateados
        ]);
    }


    public static function errorNotFound (Router $router) {

      

        $router->render('/paginas/error', [
            'titulo' => 'Pagina no encontrada'
        ]);
    }


}