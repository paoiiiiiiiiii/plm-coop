<?php 
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
    <body style="background-image: url('static/background/Landing.png');">    	
        <div class="w-3/5 flex flex-col px-10 items-center justify-center pt-[120px]">
            <div class="">
                <img src="thumbnails/test.png" width="120" height="120">
                <h1 class="text-6xl font-extrabold text-[#FCE4BE] mt-5">Transactions</br> made convenient!</h1>
                <p class="text-xl text-white w-[38rem] mt-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                <div class="mt-5">
                    <a href="register.php"><button class="w-60 h-[40px] text-xl text-white font-bold rounded-full bg-[#2274A5] px-4 text-white hover:bg-[#38aaef] mr-5">
                        Sign Up
                    </button></a>
                    <a href="login.php"><button class="w-60 h-[40px] text-xl text-white font-bold rounded-full bg-[#221E3F] px-4 text-white hover:bg-[#6257b4]">
                        Log In
                    </button></a>
                </div>
            </div>
        </div>
    </body>
</html>