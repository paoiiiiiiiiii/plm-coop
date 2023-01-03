<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
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
    
</head>
<body>
	<body class="bg-[#9ed5f0]">    	
        <div class="w-full h-full flex">
            <div class="w-48">
                <?php include 'adminSideBar.php'; ?>
            </div>

            <div class="w-full h-auto px-10 py-10 flex flex-col">
                <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg grid grid-cols-2">
                    <div class="flex justify-center items-center">
                        <img src="thumbnails/<?= $product['thumbnail']?>" width="400" height="400">
                    </div>
                    <div class="flex justify-center items-center grid grid-rows-2">
                        <div class="pt-10 flex justify-center items-center">
                            <form action="adminViewProducts.php" method="POST" class="flex flex-col">
                                <div>
                                    <div>
                                        <label class=""><b>Product ID: </b><?= $product['product_id']?></label>
                                        <input type="text" name="productID" required value="<?= $product['product_id']?>" hidden>
                                    </div>

                                    <div>
                                        <label class=""><b>Product Code: </b></label>
                                        <input type="text" name="productCode" required value="<?= $product['product_code']?>">
                                    <div>

                                    <div>
                                        <label class=""><b>Product Category: </b></label>
                                        <select name="productCategory">
                                            <option value="<?= $product['product_category_id']?>" selected><?= $product['category_name']; ?></option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['category_id']?>"><?= $category['category_name']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    <div>

                                    <div>
                                        <label class=""><b>Product Name: </b></label>
                                        <input type="text" name="productName" required value="<?= $product['product_name']?>">
                                    <div>

                                    <div>
                                        <label class=""><b>Product Description: </b></label>
                                        <input type="text" name="productDescription" required value="<?= $product['product_description']?>">
                                    <div>

                                    <div>
                                        <label class=""><b>Price Per Quantity: </b></label>
                                        <input type="number" step="0.01" min="1" name="productPrice" required value="<?= $product['product_price']?>">
                                    <div>

                                    <div>
                                        <label class=""><b>Stock on Hand </b></label>
                                        <input type="number" min="0" name="productQuantity" required value="<?= $product['product_quantity']?>">
                                    <div>
                                    
                                    <div>
                                        <button type="submit" name="deleteProduct" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                        <button type="submit" name="updateProduct">Update</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</body>

</html>