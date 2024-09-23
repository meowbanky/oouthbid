<?php
require_once('Connections/bid.php');
include('session_check.php');

// Check if the session variables are set
if(!isset($_SESSION['SESS_MEMBER_ID']) || trim($_SESSION['SESS_MEMBER_ID']) == '') {
    header("Location: index.php");
    exit();
}

if(!isset($_SESSION['company_id'])) {
    header("Location: index.php");
    exit();
}

$col_itemSearch = -1;
$percent = 0;

if (isset($_POST['company_id'])) {
    $col_itemSearch = $_POST['company_id'];
    $percent = $_POST['percentage'];
}

// Prepared statements for secure SQL queries
$mysqli = new mysqli($hostname_bid, $username_bid, $password_bid, $database_bid);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query_itemPrint = $mysqli->prepare("SELECT ANY_VALUE(item_price.company_id) AS company_id, ANY_VALUE(item_price.price) AS price, ANY_VALUE(item_price.qty) AS qty, ANY_VALUE(items.dept_id) AS dept_id, ANY_VALUE(tbl_dept.dept) AS dept 
    FROM tbl_evaluation
    INNER JOIN item_price ON item_price.item_price_id = tbl_evaluation.item_price_id
    INNER JOIN items ON items.item_id = item_price.item_id
    INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
    WHERE item_price.company_id = ?
    GROUP BY items.dept_id");
$query_itemPrint->bind_param("s", $col_itemSearch);
$query_itemPrint->execute();
$result_itemPrint = $query_itemPrint->get_result();
$totalRows_itemPrint = $result_itemPrint->num_rows;

$query_company = $mysqli->prepare("SELECT company_id, company_name, company_tel, company_address, state, lg, email, userid
    FROM tbl_company WHERE company_id = ?");
$query_company->bind_param("s", $col_itemSearch);
$query_company->execute();
$result_company = $query_company->get_result();
$row_company = $result_company->fetch_assoc();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($_SESSION['companyName']); ?> -- Powered By OOUTH ICT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- jQuery Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Select2 CSS and JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <!-- jQuery UI Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet" type="text/css" media="all">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">

    <!-- Gritter CSS -->
    <link href="https://cdn.jsdelivr.net/npm/gritter@1.7.4/css/jquery.gritter.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/gritter@1.7.4/js/jquery.gritter.min.js"></script>

    <!-- Custom CSS -->
    <link href="css/unicorn.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/custom.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/token-input-facebook.css" rel="stylesheet" type="text/css" media="all">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <!-- Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" media="all">

    <!-- Bootstrap Select CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" media="all">

    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">

    <!-- Loadmask CSS -->
    <link href="https://cdn.jsdelivr.net/npm/jquery.loadmask@1.0.1/jquery.loadmask.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery.loadmask@1.0.1/jquery.loadmask.min.js"></script>

    <!-- DataTables CSS and JS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- DataTables TableTools CSS and JS -->
    <link href="https://cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>

    <script src="js/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#search").focus();
        });
        var SITE_URL= "index.php";
    </script>
    <script type="text/javascript">
        COMMON_SUCCESS = "Success";
        COMMON_ERROR = "Error";
        $.ajaxSetup({
            cache: false,
            headers: { "cache-control": "no-cache" }
        });
        $(document).ready(function() {
            $("#employee_current_location_id").change(function() {
                $("#form_set_employee_current_location_id").ajaxSubmit(function() {
                    window.location.reload(true);
                });
            });
        });
        var isNS4 = (navigator.appName == "Netscape") ? 1 : 0;
        function auto_logout(iSessionTimeout, iSessTimeOut, sessiontimeout) {
            window.setTimeout('', iSessionTimeout);
            window.setTimeout('winClose()', iSessTimeOut);
        }
        function winClose() {
            if (!isNS4) {
                window.navigate("index.php");
            } else {
                window.location = "index.php";
            }
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
    </div>
    <div id="user-nav" class="hidden-print hidden-xs">
        <ul class="btn-group">
            <li class="btn hidden-xs"><a title="" href="switch_user" data-toggle="modal" data-target="#myModal"><i class="icon fa fa-user fa-2x"></i> <span class="text">Welcome <b><?php echo ($_SESSION['SESS_FIRST_NAME']); ?></b></span></a></li>
            <li class="btn hidden-xs disabled">
                <a title="" href="pos/" onclick="return false;"><i class="icon fa fa-clock-o fa-2x"></i> <span class="text">
                        <?php
                        echo date('l, F d, Y', strtotime(date('y:m:d')));
                        ?>
                    </span></a>
            </li>
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
                <div id="company_name"><?php echo htmlspecialchars($row_company['company_name']); ?></div>
                <div id="company_address"><?php echo htmlspecialchars($row_company['company_address']); ?></div>
                <div id="company_phone"><?php echo htmlspecialchars($row_company['company_tel']); ?></div>
                <div id="company_state"><?php echo htmlspecialchars($row_company['state']); ?></div>
                <div id="company_lg"><?php echo htmlspecialchars($row_company['lg']); ?></div>
                <div id="company_email"><?php echo htmlspecialchars($row_company['email']); ?></div>
                <div id="website"></div>
                <div id="sale_receipt">Letter of Award</div>
                <div id="sale_time"><?php echo date('l, F d, Y', strtotime(date('y:m:d'))); ?></div>
            </div>
            <div id="receipt_general_info">
                <div id="merchant_id"></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="register" class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="item_name_heading"><strong>S/N</strong></th>
                            <th class="item_name_heading"><strong>ITEM NO</strong></th>
                            <th class="item_name_heading"><strong>DRUGS/ITEMS</strong></th>
                            <th class="item_name_heading"><strong>UNIT/ PACK</strong></th>
                            <th class="item_name_heading"><strong>TOTAL QTY AWARDED</strong></th>
                            <th class="item_name_heading"><strong>QUOTED PRICE</strong></th>
                            <th class="item_name_heading"><strong>AMOUNT</strong></th>
                        </tr>
                        </thead>
                        <?php if ($totalRows_itemPrint > 0) {
                            while ($row_itemPrint = $result_itemPrint->fetch_assoc()) { ?>
                                <tr>
                                    <td colspan="6"><strong><?php echo htmlspecialchars($row_itemPrint['dept']); ?></strong></td>
                                    <td align="right">&nbsp;</td>
                                </tr>
                                <?php
                                $query_itemSearch = $mysqli->prepare("SELECT ANY_VALUE(item_price.company_id) AS company_id, ANY_VALUE(item_price.price) AS price, ANY_VALUE(item_price.qty) AS qty, ANY_VALUE(items.dept_id) AS dept_id, tbl_dept.dept, items.packSize as unit,items.item_id, items.item
                                    FROM tbl_evaluation
                                    INNER JOIN item_price ON item_price.item_price_id = tbl_evaluation.item_price_id
                                    INNER JOIN items ON items.item_id = item_price.item_id
                                    INNER JOIN tbl_dept ON tbl_dept.dept_id = items.dept_id
                                    WHERE item_price.company_id = ? AND items.dept_id = ?
                                    GROUP BY items.item_id");
                                $query_itemSearch->bind_param("si", $col_itemSearch, $row_itemPrint['dept_id']);
                                $query_itemSearch->execute();
                                $result_itemSearch = $query_itemSearch->get_result();
                                $totalRows_itemSearch = $result_itemSearch->num_rows;

                                if ($totalRows_itemSearch > 0) {
                                    $i = 0;
                                    while ($row_itemSearch = $result_itemSearch->fetch_assoc()) { ?>
                                        <tr>
                                            <td align="center"><?php echo ++$i; ?></td>
                                            <td><?php echo htmlspecialchars($row_itemSearch['item_id']); ?></td>
                                            <td><?php echo htmlspecialchars($row_itemSearch['item']); ?></td>
                                            <td><?php echo htmlspecialchars($row_itemSearch['unit']); ?></td>
                                            <td><?php echo htmlspecialchars($row_itemSearch['qty']); ?></td>
                                            <td><?php echo number_format($row_itemSearch['price'], 2); ?></td>
                                            <td><?php echo number_format(($row_itemSearch['qty'] * $row_itemSearch['price']), 2); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php }
                            }
                        } ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary hidden-print" onclick="window.print();">Print</button>
                    <a href="dashboard" class="btn btn-info hidden-print">Finish</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
$mysqli->close();
?>
