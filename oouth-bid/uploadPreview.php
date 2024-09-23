<?php
require_once('Connections/bid.php');
session_start();

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
    switch ($theType) {
        case "text":
            $theValue = ($theValue != "") ? "'" . mysqli_real_escape_string($GLOBALS['bid'], $theValue) . "'" : "NULL";
            break;
        case "long":
        case "int":
            $theValue = ($theValue != "") ? intval($theValue) : "NULL";
            break;
        case "double":
            $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
            break;
        case "date":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "defined":
            $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
            break;
    }
    return $theValue;
}

if (isset($_GET['id'])) {
    $stmt = $bid->prepare("SELECT document_path FROM tbl_document WHERE document_id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $stmt->bind_result($fileInf);
    $stmt->fetch();
    $stmt->close();

    if ($fileInf) {
        unlink($fileInf);
        $stmt = $bid->prepare("DELETE FROM tbl_document WHERE document_id = ?");
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $stmt->close();
    }
}

$stmt = $bid->prepare("SELECT tbl_document.document_path, tbl_documenttype.documentType, tbl_document.document_id 
FROM tbl_documenttype 
INNER JOIN tbl_document ON tbl_document.document_type = tbl_documenttype.documentType_id 
WHERE company_id = ? 
ORDER BY document_id DESC");
$stmt->bind_param("i", $_SESSION['company_id']);
$stmt->execute();
$result = $stmt->get_result();
$totalRows_pixPrev = $result->num_rows;
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Untitled Document</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
</head>
<body>
<?php if ($totalRows_pixPrev > 0) { ?>
    <table width="200" border="1">
        <tbody>
        <tr>
            <th>S/N</th>
            <th>Picture</th>
            <th>Document Type</th>
            <th><button id="deletbutton" class="btn-danger">Delete Selected</button></th>
        </tr>
        <?php $i = 1; while ($row_pixPrev = $result->fetch_assoc()) { ?>
            <tr>
                <th scope="row"><?php echo $i; ?></th>
                <td><img src="<?php echo $row_pixPrev['document_path']; ?>" width="123" height="126" class="preview" alt=""/></td>
                <td><?php echo $row_pixPrev['documentType']; ?></td>
                <td>
                    <p>
                        <input type="checkbox" name="checkbox" class="delete-checkbox" value="<?php echo $row_pixPrev['document_id']; ?>">
                    </p>
                </td>
            </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
<?php } ?>

<script>
    $(document).ready(function() {
        $("#deletbutton").click(function() {
            var selected = [];
            $(".delete-checkbox:checked").each(function() {
                selected.push($(this).val());
            });

            if (selected.length > 0) {
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure you want to delete the selected pictures?',
                    buttons: {
                        confirm: function () {
                            $("#deletbutton").text('Deleting..');
                            $.each(selected, function(index, id) {
                                $.ajax({
                                    url: "uploadPreview.php",
                                    type: "GET",
                                    data: { id: id },
                                    success: function(result) {
                                        $("#pixPrev").load('uploadPreview.php');
                                        location.reload(true);
                                    }
                                });
                            });
                            $("#deletbutton").text('Delete Selected');
                        },
                        cancel: function () {}
                    }
                });
            } else {
                $.alert({
                    title: 'Alert!',
                    content: 'Select at least one item to delete!'
                });
            }
        });
    });
</script>
</body>
</html>

