<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$roleChecker = $coop->roleChecker();
$user = $coop->home();
$monthlySale = $coop->getMonthlySales();
$averageDailySale = round($monthlySale/23, 2);
$yearlySale = $coop->getYearlySales();
$yearlySaleChart = $coop->getYearlySalesChart();

$topSelling = $coop->getTopSelling();
$topSellingItem = $coop->getTopSellingItem();
$soldItems = $coop->soldItems();

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d");
$month = date("m");

$dateDay = date("l");
$time = date("h:i:sa");

$counter = 0;
$counter1 = 0;

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
        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        const d = new Date();
        let year = d.getFullYear();

        function drawChart() {
            //=============================== monthly sales chart =====================================
            var data = google.visualization.arrayToDataTable([
                ["Month", "Sales", { role: "style" } ],
                ["January", <?= $coop->getMonthlySalesChart("1"); ?>, "#67b7ff"],
                ["February",<?= $coop->getMonthlySalesChart("2"); ?>, "#67b7ff"],
                ["March",<?= $coop->getMonthlySalesChart("3"); ?>, "#67b7ff"],
                ["April",<?= $coop->getMonthlySalesChart("4"); ?>, "#67b7ff"],
                ["May",<?= $coop->getMonthlySalesChart("5"); ?>, "#67b7ff"],
                ["June",<?= $coop->getMonthlySalesChart("6"); ?>, "#67b7ff"],
                ["July",<?= $coop->getMonthlySalesChart("7"); ?>, "#67b7ff"],
                ["August",<?= $coop->getMonthlySalesChart("8"); ?>, "#67b7ff"],
                ["September",<?= $coop->getMonthlySalesChart("9"); ?>, "#67b7ff"],
                ["October",<?= $coop->getMonthlySalesChart("10"); ?>, "#67b7ff"],
                ["November",<?= $coop->getMonthlySalesChart("11"); ?>, "#67b7ff"],
                ["December",<?= $coop->getMonthlySalesChart("12"); ?>, "#67b7ff"],
            ]);

            // var data = google.visualization.arrayToDataTable([
            //     ["Month", "Sales", { role: "style" } ],
            //     ["January", 10231, "#67b7ff"],
            //     ["February",12001, "#67b7ff"],
            //     ["March",12321, "#67b7ff"],
            //     ["April",13531, "#67b7ff"],
            //     ["May",9812, "#67b7ff"],
            //     ["June",10203, "#67b7ff"],
            //     ["July",10289, "#67b7ff"],
            //     ["August",11201, "#67b7ff"],
            //     ["September",12312, "#67b7ff"],
            //     ["October",13201, "#67b7ff"],
            //     ["November",14201, "#67b7ff"],
            //     ["December",10281, "#67b7ff"],
            // ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                            { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" },
                            2]);

            var options = {
                title: "MONTHLY SALES "+year,
                width: 600,
                height: 380,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
                chartArea:{left:10,top:20,width:"90%",height:"80%"},
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("monthly_sale"));
            chart.draw(view, options);

            //=============================== yearly sales chart =====================================
            var yearSale = google.visualization.arrayToDataTable([
                ["Year", "Sales", { role: "style" } ],
                <?php foreach ($yearlySaleChart as $sale): ?>
                    ["<?= $sale['year']; ?>", <?= $sale['total']; ?>, "#ffd966"],
                <?php endforeach ?>
                
            ]);

            var viewYear = new google.visualization.DataView(yearSale);
            viewYear.setColumns([0, 1,
                            { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" },
                            2]);

            var optionsYear = {
                title: "YEARLY SALES ",
                width: 800,
                height: 380,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
            };
            var chartYear = new google.visualization.ColumnChart(document.getElementById("yearly_sale"));
            chartYear.draw(viewYear, optionsYear);

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
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">Analytics - OVERALL</p>
                        <div class="justify-end mx-1 w-full flex items-center">
                            <a href="adminAnalytics.php"><p class="text-xs ml-3 text-[#2986CC] font-bold outline outline-offset-1 outline-[#221E3F] rounded-md bg-[#43365E] p-2 text-white">OVERALL</p></a>
                            <a href="adminAnalyticsDaily.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">DAILY</p></a>
                            <a href="adminAnalyticsWeekly.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">WEEKLY</p></a>
                            <a href="adminAnalyticsMonthly.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">MONTHLY</p></a>
                            <a href="adminAnalyticsYearly.php"><p class="text-xs text-[#43365E] font-bold ml-3 outline outline-offset-1 outline-[#221E3F] rounded-md bg-transparent p-2 hover:bg-[#43365E] hover:text-white cursor-pointer">YEARLY</p></a>
                        </div>
                    </div>

                    <div class="bg-white mt-5 rounded-2xl py-5 px-5 drop-shadow-xl">
                        <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F] mb-10">SALES SUMMARY</p>
                        <div class="flex">
                            <div class="bg-white flex flex-col w-full">
                                <div>
                                    <div class="grid grid-cols-3">

                                        <div class="flex-1 text-[#221E3F] rounded-md h-[8rem] p-2 grid-cols-3 col-span-3 items-center">
                                            <div class="col-span-3 text-lg pr-3 pt-1 pl-4">
                                                <ul class="text-lg font-semibold text-left"><b>Average Daily Sale </b><p class="text-sm">(23 - day basis)</p></ul> 
                                                <ul class="text-4xl text-center font-bold mt-3">₱ <?= $averageDailySale ?></ul> 
                                            </div>
                                        </div>

                                        <div class="flex justify-center items-center text-center col-span-3 mx-5">
                                            <hr class="h-[2px] w-full bg-gray-200 border-0 dark:bg-gray-700">
                                        </div>

                                        <div class="flex-1 text-[#221E3F] rounded-md h-[8rem] p-2 grid grid-cols-3 col-span-3">
                                            <div class="col-span-3 text-lg pr-5 pt-1 pl-4">
                                                <ul class="text-lg font-semibold text-left"><b>Monthly Sale </b><p class="text-sm">(<?= $coop->monthEquivalent($month)?>)</p></ul> 
                                                <ul class="text-4xl text-center font-bold mt-3">₱ <?= $monthlySale ?></ul> 
                                            </div>
                                        </div>

                                        <div class="flex justify-center items-center text-center col-span-3 mx-5">
                                            <hr class="h-[2px] w-full bg-gray-200 border-0 dark:bg-gray-700">
                                        </div>
                                        
                                        <div class="flex-1 text-[#221E3F] rounded-md h-[8rem] p-2 grid grid-cols-3 col-span-3">
                                            <div class="col-span-3 text-lg pr-5 pt-1 pl-4">
                                                <ul class="text-lg font-semibold text-left"><b>Yearly Sale </b><p class="text-sm">(<?= date("Y") ?>)</p></ul> 
                                                <ul class="text-4xl text-center font-bold mt-3">₱ <?= $yearlySale ?></ul> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="monthly_sale" class="w-full ml-3 mt-3"></div>
                        </div>

                        <div class="flex justify-center items-center text-center mt-10">
                            <hr class="h-[2px] w-full bg-gray-200 border-0 dark:bg-gray-700">
                        </div>

                        <div class="flex justify-center items-center mt-10">
                            <div id="yearly_sale" class="bg-white rounded-lg w-full flex flex justify-center"></div>
                        </div>
                    </div>

                    <div class="bg-white mt-5 rounded-2xl py-5 px-5 drop-shadow-xl">
                        <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F]">TOP SELLING ITEMS - OVERALL</p>
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
                                <p class="text-2xl font-extrabold w-full px-3 text-[#221E3F]">TOTAL SALES PER ITEM - OVERALL</p>
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

</html>