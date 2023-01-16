<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$roleChecker = $coop->roleChecker();
$user = $coop->home();
$product = $coop->getAdminProductDetails();
$categories = $coop->getCategory();

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
                    <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">View Product</p>
                    <div class="w-full flex justify-center">
                        <div class="w-4/5 mt-5">
                            <p class="text-2xl font-extrabold w-full text-[#221E3F]">PRODUCT DETAILS</p>

                            <form action="adminViewProducts.php" method="POST" enctype="multipart/form-data" class="w-full mt-5 grid grid-cols-2 gap-10"> 
                                <div class="flex items-center">
                                    <img src="thumbnails/<?= $product['pthumbnail']?>" width="400" height="400">
                                </div>
                                <div>
                                    <div class="input-group">
                                        <label class="text-center text-[#221E3F] font-bold text-xl mb-3">Product ID: <?= $product['product_id']?></label>
                                        <input type="text" name="productID" required value="<?= $product['product_id']?>" hidden>
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-lg">Product Code</label></ul>
                                        <input type="text" name="productCode" required class="mt-2 bg-[#efefef] text-md text-[#525252] h-[25px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $product['product_code']?>">
                                    </div>
                                    <div class="input-group mt-1">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-lg">Product Category</label></ul>
                                        <select name="productCategory" class="mt-2 bg-[#efefef] text-md text-[#525252] h-[25px] w-full mb-2 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]"">
                                            <option value="<?= $product['product_category_id']?>" selected><?= $product['category_name']; ?></option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['category_id']?>"><?= $category['category_name']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="input-group mt-1">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-lg">Product Name</label></ul>
                                        <input type="text" name="productName" required class="mt-2 bg-[#efefef] text-md text-[#525252] h-[25px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $product['product_name']?>">
                                    </div>
                                    <div class="input-group mt-1">  
                                        <ul><label class="text-center text-[#221E3F] font-bold text-lg">Product Description</label></ul>
                                        <input type="text" name="productDescription" required class="mt-2 bg-[#efefef] text-md text-[#525252] h-[25px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $product['product_description']?>">
                                    </div>
                                    <div class="input-group mt-1">  
                                        <ul><label class="text-center text-[#221E3F] font-bold text-lg">Price Per Quantity</label></ul>
                                        <input type="number" step="0.01" min="1" name="productPrice" required class="mt-2 bg-[#efefef] text-md text-[#525252] h-[25px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $product['product_price']?>">
                                    </div>
                                    <div class="input-group mt-1">  
                                        <ul><label class="text-center text-[#221E3F] font-bold text-lg">Stock On Hand</label></ul>
                                        <input type="number" min="0" name="productQuantity" required class="mt-2 bg-[#efefef] text-md text-[#525252] h-[25px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $product['product_quantity']?>">
                                    </div>
                                </div>
                                <div class="flex justify-center col-span-2">
                                    <button class="mr-3 w-48 h-[40px] text-lg text-white mb-2 rounded-full bg-[#221E3F] px-4 py-1 text-white hover:bg-[#6257b4] mt-3" name="updateProduct">
                                        Update
                                    </button>
                                    <a href="adminViewProducts.php?deleteProductID=<?= $product['product_id']?>" onclick="return confirm('Are you sure you want to delete this product?')"><button class="w-48 h-[40px] text-lg text-white mb-2 rounded-full bg-[#221E3F] px-4 py-1 text-white hover:bg-[#6257b4] mt-3" name="deleteProduct">
                                        Delete
                                    </button></a>
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