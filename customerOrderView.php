<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$product = $coop->getTransactionProductsView();
$transaction = $coop->getTransactionView();


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
                        <div>
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-bold text-md sticky top-0">
                                        <td class="py-2 rounded-tl-md py-2">Product</td>
                                        <td class="py-2">Product Code</td>
                                        <td class="py-2">Product Name</td>
                                        <td class="py-2">Quantity</td>
                                        <td class="py-2">Total Price</td>
                                    </thead>
                            <?php if($product){ ?>
                                    <?php foreach($product as $products): ?>
                                        <tr>
                                            <td><img src="thumbnails/<?= $products['thumbnail']?>" width="100" height="100"></td>
                                            <td><p><?= $products['product_code']; ?></p></td>
                                            <td><p><?= $products['product_name']; ?></p></td>
                                            <td><p><?= $products['quantity_added']; ?></p></td>
                                            <td><p><?= $products['total_price']; ?></p></td>

                                        </tr>
                                    <?php endforeach; ?>
                            <?php }?>
                            </table>
                            <?php if(!$product) {?>
                                    <p>THERE ARE NO PRODUCTS IN THE CART!</p>
                            <?php } ?>

                            <p class="text-center text-2xl my-5"><b>ORDER DETAILS</b></p>
                                <table class="w-96">
                                    <tr>
                                        <td><p class="flex-auto text-lg"><b>Transaction ID</b> </td>
                                        <td><p class="flex-auto text-lg"><?= $transaction['transaction_id'] ?></td>
                                    </tr>

                                    <tr>
                                        <td><p class="flex-auto text-lg"><b>Date</b> </td>
                                        <td><p class="flex-auto text-lg"><?= $transaction['date'] ?></td>
                                    </tr>

                                    <tr>
                                        <td><p class="flex-auto text-lg"><b>Process</b></td>
                                        <td><p class="flex-auto text-lg"><?= $transaction['process'] ?></td>
                                    </tr>

                                    <tr>
                                        <td><p class="flex-auto text-lg"><b>State</b></td>
                                        <td><p class="flex-auto text-lg"><?= $transaction['state'] ?></td>
                                    </tr>
                                <table>
                                
                                <?php if ($transaction['process'] == 'delivery') {?>
                                    <p class="text-center text-2xl my-5"><b>SHIPPING DETAILS</b></p>
                                    <table class="w-96">
                                        <tr>
                                            <td><p class="flex-auto text-lg"><b>Name of Receiver</b> </td>
                                            <td><p class="flex-auto text-lg"><?= $transaction['name'] ?></td>
                                        </tr>

                                        <tr>
                                            <td><p class="flex-auto text-lg"><b>Phone Number</b> </td>
                                            <td><p class="flex-auto text-lg"><?= $transaction['phone_number'] ?></td>
                                        </tr>

                                        <tr>
                                            <td><p class="flex-auto text-lg"><b>Email</b></td>
                                            <td><p class="flex-auto text-lg"><?= $transaction['email'] ?></td>
                                        </tr>

                                        <tr>
                                            <td><p class="flex-auto text-lg"><b>Address</b></td>
                                            <td><p class="flex-auto text-lg"><?= $transaction['address'] ?></td>
                                        </tr>
                                        <tr><p>PLEASE READY AN AMOUNT OF <?= $transaction['amount'] ?> + SHIPPING FEE (please check your email)</p></tr>
                                    <table>
                                <?php } else { ?>
                                    <p class="text-center text-2xl my-5"><b>OTHER DETAILS</b></p>
                                    <table class="w-96">
                                        <tr>
                                            <td><p class="flex-auto text-lg"><b>Name of Receiver</b> </td>
                                            <td><p class="flex-auto text-lg"><?= $transaction['name'] ?></td>
                                        </tr>

                                        <tr>
                                            <td><p class="flex-auto text-lg"><b>Phone Number</b> </td>
                                            <td><p class="flex-auto text-lg"><?= $transaction['phone_number'] ?></td>
                                        </tr>

                                        <tr>
                                            <td><p class="flex-auto text-lg"><b>Email</b></td>
                                            <td><p class="flex-auto text-lg"><?= $transaction['email'] ?></td>
                                        </tr>
                                        <tr><p>PLEASE CHECK YOUR EMAIL FOR UPDATES!</p></tr>
                                    <table>
                                <?php } ?>

                            <?php if ($transaction['state'] == 'pending') { ?>
                                <a href="customerOrderView.php?cancelOrderID=<?= $transaction['transaction_id']; ?>"><button type="submit" name="cancel" onclick="return confirm('Are you sure you want to cancel?')" >CANCEL ORDER</button></a>
                            <?php } else { ?>
                                <button type="submit" name="cancel" disabled>CANCEL ORDER</button>
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