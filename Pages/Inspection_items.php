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
    addInspectionItems($input);
  }
  header('Location: Inspection_items.php');
}

function makeList(&$results) {
  $AccessLayer = new AccessLayer();
  $results = $AccessLayer->get_inspection_items();
}

function addInspectionItems($InspectionItemsName){
  $AccessLayer = new AccessLayer();
  $AccessLayer->add_inspection_items($InspectionItemsName);
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
          <tr>
            <td><?php echo $Inspection_items->inspection_item_name; ?></td>
            <td><input type="checkbox" name="type[]" id=pre[] checked="true"></td>
            <td><input type="checkbox" name="type[]" id=pro[] checked="false"></td>
            <td style="display:none;"><?php echo $Inspection_items->id; ?></td>
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