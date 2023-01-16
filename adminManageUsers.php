<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();
$roleChecker = $coop->roleChecker();
$user = $coop->home();
$users = $coop->getUsers();
$filterRole = $coop->getUserRole();

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
                    <p class="text-4xl font-extrabold w-full px-3 text-[#221E3F]">Manage Users</p>
                    <div class="flex my-5 grid grid-cols-2">
                        <form action = "adminManageUsers.php" method = "get" class="flex mr-5">
                            <select name="role" id="role" class="ml-2 rounded-md h-[30px]" >
                                <!-- <option value='all' selected>All</option>
                                <option value='staff'>Staff</option>
                                <option value='customer'>Customer</option>
                                -->
                                <?php if ($filterRole == 'staff') { ?>
                                    <option value='all'>All</option>
                                    <option value='staff' selected>Staff</option>
                                    <option value='customer'>Customer</option>

                                <?php } else if ($filterRole == 'customer') { ?>
                                    <option value='all'>All</option>
                                    <option value='staff'>Staff</option>
                                    <option value='customer' selected>Customer</option>

                                <?php } else { ?>
                                    <option value='all' selected>All</option>
                                    <option value='staff'>Staff</option>
                                    <option value='customer'>Customer</option>

                                <?php } ?>
                            </select>
                            <button type="submit" name="userRole" class="ml-2 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] text-sm h-[30px] px-2">GO</button>

                            <input type="text" name="searchTag" placeholder="Search Name or ID" class="ml-5 rounded-md h-[30px] pl-2"></input>
                            <button type="submit" name="searchUsers" class="ml-2 rounded-lg bg-[#67b0e7] text-white hover:bg-[#2986CC] text-sm h-[30px] px-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                        <div class="flex justify-end">
                            <a href="adminAddUser.php" class="col-span-1 text-right"><button class="flex w-48 h-[40px] text-md text-white rounded-full bg-[#221E3F] px-4 text-white hover:bg-[#6257b4]"><p class="ml-5 text-3xl font-bold">+</p> <p class="ml-3 mt-2">Add user</p></button></a>
                        </div>
                    </div>

                    <div class="w-full flex h-[36rem] bg-white rounded-b-lg">
                        <div class="justify-self-start w-full overflow-auto max-h-106"> 
                            <table class="justify-self-stretch w-full m-auto">
                                    <thead class="font-semibold text-md bg-[#221E3F] text-white sticky top-0">
                                        <td class="px-3 py-3 rounded-tl-lg">User ID</td>
                                        <td class="px-3">Name</td>
                                        <td class="px-3">Role</td>
                                        <td class="px-3">Email</td>
                                        <td class="px-3">Phone Number</td>
                                        <td></td>
                                        <td class="rounded-tr-lg"></td>
                                    </thead>
                            <?php foreach($users as $userss): ?>
                                <tr class="cursor-pointer hover:bg-[#eeeeee]">
                                    <td class="py-3 px-3"><?= $userss['user_id']; ?></td>
                                    <td class="py-3 px-2"><?= $userss['fname']." ".$userss['lname']; ?></td>
                                    <td class="py-3 px-2"><?= $userss['role']; ?></td>
                                    <td class="py-3 px-2"><?= $userss['email']; ?></td>
                                    <td class="py-3 px-2"><?= $userss['phone_number']; ?></td>
                                    <td class="py-3 px-2"><a href="adminManageUsers.php?deleteUserID=<?= $userss['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')"><button class="ml-1 rounded-lg bg-[#d73a2f] px-4 text-white hover:bg-[#f85e53] text-white p-2 text-sm">Delete</button></a></td>
                                    <td class="py-3 px-2"><a href='adminViewUser.php?userID=<?= $userss['user_id']?>'><button class="ml-1 rounded-lg bg-[#221E3F] px-4 text-white hover:bg-[#6257b4] text-white p-2 text-sm">View</button></a></td>                   
                                </tr>
                            <?php endforeach; ?>
                            </table>
                            <?php if(!$users) {?>
                                <div class="flex items-center justify-center h-[30rem] w-full">
                                    <p class="text-center">NO USERS RECORDED!</p>
                                <div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

