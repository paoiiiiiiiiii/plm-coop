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

        <div class="w-full h-auto px-10 py-5">
            <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-full px-10 py-10">
                <div>
                    <div class="grid grid-cols-2">
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F] pb-4">INVENTORY</p>

                    </div>
                    <div class="w-full flex">
                        <div class="justify-self-start w-full bg-[#FCE4BE]">
                            <?php if($category){ ?>
                                    <?php foreach($category as $categories): ?>
                                        <?php $product = $coop->getStaffProducts($categories['category_id']); ?>
                                            <div class="h-auto w-full mx-2 my-4 bg-[#221E3F] rounded-md cursor-pointer px-5 py-2 drop-shadow-xl">
                                                <div class='w-full'>
                                                    <p class="text-white py-2 pr-4 font-bold text-xl">CATEGORY: <?= $categories['category_name']; ?></p>
                                                </div>
                                                <div class="w-full bg-[#ffd695] rounded-md">
                                                    <table class="justify-self-stretch w-full mb-5">
                                                            <thead class="bg-[#e5c38c] text-black font-bold">
                                                                <td class="rounded-tl-md"></td>
                                                                <td class="py-2">Product Code</td>
                                                                <td>Product Name</td>
                                                                <td>Product Price</td>
                                                                <td>Stocks on Hand</td>
                                                                <td class="rounded-tr-md"></td>
                                                            </thead>
                                                    <?php if ($product) { ?>
                                                        <?php foreach($product as $products): ?>
                                                                <tr class="cursor-pointer hover:bg-[#e8d2ae]">
                                                                    <td class="py-2 px-2"><img src="thumbnails/<?= $products['thumbnail']; ?>" height="50" width="50"></td>
                                                                    <td><?= $products['product_code']; ?></td>
                                                                    <td><?= $products['product_name']; ?></td>
                                                                    <td><?= $products['product_price']; ?></td>
                                                                    <td><?= $products['product_quantity']; ?></td>
                                                                    <td><a href='staffProductStockIn.php?productID=<?= $products['product_id'];?>'><button class="ml-1 rounded-lg bg-[#221E3F] px-4 text-white hover:bg-[#6257b4] text-white p-2 text-sm">Stock In</button></a></td>
                                                                </tr>
                                                        <?php endforeach; ?>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="py-2">There are no products in this category!</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </table>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                            <?php }?>
                            <?php if(!$category) {?>
                                    <p>THERE ARE NO CATEGORIES!</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
