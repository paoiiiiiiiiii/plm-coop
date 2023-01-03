<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <link rel="icon" type="image/png" href="static/images/logo.png"> -->
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="bg-[#eaca67] flex rounded-lg p-5">
        <div class="justify-self-start w-1/5 flex items-center">
                <div>
                    <div class="bg-white h-18">PLM - COOPERATIVES</div>
                </div>
                <div class="px-2">
                    <p class="text-lg font-bold"><?= $user['fname'];?> <?= $user['lname'];?></p>
                    <p class="text-sm"><?= $user['role'];?></p>
                </div>
        </div>
        <div class="justify-self-stretch mx-3 w-4/5 px-4 grid grid-cols-8 flex items-center">
            <div class="col-span-3"></div>
            <a href="customerDashboard.php"><div class="text-center cursor-pointer">HOME</div></a>
            <a href="customerCart.php"><div class="text-center cursor-pointer">CART</div></a>
            <a href="customerProfile.php"><div class="text-center cursor-pointer">PROFILE</div></a>
            <a href="customerOrders.php"><div class="text-center cursor-pointer">ORDERS</div></a>
            <a href="login.php?logout='1'" onclick="return confirm('Are you sure you want to logout?')"><div class="text-center cursor-pointer">LOGOUT</div></a>
        </div>
    </div>
</body>
</html>