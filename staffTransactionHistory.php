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
                <div>
                    <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">TRANSACTION HISTORY</p>
                    <div class="flex my-5 grid grid-cols-2">
                        <form action = "staffTransactionHistory.php" method = "POST" class="flex mr-5">
                            <select name="processType" id="process" class="ml-2 rounded-md h-[30px]">
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
                            <button name="process" class="ml-2 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] text-sm h-[30px] px-2">GO</button>
                        </form>
                    </div>

                    <div class="w-full flex h-[36rem] bg-[#ffd695] rounded-b-lg">
                        <div class="justify-self-start w-full overflow-auto max-h-106"> 
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-semibold text-md bg-[#221E3F] text-white sticky top-0">
                                        <td class="pl-2 rounded-tl-md py-2">Transaction ID</td>
                                        <td class="py-2">Date</td>
                                        <td class="py-2">Customer Name</td>
                                        <td class="py-2">Amount</td>
                                        <td class="py-2">Transaction State</td>
                                        <td class="py-2">Transaction Process</td>
                                        <td class="py-2">Cashier Name</td>
                                        <td class="rounded-tr-md"></td>
                                    </thead>
                            <?php foreach($transactions as $transaction): ?>
                                <tr class="cursor-pointer hover:bg-[#e8d2ae]">
                                    <td class="py-2 px-2"><?= $transaction['transaction_id']; ?></td>
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
                                    <td><a href='staffViewTransaction.php?transactionID=<?=$transaction['transaction_id'];?>'><button class="ml-1 rounded-lg bg-[#221E3F] px-4 text-white hover:bg-[#6257b4] text-white p-2 text-sm">View</button></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </table>
                            <?php if(!$transactions) {?>
                                <div class="flex items-center justify-center h-[30rem] w-full">
                                    <p class="text-center">NO TRANSACTIONS!</p>
                                <div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>