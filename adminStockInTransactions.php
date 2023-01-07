<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$stock = $coop->getAdminStockInHistory();

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
            <?php include 'adminSideBar.php'; ?>
        </div>

        <div class="w-full h-screen px-10 py-5">
            <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-full px-10 py-10">
                <div class="w-full">
                    <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">Stock In Transactions</p>
                    <div class="flex my-5 mr-5">
                        <form action = "adminStockInTransactions.php" method = "GET" class="flex ml-3">
                            <label class="ml-2 text-md text-[#221E3F] font-bold mt-1 mr-1">From:</label>
                            <input type="date" name="from" class="ml-2 outline outline-offset-2 outline-[#221E3F] rounded-md h-[30px]" required></input>
                            <label class="text-md text-[#221E3F] font-bold mt-1 ml-3 mr-1">To:</label>
                            <input type="date" name="to" class="ml-2 outline outline-offset-2 outline-[#221E3F] rounded-md h-[30px]" required></input>
                            <button type="submit" name="betweenDates" class="ml-1 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] text-sm h-[32px] px-2 ml-2">Pick Dates</button>
                        </form>
                    </div>

                    <div class="w-full flex h-[36rem] bg-[#FCE4BE] rounded-lg"> 
                        <div class="justify-self-start w-full overflow-auto max-h-106 bg-white rounded-lg">
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-semibold text-md bg-[#221E3F] text-white sticky top-0">
                                        <td class="px-3 py-3 rounded-tl-lg"></td>
                                        <td></td>
                                        <td class="py-2 ">Staff Name</td>
                                        <td>Date</td>
                                        <td>Product ID</td>
                                        <td>Product Name</td>
                                        <td class="rounded-tr-lg">Stock In Quantity</td>
                                    </thead>
                            <?php if ($stock) { $counter=0;?>
                                <?php foreach($stock as $stockIn): $counter += 1;?>
                                        <tr class="text-md cursor-pointer hover:bg-[#eeeeee]">
                                            <td class="py-3 px-3"><?= $counter; ?></td>
                                            <td class="py-2 px-3"><img src="thumbnails/<?= $stockIn['thumbnail']; ?>" width='50' height='50'></td>
                                            <td><?= $stockIn['fname']." ".$stockIn['lname']; ?></td>
                                            <td><?= $stockIn['date']; ?></td>
                                            <td><?= $stockIn['product_id']; ?></td>
                                            <td><?= $stockIn['product_name']; ?></td>
                                            <td><?= $stockIn['added_quantity']; ?></td>
                                        </tr>
                                <?php endforeach; ?>
                            <?php } ?>
                            </table>
                            <?php if(!$stock) {?>
                                <div class="flex items-center justify-center h-[30rem] w-full">
                                    <p class="text-center">NO STOCK IN HISTORY TRANSACTIONS!</p>
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