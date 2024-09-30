<?php include 'partials/main.php'; ?>

<head>
    <?php $title = "Login";
    include 'partials/title-meta.php'; ?>
    <?php include 'partials/head-css.php'; ?>
</head>

<body class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black text-gray-900 dark:text-gray-100">

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="h-screen w-screen flex justify-center items-center">

    <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
        <div class="card overflow-hidden sm:rounded-md rounded-none bg-gray-50 dark:bg-gray-800 shadow-md">
            <form class="p-6" method="POST" name="form_login" id="form_login">
                <a href="index.php" class="block mb-8">
                    <img class="h-6 block dark:hidden" src="assets/images/logo-dark.png" alt="Logo">
                    <img class="h-6 hidden dark:block" src="assets/images/logo-light.png" alt="Logo">
                </a>
                <div class="mb-4 relative">
                    <input id="email" required name="email" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="email" placeholder=" ">
                    <label class="absolute ml-2 px-2 text-gray-500 rounded dark:text-gray-400 block bg-gray-50 dark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-gray-50 peer-focus:dark:bg-gray-700 peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1" for="email">Email</label>
                </div>

                <div class="mb-4 relative">
                    <input id="password" required name="password" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="password" placeholder=" ">
                    <label class="ml-2 px-2 rounded absolute text-gray-500 dark:text-gray-400 block bg-gray-50 dark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:px-2 peer-focus:bg-gray-50 peer-focus:dark:bg-gray-700 peer-focus:text-blue-600 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1" for="password">Password</label>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" class="form-checkbox rounded dark:bg-gray-700 dark:border-gray-600" id="checkbox-signin">
                        <label class="ms-2" for="checkbox-signin">Remember me</label>
                    </div>
                    <a href="auth-recoverpw.php" class="text-sm text-primary border-b border-dashed border-primary">Forget Password?</a>
                </div>

                <div class="flex justify-center mb-6">
                    <button class="btn w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Log In</button>
                </div>

                <div class="flex items-center my-6">
                    <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                    <div class="mx-4 text-secondary">Or</div>
                    <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                </div>

                <div class="flex gap-4 justify-center mb-6">
                    <a href="google-login.php" class="btn border-light text-gray-400 dark:border-slate-700">
                            <span class="flex justify-center items-center gap-2">
                                <i class="mgc_google_line text-danger text-xl"></i>
                                <span class="lg:block hidden">Google</span>
                            </span>
                    </a>
                </div>

                <p class="text-center">Don't have an account?<a href="auth-register.php" class="text-primary ms-1"><b>Register</b></a></p>
            </form>
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
        $('#form_login').submit(function(event) {
            event.preventDefault();
            document.getElementById('backdrop').style.display = 'flex';
            const formData = $(this).serialize();
            $.ajax({
                type: "post",
                url: "libs/login.php",
                dataType: "json",
                data: formData,
                success: function(response) {
                    document.getElementById('backdrop').style.display = 'none';
                    if (response.status === 'success') {
                        displayAlert(response.message, "center", "success")
                        setTimeout(function() {
                         window.location.href = 'subscription.php'
                        },3000)
                    } else if (response.status === 'error' && response.errors) {
                        var errors = '';
                        response.errors.forEach(function(error) {
                            errors += error + '<br>';
                        });
                        displayAlert(errors, 'center', 'error');
                    } else if (response.status === 'error') {
                        displayAlert(response.message, 'center', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    document.getElementById('backdrop').style.display = 'none';
                    displayAlert('An unexpected error occurred: ' + error, "center", "error");
                }
            })
        })
    });
</script>
</body>

</html>
