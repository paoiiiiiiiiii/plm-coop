<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->loginUser();

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d");
$dateDay = date("l");
$time = date("h:i:sa");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            PLM-COOP
        </title>
        <!-- <link rel="icon" type="image/png" href="static/images/logo.png"> -->
        <link href="styles.css" rel="stylesheet">
        <script src="assets/js/tailwind.js"></script>
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/fonts.css">

    </head>
    <body class="bg-[221E3F]">    	
        <div class="w-100% h-screen items-center bg-[#221E3F]">
            <div class="rounded-md pb-5 h-full">
                <div class="w-full flex h-screen">
                    <div class="w-full bg-[#221E3F] flex">
                        <div class="flex items-center px-8 w-2/6">
                            <div class="space-y-6">
                                <div class="space-y-3">
                                <p class="text-6xl font-bold text-[#D7DDDD]">Welcome back</p>
                                <p class="text-6xl font-bold text-[#D7DDDD]">to PLM</p>
                                <p class="text-6xl font-bold text-[#D7DDDD] mb-10">Co-Operative!</p>
                                </div>
                                <hr class="my-2 text-gray-600">
                                <p class="text-xl font-light text-[#D7DDDD]">New user? <a href="register.php" class="text-[#2274A5]">Sign up</a></p>
                            </div>
                        </div>

                        <div class="flex justify-center items-center w-4/6 px-5 py-5">
                            <div class="bg-[#FCE4BE] h-full w-full rounded-3xl flex items-center justify-center">
                                <div class="w-3/6">
                                    <h2 class="text-center text-[#221E3F] font-bold text-6xl mb-3">Log In</h2>
                                    
                                    <form method="post" action="login.php">
                                        <div class="input-group mt-5">
                                            <ul><label class="text-center text-[#221E3F] font-bold text-2xl mb-3">Email</label></ul>
                                            <input type="text" name="email" class="mt-3 bg-[#efefef] text-xl text-[#525252] w-full h-[40px] mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                        </div>
                                        <div class="input-group mt-5">
                                            <ul><label class="text-center text-[#221E3F] font-bold text-2xl mb-3">Password</label></ul>
                                            <input type="password" name="password" class="mt-3 bg-[#efefef] text-xl text-[#525252] w-full h-[40px] mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                        </div class="input-group">
                                        <div class="flex justify-center my-5">
                                            <button type="submit" class="w-48 h-[50px] text-xl text-white mb-2 rounded-full bg-[#221E3F] px-4 py-2 text-white hover:bg-[#6257b4]" name="login_user">
                                                Login
                                            </button>
                                        </div>

                                        <div class="flex justify-center items-center text-center">
                                            <hr class="h-[2px] w-4/5 bg-gray-200 border-0 dark:bg-gray-700">
                                        </div>

                                        
                                        <div class="flex justify-center items-center text-center mt-3">
                                            <a href="#" class="text-[#2274A5] text-center text-lg font-light">Forgot Password?</a>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <p><b>Date: </b><?= $date ?> <?= $dateDay ?></p> -->
        </div>
    </body>
</html>
<!-- #2E294E -->