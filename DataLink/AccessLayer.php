<?php
include_once('../Model/User.php');

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

    // CUSTOM METHODS HERE
      public function get_user_as_User_Object($id){
        // Reuse existing query
        $sql = "SELECT * FROM users WHERE id='$id'";
        $results = $this->query($sql);
         
        // check for results
        if (!$results){
          return $results;
        }
        else{
          // array to hold User objects
          $object_results = array();
          // cycle through and convert to User objects
          foreach ($results as $result){
            $object_results[] = new User($result);
          }
          // return array of User objects
          return $object_results;
        }
      }

      public function get_all_users_as_User_Objects(){
        // Reuse existing query
        $sql = "SELECT * FROM users";
        $results = $this->query($sql);
         
        // check for results
        if (!$results){
          return $results;
        }
        else{
          // array to hold User objects
          $object_results = array();
          // cycle through and convert to User objects
          foreach ($results as $result){
            $object_results[] = new User($result);
          }
          // return array of User objects
          return $object_results;
        }
      }

      public function update_user($userID, $firstname, $lastname) {
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname' WHERE id='$userID'";
        $results = $this->query($sql);
      }

      public function remove_user($userID) {
        $sql = "UPDATE users SET is_deleted=1 WHERE id='$userID'";
        $results = $this->query($sql);
      }

    // END METHODS QUERIES


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
