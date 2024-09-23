<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\App;

$App = new App();

$token = (isset($_GET['token'])) ? $_GET['token'] : "" ;

$tokenCheck = $App->tokenCheck($token);
?>
<?php include 'partials/main.php'; ?>

<head>
    <?php $title = "Register User";
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
            <div class="card overflow-hidden sm:rounded-md rounded-none">
                <div class="p-6 bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">
                    <a href="index.php" class="block mb-8">
                        <img class="h-6 block dark:hidden" src="assets/images/logo-dark.png" alt="">
                        <img class="h-6 hidden dark:block" src="assets/images/logo-light.png" alt="">
                    </a>
                    <?php if($tokenCheck != false){ ?>
                        <form method="post" id="register-user" name="register-user">
                            <div class="mb-4 relative">
                                <input id="LoggingEmailAddress" name="LoggingEmailAddress" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="email" placeholder=" " required>
                                <label for="LoggingEmailAddress" class="ml-2 px-2 rounded absolute text-gray-500 dark:text-gray-400 block  bg-gray-50 dark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0]  peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-indigo-500 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4">Email Address</label>
                                <input type="hidden" value="<?php echo $tokenCheck['company_id'] ?>" name="company_id" id="company_id"/>
                                <input type="hidden" value="<?php echo $_GET['token'] ?>" name="token" id="token"/>
                            </div>

                            <div class="mb-4 relative">
                                <input id="user_firstname" name="user_firstname" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" " required>
                                <label for="user_firstname" class="ml-2 px-2 rounded absolute text-gray-500 dark:text-gray-400 block  bg-gray-50 dark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-indigo-500 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4">First Name</label>
                            </div>

                            <div class="mb-4 relative">
                                <input id="user_lastname" name="user_lastname" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" " required>
                                <label for="user_lastname" class="ml-2 px-2 rounded absolute text-gray-500 dark:text-gray-400 block  bg-gray-50 dark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-indigo-500 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4">Last Name</label>
                            </div>

                            <div class="mb-4 relative">
                                <input id="user_mobile" name="user_mobile" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 dark:bg-gray-700 peer" type="text" placeholder=" " required>
                                <label for="user_mobile" class="ml-2 px-2 rounded absolute text-gray-500 dark:text-gray-400 block  bg-gray-50 dark:bg-gray-700 text-sm font-medium mb-2 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] peer-focus:bg-white peer-focus:dark:bg-gray-700 peer-focus:rounded peer-focus:text-indigo-500 peer-focus:dark:text-white peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4">Mobile No</label>
                            </div>

                            <div class="flex justify-center mb-6">
                                <button class="btn-purple" type="submit"> Register </button>
                            </div>
                        </form>
                        <div class="flex items-center my-6">
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                            <div class="mx-4 text-secondary">Or</div>
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        </div>

                        <p class="text-gray-500 dark:text-gray-400 text-center">Back to<a href="index.php" class="text-primary ms-1"><b>Log In</b></a></p>
                    <?php } else { ?>
                        <div class="mb-4 flex items-center justify-center">
                            <div class="text-red-500 font-bold text-lg-center">Invalid Token/Token already used</div>
                        </div>
                    <?php } ?>
                </div>
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
    $(document).ready(function(){

        $('#register-user').submit(function(event){
            event.preventDefault();
            document.getElementById('backdrop').style.display = 'flex';
            const formData = $(this).serialize();
            $.ajax({
                type: "post",
                url: "libs/register-user.php",
                dataType: "json",
                data: formData,
                success: function(response) {
                    document.getElementById('backdrop').style.display = 'none';
                    if (response.status === 'success') {
                        console.log(response.success);
                        displayAlert(response.message, "center", "success")
                    } else if (response.status === 'error' && response.errors) {
                        var errors = '';
                        response.errors.forEach(function (error) {
                            errors += error + '<br>';
                        });
                        displayAlert(errors, 'center', 'error');
                    }
                },
                error: function(xhr, status, error){
                    document.getElementById('backdrop').style.display = 'none'; // Hide backdrop
                    displayAlert('An unexpected error occurred: ' + error, "center", "error");
                }
            })
        })

    });
</script>
</body>

</html>
