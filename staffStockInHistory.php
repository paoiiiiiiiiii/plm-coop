<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$stock = $coop->getStockInHistory();

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
                    <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">YOUR STOCK IN HISTORY</p>

                    <div class="w-full flex h-[36rem] bg-[#ffd695] rounded-b-lg mt-10">
                        <div class="justify-self-start w-full overflow-auto max-h-106"> 
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-semibold text-md bg-[#221E3F] text-white sticky top-0">
                                        <td class="pl-2 rounded-tl-md py-2">#</td>
                                        <td></td>
                                        <td class="py-2">Staff Name</td>
                                        <td class="py-2">Date</td>
                                        <td class="py-2">Product ID</td>
                                        <td class="py-2">Product Name</td>
                                        <td class="rounded-tr-md">Stock In Quantity</td>
                                    </thead>
                            <?php if ($stock) { $counter=0;?>
                                <?php foreach($stock as $stockIn): $counter += 1;?>
                                <tr class="cursor-pointer hover:bg-[#e8d2ae]">
                                    <td class="px-2"><?= $counter; ?></td>
                                    <td class="py-2"><img src="thumbnails/<?= $stockIn['thumbnail']; ?>" width='50' height='50'></td>
                                    <td><p><?= $stockIn['fname']." ".$stockIn['lname']; ?></p></td>
                                    <td><p><?= $stockIn['date']; ?></p></td>
                                    <td><p><?= $stockIn['product_id']; ?></p></td>
                                    <td><p><?= $stockIn['product_name']; ?></p></td>
                                    <td><p><?= $stockIn['added_quantity']; ?></p></td>

                                </tr>
                                <?php endforeach; ?>
                            <?php } ?>
                            </table>
                            <?php if(!$stock) {?>
                                <div class="flex items-center justify-center h-[30rem] w-full">
                                    <p class="text-center">NO STOCK IN TRANSACTIONS!</p>
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
