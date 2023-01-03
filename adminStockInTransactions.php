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

<body class="bg-[#9ed5f0]">    	
    <div class="w-full h-full flex">
        <div class="w-[310px]">
            <?php include 'adminSideBar.php'; ?>
        </div>

        <div class="w-full h-auto px-10 py-10">
            <div class="bg-[#eaf8ff] rounded-lg flex flex-col w-full">
                <div class="w-full">
                    <p class="text-3xl font-bold w-full">MANAGE STOCK IN TRANSACTIONS</p>
                    <div class="w-full flex"> 
                        <table class="justify-self-stretch w-full m-auto ">
                                <thead>
                                    <td>#</td>
                                    <td></td>
                                    <td class="py-2">Staff Name</td>
                                    <td class="py-2">Date</td>
                                    <td class="py-2">Product ID</td>
                                    <td class="py-2">Product Name</td>
                                    <td>Stock In Quantity</td>
                                </thead>
                            <?php if ($stock) { $counter=0;?>
                                <?php foreach($stock as $stockIn): $counter += 1;?>
                                    <tr>
                                        <td><?= $counter; ?></td>
                                        <td><img src="thumbnails/<?= $stockIn['thumbnail']; ?>" width='50' height='50'></td>
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
                                <p>THERE ARE NO STOCK IN HISTORY!</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>