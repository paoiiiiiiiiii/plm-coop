<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$categoryCount = $coop->getCategoryCount();
$productLine = $coop->getProductLine();
$stockOnHand = $coop->getStocksOnHand();

$category = $coop->getCategory();
$categoryDetails = $coop->getAdminProductCategory();
$productDetails = $coop->getAdminProducts();

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d");
$dateDay = date("l");
$time = date("h:i:sa");

$counter = 0;
$counter1 = 0;
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
<body>
	<body class="bg-[#221E3F]">    	
        <div class="w-full h-full flex">
            <div class="w-[310px]">
                <?php include 'adminSideBar.php'; ?>
            </div>

            <div class="w-full h-auto px-10 flex flex-col">
                <div class="w-full">
                    <div class="flex my-5 w-full">
                        <div class="bg-[#FCE4BE] flex w-full rounded-3xl">
                            <div class="w-full px-10 py-10 ">
                                <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">Product Summary</p>
                                <div class="grid grid-cols-3">
                                    <div class="flex-1 bg-[#1bcb00] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center"><div class="col-span-1 flex items-center justify-center"><i class="fa-solid fa-bars text-7xl"></i></div>
                                        <div class="col-span-2">
                                            <ul class="text-4xl font-bold text-left"><?= $categoryCount ?></ul> 
                                            <ul class="text-lg font-semibold text-left"><b>TOTAL CATEGORIES</b></ul> 
                                        </div>
                                    </div>

                                    <div class="flex-1 bg-[#00b9e5] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center"><div class="col-span-1 flex items-center justify-center"><i class="fa-solid fa-bag-shopping text-7xl"></i></div>
                                        <div class="col-span-2">
                                            <ul class="text-4xl font-bold text-left"><?= $productLine ?></ul> 
                                            <ul class="text-lg font-semibold text-left"><b>TOTAL PRODUCTS</b></ul> 
                                        </div>
                                    </div>

                                    <div class="flex-1 bg-[#f8de00] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center"><div class="col-span-1 flex items-center justify-center"><i class="fa-solid fa-boxes-stacked text-7xl"></i></div>
                                        <div class="col-span-2">
                                            <ul class="text-4xl font-bold text-left"><?= $stockOnHand ?></ul> 
                                            <ul class="text-lg font-semibold text-left"><b>STOCKS ON HAND</b></ul> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex bg-[#FCE4BE] w-full h-[38rem] rounded-3xl">
                        <div class="w-full px-10 py-10 ">
                            <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F] mb-5">Product Categories</p>
                            <div class="w-full flex">
                            <div class="justify-self-start w-4/6 bg-[#ffd695] rounded-bl-lg overflow-auto max-h-[450px]">
                                <table class="justify-self-stretch w-full m-auto">
                                        <thead class="font-semibold text-md bg-[#221E3F] text-white sticky top-0">
                                            <td class="rounded-tl-lg"></td>
                                            <td class="py-2">Category ID</td>
                                            <td>Category Name</td>
                                            <td>Total Products</td>
                                            <td></td>
                                        </thead>
                                        <?php if($category){ ?>
                                            <?php foreach($category as $categories): ?>
                                                <tr class="cursor-pointer hover:bg-[#e8d2ae]">
                                                    <td class="py-2 px-3"><img src="thumbnails/<?= $categories['thumbnail']?>" width="40" height="40"></td>
                                                    <td><?= $categories['category_id']?></td>
                                                    <td><?= $categories['category_name']?></td>
                                                    <td><?= $coop->getNumberProductsPerCategory($categories['category_id']); ?></td>
                                                    <td><a href="adminProducts.php?categoryID=<?= $categories['category_id'] ?>">Select</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php }?>
                                        <?php if(!$category) {?>
                                            <p>THERE ARE NO CATEGORIES!</p>
                                        <?php } ?>
                                </table>
                            </div>

                            <div class="w-2/6 bg-[#FCE4BE] rounded-br-lg rounded-tr-lg pl-2">
                                <div class="flex-1 items-center rounded-lg h-auto bg-[#67b0e7] grid grid-cols-2">
                                    <div class="col-span-2 bg-[#221E3F] rounded-t-lg py-2"><b><p class="text-white text-center">Category Details:</p></b></div>
                                    <form method="post" action="adminProducts.php" class="grid grid-cols-2 col-span-2 px-4 pt-3">
                                        
                                        <div class="col-span-2"><img src="thumbnails/<?= $categoryDetails['thumbnail']; ?>" width="40" height="40"></div>
                                        <p class="text-sm text-white mt-2 mb-1"><b>Category ID: </b></p>
                                        <p class="text-sm text-white mt-2"><?= $categoryDetails['category_id'];?></p>
                                        <input type="text" name="categoryID" value = "<?= $categoryDetails['category_id'];?>" hidden>
                                        
                                    
                                        <label class="text-white text-sm"><b>Category Name: </b></label>
                                        <input type="text" name="categoryName" required class="rounded-md bg-[#efefef] p-1 text-sm mb-1" value = "<?= $categoryDetails['category_name'];?>">
                                        

                                        <div class="my-3 col-span-2 grid grid-cols-3">
                                            <button name="removeCategory" type="submit" class="rounded-lg text-white bg-[#5094c8] rounded-md hover:bg-[#eaf8ff] hover:text-[#2986CC] p-2 text-xs">Remove</button>
                                            <button name="updateCategory" type="submit" class="ml-1 rounded-lg text-white bg-[#5094c8] rounded-md hover:bg-[#eaf8ff] hover:text-[#2986CC] p-2 text-xs">Update</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="flex-1 items-center rounded-lg h-auto bg-[#67b0e7] mt-2 grid grid-cols-2">
                                    <div class="col-span-2 bg-[#221E3F] rounded-t-lg py-2"><b><p class="text-white text-center">Category Details:</p></b></div>
                                    <form method="post" action="adminProducts.php" class="grid grid-cols-2 col-span-2" enctype="multipart/form-data">
                                        <div class="col-span-2"><b><p class="text-white text-center">ADD CATEGORY</p></b></div>
                                    
                                        <label class="text-white text-sm"><b>Category Name: </b></label>
                                        <input type="text" name="categoryName" required class="rounded-md bg-[#efefef] p-1 text-sm mb-1">
                                        
                                        <label class="text-white text-sm"><b>Thumbnail: </b></label>
                                        <input type="file" name="categoryThumbnail" required>

                                        <div class="my-3 col-span-2 grid grid-cols-3">
                                            <button name="addCategory" type="submit" class="rounded-lg text-white bg-[#5094c8] rounded-md hover:bg-[#eaf8ff] hover:text-[#2986CC] p-2 text-xs">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full bg-white mt-5 grid grid-cols-4">
                        <p class="col-span-3 text-3xl font-bold">PRODUCTS</p>
                        <a href="adminAddProducts.php"><button>Add products</button></a>
                    </div>

                    <div class="flex bg-white w-full h-[32rem] py-5">
                        <div class="justify-self-start w-full bg-[#f0faff] rounded-bl-lg overflow-auto max-h-106">
                            <?php if($category){ ?>
                                    <?php foreach($category as $categories): ?>
                                        <?php $product = $coop->getAdminProduct($categories['category_id']); ?>
                                            <div class="h-auto w-full my-2 bg-white rounded-md cursor-pointer px-5 py-5">
                                                <div class='w-full'>
                                                    <p class="">CATEGORY: <?= $categories['category_name']; ?></p>
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
                                                                <td><a href='adminViewProducts.php?productID=<?= $products['product_id'];?>'>View</a></td>
                                                            </tr>
                                                    <?php endforeach; ?>
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
    </body>
</body>

</html>