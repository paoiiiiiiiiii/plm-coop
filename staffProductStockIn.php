<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$product = $coop->getProduct();
$quantityOnline = $coop->getQuantitySeenOnline();
$stockin = $coop->stockIn();

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
            <?php include 'staffTopBar.php'; ?>
        </div>

        <div class="w-full h-screen px-10 py-5">
            <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-full px-10 py-10">
                <div>
                    <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">Stock In Product</p>
                    <div class="w-full flex justify-center">
                        <div class="w-4/5 mt-5">
                            <p class="text-2xl font-extrabold w-full text-center text-[#221E3F] mt-5">PRODUCT DETAILS</p>
                            <div class="grid grid-cols-2 mt-4">
                                
                                <div class="pt-10">
                                    <img src="thumbnails/<?= $product['pthumbnail']?>" width="400" height="400">
                                </div>

                                <div class="px-10 py-5">
                                    <hr style="height:2px;border-width:0;color:#221E3F;background-color:#221E3F" class="mb-2">
                                    <p class="text-left text-[#221E3F] text-xl mb-2"><b>Product Code: </b><?= $product['product_code']?></p>
                                    <hr style="height:2px;border-width:0;color:#221E3F;background-color:#221E3F" class="mb-2">
                                    <p class="text-left text-[#221E3F] text-xl mb-3"><b>Product Category:</b> <?= $product['category_name']?></p>
                                    <hr style="height:2px;border-width:0;color:#221E3F;background-color:#221E3F" class="mb-2">
                                    <p class="text-left text-[#221E3F] text-xl mb-3"><b>Product Name:</b> <?= $product['product_name']?></p>
                                    <hr style="height:2px;border-width:0;color:#221E3F;background-color:#221E3F" class="mb-2">
                                    <p class="text-left text-[#221E3F] text-xl mb-3"><b>Product Description:</b> <?= $product['product_description']?></p>
                                    <hr style="height:2px;border-width:0;color:#221E3F;background-color:#221E3F" class="mb-2">
                                    <p class="text-left text-[#221E3F] text-xl mb-3"><b>Price per Quantity:</b> <?= $product['product_price']?></p>
                                    <hr style="height:2px;border-width:0;color:#221E3F;background-color:#221E3F" class="mb-2">
                                    <p class="text-left text-[#221E3F] text-xl mb-3"><b>Stocks on Hand:</b> <?= $product['product_quantity']?> </p>
                                    <hr style="height:2px;border-width:0;color:#221E3F;background-color:#221E3F" class="mb-2">
                                    
                                    <form method="post" action="staffProductStockIn.php" class="mt-10">
                                        <div class="grid grid-rows-2 flex">
                                            <div class="flex justify-center items-centern mb-3">
                                                <label class="text-left text-[#221E3F] text-xl "><b>Stock in Quantity: </b></label>
                                                <input type="number" name="quantity" required min="1" class="rounded-md bg-[#efefef] p-1 text-sm w-32 ml-2">
                                                <input type="number" name="productID" value="<?= $product['product_id'];?>" hidden ></input>
                                            </div>

                                            <div>
                                                
                                                <button class="ml-1 rounded-full w-full bg-[#221E3F] px-4 text-white hover:bg-[#6257b4] text-white p-2 text-lg" name="addStock">
                                                    Add Stocks
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>