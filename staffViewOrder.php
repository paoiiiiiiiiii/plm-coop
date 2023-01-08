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

<body class="bg-[#221E3F]">    	
    <div class="w-full h-full flex">
        <div class="w-[310px]">
            <?php include 'staffTopBar.php'; ?>
        </div>

        <div class="w-full h-screen px-10 py-5">
            <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-auto px-10 py-10">
                <div class="h-auto">
                    <div class="grid grid-cols-2">
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F] pb-4">VIEW ORDER</p>
                    </div>
                    <div class="w-full h-auto flex">
                        <div class="w-full flex h-auto rounded-lg">
                            <div class="justify-self-start w-full bg-[#ffd695] rounded-b-lg rounded-t-lg">
                                <div class="h-auto">
                                    <form method="POST" action="staffViewOrder.php">
                                        <table class="justify-self-stretch w-full m-auto">
                                                <thead class="font-bold text-md bg-[#221E3F] text-white">
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
                                                        <td class="px-3"><?= $counter; ?></td>
                                                        <td class="py-2 px-3"><img src="thumbnails/<?= $productsInCart['thumbnail']?>" width="100" height="100"></td>
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

                                        <div class="px-8 py-8 text-lg">
                                            <p><b>Total Price: </b><?= $transaction['amount']?></p>

                                            <p class="text-center text-3xl font-bold mt-5">ORDER DETAILS:</p>
                                            <p><b>Transaction ID: </b> <?= $transaction['transaction_id']?></p>
                                            <p><b>Transaction Date: </b><?= $transaction['date']?></p>
                                            <p><b>Account: </b><?= $transaction['fname']." ".$transaction['lname']; ?></p>
                                            <p><b>Receiver Name: </b><?= $transaction['name']; ?></p>
                                            <p><b>Email: </b><?= $transaction['email']; ?></p>
                                            <p><b>Phone Number: </b><?= $transaction['phone_number']; ?></p>
                                            <p><b>Process: </b><?= $transaction['process']; ?></p>

                                            <?php if ($transaction['process'] == 'delivery' ) { ?>
                                                <p class="text-center text-3xl  font-bold mt-5">DELIVERY DETAILS:</p>
                                                <p><b>Address: </b><?= $transaction['address']; ?></p>
                                            <?php } ?>

                                            <select name="state" id="state" class="mt-10 ml-2 outline outline-offset-2 outline-[#221E3F] rounded-md h-[30px]">
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
                                                <button name="saveState" disabled class="ml-1 rounded-lg bg-[#221E3F] px-4 text-white hover:bg-[#6257b4] text-white p-2 text-sm">SAVE</button>
                                            <?php } else { ?>
                                                <button name="saveState" class="ml-1 rounded-lg bg-[#221E3F] px-4 text-white hover:bg-[#6257b4] text-white p-2 text-sm">SAVE</button>
                                            <?php } ?>
                                        </div>
                                    </form>
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