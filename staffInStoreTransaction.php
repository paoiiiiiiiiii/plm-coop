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

        <div class="w-full h-screen px-10 py-5">
            <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-full px-10 py-10">
                <div class="h-full">
                    <div class="grid grid-cols-2">
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F] pb-4">IN STORE TRANSACTION</p>

                    </div>
                    <div class="w-full h-full flex">
                        <div class="w-full flex h-[40rem] rounded-lg">
                            <div class="justify-self-start w-4/5 bg-[#ffd695] px-5 rounded-bl-lg pt-2 rounded-tl-lg">
                                <div class="justify-self-stretch mx-3 w-3/5 pb-4 pt-1 text-[#221E3F]">
                                    <p><b>Transaction Number:</b> <?= $transac['transaction_id'];?></p>
                                    <p><b>Customer Name:</b> <?= $transac['name'];?></p>
                                    <p><b>Transaction Date:</b> <?= $transac['date'];?></p>
                                </div>
                                <div class="overflow-auto h-[32rem] max-h-106">
                                    <table class="justify-self-stretch w-full m-auto">
                                        <thead class="font-bold text-md bg-[#221E3F] text-white sticky top-0">
                                            <td class="pl-2 rounded-tl-md py-2">#</td>
                                            <td class="py-2">Product Name</td>
                                            <td class="py-2">Price</td>
                                            <td class="py-2">Quantity</td>
                                            <td class="py-2">Total</td>
                                            <td class="rounded-tr-md"></td>
                                        </thead>
                                        <?php if($cart){ ?>
                                            <?php foreach($cart as $carts): ?>
                                                <tr class="cursor-pointer hover:bg-[#e8d2ae]">
                                                    <td class="py-2 px-2"><img src="thumbnails/<?= $carts['thumbnail']; ?>" width='50' height='50'></td>
                                                    <td><?= $carts['product_name'];?></td>
                                                    <td><?= $carts['product_price'];?></td>
                                                    <td><?= $carts['quantity_added'];?></td>
                                                    <td><?= $carts['total_price'];?></td>
                                                    <td><a href="staffInStoreTransaction.php?cartID=<?= $carts['cart_products_id']?>"><button class="ml-1 rounded-lg bg-[#d73a2f] px-1 text-white hover:bg-[#f85e53] text-white p-2 text-sm">Delete</button><a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php }?>
                                    </table>
                                    <?php if(!$cart) {?>
                                            <div class="mt-[10rem] text-lg text-[#221E3F] text-center"><p>THERE ARE NO PRODUCTS IN THE CART YET!</p></div>
                                    <?php } ?>
                                </div>


                            </div>

                            <div class="w-1/5 bg-[#ffd695] pr-5 py-3 rounded-br-lg flex-initial rounded-tr-lg">
                                <div class="w-full pb-4 text-[#221E3F]">
                                    <p class="text-lg font-bold">Total:</p>
                                    <p class="text-4xl text-center font-bold">₱ <?= $total; ?></p>
                                </div>
                                
                                <div class="flex-1 items-center rounded-md h-auto bg-[#221E3F]">
                                    <div class="place-items-center">
                                        <div class="pt-1 pb-3 px-3">
                                            <p class="text-white mb-1 text-sm font-bold text-center mt-3">CUSTOMER DETAILS</p>
                                            <form action="staffInStoreTransaction.php" method="post">         
                                                    
                                                <?php if (!$session) { ?>
                                                    <p class="text-white mb-1 text-sm">Customer Name:</p>
                                                    <input type="text" name="soldTo" required class="rounded-md bg-[#efefef] w-full p-1 mb-3"> 
                                                    <p class="text-white mb-1 text-sm">Phone Number:</p>
                                                    <input type="text" name="phoneNum" required class="rounded-md bg-[#efefef] w-full p-1 mb-3"> 
                                                    <button class="w-full rounded-lg bg-[#6257b4] px-4 text-white hover:bg-[#8c7dff] text-white p-2 text-sm cursor-pointer" name="newTransac">New Transaction</button>
                                                <?php } else { ?>
                                                    <p class="text-white mb-1 text-sm">Name:</p>
                                                    <input type="text" name="soldTo" required class="rounded-md bg-[#efefef] w-full p-1 mb-3" placeholder="<?= $transac['name']; ?>" disabled>
                                                    <p class="text-white mb-1 text-sm">Phone Number:</p>
                                                    <input type="text" name="phoneNum" required class="rounded-md bg-[#efefef] w-full p-1 mb-3" placeholder="<?= $transac['phone_number']; ?>" disabled>  
                                                    <button class="w-full rounded-lg bg-[#6257b4] px-4 text-white text-white p-2 text-sm cursor-pointer" name="newTransac" disabled>New Transaction</button>
                                                <?php } ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="my-3 h-auto flex-1 mb-3">
                                    <?php if (!$session) { ?>
                                        <a href="staffBrowseProducts.php"><button class="w-full rounded-lg bg-[#6257b4] px-4 text-white text-white py-3 text-sm cursor-pointer mb-2" disabled>BROWSE PRODUCTS</button></a>
                                    <?php } else { ?>
                                        <a href="staffBrowseProducts.php"><button class="w-full rounded-lg bg-[#6257b4] px-4 text-white hover:bg-[#8c7dff] text-white py-3 text-sm cursor-pointer mb-2">BROWSE PRODUCTS</button></a>
                                    <?php } ?>
                                    <a href="staffInStoreTransaction.php?deleteAll='1'" onclick="return confirm('Are you sure you want to clear cart?')"><button class="w-full rounded-lg bg-[#6257b4] px-4 text-white hover:bg-[#8c7dff] text-white py-3 text-sm cursor-pointer">CLEAR CART</button><a>
                                    
                                </div>

                                <div class="flex-1 items-center rounded-md h-auto bg-[#221E3F]">
                                    <div class="pt-1 pb-3 px-3">
                                        <p class="text-white mb-1 text-sm font-bold text-center mt-3">PAYMENT</p>
                                        <form action="staffInStoreTransaction.php" method="post">
                                            <p class="text-white mb-1 text-sm">Enter Money: </p>
                                            <input type="number" name="money" step="0.01" class="rounded-md bg-[#efefef] w-full p-1" required min='<?= $total; ?>'>
                                            <button class="w-full rounded-lg bg-[#6257b4] px-4 text-white hover:bg-[#8c7dff] text-white p-2 text-sm cursor-pointer mt-3" name="settlePayment">Settle Payment</button>
                                        </form>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>