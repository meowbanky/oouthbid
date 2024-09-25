
<?php include 'partials/main.php'; ?>

<head>
    <?php $title = "Recover Password";
    include 'partials/title-meta.php'; ?>

    <?php include 'partials/head-css.php'; ?>
</head>

<body>

    <div class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="h-screen w-screen flex justify-center items-center">

            <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
                <div class="card overflow-hidden sm:rounded-md rounded-none bg-gray-50 dark:bg-gray-800 shadow-md">
                    <div class="p-6">
                        <a href="index.php" class="block mb-8">
                            <img class="h-6 block dark:hidden" src="assets/images/logo-dark.png" alt="Logo">
                            <img class="h-6 hidden dark:block" src="assets/images/logo-light.png" alt="Logo">
                        </a>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="LoggingEmailAddress">Email Address</label>
                            <input id="LoggingEmailAddress" class="form-input" type="email" placeholder="Enter your email" >
                        </div>

                        <div class="flex justify-center mb-6">
                            <button id="send" class="btn w-full text-white bg-primary"> Reset Password </button>
                        </div>

                        <div class="flex items-center my-6">
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                            <div class="mx-4 text-secondary">Or</div>
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        </div>
                    
                        <p class="text-gray-500 dark:text-gray-400 text-center">Back to<a href="index.php" class="text-primary ms-1"><b>Log In</b></a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function() {
            $('#send').click(function (event) {
                $.ajax({
                    dataType: 'json',
                    url: 'libs/request_reset.php',
                    method: 'POST',
                    data: {
                        email: $('#LoggingEmailAddress').val(),
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            displayAlert(response.message, 'center', 'success');
                        } else {
                            displayAlert(response.message, 'center', 'error');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error: ', textStatus, errorThrown);
                    }
                });
            });
        })
</script>
</body>

</html>