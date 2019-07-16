<?php

class AccessLayer
{
    public function __construct()
    { }

    public function dbconnect()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB)
            or die("<br/>Coule not connect to MYSQL Server");

        // mysqli_select_db($conn, DB_DB)
        //     or die("<br/>Could not select the indicated database");

        return $conn;
    }

    // CUSTOM QUERIES HERE
    public function get_user($id){
        $sql = "SELECT * FROM users WHERE id='$id'";
        return $this->query($sql);
      }

    // END CUSTOM QUERIES


    // Turns each returned field name into a property of the QueryResult object. 
    private function query($sql)
    {
        
        $this->dbconnect();

        $conn = $this->dbconnect();

        $res = mysqli_query($conn,$sql);

        if ($res) {
            if (strpos($sql, 'SELECT') === false) {
                return true;
            }
        } else {
            if (strpos($sql, 'SELECT') === false) {
                return false;
            } else {
                return null;
            }
        }

        $results = array();

        while ($row = mysqli_fetch_array($res)) {

            $result = new QueryResult();

            foreach ($row as $k => $v) {
                $result->$k = $v;
            }

            $results[] = $result;
        }
        return $results;
    }
}

class QueryResult
{

    private $_results = array();

    public function __construct()
    { }

    public function __set($var, $val)
    {
        $this->_results[$var] = $val;
    }

    public function __get($var)
    {
        if (isset($this->_results[$var])) {
            return $this->_results[$var];
        } else {
            return null;
        }
    }
}
