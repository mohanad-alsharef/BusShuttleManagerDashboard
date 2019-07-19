<?php
session_start();
require '../Database/connect.php';

$stopNames = array();
$input = "";

makeList($stopNames, $con);


// If post occurs
if (isset($_POST['SubmitButton'])) {
    $input = $_POST['inputText'];
    if ($input != '') {
        postLoop($con, $input);
    }
    header('Location: Stops.php');
}

function makeList(&$stopNames, $con)
{
    $sql = sprintf("SELECT * FROM stops ORDER BY stops ASC");

    if ($result = mysqli_query($con, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($stopNames, $row);
        }
    } else {
        http_response_code(404);
    }
}

function postLoop($con, $input)
{
    $sql = sprintf("INSERT INTO `stops`(`stops`) VALUES ( '$input' )");

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
                <h3>Create a New Stop<h3>
            </p>
        </div>
        <br>
        <div class="d-flex justify-content-center">
            <div class="form-group">
                <form class="needs-validation" novalidate action="" method="post">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <label class="sr-only" for="inlineFormInput">Stop Name</label>
                            <input type="text" input="text" class="form-control mb-2" name='inputText' id="inlineFormInput" placeholder="Enter New Stop" required>
                        </div>
                        <div class="col-auto">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="SubmitButton" class="btn btn-dark form-control mb-2">Submit</button>
                        </div>
                    </div>
                </form>



                <div class="d-flex justify-content-center">
                </div>
                <br>
                <div class="d-flex justify-content-center">
                </div>
            </div>
        </div>
    </div>

    <table id="editable_table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Stop</th>
            </tr>
        </thead>
        <tbody class="row_position">
            <?php foreach ($stopNames as $log) : ?>
                <tr id="<?php echo $log['id'] ?>">
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

</script>


</HTML>
<?php require '../themepart/footer.php'; ?>