<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$completed = $coop->getCompletedOrders();

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
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F] pb-4">ONLINE TRANSACTION</p>
                        <div class="justify-end pr-2 w-full flex items-center">
                            <a href="staffOnlineTransaction.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">PENDING</p></a>
                            <a href="staffProcessingTransaction.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">PROCESSING</p></a>
                            <a href="staffCancelledTransaction.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">CANCELLED</p></a>
                            <a href="staffCompletedTransaction.php"><p class="text-xs ml-3 text-[#2986CC] font-bold outline outline-offset-1 outline-[#221E3F] rounded-md bg-[#43365E] p-2 text-white">COMPLETED</p></a>
                            
                        </div>
                    </div>
                    <div class="w-full h-full flex">
                        <div class="w-full flex h-[40rem] rounded-lg">
                            <div class="justify-self-start w-full bg-[#ffd695] rounded-b-lg rounded-t-lg">
                                <div class="overflow-auto h-[32rem] max-h-106">
                                    <table class="justify-self-stretch w-full m-auto">
                                        <thead class="font-bold text-md bg-[#221E3F] text-white sticky top-0">
                                            <td class="pl-2 rounded-tl-lg py-2">Transaction ID</td>
                                            <td class="py-2">Date</td>
                                            <td class="py-2">Account</td>
                                            <td class="py-2">Receiver Name</td>
                                            <td class="py-2">Process</td>
                                            <td class="py-2">State</td>
                                            <td class="py-2">Total Price</td>
                                            <td class="rounded-tr-lg w-[10px]"></td>
                                        </thead>
                                        <?php if ($completed) { ?>
                                            <?php foreach($completed as $completedOrders): ?>
                                                <tr class="cursor-pointer hover:bg-[#e8d2ae]">
                                                    <td class="py-2 px-3"><p><?= $completedOrders['transaction_id']; ?></p></td>
                                                    <td><p><?= $completedOrders['date']; ?></p></td>
                                                    <td><p><?= $completedOrders['fname']." ".$completedOrders['lname']; ?></p></td>
                                                    <td><p><?= $completedOrders['name']; ?></p></td>
                                                    <td><p><?= $completedOrders['process']; ?></p></td>
                                                    <td><p><?= $completedOrders['state']; ?></p></td>
                                                    <td><p><?= $completedOrders['amount']; ?></p></td>
                                                    <td class="py-2 px-3"><a href="staffViewOrder.php?transactionID=<?= $completedOrders['transaction_id']?>"><button class="ml-1 rounded-lg bg-[#221E3F] px-4 text-white hover:bg-[#6257b4] text-white p-2 text-sm">View</button></a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                    <?php } ?>
                                    </table>
                                    <?php if(!$completed) {?>
                                            <div class="mt-[15rem] text-lg text-[#221E3F] text-center">
                                                <p>THERE ARE NO COMPLETED ORDERS!</p>
                                            </div>
                                    <?php } ?>
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
