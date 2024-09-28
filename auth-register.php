<?php include 'partials/main.php'; ?>

<head>
    <?php $title = "Register";
    include 'partials/title-meta.php'; ?>

    <?php include 'partials/head-css.php'; ?>
</head>

<body class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">

<div class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="flex justify-center items-center overflow-auto">

        <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
            <div class="card sm:rounded-md rounded-none">
                <div class="mt-8 p-6 overflow-y-auto bg-white dark:bg-gray-800 shadow-md">
                    <a href="index.php" class="block mb-8">
                        <img class="h-6 block dark:hidden" src="assets/images/logo-dark.png" alt="">
                        <img class="h-6 hidden dark:block" src="assets/images/logo-light.png" alt="">
                    </a>
                    <form method="post" name="companyregistration" id="companyregistration">
                        <div class="mb-4 relative">
                            <input id="comp_name" required name="comp_name" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_name">Company Name</label>
                            <div id="companyNameFeedback" class="mt-1 text-sm"></div>
                        </div>

                        <div class="mb-4 relative">
                            <input id="comp_email" required name="comp_email" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="email" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_email">Company Email Address</label>
                            <div id="companyEmailFeedback" class="mt-1 text-sm"></div>
                        </div>

                        <div class="mb-4 relative">
                            <input id="comp_tel" required name="comp_tel" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="number" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_tel">Company Tel. No.</label>
                        </div>

                        <div class="mb-4 relative">
                            <input id="comp_rcno" name="comp_rcno" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_rcno">Registration No.</label>
                        </div>

                        <div class="mb-4 relative">
                            <input id="comp_address1" required name="comp_address1" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_address1">Address</label>
                        </div>

                        <div class="mb-4 relative">
                            <input id="comp_address2" name="comp_address2" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_address2">Address 2</label>
                        </div>

                        <div class="mb-4 relative">
                            <input id="comp_state" required name="comp_state" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_state">State</label>
                        </div>

                        <div class="mb-4 relative">
                            <input id="comp_lg" required name="comp_lg" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_lg">LG</label>
                        </div>

                        <div class="mb-4 relative">
                            <input id="comp_city" required name="comp_city" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_city">City</label>
                        </div>
                        <div class="mb-4 relative">
                            <input id="comp_taxno" name="comp_taxno" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" ">
                            <label class="ml-2 px-2 absolute text-gray-500 dark:text-gray-400 block bg-gray-50 roundeddark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4" for="comp_taxno">Tax No.</label>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" required class="form-checkbox rounded" id="checkbox-signup">
                                <label class="ms-2 text-slate-900 dark:text-slate-200" for="checkbox-signup">I accept <a href="#" class="text-gray-400 underline">Terms and Conditions</a></label>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="backdrop" id="backdrop">
        <div class="spinner"></div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function() {

            $('#comp_name').on("input",function(){
                var companyName = $(this).val();
                $('#companyNameFeedback').html('');
                if(companyName.length > 4){
                $.ajax({
                    type: 'POST',
                    url: 'libs/check-company-name.php',
                    data:{companyName:companyName},
                    dataType: 'JSON',
                    success:function (response){
                        if(response.status === 'success'){
                            $('#companyNameFeedback').html('<span class="text-green-500">' + response.message + '</span>');
                        }else{
                            $('#companyNameFeedback').html('<span class="text-red-500">' + response.message + '</span>');
                        }
                    },
                    error: function (xhr,status,error){
                        cosole.log(error)
                        $('#companyNameFeedback').html('<span class="text-red-500">An error occurred. Please try again.</span>');
                    }
                })

                }
            })

            $('#comp_email').on("input",function(){
                var comp_email = $(this).val();
                $('#companyEmailFeedback').html('');
                if(comp_email.length > 4){
                    $.ajax({
                        type: 'POST',
                        url: 'libs/check-company-name.php',
                        data:{comp_email:comp_email},
                        dataType: 'JSON',
                        success:function (response){
                            if(response.status === 'success'){
                                $('#companyEmailFeedback').html('<span class="text-green-500">' + response.message + '</span>');
                            }else{
                                $('#companyEmailFeedback').html('<span class="text-red-500">' + response.message + '</span>');
                            }
                        },
                        error: function (xhr,status,error){
                            cosole.log(error)
                            $('#companyEmailFeedback').html('<span class="text-red-500">An error occurred. Please try again.</span>');
                        }
                    })

                }
            })

            $('#companyregistration').submit(function(event) {
                event.preventDefault();
                document.getElementById("backdrop").style.display = "flex";

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'libs/add-auth-register.php', // PHP script to handle form submission
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        $('#backdrop').hide(); // Hide backdrop in all cases

                        if (response.status === 'success') {
                            displayAlert(response.message, 'center', 'success');
                            setTimeout(function(){
                                window.location.href = 'index.php';
                            },5000)

                        } else if (response.status === 'error' && response.errors) {
                            var errors ='';
                            response.errors.forEach(function(error) {
                                errors += error + '<br>';
                            });
                            displayAlert(errors, 'center', 'error');
                            document.getElementById("backdrop").style.display = "none"
                        } else {
                            displayAlert(response.message, 'center', 'error');
                            document.getElementById("backdrop").style.display = "none";
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#backdrop').hide();
                        console.log(error);
                        displayAlert('An unexpected error occurred. Please try again later.', 'center', 'error');
                    }
                });
            });

        })
    </script>

</body>

</html>