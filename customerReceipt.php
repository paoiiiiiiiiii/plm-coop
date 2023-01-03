<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$userProfile = $coop->getUserProfile();
$product = $coop->getTransactionProducts();
$transaction = $coop->getTransactionID();

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d");
$dateDay = date("l");
$time = date("h:i:sa");

?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            PLM - COOP
        </title>
        <link href="styles.css" rel="stylesheet">
    </head>
    <body class="px-10">    	
        <div>
            <div class="flex">
                <button onClick="window.print()" class="ml-10 mt-5 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] p-1 text-sm">Print receipt</button>
                    <form method="POST" action="customerReceipt.php">
                            <button type="submit" class="ml-4 mt-5 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] p-1 text-sm"
                                        name="finish">
                                Finish
                            </button>
                    </form>
            </div>

            <div class="items-center mb-4">
                <p class="text-center mt-5 text-2xl font-bold">PLM MULTIPURPOSE COOPERATIVE</p>
                <p class="text-center text-lg">Intramuros</p>
                <p class="text-center">Manila</p>
                <p class="text-center">Non-VAT Reg. TIN: ###-###-###-0000</p>
                <p class="text-center">Contact No.: ############</p>
            </div>

            <div class="mx-10 mb-4">
                <p><b>Date & Time: </b><?= $date; ?>, <?= $dateDay; ?> <?= $time; ?></p>
            </div>

            <div class="mb-5 mx-10">
                <hr style="border-width: 1px; border-color:black; margin-bottom:20px;">
                <table class="justify-self-stretch w-full m-auto">
                    <thead class="font-bold text-md">
                        <td class="py-2">Product Code</td>
                        <td class="py-2">Product Name</td>
                        <td class="py-2">Quantity</td>
                        <td class="py-2">Total Price</td>
                    </thead>
                    <?php if($product){?>
                        <?php foreach($product as $productsInCart): ?>
                                <tr>
                                    <td><p><?= $productsInCart['product_code']; ?></p></td>
                                    <td><p><?= $productsInCart['product_name']; ?></p></td>
                                    <td><p><?= $productsInCart['quantity_added']; ?></p></td>
                                    <td><p><?= $productsInCart['total_price']; ?></p></td>
                                </tr>
                        <?php endforeach; ?>
                    <?php }?>
                </table>
                <hr style="border-width: 1px; border-color:black; margin-top:20px;">
            </div>

            <div class="mb-5 mx-10 text-left">
                <table class="w-96">
                    <tr>
                        <td><p class="flex-auto text-lg"><b>Total Sales</b> </td>
                        <td><p class="flex-auto text-lg"><?= $transaction['amount'] ?></td>
                    </tr>
                <table>

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
                <p class="text-center text-2xl my-5"><b>THANK YOU!</b></p>
            </div>

        </div>
    </body>
 
</html>