<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$roleChecker = $coop->roleChecker();
$user = $coop->home();
$categories = $coop->getCategory();
$addProduct = $coop->adminAddProducts();

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d");
$dateDay = date("l");
$time = date("h:i:sa");

?>

<!DOCTYPE html>
<html>
<head>
    <title>
            PLM COOP
    </title>
    <!-- <link rel="icon" type="image/png" href="static/images/logo.png"> -->
    <link href="styles.css" rel="stylesheet">
    <script src="assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/fonts.css"> 
    
</head>
<body class="bg-[#221E3F]">    	
    <div class="w-full h-full flex">
        <div class="w-[310px]">
            <?php include 'adminSideBar.php'; ?>
        </div>

        <div class="w-full h-screen px-10 py-5">
            <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-full px-10 py-10">
                <div>
                    <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">Add Products</p>
                    <div class="w-full flex justify-center">
                        <div class="w-4/5 mt-5">
                            <p class="text-2xl font-extrabold w-full text-[#221E3F]">PRODUCT DETAILS</p>

                            <form action="adminAddProducts.php" method="POST" enctype="multipart/form-data" class="w-full mt-5 grid grid-cols-2 gap-5"> 
                                <div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Product Code</label></ul>
                                        <input type="text" name="productCode" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                    <div class="input-group mt-3">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Product Category</label></ul>
                                        <select name="productCategory" class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['category_id']?>"><?= $category['category_name']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="input-group mt-3">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Product Name</label></ul>
                                        <input type="text" name="productName" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                    <div class="input-group mt-3">  
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Product Description</label></ul>
                                        <input type="text" name="productDescription" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                </div>
                                <div>
                                    <div class="input-group">  
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Product Thumbnail</label></ul>
                                        <input type="file" name="productThumbnail" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                    <div class="input-group mt-3">  
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Price Per Quantity</label></ul>
                                        <input type="number" step="0.01" min="1" name="productPrice" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                    <div class="input-group mt-3">  
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Stock On Hand</label></ul>
                                        <input type="number" min="0" name="productQuantity" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                </div>
                                <div class="flex justify-center col-span-2">
                                    <button class="w-48 h-[40px] text-lg text-white mb-2 rounded-full bg-[#221E3F] px-4 py-1 text-white hover:bg-[#6257b4] mt-3" name="addProduct">
                                        Add Product
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>