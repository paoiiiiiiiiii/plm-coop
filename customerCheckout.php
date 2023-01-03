<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$userProfile = $coop->getUserProfile();
$checkoutProcess = $coop->customerCheckoutProcess();
$cartCheckedOut = $coop->customerProductCheckout();
$confirmTransac = $coop->confirmTransaction();

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
                
                <div class="w-full flex h-auto mt-8 justify-center items-center">
                    <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg pt-10">
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-bold text-md sticky top-0">
                                        <td class="pl-2 rounded-tl-md py-2">Product</td>
                                        <td class="py-2">Product Code</td>
                                        <td class="py-2">Product Name</td>
                                        <td class="py-2">Quantity</td>
                                        <td class="py-2">Total Price</td>
                                    </thead>
                            <?php if($cartCheckedOut){ $totalprice = 0;?>
                                    <?php foreach($cartCheckedOut as $productsInCart): ?>
                                        <?php $product = $coop->getCartProduct($productsInCart); ?>
                                        <tr>
                                            <td><img src="thumbnails/<?= $product['thumbnail']?>" width="100" height="100"></td>
                                            <td><p><?= $product['product_code']; ?></p></td>
                                            <td><p><?= $product['product_name']; ?></p></td>
                                            <td><p><?= $product['quantity_added']; ?></p></td>
                                            <td><p><?= $product['total_price']; ?></p></td>
                                        </tr>
                                        <?php $totalprice += $product['total_price']; $_SESSION['total_amount'] = $totalprice; ?>
                                    <?php endforeach; ?>
                            <?php }?>
                            </table>
                        <p>TOTAL AMOUNT: <?= $totalprice  ?></p>
                    </div>
                </div>

                <?php if ($checkoutProcess == 'delivery') { ?>
                    <div class="w-full flex h-auto mt-8 justify-center items-center">
                        <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg pt-10">
                            <h1 class="text-center text-5xl font-bold uppercase">SHIPPING & CONTACT DETAILS</h1>

                            <div class="w-full bg-[#eaf8ff] px-5 rounded-bl-lg">
                                <form method="POST" action="customerCheckout.php">
                                    <p>Cash on Delivery via DELIVERY</p>
                                    <div>
                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">First Name </label>
                                            <input type="text" name="fname" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $user['fname'] ?>">
                                        </div>

                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">Last Name </label>
                                            <input type="text" name="lname" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $user['lname'] ?>">
                                        </div>

                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">Email </label>
                                            <input type="text" name="email" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $user['email'] ?>">
                                        </div>

                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">Phone Number/Telephone: </label>
                                            <input type="text" name="telNum" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $userProfile['phone_number'] ?>">
                                        </div>

                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">House No. & Subdivision: </label>
                                            <input type="text" name="houseNo" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $userProfile['house_no'] ?>">
                                        </div>

                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">Baranggay: </label>
                                            <input type="text" name="baranggay" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $userProfile['baranggay'] ?>">
                                        </div>
                                        
                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">City: </label>
                                            <input type="text" name="city" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $userProfile['city'] ?>">
                                        </div>
                                        
                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">Region: </label>
                                            <input type="text" name="region" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $userProfile['region'] ?>">
                                        </div>                                
                                        <button type="submit" class="w-64 rounded-full text-md text-white bg-[#5094c8] rounded-md hover:bg-[#eaf8ff] hover:text-[#2986CC] mt-2 p-2" name="confirmTransac" onclick="return confirm('Are you sure you want to checkout?')">
                                            Confirm Transaction(delivery)
                                        </button>
                                    </div>                                
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="w-full flex h-auto mt-8 justify-center items-center">
                        <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg pt-10">
                            <h1 class="text-center text-5xl font-bold uppercase">CONTACT DETAILS</h1>

                            <div class="w-full bg-[#eaf8ff] px-5 rounded-bl-lg">
                                <form method="POST" action="customerCheckout.php">
                                    <p>WALKIN - Payment will be done on site.</p>
                                    <div>
                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">First Name </label>
                                            <input type="text" name="fname" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $user['fname'] ?>">
                                        </div>

                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">Last Name </label>
                                            <input type="text" name="lname" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $user['lname'] ?>">
                                        </div>

                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">Email </label>
                                            <input type="text" name="email" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $user['email'] ?>">
                                        </div>

                                        <div>
                                            <label class="text-center text-[#a8a8a8] text-sm">Phone Number/Telephone: </label>
                                            <input type="text" name="telNum" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg" value="<?= $userProfile['phone_number'] ?>">
                                        </div>                          
                                        <button type="submit" class="w-64 rounded-full text-md text-white bg-[#5094c8] rounded-md hover:bg-[#eaf8ff] hover:text-[#2986CC] mt-2 p-2" name="confirmTransac" onclick="return confirm('Are you sure you want to checkout?')">
                                            Confirm Transaction(walkin)
                                        </button>
                                    </div>                                
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
            </div>
            <!-- <p class="pb-2 bg-[#9ed5f0] pl-20 text-white text-lg"><b>Date: </b><?= $date ?> <?= $dateDay ?></p>
            <button class="ml-20 text-sm text-white mb-6 rounded-lg bg-[#67b0e7] p-2 text-white hover:bg-[#2986CC]"><a href="login.php?logout='1'" onclick="return confirm('Are you sure you want to logout?')"><img src="static/icons/logout.png" width="18" height="18"></a></button> -->
        </div>
    </body>
</body>

</html>