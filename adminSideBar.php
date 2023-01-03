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
        <h1 class="text-[15px] text-xl text-gray-200 font-bold mt-5">PLMMPCI - Admin</h1>
        <p class="text-sm text-left"><?= $user['fname'];?> <?= $user['lname'];?></p>
      </div>


      <div>
        <a href="adminDashboard.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-house text-gray-200"></i>
          <span class="text-[15px] ml-4 text-gray-200">Home</span>
        </div></a>
        <a href="adminAnalytics.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-chart-simple text-gray-200"></i>
          <span class="text-[15px] ml-4 text-gray-200">Analytics</span>
        </div></a>
        <a href="adminManageUsers.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-users text-gray-200 text-[15px]"></i>
          <span class="text-[15px] ml-4 text-gray-200">Users</span>
        </div></a>
        <a href="adminProducts.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-warehouse text-gray-200 text-[15px]"></i>
          <span class="text-[15px] ml-4 text-gray-200">Products</span>
        </div></a>
        <div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-[#43365E]">
          <i class="fa-solid fa-file text-gray-200 "></i>
          <div class="flex justify-between w-full items-center" onclick="dropDown()">
            <span class="text-[15px] ml-4 text-gray-200">Transactions</span>
            <span class="text-sm rotate-180" id="arrow"><i class="fa-solid fa-caret-down"></i></span>
            </span>
          </div>
        </div>
        <div class=" leading-7 text-left text-sm font-thin mt-2 w-4/5 mx-auto" id="submenu">
          <a href="adminInStoreTransactions.php"><h1 class="cursor-pointer p-2 hover:bg-[#43365E] rounded-md mt-1">In-Store</h1></a>
          <a href="adminOnlineTransactions.php"><h1 class="cursor-pointer p-2 hover:bg-[#43365E] rounded-md mt-1">Online</h1></a>
          <a href="adminStockInTransactions.php"><h1 class="cursor-pointer p-2 hover:bg-[#43365E] rounded-md mt-1">Stock In</h1></a>
        </div>
        <!-- <a href="adminTransactions.php"><div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
          <i class="fa-solid fa-file text-gray-200 "></i>
          <span class="text-[15px] ml-4 text-gray-200">Transactions</span>
        </div></a> -->

        <hr class="my-4 text-gray-600 mx-3">

        <!-- <div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-blue-600">
          <i class="bi bi-envelope-fill"></i>
          <span class="text-[15px] ml-4 text-gray-200">Messages</span>
        </div>

        <div class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-blue-600">
          <i class="bi bi-chat-left-text-fill"></i>
          <div class="flex justify-between w-full items-center" onclick="dropDown()">
            <span class="text-[15px] ml-4 text-gray-200">Chatbox</span>
            <span class="text-sm rotate-180" id="arrow">
              <i class="bi bi-chevron-down"></i>
            </span>
          </div>
        </div>
        <div class=" leading-7 text-left text-sm font-thin mt-2 w-4/5 mx-auto" id="submenu">
          <h1 class="cursor-pointer p-2 hover:bg-gray-700 rounded-md mt-1">Social</h1>
          <h1 class="cursor-pointer p-2 hover:bg-gray-700 rounded-md mt-1">Personal</h1>
          <h1 class="cursor-pointer p-2 hover:bg-gray-700 rounded-md mt-1">Friends</h1>
        </div> -->

        <a href="#"><div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer  hover:bg-[#43365E]">
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
    <!-- <div class="bg-[#eaca67] h-screen">

        <p class="text-lg font-bold"><?= $user['fname'];?> <?= $user['lname'];?></p>
        <p class="text-sm"><?= $user['role'];?></p>

        <ul>
        <a href="adminDashboard.php"><div class="cursor-pointer">HOME</div></a>
        <a href="adminAnalytics.php"><div class="cursor-pointer">ANALYTICS</div></a>
        <a href="adminManageUsers.php"><div class="cursor-pointer">USERS</div></a>
        <a href="adminProducts.php"><div class="cursor-pointer">PRODUCTS</div></a>
        <a href="adminTransactions.php"><div class="tcursor-pointer">TRANSACTIONS</div></a>
        <div class="tcursor-pointer">PROFILE</div></a>
        <a href="login.php?logout='1'" onclick="return confirm('Are you sure you want to logout?')"><div class="cursor-pointer">LOGOUT</div></a>
        </ul>

    </div> -->

</body>
</html>