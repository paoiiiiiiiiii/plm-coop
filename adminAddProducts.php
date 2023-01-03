<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
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
    
</head>
<body>
	<body class="bg-[#9ed5f0]">    	
        <div class="w-full h-full flex">
            <div class="w-48">
                <?php include 'adminSideBar.php'; ?>
            </div>

            <div class="w-full h-auto px-10 py-10 flex flex-col">
                <div class="justify-center items-center w-full bg-[#eaf8ff] px-5 rounded-bl-lg">
                    <div class="flex justify-center items-center grid grid-rows-2">
                        <div class="pt-10 flex justify-center items-center">
                            <form action="adminAddProducts.php" method="POST" class="flex flex-col" enctype="multipart/form-data">
                                <div>
                                    <div>
                                        <label class=""><b>Product Code: </b></label>
                                        <input type="text" name="productCode" required>
                                    <div>

                                    <div>
                                        <label class=""><b>Product Category: </b></label>
                                        <select name="productCategory">
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['category_id']?>"><?= $category['category_name']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    <div>

                                    <div>
                                        <label class=""><b>Product Name: </b></label>
                                        <input type="text" name="productName" required>
                                    <div>

                                    <div>
                                        <label class=""><b>Product Description: </b></label>
                                        <input type="text" name="productDescription" required>
                                    <div>

                                    <div>
                                        <label class=""><b>Product Thumbnail: </b></label>
                                        <input type="file" name="productThumbnail" required>
                                    <div>

                                    <div>
                                        <label class=""><b>Price Per Quantity: </b></label>
                                        <input type="number" step="0.01" min="1" name="productPrice" required>
                                    <div>

                                    <div>
                                        <label class=""><b>Stock on Hand </b></label>
                                        <input type="number" min="0" name="productQuantity" required>
                                    <div>
                                    
                                    <div>
                                        <button type="submit" name="addProduct">ADD PRODUCT</button>
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