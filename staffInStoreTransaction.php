<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$transac = $coop->newInStoreTransaction();
$cart = $coop->staffGetInStoreCart();
$session = $coop->inStoreSessionChecker();
$deleteItem = $coop->staffDeleteCart();
$settlePayment = $coop->staffSettlePayment();

$total = $_SESSION['total_amount'];

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
                    <div class="justify-self-start w-4/5 bg-[#eaf8ff] px-5 rounded-bl-lg pt-2">
                        <!-- <h1 class="text-center text-3xl font-bold">IN STORE TRANSACTION</h1> -->
                        <div class="justify-self-stretch mx-3 w-3/5 px-4">
                            <p><b>Transaction Number:</b> <?= $transac['transaction_id'];?></p>
                            <p><b>Customer Name:</b> <?= $transac['name'];?></p>
                            <p><b>Transaction Date:</b> <?= $transac['date'];?></p>
                        </div>
                        <table class="justify-self-stretch w-full m-auto ">
                            <thead class="font-bold text-md bg-[#67b0e7] text-white sticky top-0">
                                <td class="pl-2 rounded-tl-md py-2">#</td>
                                <td class="py-2">Product Name</td>
                                <td class="py-2">Price</td>
                                <td class="py-2">Quantity</td>
                                <td class="py-2">Total</td>
                                <td class="rounded-tr-md"></td>
                            </thead>
                            <?php if($cart){ ?>
                                <?php foreach($cart as $carts): ?>
                                    <tr>
                                        <td class="py-2"><img src="thumbnails/<?= $carts['thumbnail']; ?>" width='50' height='50'></td>
                                        <td><?= $carts['product_name'];?></td>
                                        <td><?= $carts['product_price'];?></td>
                                        <td><?= $carts['quantity_added'];?></td>
                                        <td><?= $carts['total_price'];?></td>
                                        <td><a href="staffInStoreTransaction.php?cartID=<?= $carts['cart_products_id']?>">Delete<a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php }?>
                        </table>
                        <?php if(!$cart) {?>
                                <div class="mt-[10rem] text-lg text-[#67b0e7] text-center"><p>THERE ARE NO PRODUCTS IN THE CART YET!</p></div>
                        <?php } ?>


                    </div>

                    <div class="w-1/5 bg-[#eaf8ff] p-5 rounded-br-lg flex-initial">
                        
                        <div class="flex-1 items-center rounded-md h-auto bg-[#67b0e7]">
                            
                            <div class="place-items-center">
                                <div class="pt-1 pb-2 px-2">
                                    <form action="staffInStoreTransaction.php" method="post">         
                                            
                                        <?php if (!$session) { ?>
                                            <p class="text-white mb-1 text-sm">Customer Name:</p>
                                            <input type="text" name="soldTo" required class="rounded-md bg-[#efefef] w-full p-1"> 
                                            <p class="text-white mb-1 text-sm">Phone Number:</p>
                                            <input type="text" name="phoneNum" required class="rounded-md bg-[#efefef] w-full p-1"> 
                                            <button type="submit" class="text-xs text-white bg-[#5094c8] p-2 mt-2 rounded-full hover:bg-[#eaf8ff] hover:text-[#2986CC] w-full" name="newTransac">New Transaction</button>
                                        <?php } else { ?>
                                            <p class="text-white mb-1 text-sm">Customer Name:</p>
                                            <input type="text" name="soldTo" required class="rounded-md bg-[#efefef] w-full p-1" placeholder="<?= $transac['name']; ?>" disabled>
                                            <p class="text-white mb-1 text-sm">Phone Number:</p>
                                            <input type="text" name="soldTo" required class="rounded-md bg-[#efefef] w-full p-1" placeholder="<?= $transac['phone_number']; ?>" disabled>  
                                            <button type="submit" class="text-xs text-white bg-[#5094c8] p-2 mt-2 rounded-full w-full" name="newTransac" disabled>New Transaction</button>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="my-3 h-auto flex-1 mb-1">
                            <a href="staffBrowseProducts.php"><button class="w-full mb-3 rounded-full bg-[#67b0e7] p-2 text-white hover:bg-[#2986CC]">BROWSE PRODUCTS</button></a>
                            <a href="staffInStoreTransaction.php?deleteAll='1'" onclick="return confirm('Are you sure you want to clear cart?')"><button class="w-full mb-3 rounded-full bg-[#67b0e7] p-2 text-white hover:bg-[#2986CC]">CLEAR CART</button><a>
                            
                        </div>

                        <div class="flex-1 items-center rounded-md h-auto bg-[#67b0e7]">
                            <div class="pt-1 pb-2 px-2">
                                <form action="staffInStoreTransaction.php" method="post">
                                    <p>Total: <?= $total; ?></p>
                                    <p class="text-white mb-1 text-sm">Enter Money: </p>
                                    <input type="number" name="money" step="0.01" class="rounded-md bg-[#efefef] w-full p-1" required min='<?= $total; ?>'>
                                    <button type="submit" class="text-xs text-white bg-[#5094c8] p-2 mt-2 rounded-full hover:bg-[#eaf8ff] hover:text-[#2986CC] w-full" name="settlePayment">Settle Payment</button>
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