<?php

/**
 * @global Gestiona las cuentas de usuarios
 */

App::uses('Security', 'Utility');
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends \AppModel
{

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'El UserName es requerido'
            ),
            'unique' => array(
                'rule' => array('isUniqueUsername'),
                'message' => 'No puede ser utilizado este userName'
            ),
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'El passowrd es requerido'
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'),
                'message' => 'El passowrd debe tener un minimo de 6 caracteres'
            )
        ),
        'password_confirm' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Por favor confirma el password'
            ),
            'equaltofield' => array(
                'rule' => array('equaltofield', 'password'),
                'message' => 'Ambos password son diferentes.'
            )
        ),
        'email' => array(
            'required' => array(
                'rule' => array('email', true),
                'message' => 'Por favor ingrese una direccion vailda.'
            ),
            'unique' => array(
                'rule' => array('isUniqueEmail'),
                'message' => 'El email no ha podido ser establecido',
            ),
            'between' => array(
                'rule' => array('between', 6, 60),
                'message' => 'El userName debe tener entre 6 y 60 caracteres'
            )
        ),

        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            ),
        )
    );

    /**
     * Before isUniqueUsername
     * @param array $options
     * @return boolean
     */

    function isUniqueUsername($check)
    {
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id',
                    'User.username'
                ),
                'conditions' => array(
                    'User.username' => $check['username']
                )
            )
        );

        if (!empty($username)) {
            if ($this->data[$this->alias]['id'] == $username['User']['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    function isUniqueEmail($check)
    {

        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id'
                ),
                'conditions' => array(
                    'User.email' => $check['email']
                )
            )
        );

        if (!empty($email)) {
            if ($this->data[$this->alias]['id'] == $email['User']['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function equaltofield($check, $otherfield)
    {
        //get name of field
        $fname = '';
        foreach ($check as $key => $value) {
            $fname = $key;
            break;
        }
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname];
    }

    public function beforeSave($options = array())
    {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}