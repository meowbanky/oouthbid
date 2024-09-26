<?php
//require_once 'libs/App.php';
require_once __DIR__ . '/vendor/autoload.php';
use App\App;
use App\Database;

$App = new App();
$database = new Database($App);
$token = $_GET['token'] ?? null;

$tokenCheck = $database->passwordReset($token);

?>
<?php include 'partials/main.php'; ?>

<head>
    <?php $title = "Set Password";
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
                            <img class="h-6 block dark:hidden" src="assets/images/logo-dark.png" alt="">
                            <img class="h-6 hidden dark:block" src="assets/images/logo-light.png" alt="">
                        </a>
                        <form method="post" name="form_setpassword" id="form_setpassword">
                        <?php if($tokenCheck){ ?>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="user_password">Password</label>
                                <input id="user_password" name="user_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="password" placeholder="Enter your password" >
                                <input type = "hidden" name="token" value="<?php echo $_GET["token"]; ?>">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2" for="user_cpassword">Confirm Password</label>
                                <input id="user_cpassword" name="user_cpassword" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" type="password" placeholder="Enter your confirm" >
                            </div>
                        <div class="flex justify-center mb-6">
                            <button class="btn w-full text-white bg-primary"> Reset Password </button>
                        </div>
                        <?php } else{ ?>
                            <div class="mb-4 flex items-center justify-center">
                            <div class="text-red-500 font-bold text-lg-center">Invalid Token/Token already used</div>
                        </div>
                         <?php
                        } ?>
                        </form>
                        <div class="flex items-center my-6">
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                            <div class="mx-4 text-secondary">Or</div>
                            <div class="flex-auto mt-px border-t border-dashed border-gray-200 dark:border-slate-700"></div>
                        </div>
                    
                        <p class="text-gray-500 dark:text-gray-400 text-center">Back to<a href="auth-login.php" class="text-primary ms-1"><b>Log In</b></a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="backdrop" id="backdrop">
        <div class="spinner"></div>
    </div>
    <script>
        $(document).ready(function() {

            $('#form_setpassword').submit(function(event) {
                event.preventDefault();
                document.getElementById("backdrop").style.display = "flex";

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'libs/setpassword.php',
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
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</body>

</html>