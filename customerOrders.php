<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$orders = $coop->getCustomerTransactions();


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
                <?php include 'customerTopBar.php'; ?>
                

                <div class="w-full flex h-auto mt-8">
                    <div class="w-full bg-[#eaf8ff] px-5 rounded-bl-lg">
                            <table class="justify-self-stretch w-full m-auto">
                            <?php if($orders){ ?>
                                    <?php foreach($orders as $order): ?>
                                        <tr>
                                            <td><p><?= $order['transaction_id']; ?></p></td>
                                            <td><p><?= $order['date']; ?></p></td>
                                            <td><p><?= $order['description']; ?></p></td>
                                            <td><p><?= $order['amount']; ?></p></td>
                                            <td><p><?= $order['state']; ?></p></td>
                                            <td><a href="customerOrderView.php?orderID=<?= $order['transaction_id']; ?>">View</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                            <?php }?>
                            </table>
                            <?php if(!$orders) {?>
                                    <p>THERE ARE NO ORDERS YET! ORDER NOW!</p>
                            <?php } ?>
                        </form>
                    </div>
                </div>
                
            </div>
            <!-- <p class="pb-2 bg-[#9ed5f0] pl-20 text-white text-lg"><b>Date: </b><?= $date ?> <?= $dateDay ?></p>
            <button class="ml-20 text-sm text-white mb-6 rounded-lg bg-[#67b0e7] p-2 text-white hover:bg-[#2986CC]"><a href="login.php?logout='1'" onclick="return confirm('Are you sure you want to logout?')"><img src="static/icons/logout.png" width="18" height="18"></a></button> -->
        </div>
    </body>
</body>

</html>