<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$roleChecker = $coop->roleChecker();
$user = $coop->home();
$totalDailySale = $coop->getDailySale();
$topSellingItem = $coop->getDailyTopSellingItem();
$soldItems = $coop->getDailySoldItems();

//chart data
$dailyChartData = $coop->getDailyChart();
$topSelling = $coop->getDailyTopSelling();

$totalProductSold = $coop->getTotalProducts();
$totalDailyTransactions = $coop->getTotalTransactions();
$dailyTransaction = $coop->getDailyTransactions();

date_default_timezone_set('Asia/Manila');
$present = date("m-d-Y");
$dateDay = date("l");
$time = date("h:i:sa");

$counter = 0;
$counter1 = 0;

$date = date("m-d-Y", strtotime($coop->getDate()));
$date1 = $coop->getDate();

if (!$date1) {
    $datePreset = date("Y-m-d");
} else {
    $parts = explode('-', $date);
    $month = $parts[0]; 
    $day = $parts[1]; 
    $year = $parts[2];

    $datePreset = $year."-".$month."-".$day;
}

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

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        const d = new Date();
        let year = d.getFullYear();

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ["Day", "Sales", { role: "style" } ],
                <?php foreach($dailyChartData as $dataDaily):?>
                    ["<?= $dataDaily['date']; ?>", <?= $dataDaily['total']; ?>, "#67b7ff"],
                <?php endforeach; ?>
                    
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                            { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" },
                            2]);

            var options = {
                title: "DAILY SALES",
                width: 600,
                height: 380,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
                chartArea:{left:10,top:20,width:"90%",height:"80%"},
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("daily_sale"));
            chart.draw(view, options);

            //=============================== top selling chart =====================================
            var topSelling = google.visualization.arrayToDataTable([
                ['Product Name', 'Quantity Sold'],
                <?php foreach ($topSelling as $product): ?>
                    ['<?= $product['product_name'] ?>', <?= $product['total_sold'] ?>],
                <?php endforeach ?>
            ]);

            var options = {
                title: 'Top 5 Selling Items',
                width: 500,
                height: 420,
                chartArea:{left:50,top:60,width:"100%",height:"80%"},
            };

            var chart = new google.visualization.PieChart(document.getElementById('top_selling'));

            chart.draw(topSelling, options);
            }

    </script>
    
