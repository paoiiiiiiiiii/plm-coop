<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$cart = $coop->staffGetCustomerCart();
$transaction = $coop->staffGetTransactionDetails();
$updateTransaction = $coop->staffChangeTransactionState();

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
                
                <div class="w-full flex h-auto mt-8">
                    <div class="w-full bg-[#eaf8ff] px-5 rounded-bl-lg">
                        <form method="POST" action="staffViewOrder.php">
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-bold text-md sticky top-0">
                                        <td class="pl-2 rounded-tl-md py-2"></td>
                                        <td class="py-2">Product</td>
                                        <td class="py-2">Product Code</td>
                                        <td class="py-2">Product Name</td>
                                        <td class="py-2">Quantity</td>
                                        <td class="py-2">Total Price</td>
                                    </thead>
                            <?php if($cart){ $counter;?>
                                    <?php foreach($cart as $productsInCart): $counter += 1;?>
                                        <tr>
                                            <td><?= $counter; ?></td>
                                            <td><img src="thumbnails/<?= $productsInCart['thumbnail']?>" width="100" height="100"></td>
                                            <td><p><?= $productsInCart['product_code']; ?></p></td>
                                            <td><p><?= $productsInCart['product_name']; ?></p></td>
                                            <td><p><?= $productsInCart['quantity_added']; ?></p></td>
                                            <td><p><?= $productsInCart['total_price']; ?></p></td>
                                        </tr>
                                    <?php endforeach; ?>
                            <?php }?>
                            </table>
                            <?php if(!$cart) {?>
                                    <p>THERE ARE NO PRODUCTS IN THE CART!</p>
                            <?php } ?>

                            <p>Total Price: <?= $transaction['amount']?></p>

                            <p class="text-center text-3xl">ORDER DETAILS:</p>
                            <p>Transaction ID: <?= $transaction['transaction_id']?></p>
                            <p>Transaction Date: <?= $transaction['date']?></p>
                            <p>Account: <?= $transaction['fname']." ".$transaction['lname']; ?></p>
                            <p>Receiver Name: <?= $transaction['name']; ?></p>
                            <p>Email: <?= $transaction['email']; ?></p>
                            <p>Phone Number: <?= $transaction['phone_number']; ?></p>
                            <p>Process: <?= $transaction['process']; ?></p>

                            <?php if ($transaction['process'] == 'delivery' ) { ?>
                                <p class="text-center text-3xl">DELIVERY DETAILS:</p>
                                <p>Address: <?= $transaction['address']; ?></p>
                            <?php } ?>

                            <select name="state" id="state" >
                                <?php if ($transaction['state'] == 'pending') { ?>  
                                    <option value="pending" selected>Pending</option> 
                                    <option value="on processing">On Process</option>  
                                    <option value="cancelled">Cancel</option>  
                                    <option value="completed">Completed</option> 
                                <?php } else if ($transaction['state'] == 'on processing') { ?>
                                    <option value="on processing">On Process</option> 
                                    <option value="completed">Completed</option> 
                                <?php } else if ($transaction['state'] == 'cancelled') { ?>
                                    <option value="cancelled">Cancelled</option> 
                                <?php } else { ?>
                                    <option value="completed">Completed</option>
                                <?php } ?>
                            </select>
                            <input type="text" name="transactionID" value='<?= $transaction['transaction_id']; ?>' hidden>

                            <?php if ($transaction['state'] == 'cancelled' OR $transaction['state'] == 'completed') { ?>
                                <button type="submit" name="saveState" disabled>SAVE</button>
                            <?php } else { ?>
                                <button type="submit" name="saveState">SAVE</button>
                            <?php } ?>
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