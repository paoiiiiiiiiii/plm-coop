<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$roleChecker = $coop->roleChecker();
$users = $coop->getStaffProfile();
$userProfile = $coop->getStaffUserProfile();
$update = $coop->updateAdminStaffProfile();

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
                        <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">PROFILE OVERVIEW</p>
                    </div>
                    <div class="w-full flex justify-center">
                        <div class="w-4/5 mt-5">
                            <p class="text-2xl font-extrabold w-full text-[#221E3F]">ACCOUNT DETAILS</p>

                            <form method="post" action="adminViewUser.php" class="w-full mt-5 grid grid-cols-2 gap-6"> 
                                <div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">User ID</label></ul>
                                        <input type="text" name="userID" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $users['user_id'] ?>" disabled>
                                        <input type="text" name="staffUserID" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $users['user_id'] ?>" hidden>
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Email</label></ul>
                                        <input type="email" name="email" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $users['email'] ?>">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">First Name</label></ul>
                                        <input type="text" name="fname" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $users['fname'] ?>">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Last Name</label></ul>
                                        <input type="text" name="lname" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $users['lname'] ?>">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Personal number</label></ul>
                                        <input type="number" name="phoneNum" required minlength="11" maxlength="11" class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $users['phone_number'] ?>">
                                    </div>

                                </div>

                                <div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Phone number/Telephone</label></ul>
                                        <input type="number" name="telNum" required minlength="11" maxlength="11" class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $userProfile['phone_number'] ?>">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">House No. & Subdivision</label></ul>
                                        <input type="text" name="houseNo" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $userProfile['house_no'] ?>">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Baranggay</label></ul>
                                        <input type="text" name="baranggay" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $userProfile['baranggay'] ?>">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">City</label></ul>
                                        <input type="text" name="city" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $userProfile['city'] ?>">
                                    </div>
                                    <div class="input-group">
                                        <ul><label class="text-center text-[#221E3F] font-bold text-xl mb-3">Region</label></ul>
                                        <input type="text" name="region" required class="mt-3 bg-[#efefef] text-lg text-[#525252] h-[35px] w-full mb-2 p-1 rounded-xl outline outline-offset-2 outline-[3px] outline-[#2274A5]" value="<?= $userProfile['region'] ?>">
                                    </div>
                                </div>

                                <div class="flex justify-center col-span-2">
                                    <button class="w-2/5 h-[40px] text-lg text-white mb-2 rounded-full bg-[#221E3F] px-4 py-1 text-white hover:bg-[#6257b4] mt-3" name="updateStaffProfile">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

