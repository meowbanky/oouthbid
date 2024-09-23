<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers;
use App\App;

$App = new App();
$Auth = new Controllers\AuthController($App);
$Auth->loginCheck();
$company_id = $_SESSION['company_id'];
$BidDocument = new Controllers\BidDocumentController($App);
$getBidDocuments = $BidDocument->getBidDocuments($company_id);
$getBidDocumentTypes = $BidDocument->getBidDocumentTypes()

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
                $pagetitle = "Upload";
                include 'partials/page-title.php'; ?>

                <div class="card p-6">

<div class="w-full flex justify-end gap-2 my-2">
    <div><button data-fc-target="default-modal" data-fc-type="modal" class="btn text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Add files</button>
    </div>
</div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="subscription_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" data-sortable="true">
                                    Document
                                </th>
                                <th scope="col" class="px-6 py-3" data-sortable="true">
                                  Document Type
                                </th>
                                <th scope="col" class="px-6 py-3" data-sortable="true">
                                  Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($getBidDocuments){
                                foreach($getBidDocuments as $getBidDocument){
                                    ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            <img src="<?php echo $getBidDocument['document_path']; ?>" data-image="<?php echo $getBidDocument['document_path']; ?>" data-description="<?php echo $getBidDocument['documentType']; ?>" alt="Document Image" class="h-16 w-16 object-cover preview-image cursor-pointer">
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo $getBidDocument['documentType']; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                           <div class="flex space-x-2  ml-4">
                                            <button class="text-blue-500 preview-image" data-image="<?php echo $getBidDocument['document_path']; ?>" data-description="<?php echo $getBidDocument['documentType']; ?>">
                                                <span class="mgc_zoom_in_line text-2xl font-bold"></span>
                                            </button>

                                            <button class="delete text-red-500" id="<?php echo $getBidDocument['document_id']; ?>">
                                                <span class="mgc_delete_2_line text-2xl font-bold"></span>
                                            </button>
                                           </div>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-bold text-gray-500 dark:text-gray-400"></span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-bold text-gray-500 dark:text-gray-400">No Bid Document Available</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="font-bold text-gray-500 dark:text-gray-400"></span>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>

                        </table>
                    </div>

                    <div id="default-modal" class="w-full h-full mt-5 fixed top-0 left-0 z-50 transition-all duration-500 fc-modal hidden">
                        <div class="fc-modal-open:opacity-100 duration-500 bg-opacity-50 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto flex flex-col bg-white border shadow-sm rounded-md dark:bg-slate-800 dark:border-gray-700">
                            <div class="flex justify-between items-center text-gray-800 py-2.5 px-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="font-medium text-gray-800 dark:text-white text-lg">
                                    Upload Bid Document
                                </h3>
                                <button class="inline-flex flex-shrink-0 justify-center items-center h-8 w-8 text-gray-800 dark:text-gray-200"
                                        data-fc-dismiss type="button">
                                    <span class="material-symbols-rounded">close</span>
                                </button>
                            </div>
                            <div class="px-4 py-8 overflow-y-auto bg-white dark:bg-slate-800">
                                <p class="text-gray-800 dark:text-gray-200">
                                <form id="file-dropzone" action="libs/process_upload.php" method="POST" target="_blank" class="p-4 md:p-5 bg-white dark:bg-slate-800 dropzone">
                                    <div class="grid gap-4 mb-4 grid-cols-1">
                                        <div class="col-span-1 sm:col-span-1">
                                            <label for="docType" class="block mb-2 text-sm font-medium text-gray-800 dark:text-white">Document Type</label>
                                            <select id="docType" class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                <option selected="">Select Doc Type</option>
                                                <?php if($getBidDocumentTypes){
                                                    foreach ($getBidDocumentTypes as $getBidDocumentType){
                                                        ?>
                                                        <option  value="<?php echo $getBidDocumentType['documentType_id'] ;?>"><?php echo $getBidDocumentType['documentType'] ;?></option>
                                                    <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="bg-white dark:bg-slate-800 p-8 rounded-lg shadow-md">
                                        <h1 class="text-2xl font-bold mb-6 text-center">Document</h1>

                                            <div class="dz-message needsclick w-full text-center">
                                                <div class="mb-3">
                                                    <i class="mgc_upload_3_line text-4xl text-gray-300 dark:text-gray-200"></i>
                                                </div>
                                                <h5 class="text-xl text-gray-600 dark:text-gray-200">Drop files here or click to upload.</h5>
                                            </div>
                                        <div class="text-center mt-4 gap-2">
                                            <button type="button" id="send-files" class="btn bg-violet-500 border-violet-500 text-white">Send Files</button>


                                        </div>
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

                    <!-- Image Preview Modal Structure -->
                    <div id="imagePreviewModal" class="w-full h-full mt-5 fixed top-0 left-0 z-50 transition-all duration-500 fc-modal hidden">
                        <div class="fc-modal-open:opacity-100 duration-500 bg-opacity-50 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto flex flex-col bg-white border shadow-sm rounded-md dark:bg-slate-800 dark:border-gray-700">
                            <div class="flex justify-between items-center text-gray-800 py-2.5 px-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="font-medium text-gray-800 dark:text-white text-lg" id="imagePreviewModalLabel">
                                    Image Preview
                                </h3>
                                <button class="closeModal inline-flex flex-shrink-0 justify-center items-center h-8 w-8 text-gray-800 dark:text-gray-200"
                                        data-fc-dismiss type="button">
                                    <span class="material-symbols-rounded">close</span>
                                </button>
                            </div>
                            <div class="px-4 py-8 bg-white dark:bg-slate-800 overflow-auto max-h-96"> <!-- Added overflow-auto and max-h-96 -->
                                <img id="modalImage" src="https://via.placeholder.com/800x1200" alt="Image Preview" class="img-fluid w-full h-auto">
                            </div>
                            <div class="flex justify-end items-center gap-4 p-4 border-t border-gray-200 dark:border-slate-700">
                                <button class="closeModal btn text-gray-800 border border-gray-200 hover:bg-gray-100 dark:text-gray-200 dark:border-slate-700 hover:dark:bg-slate-700 transition-all" data-fc-dismiss type="button">Close
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
        $('#openModal').on('click', function() {
            $('#myModal').removeClass('hidden');
        });

        // Close the Modal
        $('.closeModal').on('click', function() {
            $('#imagePreviewModal').addClass('hidden');
        });

        $('.preview-image').on('click', function(){
            var imageUrl = $(this).data('image');
            var description = $(this).data('description');
            $('#imagePreviewModalLabel').addClass('font-bold');
            $('#imagePreviewModalLabel').html(description);
            $('#modalImage').attr('src', imageUrl);
            $('#imagePreviewModal').removeClass('hidden');
        });

        $('.delete').click(function() {
            var document_id = ($(this).prop('id'))
            if(confirm("Are you sure you want to delete this document?")) {
            deleteDocument(document_id);
            }
        })

        function deleteDocument(id) {
            $.ajax({
                url: "libs/process_upload.php",
                data: {document_id: id},
                type: "post",
                dataType: "json",
                success: function (response) {
                    if(response.status === "success"){
                        displayAlert(response.message,"center","success")
                        window.location.reload();
                    }else {
                        displayAlert("Error Deleting document","center","error")
                    }

                },
                error: function (jqXHR, textStatus, errorTh) {

                }


            })
        }

        $('#subscription_table').DataTable({
            searching: false,
            pageLength: 100,
            lengthChange: false,
            ordering: true,
            dom: '<"flex  items-center justify-between my-2"lf>t<"flex items-center justify-between"ip>',

        });



    })
</script>
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#file-dropzone", {
            url: "libs/process_upload.php",
            autoProcessQueue: false,
            acceptedFiles: "image/*",
            init: function() {
                var dz = this;

                document.getElementById("send-files").addEventListener("click", function() {
                    if (dz.getQueuedFiles().length > 0) {
                        document.getElementById("backdrop").style.display = "flex";
                        dz.processQueue();
                    } else {
                        displayAlert('No file uploaded','center','error');
                    }
                });

                dz.on("sending", function(file, xhr, formData) {
                    var docType = $('#docType').val();
                    formData.append("docType", docType);

                });

                dz.on("complete", function(file) {
                    dz.removeFile(file);
                });

                dz.on("success", function(file, response) {
                    document.getElementById("backdrop").style.display = "none";
                    if (response = 'Bid document uploaded successfully!') {
                        displayAlert(response.message, 'center', 'success');
                        window.location.reload();
                    } else {
                        displayAlert(response.message, 'center', 'error');
                    }
                });

                dz.on("error", function(file, response) {
                    document.getElementById("backdrop").style.display = "none";
                    var errorMessage = (typeof response === 'object' && response.message) ? response.message : 'An error occurred during upload.';
                    displayAlert(errorMessage, 'center', 'error');
                });
            }
        });

    </script>
</body>

</html>