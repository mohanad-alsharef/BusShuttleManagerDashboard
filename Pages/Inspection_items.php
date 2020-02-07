<?php
require_once('../ulogin/config/all.inc.php');
require_once('../ulogin/main.inc.php');

if (!sses_running())
	sses_start();

function isAppLoggedIn(){
	return isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn']===true);
}

if (!isAppLoggedIn()) {
    header("Location: ../index.php"); /* Redirect browser */
   exit();
} 

require_once(dirname(__FILE__) . '/../DataLink/AccessLayer.php');

$_SESSION["Title"]="Inspection Items";

$input = "";
$results;



if(isset($_POST['SubmitButton'])){
  $input = $_POST['inputText'];
  if($input != '') {
    $pre = $_POST['pre_item'];
    $post = $_POST['post_item'];
    addInspectionItems($input, $pre, $post);
  }
  header('Location: Inspection_items.php');
}

function makeList(&$results) {
  $AccessLayer = new AccessLayer();
  $results = $AccessLayer->get_inspection_items();
}

function addInspectionItems($InspectionItemsName, $pre_trip, $post_trip){
  $AccessLayer = new AccessLayer();
  $AccessLayer->add_inspection_items($InspectionItemsName, $pre_trip, $post_trip);
}


?>
<?php 
require '../themepart/resources.php';
require '../themepart/sidebar.php';
require '../themepart/pageContentHolder.php';
?>
<html>
<head>

</head>
<body>
  <div align="center">

    <?php
    makeList($results);
    ?>


    <div class="d-flex justify-content-center"><p><h3>Create a New Inspection Item</h3></p></div>

    <br>
    <div class="d-flex justify-content-center">
    <form action="" method="post">
      <div class="form-row align-items-center">
        <div class="col-auto">
          <label class="sr-only" for="inlineFormInput">Inspection Item Name</label>
          <input type="text" input="text" class="form-control mb-2" name='inputText' id="inlineFormInput" placeholder="Enter New Inspection Item">
        </div>
        <div class="col-auto">
          <input type="checkbox" name="pre_item" id=pre_item value=0>  Pre-inspection   
        </div>
        <div class="col-auto">
          <input type="checkbox" name="post_item" id=post_item value=0>  Post-inspection   
        </div>
        <div class="col-auto">
          <button type="submit" name="SubmitButton" class="btn btn-dark mb-2">Submit</button>
        </div>
       </div>
    </form>
    </div>

    <table id="editable_table" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th>Inspection Item</th>
       <th>Pre-Inspection</th>
       <th>Post-Inspection</th>
      </tr>
     </thead>
     <tbody>
     <?php foreach ($results as $Inspection_items): ?>
      <?php
        // varibles to view results on checkboxes
        $name = $Inspection_items->inspection_item_name; 
        $item_id = $Inspection_items->id;
        $pre_item = (bool)$Inspection_items->pre_trip_inspection; //1 = true, 0 = false
        $checked_pre = ($pre_item) ? 'checked="checked"' : ''; //ternary operator
        $post_item = (bool)$Inspection_items->post_trip_inspection; //1 = true, 0 = false
        $checked_post = ($post_item) ? 'checked="checked"' : ''; //ternary operator
      ?>
      <tr>
        <td><?php echo $name ?></td>
        <td><input type="checkbox" name="pre_item" id="pre_item" value=0 <?php echo $checked_pre; ?> disabled /></td>
        <td><input type="checkbox" name="post_item" id="post_item" value=0 <?php echo $checked_post; ?> disabled /></td>
        <td style="display:none;"><?php echo $item_id; ?></td>
      </tr>
     <?php endforeach; ?>
     </tbody>
    </table>
  </div>
</body>


<script>

$(document).ready(function(){
  //testing table creation
  
  
  $('#editable_table').Tabledit({
    url: '../Actions/actionInspection_items.php',
    columns: {
        identifier: [3, 'id'],
        editable: [[0,'inspection_item_name']]
    },
 
  });
});

 </script>

</html>
<?php require '../themepart/footer.php'; ?>