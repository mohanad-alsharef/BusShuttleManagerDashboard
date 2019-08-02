<?php

class User {

    public $_id;
    public $_firstname;
    public $_lastname;

    public function __construct(QueryResult $result){
        $this->_id = $result->id;
        $this->_firstname = $result->firstname;
        $this->_lastname = $result->lastname;
    }

    public function __get($var){
        switch ($var) {
            case 'id':
                return $this->_id;
                break;
            case 'firstname':
                return $this->_firstname;
                break;
            case 'lastname':
                return $this->_lastname;
            default:
                return null;
                break;
        }
    }

    


}

?>