</head>
<body>
	<body class="bg-[#221E3F]">    	
        <div class="w-full h-full flex">
            <div class="w-[310px]">
                <?php include 'adminSideBar.php'; ?>
            </div>
            <div class="w-full h-auto px-10 py-5">
                <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-full px-10 py-10 flex flex-col">
                <div>
                    <div class="flex">
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">Analytics - DAILY</p>
                        <div class="justify-end mx-1 w-full flex items-center">
                            <a href="adminAnalytics.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">OVERALL</p></a>
                            <a href="adminAnalyticsDaily.php"><p class="text-xs ml-3 text-[#2986CC] font-bold outline outline-offset-1 outline-[#221E3F] rounded-md bg-[#43365E] p-2 text-white">DAILY</p></a>
                            <a href="adminAnalyticsWeekly.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">WEEKLY</p></a>
                            <a href="adminAnalyticsMonthly.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">MONTHLY</p></a>
                            <a href="adminAnalyticsYearly.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">YEARLY</p></a>
                        </div>
                    </div>

                    <div class="m-auto mt-5">
                        <form method='get' action='adminAnalyticsDaily.php'>
                            <label class="ml-2 text-md text-[#221E3F] font-bold mt-2">Date: </label>
                            <input id="datePicker" type="date" name="day" class="ml-2 outline outline-offset-2 outline-[#221E3F] rounded-md" required max="<?= date("Y-m-d")?>" value="<?= $datePreset ?>"></input>
                            <button type="submit" name="pickDate" class="ml-1 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] text-sm h-[30px] px-2">Pick Date</button>
                        </form>
                    </div> 
                    
                    <div class="bg-white mt-5 rounded-2xl py-5 px-5 drop-shadow-xl">
                        <?php if (!$date1) { ?>
                            <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F] mb-10">SALES SUMMARY  (<?= $present ?>)</p>
                        <?php } else { ?>
                            <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F] mb-10">SALES SUMMARY  (<?= $date ?>)</p>
                        <?php } ?>
                        <div class="flex">
                            <div class="bg-white flex flex-col w-full">
                                <div>
                                    <div class="grid grid-cols-3">

                                        <div class="flex-1 text-[#221E3F] rounded-md h-[8rem] p-2 grid-cols-3 col-span-3 items-center">
                                            <div class="col-span-3 text-lg pr-3 pt-1">
                                                <ul class="text-lg font-semibold text-left pl-4"><b>Total Sale</b></ul> 
                                                <ul class="text-5xl text-center font-bold mt-3">₱ <?= $totalDailySale['total'] ?></ul> 
                                            </div>
                                        </div>

                                        <div class="flex justify-center items-center text-center col-span-3 mx-5">
                                            <hr class="h-[2px] w-full bg-gray-200 border-0 dark:bg-gray-700">
                                        </div>

                                        <div class="flex-1 text-[#221E3F] rounded-md h-[8rem] p-2 grid grid-cols-3 col-span-3">
                                            <div class="col-span-3 text-lg pr-3 pt-1">
                                                <ul class="text-lg font-semibold text-left pl-4"><b>Total No. of Products Sold</b></ul> 
                                                <ul class="text-5xl text-center font-bold mt-3"><?= $totalProductSold['total_sold'] ?></ul> 
                                            </div>
                                        </div>

                                        <div class="flex justify-center items-center text-center col-span-3 mx-5">
                                            <hr class="h-[2px] w-full bg-gray-200 border-0 dark:bg-gray-700">
                                        </div>
                                        
                                        <div class="flex-1 text-[#221E3F] rounded-md h-[8rem] p-2 grid grid-cols-3 col-span-3">
                                            <div class="col-span-3 text-lg pr-3 pt-1">
                                                <ul class="text-lg font-semibold text-left pl-4"><b>Transactions Made</b></ul> 
                                                <ul class="text-5xl text-center font-bold mt-3"><?= $totalDailyTransactions ?></ul> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="daily_sale" class="w-full ml-3 mt-3"></div>
                        </div>
                    </div>

                    <div class="bg-white mt-5 rounded-2xl py-5 px-5 drop-shadow-xl">
                        <?php if (!$date1) { ?>
                            <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F] mb-5">TRANSACTIONS MADE (<?= $present ?>)</p>
                        <?php } else { ?>
                            <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F] mb-5">TRANSACTIONS MADE (<?= $date ?>)</p>
                        <?php } ?>

                        <div class="w-full flex h-[36rem] bg-[#FCE4BE] rounded-lg mt-5"> 
                            <div class="justify-self-start w-full overflow-auto max-h-106 bg-white rounded-lg">
                                <table class="justify-self-stretch w-full m-auto">
                                        <thead class="font-semibold text-md bg-[#221E3F] text-white sticky top-0">
                                            <td class="px-3 py-2 rounded-tl-lg">Trans ID</td>
                                            <td>Date</td>
                                            <td>Customer Name</td>
                                            <td>Amount</td>
                                            <td>Transaction State</td>
                                            <td>Transaction Process</td>
                                            <td>Cashier Name</td>
                                            <td class="rounded-tr-lg"></td>
                                        </thead>
                                <?php foreach($dailyTransaction as $transactions): ?>
                                        <tr class="text-md cursor-pointer hover:bg-[#eeeeee]">
                                            <td class="py-3 px-2"><?= $transactions['transaction_id']; ?></td>
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
                                            <td><a href='adminViewTransaction.php?transactionID=<?=$transactions['transaction_id'];?>'><button class="ml-1 rounded-lg bg-[#221E3F] px-4 text-white hover:bg-[#6257b4] text-white p-2 text-sm">View</button></a></td>
                                        </tr>
                                <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white mt-5 rounded-2xl py-5 px-5 drop-shadow-xl">
                        <?php if (!$date1) { ?>
                            <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F] mb-10">TOP SELLING  (<?= $present ?>)</p>
                        <?php } else { ?>
                            <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F] mb-10">TOP SELLING  (<?= $date ?>)</p>
                        <?php } ?>
                        <div class="flex">
                            <div class="flex items-center justify-center">
                                <div id="top_selling" class="rounded-lg w-full flex justify-center"></div>
                            </div>
                            <div class="bg-white flex flex-col w-full h-auto px-3">
                                <div>
                                    <div class="flex-1 bg-[#1bcb00] text-white rounded-md h-[8rem] p-2 grid grid-cols-3 mb-3 drop-shadow-lg"><div class="col-span-1 flex items-center justify-center"><img src="thumbnails/<?= $topSellingItem['thumbnail']; ?>" width="90" height="90"></div>
                                        <div class="col-span-2 text-lg pr-3 pt-1 pl-2">
                                            <ul class="text-xl text-left"><b>TOP SELLING</b></ul>
                                            <ul class="text-lg text-left"><b>Item: <?= $topSellingItem['product_name'];?> </b></ul>
                                            <ul class="text-sm text-left"><b>Quantity Bought: </b><?= $topSellingItem['total_sold'];?> </ul> 
                                            <ul class="text-sm text-left"><b>Total Sale: </b><?= $topSellingItem['total_sale'];?></ul> 
                                        </div>
                                    </div>

                                    <div class="w-full h-auto max-h-full">
                                        <table class="justify-self-stretch w-full m-auto  drop-shadow-lg">
                                                <thead class="font-semibold text-sm bg-[#221E3F] text-white">
                                                    <td class="rounded-tl-md"></td>
                                                    <td></td>
                                                    <td class="py-3">Prod. Code</td>
                                                    <td class="px-2">Prod. Name</td>
                                                    <td class="px-2">Qty. Bought</td>
                                                    <td class="rounded-tr-md">Total</td>
                                                </thead>
                                        <?php foreach($topSelling as $products): $counter += 1;?>
                                                <tr class="text-sm">
                                                    <td class="px-2"><?= $counter; ?></td>
                                                    <td class="py-1"><img src="thumbnails/<?= $products['thumbnail']; ?>" height="50" width="50"></td>
                                                    <td class="px-2"><?= $products['product_code']; ?></td>
                                                    <td class="px-2"><?= $products['product_name']; ?></td>
                                                    <td class="px-2"><?= $products['total_sold']; ?></td>
                                                    <td class="px-2"><?= $products['total_sale']; ?></td>         
                                                </tr>
                                        <?php endforeach; ?>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            
                        </div>

                        <div class="flex justify-center items-center text-center mt-10">
                            <hr class="h-[2px] w-full bg-gray-200 border-0 dark:bg-gray-700">
                        </div>

                        <div class="flex my-5">
                            <div class="bg-white flex flex-col w-full h-[42rem]">
                                <?php if (!$date1) { ?>
                                    <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F]">TOTAL SALES PER ITEM  (<?= $present ?>)</p>
                                <?php } else { ?>
                                    <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F]">TOTAL SALES PER ITEM  (<?= $date ?>)</p>
                                <?php } ?>
                                <div class="w-full py-5 px-5">
                                    <div class="w-full overflow-auto h-[40rem] max-h-full">
                                        <table class="justify-self-stretch w-full drop-shadow-lg">
                                                <thead class="font-semibold text-md bg-[#221E3F] text-white sticky top-0">
                                                    <td class="rounded-tl-md"></td>
                                                    <td></td>
                                                    <td class="py-3">Product Code</td>
                                                    <td>Product Name</td>
                                                    <td>Quantity Bought</td>
                                                    <td class="rounded-tr-md">Total Price</td>
                                                </thead>
                                        <?php foreach($soldItems as $products): $counter1 += 1;?>
                                                <tr>
                                                    <td class="px-2"><?= $counter1; ?></td>
                                                    <td class="py-1"><img src="thumbnails/<?= $products['thumbnail']; ?>" height="50" width="50"></td>
                                                    <td class="px-2"><?= $products['product_code']; ?></td>
                                                    <td class="px-2"><?= $products['product_name']; ?></td>
                                                    <td class="px-2"><?= $products['total_sold']; ?></td>
                                                    <td class="px-2"><?= $products['total_sale']; ?></td>         
                                                </tr>
                                        <?php endforeach; ?>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </body>
</body>
<script>

</script>
</html>