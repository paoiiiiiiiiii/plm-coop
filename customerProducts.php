<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$product = $coop->getProductsPerCategory();
$category = $coop->getProductCategory();

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
                
                <div class="w-100% flex h-auto mt-8">
                    <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg pt-10">
                        <h1 class="text-center text-5xl font-bold uppercase"><?= $category['category_name'] ?></h1>

                        <div class="grid grid-cols-4 px-5 py-5">
                            <?php if($product){ ?>
                                    <?php foreach($product as $products): ?>
                                        <a href="customerProductDetails.php?productID=<?= $products['product_id']?>"><div class="h-48 mx-2 my-2 bg-white rounded-md flex items-center justify-center cursor-pointer">
                                            <img src="thumbnails/<?= $products['thumbnail'];?>" width="50" height="50">
                                            <p class="text-center"><?= $products['product_name']; ?></p>
                                        </div></a>
                                    <?php endforeach; ?>
                            <?php }?>
                            <?php if(!$product) {?>
                                    <p>THERE ARE NO PRODUCTS!</p>
                            <?php } ?>
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