<?php 
include('session_check.php');
require_once('Connections/bid.php'); 
//session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
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
}


mysql_select_db($database_bid, $bid);

$query_Period = "SELECT tbl_documenttype.documentType_id, tbl_documenttype.documentType FROM tbl_documenttype order by documentType_id asc";
$Period = mysql_query($query_Period, $bid) or die(mysql_error());
$row_Period = mysql_fetch_assoc($Period);
$totalRows_Period = mysql_num_rows($Period);

$query_documentType = "SELECT tbl_documenttype.documentType_id, tbl_documenttype.documentType FROM tbl_documenttype";
$documentType = mysql_query($query_documentType, $bid) or die(mysql_error());
$row_documentType = mysql_fetch_assoc($documentType);
$totalrow_documentType = mysql_num_rows($documentType);

if (isset($_GET['id'])){

$queryDelete = "delete from tbl_document where document_id = '".$_GET['id']."'";
$pixPrev = mysql_query($queryDelete, $bid) or die(mysql_error());
}

?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/fav.png" />
    <!-- Author Meta -->
    <meta name="author" content="colorlib" />
    <!-- Meta Description -->
    <meta name="description" content="" />
    <!-- Meta Keyword -->
    <meta name="keywords" content="" />
    <!-- meta character set -->
    <meta charset="UTF-8" />
    <!-- Site Title -->
    <title>OOUTH BID - Sign UP</title>

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900|Roboto:400,400i,500,700" rel="stylesheet" />
    <!--
      CSS
      =============================================
    -->
    <link rel="stylesheet" href="css/linearicons.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/owl.carousel.css" />
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/hexagons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/signupbg.css" />
      
    <script src="js/jquery.nice-select.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/jquery.nice-select.js"></script>
    
</head>

<body>
    <div class="bodybg">
        <div class="forminput">

            <h2 class="text-black">
                Submit Documents<br> </h2><br>

            <h4>Ensure all fields are filled appropriately</h4><br><br>
            <br>
            <br> <br>
            <br> <br> Annual Practice Licence <br>
                <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
<div id="image_preview"><img id="previewing" src="noimage.png" /></div>
<hr id="line">
<div id="selectImage">
<label>Select Your Image</label><br/>
<input name="file" type="file" required class="badge-dark" id="file" />
<input type="submit" value="Upload" class="alert-danger" />

    <select name="documentType" required="required" id="documentType" >
                                 <option value="0">Select Document Type</option>
                                 <?php
do {  
?>
                                 <option value="<?php echo $row_Period['documentType_id']?>"><?php echo $row_Period['documentType']?></option>
                                 <?php
} while ($row_Period = mysql_fetch_assoc($Period));
  $rows = mysql_num_rows($Period);
  if($rows > 0) {
      mysql_data_seek($Period, 0);
	  $row_Period = mysql_fetch_assoc($Period);
  }
?>
                               </select>
    


          </form>
      </div>
</div>
<h4 id='loading' >loading..</h4>
<div id="message"></div>
                <br> <br>
    <div id="pixPrev"></div>
    

 
    </div>
    <hr id="line">
   
<script>
    
$(document).ready(function (e) {
$('select').niceSelect();
 $("#pixPrev").load('uploadPreview.php');   
$("#uploadimage").on('submit',(function(e) {
    if($('#documentType').val() == 0){
        alert('kindly select Document Type');
        $('#documentType').focus();
        return false;
        
    }
    e.preventDefault();
$("#message").empty();
$('#loading').show();
$.ajax({
url: "ajax_php_file.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$('#loading').hide();
$("#message").html(data);
$("#pixPrev").load('uploadPreview.php');
 $('#file').empty();   
}
});
}));

// Function to preview image after validation
$(function() {
$("#file").change(function() {
    
$("#message").empty(); // To remove the previous error message
var file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{
   
$('#previewing').attr('src','noimage.png');
$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
    
return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});
function imageIsLoaded(e) {
$("#file").css("color","green");
$('#image_preview').css("display", "block");
$('#previewing').attr('src', e.target.result);
$('#previewing').attr('width', '250px');
$('#previewing').attr('height', '230px');
};
});
    
    $("button").click(function(){
    $.ajax({url: "uploadPreview.php?id=40", success: function(result){
     // $("#div1").html(result);
        alert(result);
    }});
  });


    </script>
</body>

</html>