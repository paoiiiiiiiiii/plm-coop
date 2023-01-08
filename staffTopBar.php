<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$user = $coop->home();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <link rel="icon" type="image/png" href="static/images/logo.png"> -->
    <script src="assets/js/tailwind.js"></script>
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
</head>
<body>
<span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="Openbar()">
    <p class="px-2 bg-[#221E3F] rounded-md">x</p>
  </span>
  <div class="sidebar fixed top-0 bottom-0 lg:left-0 left-[-300px] duration-1000
    p-2 w-[280px] overflow-y-auto text-center bg-[#221E3F] shadow h-screen">
    <div class="text-gray-100 text-xl">
      <div class="p-2.5 mt-1 flex items-center rounded-md text-center">
        <h1 class="ml-7 text-[20px] font-medium text-gray-200 ">PLM - Cooperatives</h1>
        <p class=" ml-20 cursor-pointer lg:hidden" onclick="Openbar()">x</p>
      </div>

      <div class="p-2.5 mx-3 my-5 flex items-center rounded-xl flex-col bg-[#43365E] py-7">
        <div class="">
            <div class="rounded-full bg-[#D7DDDD] h-[140px] w-[140px] flex items-center justify-center"><i class="fa-solid fa-user text-[#43365E] text-7xl"></i></div>
        </div>
        <h1 class="text-[15px] text-xl text-gray-200 font-bold mt-5">PLMMPCI - Staff</h1>
        <p class="text-sm text-left"><?= $user['fname'];?> <?= $user['lname'];?></p>
      </div>


      <div>
        <a href="staffDashboard.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-house text-gray-200"></i>
          <span class="text-[15px] ml-4 text-gray-200">Home</span>
        </div></a>
        <a href="staffInStoreTransaction.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-store text-gray-200"></i>
          <span class="text-[15px] ml-4 text-gray-200">In Store Transaction</span>
        </div></a>
        <a href="staffOnlineTransaction.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-globe text-gray-200"></i>
          <span class="text-[15px] ml-4 text-gray-200">Online Transaction</span>
        </div></a>
        <a href="staffTransactionHistory.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-file text-gray-200 "></i>
          <span class="text-[15px] ml-4 text-gray-200">Transaction History</span>
        </div></a>
        <a href="staffStockInHistory.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-box text-gray-200 "></i>
          <span class="text-[15px] ml-4 text-gray-200">Stock In History</span>
        </div></a>
        
        <hr class="my-4 text-gray-600 mx-3">

        <a href="staffProfile.php"><div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-gear text-gray-200"></i>
          <span class="text-[15px] ml-4 text-gray-200">Account Settings</span>
        </div></a>

        <a href="login.php?logout='1'" onclick="return confirm('Are you sure you want to logout?')"><div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-right-from-bracket text-gray-200"></i>
          <span class="text-[15px] ml-4 text-gray-200">Logout</span>
        </div></a>

      </div>
    </div>
  </div>

  <script>
    function dropDown() {
      document.querySelector('#submenu').classList.toggle('hidden')
      document.querySelector('#arrow').classList.toggle('rotate-0')
    }
    dropDown()

    function Openbar() {
      document.querySelector('.sidebar').classList.toggle('left-[-300px]')
    }
  </script>

</body>
</html>