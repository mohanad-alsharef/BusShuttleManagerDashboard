<?php

class Loop {

    private $_id;
    private $_loop_name;
    private $_Route;

    public function __construct(QueryResult $result){
        $this->_id = $result->id;
        $this->_loop_name = $result->_loop_name;
    }

    public function __get($var){
        switch ($var) {
            case 'id':
                return $this->_id;
                break;
            case 'loop_name':
                return $this->_loop_name;
                break;
            default:
                return null;
                break;
        }
    }

    


}

?>