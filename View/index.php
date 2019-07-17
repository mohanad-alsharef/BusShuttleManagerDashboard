<?php
require ('../Model/User.php');
//include the configuration
require_once(dirname(__FILE__) . '/../Configuration/config.php');


//instance of AccessLayer
$AccessLayer = new AccessLayer();

$users = Array(1);

foreach ($users as $user) {
    $results = $AccessLayer->get_all_users_as_User_Objects();
    echo "<h1>Users by $user</h1>";
    //$AccessLayer->update_user(1, "hello", "world");
    //$AccessLayer->remove_user(1);

    if ($results){
        echo "<ul>";

        foreach ($results as $user) {
           echo "<li>$user->firstname (Database ID: $user->id)</li>";
       }
        echo "</ul>";
    } else {
        echo "Sorry nothing to show here.";
    }
}


?>