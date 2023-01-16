<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$roleChecker = $coop->roleChecker();
$user = $coop->home();
$monthlySale = $coop->getMonthlySales();
$dailySale = $coop->getDailySales();
$productLine = $coop->getProductLine();
$stockOnHand = $coop->getStocksOnHand();
$criticalItem = $coop->getCriticalItems();
$numOfCustomers = $coop->getCustomers();
$numofTransactions = $coop->getTransactions();

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
        <div class="w-full h-screen flex">
            <div class="w-[310px]">
                <?php include 'adminSideBar.php'; ?>
            </div>

            <div class="w-full h-screen px-10 py-5">
                <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-full px-10 py-10">
                    <div>
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">Dashboard</p>
                        <div class="grid grid-cols-3 mt-5">
                            <a href="adminAnalyticsMonthly.php"><div class="flex-1 bg-[#1bcb00] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center cursor-pointer"><div class="col-span-1 flex items-center justify-center"><img src="static/icons/sales.png" width="90" height="90"></div>
                                <div class="col-span-2">
                                    <ul class="text-4xl font-bold text-left"><b><?= $monthlySale; ?></b></ul>
                                    <ul class="text-lg font-semibold text-left"><b>MONTHLY SALES</b></ul> 
                                    <ul class="text-sm text-left">Total monthly sales recorded on database</ul> 
                                </div>
                            </div></a>

                            <a href="adminProducts.php"><div class="flex-1 bg-[#00b9e5] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center cursor-pointer"><div class="col-span-1 flex items-center justify-center pl-3"><img src="static/icons/products.png" width="85" height="85"></div>
                                <div class="col-span-2">
                                    <ul class="text-4xl font-bold text-left"><b><?= $productLine; ?></b></ul>
                                    <ul class="text-lg font-semibold text-left"><b>PRODUCT LINE</b></ul> 
                                    <ul class="text-sm text-left">Total product line recorded on database</ul> 
                                </div>
                            </div></a>

                            <a href="adminProducts.php"><div class="flex-1 bg-[#f8de00] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center cursor-pointer"><div class="col-span-1 flex items-center justify-center pl-3"><img src="static/icons/stocks.png" width="90" height="90"></div>
                                <div class="col-span-2">
                                    <ul class="text-4xl font-bold text-left"><b><?= $stockOnHand; ?></b></ul>  
                                    <ul class="text-lg font-semibold text-left"><b>STOCK ON HAND</b></ul> 
                                    <ul class="text-sm text-left">Total stocks recorded on database</ul> 
                                </div>
                            </div></a>

                            <a href="adminProducts.php"><div class="flex-1 bg-[#ff6363] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center cursor-pointer"><div class="col-span-1 flex items-center justify-center pl-3"><img src="static/icons/criticals.png" width="80" height="80"></div>
                                <div class="col-span-2">
                                    <ul class="text-4xl font-bold text-left"><b><?= $criticalItem; ?></b></ul>  
                                    <ul class="text-lg font-semibold text-left"><b>CRITICAL ITEMS</b></ul> 
                                    <ul class="text-sm text-left">Total critical items recorded on database</ul> 
                                </div>
                            </div></a>

                            <a href="adminManageUsers.php"><div class="flex-1 bg-[#FFA15E] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center cursor-pointer"><div class="col-span-1 flex items-center justify-center pl-3"><img src="static/icons/customers.png" width="90" height="90"></div>
                                <div class="col-span-2">
                                    <ul class="text-4xl font-bold text-left"><b><?= $numOfCustomers; ?></b></ul>  
                                    <ul class="text-lg font-semibold text-left"><b>STAFFS</b></ul> 
                                    <ul class="text-sm text-left">Total customers recorded on database</ul> 
                                </div>
                            </div></a>

                            <a href="adminAnalyticsDaily.php"><div class="flex-1 bg-[#DE53C8] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-xl items-center cursor-pointer"><div class="col-span-1 flex items-center justify-center pl-3"><img src="static/icons/transactions.png" width="90" height="90"></div>
                                <div class="col-span-2 text-lg">
                                    <ul class="text-4xl font-bold text-left"><b><?= $numofTransactions; ?></b></ul>  
                                    <ul class="text-lg font-semibold text-left"><b>TRANSACTIONS</b></ul> 
                                    <ul class="text-sm text-left">Total transactions made today</ul> 
                                </div>
                            </div></a>

                            <div class="border-2 border-[#221E3F] flex-1 bg-[#FCE4BE] text-[#221E3F] rounded-3xl h-[10rem] mx-3 my-5 p-2 grid grid-cols-3 drop-shadow-md items-center col-span-3 divide-x-8 divide-[#221E3F] cursor-pointer">
                                <div class="col-span-1 flex items-center justify-center pl-3">
                                    <img src="static/icons/sales.png" width="90" height="90">
                                    <p class="text-5xl font-bold text-left pl-3"><b><?= $dailySale ?></b></p>
                                </div>
                                <div class="col-span-2 text-lg pl-8">
                                    <ul class="text-3xl font-semibold text-left"><b>SALES TODAY</b></ul> 
                                    <ul class="text-md text-left"><b>Date: </b><?= $dateDay." ".$date ?></ul> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
        </div>
        <!-- <span class="fa fa-edit text-3xl text-white"> -->

    </body>


</html>