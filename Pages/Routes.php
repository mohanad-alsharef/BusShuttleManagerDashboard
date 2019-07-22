<?php
session_start();
//include the configuration
require_once(dirname(__FILE__) . '/../Configuration/config.php');
$_SESSION["Title"] = "Routes";

$stopNames;
$input = "";
$loopDropdown;
$stopDropdown;
$loopName;
$results;

$AccessLayer = new AccessLayer();
$loopDropdown = $AccessLayer->get_loops();
$stopDropdown = $AccessLayer->get_stops();

if (isset($_SESSION['savedLoopValue'])) {
    $stopNames = array();
    makeList($stopNames, $_SESSION['savedLoopValue']);
}
if (isset($_POST['loop'])) {
    $input = $_POST['loop'];
    if ($input != '') {
        $_SESSION['savedLoopValue'] = '';
        $loopName = $AccessLayer->get_distinct_loops_in_stoploop_and_loops($input);
        makeList($stopNames, $input);
    }
}

// If post occurs
if (isset($_POST['SubmitButton'])) {
    $input = $_POST['stopToAdd'];
    $loopInput = $_POST['loopToAdd'];
    if ($input != '' && $loopInput != '') {
        postLoop($input, $loopInput);
        $_SESSION['savedLoopValue'] = $loopInput;
    }
    header('Location: Routes.php');
}


function makeList(&$stopNames, $input)
{
    $AccessLayer = new AccessLayer();
    $stopNames = $AccessLayer->get_stop_id_and_displayOrder_by_displayOrder($input);
}

function postLoop($stopID, $loopID)
{
    $AccessLayer = new AccessLayer();
    $AccessLayer->add_route($stopID, $loopID);
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
        <form action="" method="post">
            <p>
                <h3>Assign <select class="" name="stopToAdd" id="stopToAdd" required>
                        <option selected="selected">Select a Stop</option>
                        <?php
                        foreach ($stopDropdown as $name) { ?>
                            <option name="stopToAdd" value="<?= $name->id ?>"><?= $name->stops ?>
                            </option>
                        <?php
                        } ?>
                    </select>
                     to <select class="" name="loopToAdd" id="loopToAdd" required>
                            <option selected="selected">Select a Loop</option>
                            <?php
                            foreach ($loopDropdown as $name) { ?>
                                <option name="loopToAdd" value="<?= $name->id ?>"><?= $name->loops ?>
                                </option>
                            <?php
                            } ?>
                        </select>
                        <button type="submit" name="SubmitButton" class="btn btn-dark">Assign</button>
                        </h3>
            </p>
        </div>
                        </form>
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
                                    <option name="loop" value="<?= $name->id ?>"><?= $name->loops ?>
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
                <th><?php if(isset($loopName[0])){echo $loopName[0]->loops ;} ?> - Route Order</th>
                <th>Stop                                                                                </th>
            </tr>
        </thead>
        <tbody class="row_position">
            <?php foreach ($stopNames as $log) : ?>
                <tr id="<?php $log->id; ?>">
                    <td><?php if($log->displayOrder == "0"){echo "Click and Drag To Set Position" ;} else {echo $log->displayOrder ;} ?></td>
                    <td><?php echo $log->stops; ?></td>
                    <td style="display:none;"><?php echo $log->id; ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <button type="submit" id="refreshButton" class="btn btn-success">Set Order</button>
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

        $("#refreshButton").click(function(){
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                var test = $(this).attr("id");
                selectedData.push($.trim(test));
            });
            console.log(selectedData);
            updateOrder(selectedData);
    }); 

    });

    // Right now, it will not automatically reload when the user drags and releases
    $(".row_position").sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                var test = $(this).attr("id");
                selectedData.push($.trim(test));
            });
            console.log(selectedData);
            //updateOrder(selectedData);
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