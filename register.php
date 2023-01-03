<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->registerUser();

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
    </head>
    <body class="bg-[#9ed5f0]">    	
        <div class="w-100% h-screen items-center bg-[#9ed5f0]">
            <div class="rounded-md py-10 px-20 pb-5 drop-shadow-2xl h-max">
                <div class="w-full flex h-auto">
                    <div class="w-full bg-[#f0faff] rounded-md flex justify-center grid grid-cols-2">
                        <div class="flex justify-center items-center">
                            <img src="static/images/logo2.png" width="700" height="700">
                        </div>
                        <div class="flex justify-center items-center">
                            <div class="bg-[#ffff] h-[30rem] w-4/5 mx-8 rounded-lg px-10 py-5 drop-shadow-lg">
                                <h2 class="text-center text-[#67b0e7] font-bold text-2xl mb-3">REGISTRATION</h2>
                                <!-- <div><img src="static/icons/user.png" width="80"></div> -->
                                <form method="post" action="register.php"> 
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#a8a8a8] text-sm">Email</label></ul>
                                        <input type="email" name="email" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#a8a8a8] text-sm">Enter Password (Min. of 8 characters)</label></ul>
                                        <input type="password" name="password_1" minlength="8" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#a8a8a8] text-sm">Confirm password</label></ul>
                                        <input type="password" name="password_2" minlength="8" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg">
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="pr-2">
                                            <ul><label class="text-center text-[#a8a8a8] text-sm">First Name</label></ul>
                                            <input type="text" name="fname" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg">
                                        </div>
                                        <div class="input-group">
                                            <ul><label class="text-center text-[#a8a8a8] text-sm">Last Name</label></ul>
                                            <input type="text" name="lname" required class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2">
                                        <div class="pr-2">
                                            <ul><label class="text-center text-[#a8a8a8] text-sm">Phone number</label></ul>
                                            <input type="number" name="phoneNum" required minlength="11" maxlength="11" class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg">
                                        </div>
                                        <div class="input-group">
                                            <ul><label class="text-center text-[#a8a8a8] text-sm">User Role</label></ul>
                                            <select name="userRole" id="userRole" class="bg-[#efefef] text-sm text-[#525252] w-full mb-2 p-1 rounded-lg">  
                                                <option value="admin">Admin</option>  
                                                <option value="staff">Staff</option>  
                                                <option value="customer">Customer</option>  
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex justify-center">
                                        <button type="submit" class="w-48 text-sm text-white mb-2 rounded-full bg-[#67b0e7] px-4 py-2 mt-5 text-white hover:bg-[#2986CC]" name="register_user">
                                            REGISTER
                                        </button>
                                    </div>
                                    <div class="text-[#a8a8a8] mt-2 text-center text-sm">Already have an account?
                                        <a href="login.php" class="hover:text-[#2986CC]">Login Here!</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <p class="pb-2 bg-[#9ed5f0] pl-20 text-white text-lg"><b>Date: </b><?= $date ?> <?= $dateDay ?></p>
        </div>
    </body>
</html>