<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$inStoreTransaction = $coop->getAdminTransactions('online');
// $filterTransactionProcess = $coop->returnTransactionProcess();

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
    <script src="assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
</head>

<body class="bg-[#9ed5f0]">    	
    <div class="w-full h-full flex">
        <div class="w-[310px]">
            <?php include 'adminSideBar.php'; ?>
        </div>

        <div class="w-full h-auto px-10 py-10">
            <div class="bg-[#eaf8ff] rounded-lg flex flex-col w-full">
                <div class="w-full">
                    <p class="text-3xl font-bold w-full">MANAGE ONLINE TRANSACTIONS</p>
                    <div class="w-full flex"> 
                        <table class="justify-self-stretch w-full m-auto ">
                                <thead>
                                    <td>Transaction ID</td>
                                    <td>Date</td>
                                    <td>Customer Name</td>
                                    <td>Amount</td>
                                    <td>Transaction State</td>
                                    <td>Transaction Process</td>
                                    <td>Cashier Name</td>
                                    <td>View</td>
                                </thead>
                        <?php foreach($inStoreTransaction as $transactions): ?>
                                <tr>
                                    <td><?= $transactions['transaction_id']; ?></td>
                                    <td><?= $transactions['date']; ?></td>
                                    <td><?= $transactions['name']; ?></td>
                                    <td><?= $transactions['amount']; ?></td>
                                    <td><?= $transactions['state']; ?></td>
                                    <?php if($transactions['online'] == '1') { ?>
                                        <td>Online</td>
                                    <?php } else { ?>
                                        <td>In-Store</td>
                                    <?php } ?>
                                    <td><?= $transactions['cashier_name']; ?></td>
                                    <td><a href='adminViewTransaction.php?transactionID=<?=$transactions['transaction_id'];?>'>View Details</a></td>
                                </tr>
                        <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>