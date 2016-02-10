<?php

APP::uses('AppController', 'Controller');

/**
 * Created by PhpStorm.
 * User: Dany
 * Date: 25/01/2016
 * Time: 11:27 PM
 */

class HomeController extends AppController
{
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add', 'logout');
    }

    public function index()
    {
    }

    public function encriptacion($mensaje)
    {
        $encriptado = parent::encriptar($mensaje);
        $informacion = array(
            'original' => $mensaje,
            'encriptado' => $encriptado
        );
        $this->set($informacion);
    }

    public  function desencriptar($encriptado)
    {
        $original = parent::desencriptar($encriptado);
        $informacion = array(
            'encriptado' => $encriptado,
            'desencriptado' => $original
        );
        $this->set($informacion);
    }
}