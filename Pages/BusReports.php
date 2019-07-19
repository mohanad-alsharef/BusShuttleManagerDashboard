<?php
    session_start();
    require '../Database/connect.php';
    $_SESSION["Title"]="Bus Reports";


    $hourly = array();
    $entries = array();
    $input = "";
    $bus ="";
    $busArray = array();
    $allBoarded = array();
    $entryDate = date("m-d-Y");


    //if Filter By Hour is clicked
    if(isset($_POST['HourlyButton'])){
        $dateInputHourly = $_POST['dateInputHourly'];
        if($dateInputHourly != '') {

        $newDate = date("Y-m-d", strtotime($dateInputHourly));
        $entryDate = date("m-d-Y", strtotime($dateInputHourly));
        
        populateBuses($busArray, $con, $newDate);

        populateTableArray($allBoarded, $con, $newDate, $busArray);

        }
        // header('Location: Entries.php');
  
    }

    function showHourly(&$hourly, $con, $date, $bus){
        $hour =  0;

        for($hour=0; $hour<24; $hour++){
            $sql = sprintf("SELECT SUM(`boarded`) as `boarded` from `entries` where `bus_identifier` = '$bus' and `t_stamp` BETWEEN '$date $hour:00:00' and '$date $hour:59:59'");
            if($result = mysqli_query($con,$sql)) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($hourly, $row);
            }
            } else {
            http_response_code(404);
            }
        }
        
    }

    function populateHourly( $con, $date, $bus){
        $hour =  0;

        $hourly = array();

        for($hour=0; $hour<24; $hour++){
            $sql = sprintf("SELECT SUM(`boarded`) as `boarded` from `entries` where `bus_identifier` = '$bus' and `t_stamp` BETWEEN '$date $hour:00:00' and '$date $hour:59:59'");
            if($result = mysqli_query($con,$sql)) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($hourly, $row);
            }
            } else {
            http_response_code(404);
            }
        }
        return $hourly;
    
    }

    function populateBuses(&$busArray, $con, $date){
        $sql = "SELECT DISTINCT `buses`.*, `entries`.`date_added`, `entries`.`bus_identifier`
        FROM `buses` 
            LEFT JOIN `entries` ON `entries`.`bus_identifier` = `buses`.`id`
        WHERE `entries`.`date_added` = '$date'";
        
        if($result = mysqli_query($con,$sql)) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($busArray, $row);
            }
            } else {
            http_response_code(404);
            }
        
    }

    function populateTableArray(&$allBoarded, $con, $date, $busArray){

        $hourly = array();

        $counter = 0;
        foreach($busArray as $instance){
           
            $allBoarded[$counter] = array();
            $hourly = populateHourly( $con, $date, $instance['bus_identifier']);
            
            $allBoarded[$counter] = $hourly;
            $counter = $counter + 1;

        }
        $counter = 0;

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

   



    <script>
        $('#datepicker').datepicker();
    </script>

<body>



    

<!-- Controls the selections for the hourly filter -->
<div class="d-flex justify-content-center">
        <form action="" method="post">
         <div class="form-row align-items-center">
          <div class="col-auto">
                 <input class="form-control mb-2" input="text" name="dateInputHourly" id="datepickerHourly" width="276" placeholder="Click to Select Date" required />
               </div>

        <div class="col-auto">
          
          <button type="submit" name="HourlyButton" class="btn btn-dark mb-2">Filter By Hour</button>
          <a href="#" id="xx" class="btn btn-dark mb-2">Export</a>

        </div>
        </div>
    </form>
    </div>
    <!-- ends hourly selections control -->

    

    <!-- Creates table for hourly -->
    <table id="editable_table" class="table table-bordered table-striped">
        <thead>
        <tr><th colspan="18"><?php echo $entryDate?></th></tr>
            <tr>
                <th>Buses</th>
                <?php 
                $time = 7; 
                $AMOrPM = 'AM';
                
                for($i = 7; $i<24; $i=$i+1){ ?>
                    <td><?php echo "$time:00 - $time:59 $AMOrPM" ; ?></td>
                    <?php 
                        if($time == 11){
                            if($AMOrPM == 'AM'){
                                $AMOrPM ='PM';
                            }elseif($AMOrPM == 'PM'){
                                $AMorPM = 'AM';
                        }
                    }
                        if($time == 12){
                            $time = 1;

                            
                        }else{
                            $time = $time + 1;
                        }
                    
                
                    //  working here --------------
                    ?>
                <?php }  ?>          
                
                
            </tr>
        </thead>
        <!-- ends table for hourly -->


    <!-- This adds the sql info the hourly display -->
        <?php $time = 12; ?>
        <tbody id="tbodyid" class="row_position">
            <?php                
               $counter = 0;
               foreach($busArray as $bus){ ?>
                    <td> <?php echo $bus['busIdentifier']; ?>
                    <?php    
                    for($i=7;$i<24;$i=$i+1){ ?>
                    

                        <td> <?php echo 0 + $allBoarded[$counter][$i]['boarded'] ?> </td>
                        
                

                        
                            <?php 
                        }
                        if($time == 12){
                            $time = 1;
                        }else{
                            $time = $time + 1;
                        }
                        
                        $counter = $counter+1;
                        //  working here --------------
                        ?>


                    <!-- <td style="display:none;"><?php //echo $log['id']; ?></td> -->
                </tr>
                        <?php 
                 
                
             } 

             ?>
        </tbody>
    </table>
    <!-- ends sql info -->

    <script>

        $('#datepickerHourly').datepicker();

    </script>



</body>


<script>
    $(document).ready(function () {

function exportTableToCSV($table, filename) {

    var $rows = $table.find('tr:has(td),tr:has(th)'),

        // Temporary delimiter characters unlikely to be typed by keyboard
        // This is to avoid accidentally splitting the actual contents
        tmpColDelim = String.fromCharCode(11), // vertical tab character
        tmpRowDelim = String.fromCharCode(0), // null character

        // actual delimiter characters for CSV format
        colDelim = '","',
        rowDelim = '"\r\n"',

        // Grab text from table into CSV formatted string
        csv = '"' + $rows.map(function (i, row) {
            var $row = $(row), $cols = $row.find('td,th');

            return $cols.map(function (j, col) {
                var $col = $(col), text = $col.text();

                return text.replace(/"/g, '""'); // escape double quotes

            }).get().join(tmpColDelim);

        }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim) + '"',

        

        // Data URI
        csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
        
        console.log(csv);
        
        if (window.navigator.msSaveBlob) { // IE 10+
            //alert('IE' + csv);
            window.navigator.msSaveOrOpenBlob(new Blob([csv], {type: "text/plain;charset=utf-8;"}), "csvname.csv")
        } 
        else {
            $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' }); 
        }
}

// This must be a hyperlink
$("#xx").on('click', function (event) {
    
    exportTableToCSV.apply(this, [$('#editable_table'), "<?php echo strval($entryDate) ?>" + ".csv"]);
    // We actually need this to be a typical hyperlink
});

});
</script>
</HTML>

<?php require '../themepart/footer.php'; ?>