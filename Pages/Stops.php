<?php
    session_start();
    require '../Database/connect.php';

    $stopNames = array();
    $input = "";
    $loopDropdown = array();


    $sql = sprintf("SELECT loops FROM loops");
    // Populating the loops dropdown
    if($result = mysqli_query($con,$sql)) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($loopDropdown, $row);
        }
        } else {
        http_response_code(404);
        }

    if (isset($_SESSION['savedLoopValue']))
        {
            $stopNames = array();
            makeList($stopNames, $con, $_SESSION['savedLoopValue']);
        }
        if(isset($_POST['loop'])){
            $input = $_POST['loop'];
            if($input != '') {
            $_SESSION['savedLoopValue'] = '';
            makeList($stopNames, $con, $input);
            }
        }
        
    // If post occurs
    if(isset($_POST['SubmitButton'])){
        $input = $_POST['inputText'];
        $loopInput = $_POST['loopToAdd'];
        if($input != '' && $loopInput != '') {
        postLoop($con, $input, $loopInput);
        $_SESSION['savedLoopValue'] = $loopInput;

        }
        header('Location: Stops.php');
  
    }



    
    function makeList(&$stopNames, $con, $input) {
        $sql = sprintf("SELECT * FROM stops WHERE `loops`='$input' ORDER BY displayOrder");
    
        if($result = mysqli_query($con,$sql)) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($stopNames, $row);
        }
        } else {
        http_response_code(404);
        }
    }

    function postLoop($con, $input, $loop){
        $sql = sprintf("INSERT INTO `stops`(`stops`, `loops`, `displayOrder`) VALUES ( '$input','$loop', 0 )");
        if($result = mysqli_query($con,$sql)) { } 
        else {
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

<body>
    <div align="center">
        <div class="d-flex justify-content-center">
            <p>
                <h3>Create a New Stop<h3>
            </p>
        </div>
        <br>
        <div class="d-flex justify-content-center">
            <div class="form-group">
                <form class="needs-validation" novalidate action="" method="post">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <label class="sr-only" for="inlineFormInput" >Stop Name</label>
                            <input type="text" input="text" class="form-control mb-2" name='inputText'
                                id="inlineFormInput" placeholder="Enter New Stop" required>
                        </div>
                        <div class="col-auto">
                            <select class="form-control mb-2" name="loopToAdd" id="loopToAdd" required>
                                <option  selected="selected">Select a Loop</option>
                                <?php
                            foreach($loopDropdown as $name) { ?>
                                <option name="loopToAdd" value="<?= $name['loops'] ?>"><?= $name['loops'] ?>
                                </option>
                                <?php
                            } ?>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="SubmitButton" class="btn btn-dark form-control mb-2">Submit</button>
                        </div>
                    </div>
                </form>





                <div class="d-flex justify-content-center">
                    <p>
                        <h3>Filter by Loop<h3>
                    </p>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <div class="form-group">
                        <form action="" method="post">
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <select class="form-control mb-2" name="loop" id="loop">
                                        <option selected="selected">Select a Loop</option>
                                        <?php
                            foreach($loopDropdown as $name) { ?>
                                        <option name="loop" value="<?= $name['loops'] ?>"><?= $name['loops'] ?>
                                        </option>
                                        <?php
                            } ?>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" name="searchButton"
                                        class="btn btn-dark mb-2 form-control">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>














    <table id="editable_table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Route Order</th>
                <th>Stop                                                                                </th>
            </tr>
        </thead>
        <tbody class="row_position">
            <?php foreach ($stopNames as $log): ?>
            <tr id="<?php echo $log['id'] ?>">
                <td><?php echo $log['displayOrder']; ?></td>
                <td><?php echo $log['stops']; ?></td>
                <td style="display:none;"><?php echo $log['id']; ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>
</body>

<script>
$(document).ready(function() {
    $('#editable_table').Tabledit({
        url: '../Actions/actionStops.php',
        hideIdentifier: true,
        columns: {
            identifier: [2, 'id'],
            editable: [
                [1, 'stop']
            ]
        }
    });

});

$(".row_position").sortable({
    delay: 150,
    stop: function() {
        var selectedData = new Array();
        $('.row_position>tr').each(function() {
            var test = $(this).attr("id");
            selectedData.push($.trim(test));
        });
        console.log(selectedData);
        updateOrder(selectedData);
    }
});


function updateOrder(data) {
    $.ajax({
        url: "../Actions/ajaxPro.php",
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