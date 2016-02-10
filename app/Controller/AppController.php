<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    //public $components = array('DebugKit.Toolbar');

    public $components = array(
        'DebugKit.Toolbar',
        'Session',
        'AES' => array(
            'blockSize' => 256,
            'modo' => null,
        ),
        'Auth' => array(
            'loginRedirect' => array('controller' => 'home', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
            'authError' => 'You must be logged in to view this page.',
            'loginError' => 'Invalid Username or Password entered, please try again.',
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            ),
        'Email'
        ));

    public function beforeFilter() {
        $this->Auth->allow('index', 'view');
    }

    private $mcrypt_cipher = MCRYPT_RIJNDAEL_256;
    private $mcrypt_mode = MCRYPT_MODE_CBC;


    public function encriptar($plaintext)
    {
        $enc = $this->AES->encrypt($plaintext);
        return $enc;
    }

    public function desencriptar($encrypted)
    {
        $des = $this->AES->decrypt($encrypted);
        return $des;
    }

}