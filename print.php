<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers;
use App\App;
$App = new App();
$Auth = new Controllers\AuthController($App);
$Auth->loginCheck();
$company_id = $_SESSION['company_id'];
$printService = new Controllers\Price($App);
$biddedDepts = $printService->showBiddedDept($company_id);




?>
<?php include 'partials/main.php'; ?>

<head>
    <?php $title = "Print";
    include 'partials/title-meta.php'; ?>

    <?php include 'partials/head-css.php'; ?>
</head>

<body>

    <div class="flex wrapper">

        <?php include 'partials/menu.php'; ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">

            <?php include 'partials/topbar.php'; ?>

            <main class="flex-grow p-6">

                <?php
                $subtitle = "Dashboard";
                $pagetitle = "Print";
                include 'partials/page-title.php'; ?>

                <div class="card p-6">

                    <div class="w-full flex justify-between gap-2 my-2 flex-col md:flex-row">
                        <div>
                           <div class="relative">
                               <div class="relative inline-block w-full text-gray-300">
                                   <select id="dept_id" class="block w-full p-2 text-sm bg-gray-800 border border-gray-600 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-500 focus:outline-none">
                                       <option value="">Select an option</option>
                                       <option value="-1">All</option>
                                       <?php if($biddedDepts){
                                          foreach ($biddedDepts as $biddedDept){
                                          ?>
                                       <option value="<?php echo $biddedDept['dept_id']?>"><?php echo $biddedDept['dept']?></option>
                                        <?php }
                                       } ?>
                                   </select>
                               </div>

                           </div>
                        </div>
                    </div>
                    <div id="view_table">

                    </div>

                </div>

            </main>

            <?php include 'partials/footer.php'; ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    <?php include 'partials/customizer.php'; ?>

    <?php include 'partials/footer-scripts.php'; ?>

<script>
    $(document).ready(function() {

        $('#view_table').load('views/view_print.php',function(){

        })

        $('#dept_id').on("change",function () {
            let dept_id = $(this).val();
           $.post('views/view_print.php',{
              dept_id: dept_id
           },
           function(data){
               console.log(data)
               $('#view_table').html(data);
            })
               .fail(function(xhr,status,error){
                   console.log('Error ' + error )
               })
        })



    })
</script>

</body>

</html>