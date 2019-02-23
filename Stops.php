<?php
    require 'connect.php';

    $stopNames = array();
    $input = "";

    if(isset($_POST['SubmitButton'])){
        $input = $_POST['inputText'];
        if($input != '') {
        postLoop($con, $input);
        }
        header('Location: Loops.php');
    }
    
    function makeList(&$stopNames, $con) {
        $sql = sprintf("SELECT * FROM stops");
    
        if($result = mysqli_query($con,$sql)) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($stopNames, $row);
        }
        } else {
        http_response_code(404);
        }
    }

    function postLoop($con, $input){
        $sql = sprintf("INSERT INTO `loops`(`loops`) VALUES ( '$input' )");
        if($result = mysqli_query($con,$sql)) { } 
        else {
          http_response_code(404);
        }
      }

?>
<!DOCTYPE HTML>
<HTML LANG="EN">
<HEAD>
    <?php
        require './themepart/navbar.php';
    ?>

      <script src="jquery.tabledit.min.js"></script>

</HEAD>
<body>

    <div align="center">

        <?php
            makeList($stopNames, $con);
        ?>

        <div class="d-flex justify-content-center"><p><h3>Create a new stop below.<h3><p></div>

            <br>
            <div class="d-flex justify-content-center">
                <form action="" method="post">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <label class="sr-only" for="inlineFormInput">Stop Name</label>
                            <input type="text" input="text" class="form-control mb-2" name='inputText' id="inlineFormInput" placeholder="Enter New Loop">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="SubmitButton" class="btn btn-secondary mb-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        <table id="editable_table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Stop</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stopNames as $log): ?>
                <tr>
                    <td>
                        <?php echo $log['stops']; ?>
                    </td>
                    <td style="display:none;">
                        <?php echo $log['id']; ?>
                    </td>
                    <!-- <td><form action='edit.php?name="<?php echo $log['stops']; ?>"' method="post">
                        <input type="hidden" name="name" value="<?php echo $log['stops']; ?>">
                        <input type="submit" name="editButton" value="edit">
                        </form>
                    </td>
                    <td>
                        <form action='delete.php?name="<?php echo $log['stops']; ?>"' method="post">
                            <input type="hidden" name="name" value="<?php echo $log['stops']; ?>">
                            <input type="submit" name="editButton" value="delete">
                         </form>
                    </td> -->
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</body>

<script>
$(document).ready(function(){
  $('#editable_table').Tabledit({
    url: 'actionLoops.php',
    columns: {
        identifier: [1, 'id'],
        editable: [[0,'stop']]
    }
});

});
</script>

</HTML>