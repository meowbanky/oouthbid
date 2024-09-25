<?php

require_once __DIR__ . './../vendor/autoload.php';

use App\Controllers;
use App\App;
$App = new App();
$Auth = new Controllers\AuthController($App);
$Auth->loginCheck();
$company_id = $_SESSION['company_id'];
$dept_id = isset($_POST['dept_id']) ? $_POST['dept_id'] : -1;
$PriceService = new Controllers\PrintServices($App);
$printlists = $PriceService->showPriceItemsByCompany($company_id);
$printlists = $PriceService->showItemList($company_id,$dept_id);


?>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg print:block">

    <table id="price_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" data-sortable="true">
                    S/N
                </th>
                <th scope="col" class="px-6 py-3" data-sortable="true">
                    <div class="flex items-center">
                        Item No.
                    </div>
                <th scope="col" class="px-6 py-3" data-sortable="true">
                    <div class="flex items-center">
                        Item
                    </div>
                </th>
                <th scope="col" class="px-6 py-3"  data-sortable="true">
                    <div class="flex items-center">
                        Qty/Year
                    </div>
                </th>
                <th scope="col" class="px-6 py-3"  data-sortable="true">
                    <div class="flex items-center">
                        Pack Size Spec.
                    </div>
                </th>
                <th scope="col" class="px-6 py-3"  data-sortable="true">
                    <div class="flex items-center">
                        Spec.
                    </div>
                </th>
                <th scope="col" class="px-6 py-3"  data-sortable="true">
                    <div class="flex items-center">
                        Qty
                    </div>
                </th>
                <th scope="col" class="px-6 py-3"  data-sortable="true">
                    <div class="flex items-center">
                        Unit Price
                    </div>
                </th>
                <th scope="col" class="px-6 py-3"  data-sortable="true">
                    <div class="flex items-center">
                        Total Amount
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php if($printlists){
            $sn = 1;
            foreach($printlists as $printlist){
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        <?php echo $sn; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $printlist['item_id']; ?>
                    </td>
                    <td class="px-6 py-4 uppercase">
                        <?php echo $printlist['item']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $printlist['qty_year']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $printlist['packSize']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $printlist['spec']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $printlist['qty']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo number_format($printlist['price'],2); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo number_format($printlist['price']*$printlist['qty'],2); ?>
                    </td>
                </tr>
            <?php $sn++;}
        } else { ?>

        <?php } ?>
        </tbody>

    </table>
</div>
<script>
    $(document).ready(function() {

        $('#price_table').DataTable({
            searching: false,
            pageLength: 100,
            lengthChange: false,
            ordering: true,
            dom: '<"flex  items-center justify-between my-2"lf>t<"flex items-center justify-between"ip>',

        });

    })
</script>