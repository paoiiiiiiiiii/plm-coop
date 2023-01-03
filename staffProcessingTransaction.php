<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$processing = $coop->getProcessingOrders();

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
                    <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg pt-10">
                        <div class="w-full grid grid-cols-4">
                        <a href="staffOnlineTransaction.php"><p>PENDING</p></a>
                            <a href="staffProcessingTransaction.php"><p>PROCESSING</p></a>
                            <a href="staffCancelledTransaction.php"><p>CANCELLED</p></a>
                            <a href="staffCompletedTransaction.php"><p>COMPLETED</p></a>
                        </div>
                        <div>
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-bold text-md sticky top-0">
                                        <td class="pl-2 rounded-tl-md py-2">Transaction ID</td>
                                        <td class="py-2">Date</td>
                                        <td class="py-2">Account</td>
                                        <td class="py-2">Receiver Name</td>
                                        <td class="py-2">Process</td>
                                        <td class="py-2">State</td>
                                        <td class="py-2">Total Price</td>
                                        <td class="rounded-tr-md"></td>
                                    </thead>
                            <?php if ($processing) { ?>
                                    <?php foreach($processing as $processingOrders): ?>
                                        <tr>
                                            <td><p><?= $processingOrders['transaction_id']; ?></p></td>
                                            <td><p><?= $processingOrders['date']; ?></p></td>
                                            <td><p><?= $processingOrders['fname']." ".$processingOrders['lname']; ?></p></td>
                                            <td><p><?= $processingOrders['name']; ?></p></td>
                                            <td><p><?= $processingOrders['process']; ?></p></td>
                                            <td><p><?= $processingOrders['state']; ?></p></td>
                                            <td><p><?= $processingOrders['amount']; ?></p></td>
                                            <td><a href="staffViewOrder.php?transactionID=<?= $processingOrders['transaction_id']?>">View</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                            <?php } ?>
                            </table>
                            <?php if(!$processing) {?>
                                    <p>THERE ARE NO ON PROCESSING ORDERS!</p>
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