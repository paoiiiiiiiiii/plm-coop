<?php 
require_once('plmCoopServer.php');
$coop = new CoopServer();

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
    <div class="w-full h-full flex items-center justify-center">
        <p class="text-3xl font-bold text-white text-center mt-[10rem]">Sorry, you do not have access to this page :(</p>
    </div>
</body>

</html>

