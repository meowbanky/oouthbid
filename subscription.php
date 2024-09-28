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
    <?php $title = "Subscription";
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
                $pagetitle = "Subscription";
                include 'partials/page-title.php'; ?>

                <div class="card p-6">

<div class="w-full flex justify-end gap-2 my-2">
    <div><button data-fc-target="default-modal" data-fc-type="modal" class="btn text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Buy Sub.</button>
    </div>
</div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="subscription_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" data-sortable="true">
                                    Department
                                </th>
                                <th scope="col" class="px-6 py-3" data-sortable="true">
                                    <div class="flex items-center">
                                        Price
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3"  data-sortable="true">
                                    <div class="flex items-center">
                                        Company Name
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3"  data-sortable="true">
                                    <div class="flex items-center">
                                        Description
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($mySubscriptions){
                                foreach($mySubscriptions as $mySubscription){
                                    ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <?php echo $mySubscription['dept']; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo $mySubscription['price']; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo $mySubscription['company_name']; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo $mySubscription['lot_description']; ?>
                                        </td>
                                    </tr>
                                <?php }
                             ?>
                            </tbody>
                        </table>
                        <?php } else { ?>
                         <span class="font-bold text-gray-500 dark:text-gray-400">No Subscription Available</span>
                        <?php } ?>
                    </div>

                    <div id="default-modal" class="w-full h-full mt-5 fixed top-0 left-0 z-50 transition-all duration-500 fc-modal hidden">
                        <div class="fc-modal-open:opacity-100 duration-500 opacity-500 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto flex flex-col bg-white border shadow-sm rounded-md dark:bg-slate-800 dark:border-gray-700">
                            <div class="flex justify-between items-center text-gray-800 py-2.5 px-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="font-medium text-gray-800 dark:text-white text-lg">
                                    Buy Subscription
                                </h3>
                                <button class="inline-flex flex-shrink-0 justify-center items-center h-8 w-8 text-gray-800 dark:text-gray-200"
                                        data-fc-dismiss type="button">
                                    <span class="material-symbols-rounded">close</span>
                                </button>
                            </div>
                            <div class="px-4 py-8 overflow-y-auto bg-white dark:bg-slate-800">
                                <p class="text-gray-800 dark:text-gray-200">
                                <form id="paymentForm" action="" method="POST" target="_blank" class="p-4 md:p-5 bg-white dark:bg-slate-800">
                                    <div class="grid gap-4 mb-4 grid-cols-2">
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="subscription" class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">Subscription</label>
                                            <select id="subscription" class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                <option selected="">Select Sub.</option>
                                                <?php if($subSelects){
                                                    foreach ($subSelects as $subSelect){
                                                        ?>
                                                        <option data-price="<?php echo $subSelect['price'] ;?>" value="<?php echo $subSelect['dept_id'] ;?>"><?php echo $subSelect['dept'] ;?> - <?php echo $subSelect['price'] ;?></option>
                                                    <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="price" class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">Price</label>
                                            <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="2999" required="" readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" name="subscription_id" id="subscription_id" value="">
                                    <div class="flex flex-row gap-2">
                                        <button type="button" id="payflutter" name="paynow" class="h-16 w-32 text-white inline-flex flex-col items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <img class="block w-full h-full" src="assets/images/brands/flutterwave.256x48.png" alt="Image" />
                                        </button>
                                        <button type="button" id="payremitta" name="paynow" class="h-16 w-32 text-white inline-flex flex-col items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <img class="block w-full h-full" src="assets/images/brands/remitta.png" alt="Image" />
                                        </button>
                                    </div>

                                </form>
                                </p>
                            </div>
                            <div class="flex justify-end items-center gap-4 p-4 border-t border-gray-200 dark:border-slate-700">
                                <button class="btn text-gray-800 border border-gray-200 hover:bg-gray-100 dark:text-gray-200 dark:border-slate-700 hover:dark:bg-slate-700 transition-all" data-fc-dismiss type="button">Close
                                </button>
                            </div>
                        </div>
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
        $('#subscription_table').DataTable({
            searching: false,
            pageLength: 100,
            lengthChange: false,
            ordering: true,
            dom: '<"flex  items-center justify-between my-2"lf>t<"flex items-center justify-between"ip>',

        });

        $('#subscription').change(function() {
        var subscription_id = $(this).val();
        var selectedPrice =  $(this).find('option:selected')
        var price = selectedPrice.data('price');
        $('#subscription_id').val(subscription_id) ;
        $('#price').val(price);
        })

        $('#payflutter').click(function() {
           var subscriptionId =  $('#subscription_id').val()
            if(subscriptionId === ''){
                displayAlert("Please select a subscription","center","error");
                return false;
;            }
            initiatePayment(subscriptionId);

        })

        function initiatePayment(subscriptionId) {

            const paymentUrl = `process_payment.php?subscriptionId=${subscriptionId}`;
            // Open the payment gateway in a new tab
            const paymentTab = window.open(paymentUrl, '_blank');

            // Store the subscription ID and reference to the original tab in localStorage
            localStorage.setItem('subscriptionId', subscriptionId);
            localStorage.setItem('paymentTab', paymentTab);
        }

        // Listen for the payment success message from the payment tab
        window.addEventListener('message', function(event) {
            if (event.data === 'payment_success') {
                displayAlert('Payment Successful', 'center','success')
                window.location.reload();
            }
        });


    })
</script>

</body>

</html>