<?php

require_once __DIR__ . './../vendor/autoload.php';

use App\Controllers;
use App\App;
$App = new App();
$Auth = new Controllers\AuthController($App);
$Auth->loginCheck();
$company_id = $_SESSION['company_id'];
$Price = new Controllers\Price($App);
$price_items = $Price->showPriceItemsByCompany($company_id);


?>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="price_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" data-sortable="true">
                    S/N
                </th>
                <th scope="col" class="px-6 py-3" data-sortable="true">
                    Delete
                </th>
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
        <?php if($price_items){
            $sn = 1;
            foreach($price_items as $price_item){
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        <?php echo $sn; ?>
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" data-itempriceno="<?php echo $price_item['item_price_id']; ?>"
                           class="delete_item"><i class="mgc_delete_2_line text-2xl"></i> </a>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $price_item['item']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $price_item['qty']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $price_item['qty']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo $price_item['spec']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <input class="qty w-auto px-2 py-1 min-w-[80px] max-w-[100px] bg-gray-100 border border-gray-300 rounded-lg
             focus:outline-none focus:ring-2 focus:ring-blue-500
             focus:border-blue-500 transition duration-200 ease-in-out" data-itempriceno="<?php echo $price_item['item_price_id']; ?>" type="number" value="<?php echo $price_item['price_qty']; ?>">
                    </td>
                    <td class="px-6 py-4">
                        <input class="price w-auto px-2 py-1 min-w-[40px] max-w-[100px] bg-gray-100 border border-gray-300 rounded-lg
             focus:outline-none focus:ring-2 focus:ring-blue-500
             focus:border-blue-500 transition duration-200 ease-in-out"  data-itempriceno="<?php echo $price_item['item_price_id']; ?>"  type="number" value="<?php echo $price_item['price_price']; ?>">
                    </td>
                    <td class="px-6 py-4">
                        <?php echo number_format($price_item['price_price']*$price_item['price_qty'],2); ?>
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

        $(document).on('focusin',function(event)
        {
            const target = $(event.target)
            if(target.is('input[type="number"]')){
                let index = $('input[type="number"]').index(target)
                localStorage.setItem('lastFocusIndex',index);
            }else{
                localStorage.setItem('lastFocusIndex','');
            }
        })

        $('.delete_item').on('click', function(event){
            event.preventDefault()
            const url = 'libs/item_price.php';
            const itemPriceId = $(this).data('itempriceno');
            const action = "delete";
            $.post(url,{action:action,itemPriceId:itemPriceId}, function(){
                $('#view_table').load('views/view_price.php',function(){
                    bidTotal();
                    bidsecurity();
                })
            })
        })
                function Autofocus() {
            // Select all input elements of type number
            let index = parseInt(localStorage.getItem('lastFocusIndex'),10);
            const inputs = document.querySelectorAll('input[type="number"]');

            // Check if there are any inputs
            if (inputs.length > 0 && !isNaN(index) && index < inputs.length) {
                const lastInput = inputs[index]; // Get the last input element

                // Focus on the last input element
                setTimeout(() =>{
                   if(lastInput && lastInput.type === 'number') {
                        lastInput.focus();
                        lastInput.select();
                    }
                },100)
            } else {
                console.error('No input elements found.');
            }
        }

        $('#price_table').DataTable({
            searching: false,
            pageLength: 100,
            lengthChange: false,
            ordering: true,
            dom: '<"flex  items-center justify-between my-2"lf>t<"flex items-center justify-between"ip>',

        });

        $('.qty').on('blur', function() {
            // Your blur event logic here
            let index = $('.qty').index(this);
            let value = $(this).val();
            let item_price_id = $(this).data('itempriceno');
            $.post('libs/item_price.php', {
                action: 'update',
                value: value,
                item_price_id: item_price_id,
                column: 'qty'
                },function() {
                $('#view_table').load('views/view_price.php',function(){
                     Autofocus(index);
                })
                bidTotal();
                bidsecurity();
                }
            )
        })

        $('.price').on('blur', function() {
            // Your blur event logic here
            let index = $('.price').index(this);

            let value = $(this).val();
            let item_price_id = $(this).data('itempriceno');
            $.post('libs/item_price.php', {
                    action: 'update',
                    value: value,
                    item_price_id: item_price_id,
                    column: 'price'
                },function() {
                    $('#view_table').load('views/view_price.php',function(){
                        Autofocus(index);
                    })
                    bidTotal();
                    bidsecurity();
                }
            )
        });

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