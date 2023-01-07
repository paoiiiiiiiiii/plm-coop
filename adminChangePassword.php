<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
$message = $coop->returnMessage();
$changePass = $coop->changePassword();

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
            <?php include 'adminSideBar.php'; ?>
        </div>

        <div class="w-full h-screen px-10 py-5">
            <div class="bg-[#FCE4BE] rounded-3xl flex flex-col w-full h-full px-10 py-10">
                <div>
                    <div class="grid grid-cols-2">
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">CHANGE PASSWORD</p>

                    </div>
                    <div class="w-full flex justify-center items-center">
                        <div class="w-3/5 mt-10 items-center">

                            <form method="post" action="adminChangePassword.php" class="w-full mt-5"> 
                                <div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Email</label></ul>
                                        <input type="text" name="email" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Old Password</label></ul>
                                        <input type="password" name="oldPassword" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">New Password</label></ul>
                                        <input type="password" name="newPassword" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Confirm New Password</label></ul>
                                        <input type="password" name="newPassword1" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]">
                                    </div>
                                </div>

                                <div class="flex justify-center">
                                    <button class="w-2/5 h-[40px] text-lg text-white mb-2 rounded-full bg-[#221E3F] px-4 py-1 text-white hover:bg-[#6257b4] mt-3" name="save">
                                        Save
                                    </button>
                                </div>
                            </form>

                            <?php if ($message) { ?>
                                <p><?= $message?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

