<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers;
use App\App;

$App = new App();
$Auth = new Controllers\AuthController($App);
$Auth->loginCheck();
$company_id = $_SESSION['company_id'];
$Subscription = new Controllers\SubscriptionController($App);
$subSelects = $Subscription->getAllSubscription($company_id);
$mySubscriptions = $Subscription->showSubscriptionDetails($company_id );



?>
<?php include 'partials/main.php'; ?>

<head>
    <?php $title = "Add Price";
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
                $pagetitle = "Add Price";
                include 'partials/page-title.php'; ?>

                <div class="card p-6">

                    <div class="w-full flex justify-between gap-2 my-2 flex-col md:flex-row">
                        <div>
                           <div class="relative">
                                <div class="pointer-events-none absolute top-3.5 start-4 text-gray-900 text-opacity-40 dark:text-gray-200">
                                    <i class="mgc_search_line text-xl"></i>
                                </div>
                                <form id="searchform" method="post">
                                    <input id="searchItem" autofocus name="search" type="search" class="rounded-md h-12 w-full border-0 bg-gray-600 ps-11 pe-4 text-gray-900 placeholder-gray-500 dark:placeholder-gray-300 dark:text-gray-200 focus:ring-0 sm:text-sm" placeholder="Search...">
                                </form>
                            </div>
                        </div>
                        <div class="py-4 flex flex-col text-xs text-gray-700 uppercase bg-gray-50  dark:text-gray-400 p-2">
                            <div class="flex justify-between dark:bg-gray-700 font-bold">
                                <div class="p-2">Bid security:</div>
                                <div class="p-2" id="bidSecurity"></div>
                            </div>
                            <div class="flex justify-between dark:bg-gray-700 font-bold border-t-2">
                                <div class="p-2">Total:</div>
                                <div class="p-2" id="total"></div>
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

        $('#view_table').load('views/view_price.php',function(){

        })

        bidsecurity();
        bidTotal();

        $("#searchItem").autocomplete({
            source: 'libs/searchItem.php',
            type: 'POST',
            delay: 10,
            autoFocus: false,
            minLength: 3,
            select: function (event, ui) {
                event.preventDefault();
                $("#search").val(ui.item.value);

                $('#searchform').ajaxSubmit({
                    url: 'libs/item_price.php', // URL for form submission
                    type: 'POST', // Method for form submission
                    data:{item_id:ui.item.value,
                          action:'insert'},
                    success: function(response) {
                        $('#view_table').load('views/view_price.php', function() {
                            // Autofocus()
                        });
                        bidTotal();
                        bidsecurity();
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response here
                        console.log(error);
                    }
                });

            }
        });


        function Autofocus() {
            // Select all input elements of type number
            let index = localStorage.getItem('lastFocusIndex');
            const inputs = document.querySelectorAll('input[type="number"]');

            // Check if there are any inputs
            if (inputs.length > 0) {
                const lastInput = inputs[index]; // Get the last input element

                // Focus on the last input element
                setTimeout(() =>{
                    lastInput.focus();
                    lastInput.select();
                },100)


            } else {
                console.error('No input elements found.');
            }
        }



        function bidTotal(){
            $.post('libs/item_price.php',
                {action:"bidtotal"},
                function(data){
                    $('#total').html(data)
                })
        }

        function bidsecurity(){
            $.post('libs/item_price.php',
                {action:"total_bidsec"},
                function(data){
                    $('#bidSecurity').html(data)
                })
        }

    })
</script>

</body>

</html>