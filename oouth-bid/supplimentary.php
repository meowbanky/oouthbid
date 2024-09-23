<?php
require_once('Connections/bid.php');
include('session_check.php');

// Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['SESS_MEMBER_ID']) || trim($_SESSION['SESS_MEMBER_ID']) == '') {
    header("location: index.php");
    exit();
}

if (!isset($_SESSION['company_id'])) {
    header("location: index.php");
    exit();
}

// Database connection
$mysqli = new mysqli($hostname_bid, $username_bid, $password_bid, $database_bid);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$col_recept = $_SESSION['company_id'];

// Prepare and execute query
$query_supp = "SELECT items.item, items.item_id, items.packSize, items.qty
               FROM items
               LEFT JOIN item_price ON item_price.item_id = items.item_id
               WHERE item_price.item_id IS NULL
               ORDER BY item_id ASC";

$result_supp = $mysqli->query($query_supp);

// Check for query error
if (!$result_supp) {
    die("Query failed: " . $mysqli->error);
}

$totalRows_supp = $result_supp->num_rows;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OOUTH SUPPLIMENTARY -- Powered By OOUTH ICT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.gritter.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link href="css/unicorn.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <link href="css/bootstrap-select.css" rel="stylesheet">
    <link href="css/select2.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/jquery.loadmask.css" rel="stylesheet">
    <link href="css/token-input-facebook.css" rel="stylesheet">
    <link href="css/dataTables.tableTools.css" rel="stylesheet">
    <link href="css/dataTables.tableTools.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/shortcut.js"></script>
    <script src="js/dataTables.tableTools.js" type="text/javascript"></script>
    <script src="js/dataTables.tableTools.min.js" type="text/javascript"></script>
    <script src="support/all.js" type="text/javascript"></script>
    <link href="support/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="support/jquery.min1.js"></script>
    <script src="support/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var SITE_URL = "index.php";
        $(document).ready(function() {
            $("#search").focus();
        });

        // Auto logout script
        function auto_logout(iSessionTimeout, iSessTimeOut, sessiontimeout) {
            window.setTimeout('', iSessionTimeout);
            window.setTimeout('winClose()', iSessTimeOut);
        }

        function winClose() {
            window.location = "index.php";
        }

        auto_logout(1440000, 1500000, 1500);
    </script>
</head>
<body data-color="grey" class="flat">
<div class="modal fade hidden-print" id="myModal"></div>
<div id="wrapper" class="minibar">
    <div id="header" class="hidden-print">
        <h1><a href="index.php"><img src="support/header_logo.png" class="hidden-print header-log" id="header-logo" alt=""></a></h1>
        <a id="menu-trigger" href="#"><i class="fa fa-bars fa fa-2x"></i></a>
        <div class="clear"></div>
    </div>
    <div id="user-nav" class="hidden-print hidden-xs">
        <ul class="btn-group">
            <li class="btn hidden-xs"><a title="" href="switch_user" data-toggle="modal" data-target="#myModal"><i class="icon fa fa-user fa-2x"></i> <span class="text">Welcome <b><?php echo htmlspecialchars($_SESSION['SESS_FIRST_NAME']); ?></b></span></a></li>
            <li class="btn hidden-xs disabled"><a title="" href="pos/" onclick="return false;"><i class="icon fa fa-clock-o fa-2x"></i> <span class="text"><?php echo date('l, F d, Y'); ?></span></a></li>
            <li class="btn"><a href="#"><i class="icon fa fa-cog"></i><span class="text">Settings</span></a></li>
            <li class="btn"><a href="index.php"><i class="fa fa-power-off"></i><span class="text">Logout</span></a></li>
        </ul>
    </div>
    <div id="sidebar" class="hidden-print minibar sales_minibar">
        <?php include('menu.php'); ?>
    </div>
    <div id="content" class="clearfix sales_content_minibar">
        <div id="receipt_wrapper">
            <div id="receipt_header">
                <div id="company_name">OLABISI ONABANJO UNIVERSITY TEACHING HOSPITAL, SAGAMU</div>
                <div id="sale_receipt">BID SUPPLIMENTARY LIST</div>
                <div id="sale_time"><?php echo date('l, F d, Y'); ?></div>
            </div>
            <div class="row">
                <div class="co12">
                    <div class="lotDetails"><strong></strong></div>
                    <table width="100%" border="1">
                        <tbody>
                        <tr>
                            <th>S/N</th>
                            <th>Item Id</th>
                            <th>List of Drugs/Items</th>
                            <th>QTY/YEAR</th>
                            <th>Pack Size</th>
                        </tr>
                        <?php
                        $i = 1;
                        while ($row_supp = $result_supp->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($row_supp['item_id']); ?></td>
                                <td><?php echo htmlspecialchars($row_supp['item']); ?></td>
                                <td><?php echo htmlspecialchars($row_supp['qty']); ?></td>
                                <td><?php echo htmlspecialchars($row_supp['packSize']); ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="row-fluid">
                        <div class="col-lg-12">
                            <div id='sale_details'></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sale_return_policy">Have a NICE DAY!<br /></div>
        </div>
        <div id="footer" class="col-md-12 hidden-print">
            Please visit our <a href="https://www.oouth.com" target="_blank">website</a> to learn the latest information about the project.
            <span class="text-info"><span class="label label-info">14.1</span></span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(window).load(function() { window.print(); });
</script>
</body>
</html>
<?php
$mysqli->close();
?>
