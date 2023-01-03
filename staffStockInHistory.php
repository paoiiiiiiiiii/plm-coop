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
    
</head>
<body>
	<body class="bg-[#f0faff]">    	
        <div class="w-100% h-100% items-center bg-[#f0faff]">
            <div class="rounded-md py-5 px-20 pb-5 drop-shadow-md">
                <?php include 'staffTopBar.php'; ?>

                <div class="w-100% flex h-auto mt-8">
                    <div class="justify-self-start w-full bg-[#eaf8ff] px-5 rounded-bl-lg pt-10">
                        <p class="text-center text-2xl">YOUR STOCK IN HISTORY</p>
                        <div>
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-bold text-md sticky top-0">
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
            <!-- <p class="pb-2 bg-[#9ed5f0] pl-20 text-white text-lg"><b>Date: </b><?= $date ?> <?= $dateDay ?></p>
            <button class="ml-20 text-sm text-white mb-6 rounded-lg bg-[#67b0e7] p-2 text-white hover:bg-[#2986CC]"><a href="login.php?logout='1'" onclick="return confirm('Are you sure you want to logout?')"><img src="static/icons/logout.png" width="18" height="18"></a></button> -->
        </div>
    </body>
</body>

</html>