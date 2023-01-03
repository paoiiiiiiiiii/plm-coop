<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$cart = $coop->getCustomerCart();


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
                
                <div class="w-full flex h-auto mt-8">
                    <div class="w-full bg-[#eaf8ff] px-5 rounded-bl-lg">
                        <form method="POST" action="customerCart.php">
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-bold text-md sticky top-0">
                                        <td class="pl-2 rounded-tl-md py-2"></td>
                                        <td class="py-2">Product</td>
                                        <td class="py-2">Product Code</td>
                                        <td class="py-2">Product Name</td>
                                        <td class="py-2">Quantity</td>
                                        <td class="py-2">Total Price</td>
                                        <td class="rounded-tr-md">Update</td>
                                        <td class="rounded-tr-md">Delete</td>
                                    </thead>
                            <?php if($cart){ ?>
                                    <?php foreach($cart as $productsInCart): ?>
                                        <tr>
                                            <td><input type="checkbox" name="selectedCart[]" value="<?= $productsInCart['cart_products_id']; ?>"></td>
                                            <td><img src="thumbnails/<?= $productsInCart['thumbnail']?>" width="100" height="100"></td>
                                            <td><p><?= $productsInCart['product_code']; ?></p></td>
                                            <td><p><?= $productsInCart['product_name']; ?></p></td>
                                            <td><p><?= $productsInCart['quantity_added']; ?></p></td>
                                            <td><p><?= $productsInCart['total_price']; ?></p></td>
                                            <td><a href="customerCart.php?deleteID=<?= $productsInCart['cart_products_id']?>">Delete</a></td>
                                            <td><p>Update</p></td>
                                        </tr>
                                    <?php endforeach; ?>
                            <?php }?>
                            </table>
                            <?php if(!$cart) {?>
                                    <p>THERE ARE NO PRODUCTS IN THE CART!</p>
                            <?php } ?>
                            <input type="radio" id="walkin" name="checkoutProcess" value="walkin" required>
                            <label for="walkin">GET ITEMS THROUGH WALK-IN</label><br>
                            <input type="radio" id="delivery" name="checkoutProcess" value="delivery" required>
                            <label for="delivery">GET ITEMS THROUGH DELIVERY(excluding delivery fee)</label><br> 

                            <a href="customerCheckout.php"><button type="submit" name="checkout">CHECKOUT</button></a>
                        </form>
                    </div>
                </div>
                
            </div>
            <!-- <p class="pb-2 bg-[#9ed5f0] pl-20 text-white text-lg"><b>Date: </b><?= $date ?> <?= $dateDay ?></p>
            <button class="ml-20 text-sm text-white mb-6 rounded-lg bg-[#67b0e7] p-2 text-white hover:bg-[#2986CC]"><a href="login.php?logout='1'" onclick="return confirm('Are you sure you want to logout?')"><img src="static/icons/logout.png" width="18" height="18"></a></button> -->
        </div>
    </body>
</body>

</html>