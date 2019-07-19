<?php
session_start();
require '../Database/connect.php';
$_SESSION["Title"] = "Routes";

$stopNames = array();
$input = "";
$loopDropdown = array();
$stopDropdown = array();
$loopName = array();


$sql = sprintf("SELECT * FROM loops");
// Populating the loops dropdown
if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($loopDropdown, $row);
    }
} else {
    http_response_code(404);
}

$sql = sprintf("SELECT * FROM stops");
// Populating the stops dropdown
if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($stopDropdown, $row);
    }
} else {
    http_response_code(404);
}

if (isset($_SESSION['savedLoopValue'])) {
    $stopNames = array();
    makeList($stopNames, $con, $_SESSION['savedLoopValue']);
}
if (isset($_POST['loop'])) {
    $input = $_POST['loop'];
    if ($input != '') {
        $_SESSION['savedLoopValue'] = '';
        $sql = sprintf("SELECT DISTINCT `loops`.`loops`, `stop_loop`.`loop`
        FROM `loops` 
            LEFT JOIN `stop_loop` ON `stop_loop`.`loop` = `loops`.`id`
        WHERE `stop_loop`.`loop` = '$input'");
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($loopName, $row);
            }
        } else {
            http_response_code(404);
        }
        
        makeList($stopNames, $con, $input);
    }
}

// If post occurs
if (isset($_POST['SubmitButton'])) {
    $input = $_POST['stopToAdd'];
    $loopInput = $_POST['loopToAdd'];
    if ($input != '' && $loopInput != '') {
        postLoop($con, $input, $loopInput);
        $_SESSION['savedLoopValue'] = $loopInput;
    }
    header('Location: Routes.php');
}




function makeList(&$stopNames, $con, $input)
{
    $sql = sprintf("SELECT stops.stops, stops.id, stop_loop.displayOrder FROM stops inner JOIN stop_loop ON stop_loop.loop='$input' AND stop_loop.stop=stops.id ORDER BY displayOrder");
    if ($result = mysqli_query($con, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($stopNames, $row);
        }
    } else {
        http_response_code(404);
    }
}

function postLoop($con, $input, $loop)
{
    $sql = sprintf("INSERT INTO `stop_loop`(`stop`, `loop`, `displayOrder`) VALUES ( '$input','$loop', 0 )");

    if ($result = mysqli_query($con, $sql)) { } else {
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
                <h3>Assign <select class="" name="stopToAdd" id="stopToAdd" required>
                        <option selected="selected">Select a Stop</option>
                        <?php
                        foreach ($stopDropdown as $name) { ?>
                            <option name="stopToAdd" value="<?= $name['id'] ?>"><?= $name['stops'] ?>
                            </option>
                        <?php
                        } ?>
                    </select>
                    <h3> to <select class="" name="loopToAdd" id="loopToAdd" required>
                            <option selected="selected">Select a Loop</option>
                            <?php
                            foreach ($loopDropdown as $name) { ?>
                                <option name="loopToAdd" value="<?= $name['id'] ?>"><?= $name['loops'] ?>
                                </option>
                            <?php
                            } ?>
                        </select>
                        <button type="submit" name="SubmitButton" class="btn btn-dark">Assign</button>
            </p>
        </div>
        <br>
        <div class="d-flex justify-content-center">
            <div class="form-group">
                <form class="needs-validation" novalidate action="" method="post">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <label class="sr-only" for="inlineFormInput">Stop Name</label>

                        </div>
                    </div>
                </form>



                <div class="d-flex justify-content-center">

                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <div class="form-group">
                        <form action="" method="post">
                            <div class="form-row align-items-center">
                                <div class="col-auto">

                                </div>
                                <div class="col-auto">
                                <p>
                        <h3>Filter by <select class="mb-2" name="loop" id="loop">
                                <option selected="selected">Select a Loop</option>
                                <?php
                                foreach ($loopDropdown as $name) { ?>
                                    <option name="loop" value="<?= $name['id'] ?>"><?= $name['loops'] ?>
                                    </option>
                                <?php
                                } ?>
                            </select>
                            <button type="submit" name="searchButton" class="btn btn-dark mb-2">Filter</button>
                            <h3>
                    </p>
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
                <th><?php if(isset($loopName)){echo $loopName[0]['loops'] ;} ?> - Route Order</th>
                <th>Stop                                                                                </th>
            </tr>
        </thead>
        <tbody class="row_position">
            <?php foreach ($stopNames as $log) : ?>
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
            url: '../Actions/actionRoutes.php',
            hideIdentifier: true,
            editButton: false,
            columns: {
                identifier: [2, 'id'],
                editable: []
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
            // location.reload()
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
                location.reload()
            }
        })
    }
</script>


</HTML>
<?php require '../themepart/footer.php'; ?>