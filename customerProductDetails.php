<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$product = $coop->getProduct();
$addCart = $coop->addToCart();
$quantityOnline = $coop->getQuantitySeenOnline();

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
    
</head>
<body>
	<body class="bg-[#f0faff]">    	
        <div class="w-100% h-100% items-center bg-[#f0faff]">
            <div class="rounded-md py-5 px-20 pb-5 drop-shadow-md">
                <?php include 'customerTopBar.php'; ?>
                

                <div class="w-100% flex h-[32rem] mt-8">
                    <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg grid grid-cols-2">
                        <div class="flex justify-center items-center">
                            <img src="thumbnails/<?= $product['thumbnail']?>" width="400" height="400">
                        </div>
                        <div class="flex justify-center grid grid-rows-2">
                            <div class="pt-10">
                                <p><b>Product Code:</b> <?= $product['product_code']?></p>
                                <p><b>Product Category:</b> <?= $product['category_name']?></p>
                                <p><b>Product Name:</b> <?= $product['product_name']?></p>
                                <p><b>Product Description:</b> <?= $product['product_description']?></p>
                                <p><b>Price per Quantity:</b> <?= $product['product_price']?></p>
                                <p><b>Available Quantity:</b> <?= $quantityOnline; ?></p>
                            </div>
                            <div class="pt-10">
                                <form method="post" action="customerProductDetails.php?productID=<?= $product['product_id'];?>">
                                    <div class="grid grid-rows-2 flex justify-center">
                                        <div>
                                            <label class="text-sm"><b>Quantity: </b></label>
                                            <input type="number" name="quantity" required min="1" max="<?= $quantityOnline;?>" class="rounded-md bg-[#efefef] p-1 text-sm w-32 ml-2">
                                            <input type="number" name="addProd" value="<?= $product['product_id'];?>" hidden ></input>
                                        </div>

                                        <div>
                                            <?php if ($quantityOnline != 0 ) { ?>
                                                <button type="submit" class="w-64 rounded-full text-md text-white bg-[#5094c8] rounded-md hover:bg-[#eaf8ff] hover:text-[#2986CC] mt-2 p-2" name="addCart">
                                                    Add to Cart
                                                </button>
                                            <?php } else { ?>
                                                <button type="submit" class="w-64 rounded-full text-md text-white bg-[#5094c8] rounded-md hover:bg-[#eaf8ff] hover:text-[#2986CC] mt-2 p-2" name="addCart" disabled>
                                                    Add to Cart
                                                </button>                      
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- <p class="pb-2 bg-[#9ed5f0] pl-20 text-white text-lg"><b>Date: </b><?= $date ?> <?= $dateDay ?></p>
            <button class="ml-20 text-sm text-white mb-6 rounded-lg bg-[#67b0e7] p-2 text-white hover:bg-[#2986CC]"><a href="login.php?logout='1'" onclick="return confirm('Are you sure you want to logout?')"><img src="static/icons/logout.png" width="18" height="18"></a></button> -->
        </div>
    </body>
</body>

</html>