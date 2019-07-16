<?php

//include the configuration
require_once(dirname(__FILE__) . '/../Configuration/config.php');

//instance of AccessLayer
$AccessLayer = new AccessLayer();

$users = Array(3);

foreach ($users as $user) {
    $results = $AccessLayer->get_user($user);
    echo "<h1>Users by $user</h1>";


    if ($results){
        echo "<ul>";

        foreach ($results as $model) {
           echo "<li>$model->firstname (Database ID: $model->id)</li>";
       }
        echo "</ul>";
    } else {
        echo "sorry, nothing to show here you ass.";
    }
}


?>