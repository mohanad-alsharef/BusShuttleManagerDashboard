<?php

require_once(dirname(__FILE__) . '/../config.php');

include_once('../Model/User.php');

class AccessLayer
{
  public function __construct()
  { }

  public function dbconnect()
  {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DBNAME)
      or die("<br/>Coule not connect to MYSQL Server");

    // mysqli_select_db($conn, DB_DBNAME)
    //     or die("<br/>Could not select the indicated database");

    return $conn;
  }

  // CUSTOM METHODS HERE

  // Users
  public function get_user_as_User_Object($id)
  {
    // Reuse existing query
    $sql = "SELECT * FROM users WHERE id='$id'";
    $results = $this->query($sql);

    // check for results
    if (!$results) {
      return $results;
    } else {
      // array to hold User objects
      $object_results = array();
      // cycle through and convert to User objects
      foreach ($results as $result) {
        $object_results[] = new User($result);
      }
      // return array of User objects
      return $object_results;
    }
  }

  public function get_all_users_as_User_Objects()
  {
    // Reuse existing query
    $sql = "SELECT * FROM users WHERE is_deleted='0' ORDER BY lastname ASC";
    $results = $this->query($sql);

    // check for results
    if (!$results) {
      return $results;
    } else {
      // array to hold User objects
      $object_results = array();
      // cycle through and convert to User objects
      foreach ($results as $result) {
        $object_results[] = new User($result);
      }
      // return array of User objects
      return $object_results;
    }
  }

  public function update_user($userID, $firstname, $lastname)
  {
    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname' WHERE id='$userID'";
    $results = $this->query($sql);
  }

  public function remove_user($userID)
  {
    $sql = "UPDATE users SET is_deleted=1 WHERE id='$userID'";
    $results = $this->query($sql);
  }

  public function get_user_name($userID){
    $sql = sprintf("SELECT firstname,lastname FROM users WHERE id=$userID");
    return $this->query($sql);
  }

  // Loops
  public function get_loops()
  {
    $sql = sprintf("SELECT * FROM loops WHERE is_deleted='0' ORDER BY loops ASC");
    return $this->query($sql);
  }

  public function add_loop($loopName)
  {
    $sql = sprintf("INSERT INTO `loops`(`loops`) VALUES ( '$loopName' )");
    $results = $this->query($sql);
  }

  public function remove_loop($loopID)
  {
    $sql = sprintf("UPDATE loops SET is_deleted=1 WHERE id='$loopID'");
    $this->query($sql);
    $sql = sprintf("UPDATE stop_loop SET is_deleted=1 WHERE `loop`='$loopID'");
    $this->query($sql);
  }

  public function restore_loop($loopID)
  {
    $sql = sprintf("UPDATE loops SET is_deleted=0 WHERE id='$loopID'");
    $this->query($sql);
    $sql = sprintf("UPDATE stop_loop SET is_deleted=0 WHERE `loop`='$loopID'");
    $this->query($sql);
  }

  public function update_loop($loopID, $loopName)
  {
    $sql = sprintf("UPDATE loops SET loops='$loopName'WHERE id='$loopID'");
    $results = $this->query($sql);
  }

  public function get_loop_name($loopID){
    $sql = sprintf("SELECT loops FROM loops WHERE is_deleted='0' AND id=$loopID");
    return $this->query($sql);
  }

  // Stops
  public function get_stops()
  {
    $sql = sprintf("SELECT * FROM stops WHERE is_deleted='0' ORDER BY stops ASC");
    return $this->query($sql);
  }

  public function get_stops_by_loop($loopID){
    $sql = sprintf("SELECT DISTINCT `stops`.`stops`, `stop_loop`.`displayOrder`, `stop_loop`.`loop` FROM `stops` 
    INNER JOIN `stop_loop` ON `stop_loop`.`stop` = `stops`.`id` AND `stop_loop`.`loop` = '$loopID'");
    return $this->query($sql);
  }

  public function add_stop($stopName)
  {
    $sql = sprintf("INSERT INTO `stops`(`stops`) VALUES ( '$stopName' )");
    $this->query($sql);
  }

  public function remove_stop($stopID)
  {
    $sql = sprintf("UPDATE stops SET is_deleted=1 WHERE id='$stopID'");
    $this->query($sql);
    $sql = sprintf("UPDATE stop_loop SET is_deleted=1 WHERE `stop`='$stopID'");
    $this->query($sql);
  }


  public function restore_stop($stopID)
  {
    $sql = sprintf("UPDATE stops SET is_deleted=0 WHERE id='$stopID'");
    $this->query($sql);
    $sql = sprintf("UPDATE stop_loop SET is_deleted=0 WHERE `stop`='$stopID'");
    $this->query($sql);
  }

  public function update_stop($stopID, $stopName)
  {
    $sql = sprintf("UPDATE stops SET stops='$stopName'WHERE id='$stopID'");
    $this->query($sql);
  }

  public function get_stop_name($stopID) {
    $sql = sprintf("SELECT stops FROM stops WHERE is_deleted='0' AND id=$stopID");
    return $this->query($sql);
  }

  // Buses
  public function get_buses()
  {
    $sql = sprintf("SELECT * FROM buses WHERE is_deleted='0' ORDER BY busIdentifier ASC");
    return $this->query($sql);
  }

  public function add_bus($busName)
  {
    $sql = sprintf("INSERT INTO `buses`(`busIdentifier`) VALUES ( '$busName' )");
    $results = $this->query($sql);
  }

  public function remove_bus($busID)
  {
    $sql = sprintf("UPDATE buses SET is_deleted=1 WHERE id='$busID'");
    $results = $this->query($sql);
  }

  public function update_bus($busID, $busName)
  {
    $sql = sprintf("UPDATE buses SET busIdentifier='$busName'WHERE id='$busID'");
    $results = $this->query($sql);
  }

  public function get_bus_name($busID) {
    $sql = sprintf("SELECT busIdentifier FROM buses WHERE is_deleted='0' AND id=$busID");
    return $this->query($sql);
  }

  // Entries
  public function get_entries_by_date_and_loopID($dateAdded, $loopID) {
    $sql = sprintf("SELECT * FROM `entries` WHERE `date_added`='$dateAdded' AND `loop`= '$loopID'  ORDER BY `t_stamp` DESC");
    return $this->query($sql);
  } 

  public function update_entries_boarded_and_leftbehind($boarded, $leftBehind, $entryID) {
    $sql = sprintf("UPDATE entries SET boarded='$boarded', left_behind='$leftBehind' WHERE id='$entryID'");
    $this->query($sql);
  } 

  // Will likely be wanted eventually so here it is. 
  public function remove_entry($entryID) {
    $sql = sprintf("UPDATE entries SET is_deleted='1' WHERE id='$entryID'");
    $this->query($sql);
  } 

  // Routes
  public function get_distinct_loops_in_stoploop_and_loops($id) {
    $sql = sprintf("SELECT DISTINCT `loops`.`loops`, `stop_loop`.`loop`
    FROM `loops` 
        LEFT JOIN `stop_loop` ON `stop_loop`.`loop` = `loops`.`id` AND stop_loop.is_deleted='0'
    WHERE `stop_loop`.`loop` = '$id' ");

    return $this->query($sql);
  }

  public function get_stop_id_and_displayOrder_by_displayOrder($loopID){
    $sql = sprintf("SELECT stops.stops, stops.id, stops.is_deleted as stopDeletion, stop_loop.displayOrder, stop_loop.loop, stop_loop.id as route_id
      FROM stops 
        inner JOIN stop_loop ON stop_loop.loop='$loopID' AND stop_loop.is_deleted='0'
      AND stop_loop.stop=stops.id AND stops.is_deleted=0 ORDER BY displayOrder");

    return $this->query($sql);
  }

  public function remove_route($routeID){
    $sql = sprintf("UPDATE stop_loop SET is_deleted=1 WHERE `id`='$routeID'");
    $this->query($sql);
  }

  public function restore_route($routeID){
    $sql = sprintf("UPDATE stop_loop SET is_deleted=0 WHERE `id`='$routeID'");
    $this->query($sql);
  }

  public function add_route($stopID, $loopID, $afterStop){
    if($afterStop === "none") {
      $sql = sprintf("INSERT INTO `stop_loop`(`stop`, `loop`, `displayOrder`) VALUES ( '$stopID','$loopID', 0 )");
      $this->query($sql);
    } else {
      $sql = sprintf("INSERT INTO `stop_loop`(`stop`, `loop`, `displayOrder`) VALUES ( '$stopID','$loopID', $afterStop )");
      $this->query($sql);
    }
    
  }


  // END CUSTOM METHODS


  // Turns each returned field name into a property of the QueryResult object. 
  private function query($sql)
  {

    $this->dbconnect();

    $conn = $this->dbconnect();

    $res = mysqli_query($conn, $sql);

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
