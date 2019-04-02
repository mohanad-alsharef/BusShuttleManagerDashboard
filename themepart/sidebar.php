<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Collapsible sidebar using Bootstrap 4</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->



    <link rel="stylesheet" href="style.css">
    <script src="jquery.tabledit.min.js"></script>
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 style="text-align: center">Management Dashboard</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Manage Data</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a class="disabled" href="../Pages/Entries.php">Entries</a>
                        </li>
                        <li>
                            <a class="disabled" href="../Pages/Users.php">Drivers</a>
                        </li>
                        <li>
                            <a href="../Pages/Loops.php">Loops</a>
                        </li>
                        <li>
                            <a href="../Pages/Stops.php">Stops</a>
                        </li>
                        <li>
                            <a href="../Pages/Buses.php">Buses</a>
                        </li>
                    </ul>
                    <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">View Reports</a>
                        <ul class="collapse list-unstyled" id="reportSubmenu">
                            <li>
                                <a href="../Pages/EntryReports.php">Entry Reports</a>
                            </li>
			    <li>
                                <a href="../Pages/StopReports.php">Stop Reports</a>
                            </li>
                        </ul>
                </li>
                <!-- <li>
                    <a href="#">About</a>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Portfolio</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li> -->
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="https://pbuslog01.aws.bsu.edu/" class="download">Driver App</a>
                </li>
                <li>
                    <a href="../Pages/Feedback.php" class="article">Find a Bug?</a>
                </li>
            </ul>
            
            <div style= "margin:250px 50px 0px 50px;background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;">
                <a href="Logout.php">Logout</a>
            </div>

        </nav>

        