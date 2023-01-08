<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$userProfile = $coop->getUserProfile();
$product = $coop->staffGetInStoreCart();
$transaction = $coop->staffGetTransactionID();
$settleTransaction = $coop->staffSettlePayment();

$total = $_SESSION['total_amount'];
$amount_tendered = $_SESSION['tendered_amount'];

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
        <script src="assets/js/tailwind.js"></script>
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/fonts.css">
    </head>
    <body class="px-10">    	
        <div>
            <div class="flex">
                <button onClick="window.print()" class="ml-10 mt-5 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] p-1 text-sm">Print receipt</button>
                <form method="POST" action="staffSettleInStoreTransaction.php">
                        <button type="submit" class="ml-4 mt-5 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] p-1 text-sm"
                                    name="confirmTransac" onclick="return confirm('Confirm Transaction?')">
                            Confirm Transaction
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
                <p><b>Date: </b><?= $transaction['date'] ?></p>
                <p><b>Cashier Name: </b><?= $transaction['cashier_name']?></p>
            </div>

            <div class="mb-5 mx-10">
                <hr style="border-width: 1px; border-color:black; margin-bottom:20px;">
                <p class="text-center text-2xl my-5"><b>ORDER DETAILS</b></p>
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
                        <td><p class="flex-auto text-lg"><b>Total Sales: </b> </td>
                        <td><p class="flex-auto text-lg">₱ <?= $total; ?></td>
                    </tr>
                    <tr>
                        <td><p class="flex-auto text-lg"><b>Amount Tendered: </b> </td>
                        <td><p class="flex-auto text-lg">₱ <?= $amount_tendered ?></td>
                    </tr>
                    <tr>
                        <td><p class="flex-auto text-lg"><b>Change: </b> </td>
                        <td><p class="flex-auto text-lg">₱ <?= $amount_tendered - $total ?></td>
                    </tr>
                <table>

                <p class="text-center text-2xl my-5"><b>TRANSACTION DETAILS</b></p>
                <table class="w-96">
                    <tr>
                        <td><p class="flex-auto text-lg"><b>Transaction ID: </b> </td>
                        <td><p class="flex-auto text-lg text-right"><?= $transaction['transaction_id'] ?></td>
                    </tr>

                    <tr>
                        <td><p class="flex-auto text-lg"><b>Date: </b> </td>
                        <td><p class="flex-auto text-lg text-right"><?= $transaction['date'] ?></td>
                    </tr>

                    <tr>
                        <td><p class="flex-auto text-lg"><b>Process: </b></td>
                        <td><p class="flex-auto text-lg text-right">In-Store</td>
                    </tr>

                <table>
                
                <?php if ($transaction['process'] == 'delivery') {?>
                    <p class="text-center text-2xl my-5"><b>SHIPPING DETAILS</b></p>
                    <table class="w-96">
                        <tr>
                            <td><p class="flex-auto text-lg"><b>Name of Receiver: </b> </td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['name'] ?></td>
                        </tr>

                        <tr>
                            <td><p class="flex-auto text-lg"><b>Phone Number: </b> </td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['phone_number'] ?></td>
                        </tr>

                        <tr>
                            <td><p class="flex-auto text-lg"><b>Email: </b></td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['email'] ?></td>
                        </tr>

                        <tr>
                            <td><p class="flex-auto text-lg"><b>Address: </b></td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['address'] ?></td>
                        </tr>
                    
                    <table>
                <?php } else if ($transaction['process'] == 'walkin') { ?>
                    <p class="text-center text-2xl my-5"><b>OTHER DETAILS</b></p>
                    <table class="w-96">
                        <tr>
                            <td><p class="flex-auto text-lg"><b>Name of Receiver: </b> </td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['name'] ?></td>
                        </tr>

                        <tr>
                            <td><p class="flex-auto text-lg"><b>Phone Number: </b> </td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['phone_number'] ?></td>
                        </tr>

                        <tr>
                            <td><p class="flex-auto text-lg"><b>Email: </b></td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['email'] ?></td>
                        </tr>
                    <table>
                <?php } else { ?>
                    <table class="w-96">
                        <tr>
                            <td><p class="flex-auto text-lg"><b>Customer Name: </b> </td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['name'] ?></td>
                        </tr>

                        <tr>
                            <td><p class="flex-auto text-lg"><b>Phone Number: </b> </td>
                            <td><p class="flex-auto text-lg text-right"><?= $transaction['phone_number'] ?></td>
                        </tr>
                    <table>
                <?php } ?>
            </div>

        </div>
    </body>
 
</html>

