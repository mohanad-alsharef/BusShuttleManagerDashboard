<?php
    session_start();
    require '../Database/connect.php';


    $entries = array();
    $input = "";
    $loopDropdown = array();
    $loop ="";


    $sql = sprintf("SELECT * FROM loops ORDER BY loops ASC");
    // Populating the loops dropdown
    if($result = mysqli_query($con,$sql)) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($loopDropdown, $row);
        }
        } else {
        http_response_code(404);
        }
        
    // If Submit is Clicked
    if(isset($_POST['SubmitButton'])){
        $input = $_POST['loop'];
        $dateInput = $_POST['dateInput'];
        if($input != '' && $dateInput != '') {

        $newDate = date("Y-m-d", strtotime($dateInput));
        makeList($entries, $con, $newDate, $input);
        

        }
        // header('Location: Entries.php');
  
    }
    
    function makeList(&$entries, $con, $input, $loop) {
        $sql = sprintf("SELECT * FROM `entries` WHERE `date_added`='$input' AND `loop`= '$loop' AND `is_deleted`='0' ORDER BY `t_stamp` DESC");
    
        if($result = mysqli_query($con,$sql)) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($entries, $row);
        }
        } else {
        http_response_code(404);
        }
    }
?>
<?php
        require '../themepart/resources.php';
        require '../themepart/sidebar.php';
        require '../themepart/pageContentHolder.php';
    ?>


<HTML LANG="EN">

<HEAD>


</HEAD>

<form method=post>

</form>

<div class="d-flex justify-content-center">
    <form action="" method="post">
      <div class="form-row align-items-center">
         <div class="col-auto">
             <input class="form-control mb-2" input="text" name="dateInput" id="datepicker" width="276" />
            </div>
         <div class="col-auto">
                                    <select class="form-control mb-2" name="loop" id="loop">
                                        <option selected="selected">Select a Loop</option>
                                        <?php
                            foreach($loopDropdown as $name) { ?>
                                        <option name="loop" value="<?= $name['id'] ?>"><?= $name['loops'] ?>
                                        </option>
                                        <?php
                            } ?>
                                    </select>
                                </div>
        <div class="col-auto">
          <button type="submit" name="SubmitButton" class="btn btn-dark mb-2">Submit</button>
          
          
        </div>
        </div>
    </form>
    </div>
    <script>
        $('#datepicker').datepicker();
    </script>

<body>


    <table id="editable_table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Boarded</th>
                <th>Stop</th>
                <th>Time</th>
                <th>Date</th>
                <th>Loop</th>
                <th>Driver</th>
                <th>Bus #</th>
                <th>Left Behind</th>
            </tr>
        </thead>
        <tbody class="row_position">
            <?php foreach ($entries as $log): ?>
            <tr id="<?php echo $log['id'] ?>">
                <td><?php echo $log['boarded']; ?></td>
                <td><?php echo $log['stop']; ?></td>
                <td><?php echo $log['t_stamp']; ?></td>
                <td><?php echo $log['date_added']; ?></td>
                <td><?php echo $log['loop']; ?></td>
                <td><?php echo $log['driver']; ?></td>
                <td><?php echo $log['bus_identifier']; ?></td>
                <td><?php echo $log['left_behind']; ?></td>
                <td style="display:none;"><?php echo $log['id']; ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <script>

        $('#datepickerHourly').datepicker();

    </script>



</body>

<script>
$(document).ready(function() {
    $('#editable_table').Tabledit({
        url: '../Actions/actionEntries.php',
        hideIdentifier: true,
        editButton: false,
        columns: {
            identifier: [8, 'id'],
            editable: [
                [0, 'boarded'],
                [5, 'driver'],
                [7, 'leftBehind']
            ]
        }
    });

});

function updateOrder(data) {
    $.ajax({
        url: "../Actions/actionEntries.php",
        type: 'post',
        data: {
            position: data
        },
        success: function() {
            alert('your change successfully saved');
        }
    })
}
</script>



</HTML>

<?php require '../themepart/footer.php'; ?>