<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$transactions = $coop->getStaffTransactions();
$filterTransactionProcess = $coop->returnStaffTransactionProcess();

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
                        <table class="justify-self-stretch w-full m-auto ">
                            <thead class="font-bold text-md bg-[#67b0e7] text-white sticky top-0">
                                <td class="pl-2 rounded-tl-md py-2">Transaction ID</td>
                                <td class="py-2">Date</td>
                                <td class="py-2">Customer Name</td>
                                <td class="py-2">Amount</td>
                                <td class="py-2">Transaction State</td>
                                <td class="py-2">Transaction Process</td>
                                <td class="py-2">Cashier Name</td>
                                <td class="rounded-tr-md">View</td>
                            </thead>
                            <?php if($transactions){ ?>
                                <?php foreach($transactions as $transaction): ?>
                                    <tr>
                                        <td class="py-2"><?= $transaction['transaction_id']; ?></td>
                                        <td><?= $transaction['date']; ?></td>
                                        <td><?= $transaction['name']; ?></td>
                                        <td><?= $transaction['amount']; ?></td>
                                        <td><?= $transaction['state']; ?></td>
                                        <?php if($transaction['online'] == '1') { ?>
                                            <td>Online</td>
                                        <?php } else { ?>
                                            <td>In-Store</td>
                                        <?php } ?>
                                        <td><?= $transaction['cashier_name']; ?></td>
                                        <td><a href='staffViewTransaction.php?transactionID=<?=$transaction['transaction_id'];?>'>View Details</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php }?>
                        </table>
                        <?php if(!$transactions) {?>
                                <div class="mt-[10rem] text-lg text-[#67b0e7] text-center"><p>THERE ARE NO TRANSACTIONS!</p></div>
                        <?php } ?>


                    </div>

                    <div class="w-1/5 bg-[#eaf8ff] p-5 rounded-br-lg flex-initial">
                        
                        <div class="flex-1 items-center rounded-md h-auto bg-[#67b0e7]">
                            
                            <div class="place-items-center">
                                <div class="pt-1 pb-2 px-2">
                                <form action = "staffTransactionHistory.php" method = "POST">
                                    <select name="processType" id="process" >
                                        <!-- <option value='all' selected>All</option>
                                        <option value='staff'>Staff</option>
                                        <option value='customer'>Customer</option>
                                        -->
                                        <?php if ($filterTransactionProcess == 'online') { ?>
                                            <option value='all'>All</option>
                                            <option value='online' selected>Online</option>
                                            <option value='instore'>In-Store</option>

                                        <?php } else if ($filterTransactionProcess == 'instore') { ?>
                                            <option value='all'>All</option>
                                            <option value='online'>Online</option>
                                            <option value='instore' selected>In-Store</option>

                                        <?php } else { ?>
                                            <option value='all' selected>All</option>
                                            <option value='online'>Online</option>
                                            <option value='instore'>In-Store</option>

                                        <?php } ?>
                                    </select>
                                    <button type="submit" name="process">GO</button>
                                </form>
                                </div>
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