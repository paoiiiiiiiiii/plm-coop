<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$category = $coop->getCategory();


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
                <?php include 'staffTopBar.php'; ?>

                <div class="w-100% flex h-auto mt-8">
                    <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg pt-10">
                        <h1 class="text-center text-5xl font-bold">INVENTORY</h1>

                        <div class="px-5 py-5">
                            <?php if($category){ ?>
                                    <?php foreach($category as $categories): ?>
                                        <?php $product = $coop->getStaffProducts($categories['category_id']); ?>
                                            <div class="h-auto w-full mx-2 my-2 bg-white rounded-md cursor-pointer px-5 py-5">
                                                <div class='w-full'>
                                                    <p class=""><?= $categories['category_name']; ?></p>
                                                </div>
                                                <div class="w-full">
                                                    <table class="justify-self-stretch w-full m-auto">
                                                            <thead>
                                                                <td></td>
                                                                <td>Product Code</td>
                                                                <td>Product Name</td>
                                                                <td>Product Price</td>
                                                                <td>Stocks on Hand</td>
                                                                <td></td>
                                                            </thead>
                                                    <?php foreach($product as $products): ?>
                                                            <tr>
                                                                <td><img src="thumbnails/<?= $products['thumbnail']; ?>" height="50" width="50"></td>
                                                                <td><?= $products['product_code']; ?></td>
                                                                <td><?= $products['product_name']; ?></td>
                                                                <td><?= $products['product_price']; ?></td>
                                                                <td><?= $products['product_quantity']; ?></td>
                                                                <td><a href='staffProduct.php?productID=<?= $products['product_id'];?>'>Add to Cart</a></td>
                                                            </tr>
                                                    <?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                            <?php }?>
                            <?php if(!$category) {?>
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