<?php 
//require_once('mailer.php');
session_start();
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Asia/Manila');
Class CoopServer{
	

	private $server = "mysql:host=localhost;dbname=plm_coop_db";
	private $user = "root";
	private $pass = "";
	private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	protected $con;

	public function openConnection(){

		try{

			$this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
			return $this->con;

		}catch(PDOException $e) {

			echo "There is a problem in the connection: ". $e->getMessage();

		}
	}

	public function closeConnection(){

		$this->con = null;
	}

    public function loginUser(){
		if (isset($_POST['login_user'])) {
			$email = $_POST['email'];
			$password = md5($_POST['password']);

			if (empty($email) or empty($password)){
				echo("PLEASE FILL UP ALL THE FIELDS");

			} else {
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM users WHERE email = '$email' AND password = '$password';");
				$sql->execute();
				$user = $sql->fetch();
				$userCount = $sql->rowCount();

				if($userCount == 1){
					echo("Successfully Logged in!");
                    $_SESSION['authentication'] = 1;
					$_SESSION['id'] = $user['user_id'];
					$_SESSION['role'] = $user['role'];
					$_SESSION['email'] = $email;

                    if ($_SESSION['role']=="admin"){
                        header ('location:adminDashboard.php');
                    } else if ($_SESSION['role']=="staff"){
                        header ('location:staffDashboard.php');
                    } else {
						//checks if may profile details na siya address etc
						$activeUser = $_SESSION['id'];

						$sql = $connection->prepare("SELECT * FROM user_profile WHERE user_id = '$activeUser';");
						$sql->execute();
						$user = $sql->fetch();
						$userCount = $sql->rowCount();

						if ($userCount == 0) {
							header('location:customerProfile.php');
						} else {
							header ('location:customerDashboard.php');
						}
                        
                    }

				} else {
					$_SESSION['message'] = "INVALID CREDENTIALS";
					$user = null;
					header('location:login.php');
				}
			}
		}
		//logout
		if (isset($_GET['logout'])) {
			unset($_SESSION['id']);
			unset($_SESSION['role']);
			unset($_SESSION['authentication']);
			unset($_SESSION['email']);
			session_destroy();
			header("location: login.php");
		}
	}

    public function registerUser(){
		if (isset($_POST['register_user'])) {
			$email = $_POST['email'];
			$_SESSION['email'] = $email;
			$password1 = $_POST['password_1'];
			$password2 = $_POST['password_2'];
			$firstname = $_POST['fname'];
			$lastname = $_POST['lname'];
			$phoneNum = $_POST['phoneNum'];
			$userRole= $_POST['userRole'];

			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM users WHERE email = '$email';");
			$sql->execute();
			$user = $sql->fetchAll();
			$userCount = $sql->rowCount();		

			if ($userCount == 1){
				$_SESSION['message'] = "Email/User already exists!";
				header('location:register.php');
			} else {
				if (empty($email) or empty($password1) or empty($password2) or empty($firstname) or empty($lastname)or empty($phoneNum)or empty($userRole)) { 
					echo("PLEASE FILL UP ALL THE FIELDS"); 
				} else {
					if ($password1 == $password2){
						$password = md5($password1);
						$connection = $this->openConnection();
						$sql = $connection->prepare(
							"INSERT INTO users(email, password, role, phone_number, fname, lname) VALUES ('$email', '$password', '$userRole', '$phoneNum', '$lastname', '$firstname')");
						$sql->execute();

                        header('location:login.php');
						
					} else {
						$_SESSION['message'] = "The two passwords do not match!";
						header('location:register.php');
					}
				}
			}
		}
	}

	public function adminChecker(){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT * FROM users WHERE role = 'admin'");
		$sql->execute();
		$adminCount = $sql->rowCount();

		return $adminCount;
	}

    public function home(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == "admin"){
				//ADMIN
				$activeUser = $_SESSION['id'];
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM users WHERE user_id = '$activeUser'");
				$sql->execute();
				$userinfo = $sql->fetch();
				return $userinfo;

			} else if ($_SESSION['role']=="staff"){
				//STAFF/CASHIER
				$activeUser = $_SESSION['id'];
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM users WHERE user_id = '$activeUser'");
				$sql->execute();
				$userinfo = $sql->fetch();
				return $userinfo;

			} else {
                //CUSTOMER
				$activeUser = $_SESSION['id'];
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM users WHERE user_id = '$activeUser'");
				$sql->execute();
				$userinfo = $sql->fetch();
				return $userinfo;
            }
		} else {
			header ('location:login.php');
		}

	}

	public function getUserProfile(){
		if ($_SESSION['authentication']){
			$activeUser = $_SESSION['id'];

			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM user_profile WHERE user_id = '$activeUser';");
			$sql->execute();
			$user = $sql->fetch();

			return $user;
		} else {
			header('location:login.php');
		}
	}

	public function updateProfile(){
		if ($_SESSION['authentication']) {
			if(isset($_POST['updateProfile'])){
				$activeUser = $_SESSION['id'];
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$email = $_POST['email'];
				$phoneNum = $_POST['phoneNum'];

				$telNum = $_POST['telNum'];
				$houseNo = $_POST['houseNo'];
				$baranggay = $_POST['baranggay'];
				$city = $_POST['city'];
				$region = $_POST['region'];

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM user_profile WHERE user_id = '$activeUser';");
				$sql->execute();
				$user = $sql->fetch();
				$userCount = $sql->rowCount();

				if ($userCount == 0) {
					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE users SET phone_number = '$phoneNum', email = '$email', fname = '$fname', lname = '$lname' WHERE user_id = '$activeUser'; ");
					$sql->execute();

					$sql = $connection->prepare("INSERT INTO user_profile VALUES ('$activeUser', '$telNum', '$houseNo', '$baranggay', '$city', '$region'); ");
					$sql->execute();

					if ($_SESSION['role'] == 'admin') {
						header('location:adminViewProfile.php');
					} else {
						header('location:customerDashboard.php');
					}
					
				} else {
					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE users SET phone_number = '$phoneNum', email = '$email', fname = '$fname', lname = '$lname' WHERE user_id = '$activeUser'; ");
					$sql->execute();

					$sql = $connection->prepare("UPDATE user_profile SET phone_number = '$telNum', house_no = '$houseNo', baranggay = '$baranggay', city = '$city', region = '$region' WHERE user_id = '$activeUser'; ");
					$sql->execute();

					
					if ($_SESSION['role'] == 'admin') {
						header('location:adminViewProfile.php');
					} else {
						header('location:customerDashboard.php');
					}
				}
			}
		} else {
			header ('location:login.php');
		}
	}

	public function getCategory(){
		if ($_SESSION['authentication']) {
			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM category;");
			$sql->execute();
			$categories = $sql->fetchAll();
		return $categories;
		} else {
			header ('location:login.php');
		}
	}

	public function getProductsPerCategory(){
		if ($_SESSION['authentication']) {
			$category = $_GET['categoryID'];
			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM products WHERE product_category_id = '$category';");
			$sql->execute();
			$products = $sql->fetchAll();
			return $products;
		} else {
			header ('location:login.php');
		}
	}

	public function getProductCategory(){
		if ($_SESSION['authentication']) {
			$category = $_GET['categoryID'];
			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM category WHERE category_id = '$category';");
			$sql->execute();
			$category = $sql->fetch();
			return $category;
		} else {
			header ('location:login.php');
		}
	}

	public function getProduct(){
		if ($_SESSION['authentication']) {
			$productID = $_GET['productID'];
			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT *,products.thumbnail as pthumbnail, category.category_name FROM products INNER JOIN category ON products.product_category_id = category.category_id WHERE products.product_id = '$productID';");
			$sql->execute();
			$product = $sql->fetch();
			return $product;
		} else {
			header ('location:login.php');
		}
	}

	//return quantity available ONLINE which means that quantity checked out is deducted to the product quantity which is eto yugn temporary quantity that can be seen online
	//hindi mababawas sa actual inventory unless the order has been completed/processing
	public function getQuantitySeenOnline(){
		if ($_SESSION['authentication']) {
			$productID = $_GET['productID'];
			$total_quantity = 0;
			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT *,transactions.online FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.product_id = '$productID' AND transactions.online = '1' AND NOT(transactions.state = 'completed' OR transactions.state = 'cancelled');");
			$sql->execute();
			$productCheckedOutOnline = $sql->fetchAll();

			foreach ($productCheckedOutOnline as $products) {
				$total_quantity += $products['quantity_added'];
			}

			$sql = $connection->prepare("SELECT * FROM products WHERE product_id = '$productID';");
			$sql->execute();
			$product = $sql->fetch();

			$quantity = $product['product_quantity'] - $total_quantity;

			return $quantity;
		} else {
			header ('location:login.php');
		}
	}

// =========================================== CUSTOMER FUNCTIONS ======================================================

	public function addToCart(){
		if ($_SESSION['authentication']) {
			if (isset($_POST['addCart'])) {
				$activeUser = $_SESSION['id'];
				$productID = $_POST['addProd'];
				$quantity = $_POST['quantity'];

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM products WHERE product_id = '$productID';");
				$sql->execute();
				$product = $sql->fetch();

				$totalPrice = $product['product_price'] * $quantity;

				$sql = $connection->prepare("INSERT INTO user_cart_products (user_id, product_id, quantity_added, total_price) VALUES ('$activeUser', '$productID', '$quantity', '$totalPrice');");
				$sql->execute();
			}
		} else {
			header ('location:login.php');
		}
	}

	public function getCustomerCart(){
		if ($_SESSION['authentication']) {
			$activeUser = $_SESSION['id'];
			if (isset($_POST['checkout'])) {
				$productsInCart = $_POST['selectedCart'];
				$_SESSION['cartCheckedOut'] = $productsInCart;
				$checkOutProcess = $_POST['checkoutProcess'];
				$_SESSION['checkoutProcess'] = $checkOutProcess;

				header('location:customerCheckout.php');
			} else if (isset($_GET['deleteID'])){
				$deleteCart = $_GET['deleteID'];
				$connection = $this->openConnection();
				$sql = $connection->prepare("DELETE from user_cart_products WHERE cart_products_id = '$deleteCart'");
				$sql->execute();

				header('location:customerCart.php');

			} else {
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT *,products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE user_cart_products.user_id = '$activeUser' AND transaction_id IS NULL;");
				$sql->execute();
				$cart = $sql->fetchAll();

				return $cart;
			}
		} else {
			header ('location:login.php');
		}
	}

	public function customerProductCheckout(){
		if ($_SESSION['authentication']){
			return $_SESSION['cartCheckedOut'];
		} else {
			header('location:login.php');
		}
	}

	public function getCartProduct($id){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT *,products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE user_cart_products.cart_products_id = '$id' AND transaction_id IS NULL;");
		$sql->execute();
		$product = $sql->fetch();

		return $product;
	}

	public function customerCheckoutProcess(){
		if ($_SESSION['authentication']){
			return $_SESSION['checkoutProcess'];
		} else {
			header('location:login.php');
		}
	}

	public function confirmTransaction(){
		if ($_SESSION['authentication']){
			if (isset($_POST['confirmTransac'])){
				$activeUser = $_SESSION['id'];
				$productsInCart = $_SESSION['cartCheckedOut'];
				$checkOutProcess = $_SESSION['checkoutProcess'];
				$totalPrice = $_SESSION['total_amount'];
				
				if ($checkOutProcess == 'walkin') {
					$email = $_POST['email'];
					$telNum = $_POST['telNum'];
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$name = $fname." ".$lname;

					$connection = $this->openConnection();
					$sql = $connection->prepare("INSERT INTO transactions (date, customer_id, amount, state, process, email, phone_number, name, online) VALUES (NOW(), '$activeUser', '$totalPrice', 'pending', 'walkin', '$email', '$telNum', '$name', '1');");
					$sql->execute();

				} else {
					$email = $_POST['email'];
					$telNum = $_POST['telNum'];
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$houseNo = $_POST['houseNo'];
					$baranggay = $_POST['baranggay'];
					$city = $_POST['city'];
					$region = $_POST['region'];

					$name = $fname." ".$lname;
					$address = $houseNo.", ".$baranggay.", ".$city.", ".$region;

					$connection = $this->openConnection();
					$sql = $connection->prepare("INSERT INTO transactions (date, customer_id, amount, state, address, process, email, phone_number, name, online) VALUES (NOW(), '$activeUser', '$totalPrice', 'pending', '$address', 'delivery', '$email', '$telNum', '$name', '1');");
					$sql->execute();

				}

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM transactions WHERE customer_id = '$activeUser' ORDER BY transaction_id DESC LIMIT 1;");
				$sql->execute();
				$presentTransaction = $sql->fetch();

				$presentTransactionID = $presentTransaction['transaction_id'];

				foreach ($productsInCart as $productConfirmed){
					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE user_cart_products SET transaction_id = '$presentTransactionID' WHERE cart_products_id = '$productConfirmed'; ");
					$sql->execute();

				}

				unset($_SESSION['cartCheckedOut']);
				unset($_SESSION['checkoutProcess']);
				unset($_SESSION['total_amount']);

				$_SESSION['transactionID'] = $presentTransactionID;

				header('location:customerReceipt.php');
			}
		} else {
			header('location:login.php');
		}
	}


	//GETS THE PRODUCTS (CHECK OUT)
	public function getTransactionProducts(){
		if ($_SESSION['authentication']){
			$presentTransactionID = $_SESSION['transactionID'];

			$connection = $this->openConnection();
			
			$sql = $connection->prepare("SELECT *,products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE transaction_id='$presentTransactionID';");
			$sql->execute();
			$product = $sql->fetchAll();

			if (isset($_POST['finish'])){
				unset($_SESSION['transactionID']);
				
				header('location:customerDashboard.php');
			}

			return $product;

		} else {
			header('location:login.php');
		}
	}

	//GETS THE TRANSACTION BASED ON PRESENT TRANSACTION ID (CHECKOUT)
	public function getTransactionID(){
		if ($_SESSION['authentication']){
			$presentTransactionID = $_SESSION['transactionID'];

			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM transactions WHERE transaction_id = '$presentTransactionID'");
			$sql->execute();
			$transaction = $sql->fetch();

			return $transaction;
		} else {
			header('location:login.php');
		}
	}

	//GETS CUSTOMER ORDER BASED ON USER ID
	public function getCustomerTransactions(){
		if ($_SESSION['authentication']){
			$activeUser = $_SESSION['id'];

			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM transactions WHERE customer_id = '$activeUser' ORDER BY transaction_id DESC");
			$sql->execute();
			$orders = $sql->fetchAll();

			return $orders;
		} else {
			header('location:login.php');
		}
	}

	//GETS THE PRODUCTS IN THE TRANSACTIONS MADE BY THE CUSTOMER IN THE PAST BASED ON TRANSACTION ID
	public function getTransactionProductsView(){
		if ($_SESSION['authentication']){
			if (isset($_GET['orderID']) or isset($_GET['cancelOrderID'])) {
				$transactionID = $_GET['orderID'];

				if (isset($_GET['cancelOrderID'])){
					$transactionID = $_GET['cancelOrderID'];
				}
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT *,products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE transaction_id='$transactionID';");
				$sql->execute();
				$product = $sql->fetchAll();
	
				return $product;
			}
		} else {
			header('location:login.php');
		}
	}

	//GETS THE PRODUCTS IN THE TRANSACTION DETAILS BY THE CUSTOMER IN THE PAST BASED ON TRANSACTION ID
	public function getTransactionView(){
		if ($_SESSION['authentication']){
			if (isset($_GET['orderID']) or isset($_GET['cancelOrderID'])){
				$transactionID = $_GET['orderID'];

				if (isset($_GET['cancelOrderID'])){
					$transactionID = $_GET['cancelOrderID'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE transactions SET state = 'cancelled' WHERE transaction_id = '$transactionID'");
					$sql->execute();
				}

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM transactions WHERE transaction_id = '$transactionID'");
				$sql->execute();
				$transaction = $sql->fetch();
	
				return $transaction;
			}
		} else {
			header('location:login.php');
		}
	}



	// ====================== STARTING FROM HERE, ALL FUNCTIONS USED IS FOR THE STAFF ONLY =====================================

	public function newInStoreTransaction(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				if(isset($_POST['newTransac'])){
					$_SESSION['total_amount'] = 0;
					$activeUser = $_SESSION['id'];
					$name = $_POST['soldTo'];
					$phone_number = $_POST['phoneNum'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("INSERT INTO transactions (date, cashier_id, name, phone_number, online) VALUES (now(), '$activeUser','$name', '$phone_number', '0')");
					$sql->execute();
					
					$sqlLatest = $connection->prepare("SELECT * FROM transactions WHERE cashier_id = '$activeUser' ORDER BY transaction_id DESC LIMIT 1");
					$sqlLatest->execute();
					$sqlLatest1 = $sqlLatest->fetch();

					$_SESSION['transacNum'] = $sqlLatest1['transaction_id'];
					return $sqlLatest1;

					header('location:staffInStoreTransaction.php');

				} else {
					$transac_num = $_SESSION['transacNum'];
					$connection = $this->openConnection();
					$sqlLatest = $connection->prepare("SELECT * FROM transactions WHERE transaction_id = '$transac_num';");
					$sqlLatest->execute();
					$sqlLatest1 = $sqlLatest->fetch();

					return $sqlLatest1;
				}
			}
		} else {
			header ('location:login.php');
		}
	}

	public function staffGetInStoreCart(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				$_SESSION['total_amount'] = 0;
				$transac_num = $_SESSION['transacNum'];

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT *,products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE user_cart_products.transaction_id = '$transac_num';");
				$sql->execute();
				$products = $sql->fetchAll();

				foreach ($products as $product) {
					$_SESSION['total_amount'] += $product['total_price'];
				}

				return $products;
			}
		} else {
			header ('location:login.php');
		}
	}

	public function staffAddToCartInStoreTransaction(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				if (isset($_POST['addCart'])) {
					$activeUser = $_SESSION['id'];
					$transac_num = $_SESSION['transacNum'];
					$productID = $_POST['productID'];
					$quantity = $_POST['quantity'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM products WHERE product_id = '$productID';");
					$sql->execute();
					$product = $sql->fetch();
	
					$totalPrice = $product['product_price'] * $quantity;

					$connection = $this->openConnection();
					$sql = $connection->prepare("INSERT INTO user_cart_products(product_id, quantity_added, total_price, transaction_id) VALUES ('$productID', '$quantity', '$totalPrice', '$transac_num');");
					$sql->execute();

					header('location: staffBrowseProducts.php');
				}
			}
		} else {
			header ('location:login.php');
		}
	}

	public function inStoreSessionChecker(){
		return $_SESSION['transacNum'];
	}

	public function staffDeleteCart(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				if (isset($_GET['deleteAll'])) {
					$transac_num = $_SESSION['transacNum'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("DELETE FROM user_cart_products WHERE transaction_id = '$transac_num'");
					$sql->execute();
					$_SESSION['total_amount'] = 0;

					header('location:staffInStoreTransaction.php');
				}

				if (isset($_GET['cartID'])) {
					$cartID = $_GET['cartID'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("DELETE FROM user_cart_products WHERE cart_products_id = '$cartID';");
					$sql->execute();

					header('location:staffInStoreTransaction.php');
				}

			}
		} else {
			header ('location:login.php');
		}
	}

	public function staffGetTransactionID(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				$presentTransactionID = $_SESSION['transacNum'];

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM transactions WHERE transaction_id = '$presentTransactionID'");
				$sql->execute();
				$transaction = $sql->fetch();

				return $transaction;
			}
		} else {
			header('location:login.php');
		}
	}

	public function staffSettlePayment(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				$activeUser = $_SESSION['id'];
				if (isset($_POST['settlePayment'])){
					$amount = $_POST['money'];
					$_SESSION['tendered_amount'] = $amount;

					header('location:staffSettleInStoreTransaction.php');
				}

				if (isset($_POST['confirmTransac'])){
					$tenderedAmount = $_SESSION['tendered_amount'];
					$totalPrice = $_SESSION['total_amount'];
					$presentTransactionID = $_SESSION['transacNum'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE transactions SET amount = '$totalPrice', tendered_amount = '$tenderedAmount', state = 'completed', process = 'instore' WHERE transaction_id = '$presentTransactionID'; ");
					$sql->execute();

					$sql = $connection->prepare("SELECT * FROM user_cart_products WHERE transaction_id = '$presentTransactionID'");
					$sql->execute();
					$cart = $sql->fetchAll();

					foreach ($cart as $carts) {
						$productID = $carts['product_id'];
						$quantity_bought = $carts['quantity_added'];

						$sql = $connection->prepare("SELECT * FROM products WHERE product_id = '$productID';");
						$sql->execute();
						$product = $sql->fetch();
						$oldQuantity = $product['product_quantity'];

						$newQuantity = $oldQuantity - $quantity_bought;

						$sql = $connection->prepare("UPDATE products SET product_quantity = '$newQuantity' WHERE product_id = '$productID';");
						$sql->execute();
					}

					unset($_SESSION['transacNum']);
					unset($_SESSION['total_amount']);
					unset($_SESSION['tendered_amount']);

					header('location:staffInStoreTransaction.php');
				}
			}
		} else {
			header('location:login.php');
		}
	}
	
	//SESSIONS USED transacNum, total_amount, tendered_amount

	public function getStaffProducts($categoryID){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM products WHERE product_category_id = '$categoryID';");
				$sql->execute();
				$products = $sql->fetchAll();
				return $products;
			}
		} else {
			header ('location:login.php');
		}
	}

	public function stockIn(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				if (isset($_POST['addStock'])) {
					$activeUser = $_SESSION['id'];
					$productID = $_POST['productID'];
					$quantity = $_POST['quantity'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM products WHERE product_id = '$productID';");
					$sql->execute();
					$product = $sql->fetch();

					$newQuantity = $product['product_quantity'] + $quantity;

					$sql = $connection->prepare("UPDATE products SET product_quantity = '$newQuantity' WHERE product_id = '$productID'");
					$sql->execute();

					$sql = $connection->prepare("INSERT INTO stock_in_history(cashier_id, date, product_id, added_quantity) VALUES ('$activeUser', NOW(), '$productID', '$quantity');");
					$sql->execute();

					header('location:staffDashboard.php');
				}
			}
		} else {
			header ('location:login.php');
		}
	}

	public function getStaffTransactions(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				$activeUser = $_SESSION['id'];
				
				if (isset($_POST['process'])){
					$processType = $_POST['processType'];
					
					if ($processType == 'online') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE cashier_id = '$activeUser' AND online = '1' AND state IS NOT NULL ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
						$_SESSION['transaction_process'] = 'online';

						return $transaction;
					} else if ($processType == 'instore') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE cashier_id = '$activeUser' AND online = '0' AND state IS NOT NULL ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
						$_SESSION['transaction_process'] = 'instore';

						return $transaction;
					} else {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE cashier_id = '$activeUser' AND state IS NOT NULL ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
						$_SESSION['transaction_process'] = 'all';

						return $transaction;
					}
				} else {
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname)AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE cashier_id = '$activeUser' AND state IS NOT NULL ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$_SESSION['transaction_process'] = 'all';

					return $transaction;
				}
			}
		} else {
			header ('location:login.php');
		}
	}

	public function returnStaffTransactionProcess() {
		return $_SESSION['transaction_process'];
	}

	public function getStaffTransactionProducts(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				if (isset($_GET['transactionID'])) {
					$transactionID = $_GET['transactionID'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE transaction_id='$transactionID';");
					$sql->execute();
					$product = $sql->fetchAll();
		
					return $product;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getStaffTransactionDetails(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'staff') {
				if (isset($_GET['transactionID'])) {
					$transactionID = $_GET['transactionID'];
					
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname)AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE transaction_id='$transactionID';");
					$sql->execute();
					$product = $sql->fetch();
		
					return $product;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}
	// ================================== FUNCTIONS USED FOR ONLINE TRANSACTIONS (STAFF) ====================================

	public function getPendingOrders(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT *,users.* FROM transactions INNER JOIN users ON transactions.customer_id = users.user_id WHERE state = 'pending'; ");
				$sql->execute();
				$pending = $sql->fetchAll();

				return $pending;
			}
		} else {
			header('location:login.php');
		}		
	}

	public function getProcessingOrders(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT *,users.* FROM transactions INNER JOIN users ON transactions.customer_id = users.user_id WHERE state = 'on processing'; ");
				$sql->execute();
				$pending = $sql->fetchAll();

				return $pending;
			}
		} else {
			header('location:login.php');
		}		
	}

	public function getCancelledOrders(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT *,users.* FROM transactions INNER JOIN users ON transactions.customer_id = users.user_id WHERE state = 'cancelled' ORDER BY transaction_id DESC; ");
				$sql->execute();
				$pending = $sql->fetchAll();

				return $pending;
			}
		} else {
			header('location:login.php');
		}		
	}

	public function getCompletedOrders(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT *,users.* FROM transactions INNER JOIN users ON transactions.customer_id = users.user_id WHERE state = 'completed' ORDER BY transaction_id DESC; ");
				$sql->execute();
				$pending = $sql->fetchAll();

				return $pending;
			}
		} else {
			header('location:login.php');
		}		
	}

	public function getStockInHistory(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				$activeUser = $_SESSION['id'];
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT *,users.*,products.* FROM stock_in_history 
											INNER JOIN users ON stock_in_history.cashier_id = users.user_id
											INNER JOIN products ON stock_in_history.product_id = products.product_id
											WHERE stock_in_history.cashier_id = '$activeUser' ORDER BY stockin_id DESC;");
				$sql->execute();
				$stockInHistory = $sql->fetchAll();

				return $stockInHistory;
			}
		} else {
			header('location:login.php');
		}		
	}

	public function staffGetTransactionDetails(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				if(isset($_GET['transactionID'])){
					$transactionID = $_GET['transactionID'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,users.* FROM transactions INNER JOIN users ON transactions.customer_id = users.user_id WHERE transactions.transaction_id = '$transactionID';");
					$sql->execute();
					$transaction = $sql->fetch();			
					return $transaction;
				}

			}
		} else {
			header('location:login.php');
		}	
	}

	public function staffChangeTransactionState(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				if (isset($_POST['saveState'])){
					$activeUser = $_SESSION['id'];
					$transactionID = $_POST['transactionID'];
					$updatedState = $_POST['state'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE transactions SET state = '$updatedState', cashier_id = '$activeUser' WHERE transaction_id = '$transactionID';");
					$sql->execute();

					if ($updatedState == 'completed') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT * FROM user_cart_products WHERE transaction_id = '$transactionID' ");
						$sql->execute();
						$productsInCart = $sql->fetchAll();

						foreach ($productsInCart as $products) {
							$productID = $products['product_id'];
							$quantityBought = $products['quantity_added'];

							$connection = $this->openConnection();
							$sql = $connection->prepare("SELECT * FROM products WHERE product_id = '$productID' ");
							$sql->execute();
							$product = $sql->fetch();

							$oldQuantity = $product['product_quantity'];
							
							$quantity = $oldQuantity - $quantityBought;

							$sql = $connection->prepare("UPDATE products SET product_quantity = '$quantity' WHERE product_id = '$productID'");
							$sql->execute();
						}
					}

					header('location:staffOnlineTransaction.php');
				}					

			}
		} else {
			header('location:login.php');
		}	
	}

	public function staffGetCustomerCart(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'staff' ) {
				if(isset($_GET['transactionID'])){
					$transactionID = $_GET['transactionID'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE user_cart_products.transaction_id = '$transactionID';");
					$sql->execute();
					$cart = $sql->fetchAll();
	
					return $cart;
				}

			}
		} else {
			header('location:login.php');
		}	
	}

	public function updateStaffProfile(){
		if ($_SESSION['authentication']) {
			if(isset($_POST['updateProfile'])){
				$activeUser = $_SESSION['id'];
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$email = $_POST['email'];
				$phoneNum = $_POST['phoneNum'];

				$houseNo = $_POST['houseNo'];
				$baranggay = $_POST['baranggay'];
				$city = $_POST['city'];
				$region = $_POST['region'];

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM user_profile WHERE user_id = '$activeUser';");
				$sql->execute();
				$user = $sql->fetch();
				$userCount = $sql->rowCount();

				if ($userCount == 0) {
					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE users SET phone_number = '$phoneNum', email = '$email', fname = '$fname', lname = '$lname' WHERE user_id = '$activeUser'; ");
					$sql->execute();

					$sql = $connection->prepare("INSERT INTO user_profile VALUES ('$activeUser', '$phoneNum', '$houseNo', '$baranggay', '$city', '$region'); ");
					$sql->execute();

					header('location:staffProfile.php');
				} else {
					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE users SET phone_number = '$phoneNum', email = '$email', fname = '$fname', lname = '$lname' WHERE user_id = '$activeUser'; ");
					$sql->execute();

					$sql = $connection->prepare("UPDATE user_profile SET phone_number = '$phoneNum', house_no = '$houseNo', baranggay = '$baranggay', city = '$city', region = '$region' WHERE user_id = '$activeUser'; ");
					$sql->execute();

					header('location:staffProfile.php');
				}
			}
		} else {
			header ('location:login.php');
		}
	}

	// ================================= ALL FUNCTIONS USED IN ADMIN CLIENT =================================================

	public function getDailySales(){
		date_default_timezone_set('Asia/Manila');
		$day = date("d");
		$month = date("m");
		$year = date('Y');

		$connection = $this->openConnection();
		$query = "SELECT date,amount FROM transactions WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year'  AND EXTRACT(DAY FROM date) = '$day' AND state = 'completed';";
		$sql = $connection->prepare($query);
		$sql->execute();
		$sales = $sql->fetchAll();

		$dailySales = 0;

		foreach ($sales as $dailySale){
			$dailySales += $dailySale['amount'];
		}

		return $dailySales;//-$monthlyCancelledSales;
	}

	public function getMonthlySales(){
		$month = date("m");
		$year = date('Y');

		$connection = $this->openConnection();
		$query = "SELECT date,amount FROM transactions WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';";
		$sql = $connection->prepare($query);
		$sql->execute();
		$sales = $sql->fetchAll();

		$monthlySales = 0;

		foreach ($sales as $monthlySale){
			$monthlySales += $monthlySale['amount'];
		}

		//CANCELLED ORDERS OR TRANSACTIONS
		// $query = "SELECT * FROM cancelled_order WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year';";
		// $sql = $connection->prepare($query);
		// $sql->execute();
		// $cancelledSales = $sql->fetchAll();

		//$monthlyCancelledSales = 0;

		// foreach ($cancelledSales as $monthlyCancelledSale){
		// 	$monthlyCancelledSales += $monthlyCancelledSale['total_cancelled'];
		// }

		return $monthlySales;//-$monthlyCancelledSales;
	}

	public function getYearlySales(){
		$year = date('Y');

		$connection = $this->openConnection();
		$query = "SELECT date,amount FROM transactions WHERE EXTRACT(YEAR FROM date) = '$year' AND state= 'completed';";
		$sql = $connection->prepare($query);
		$sql->execute();
		$sales = $sql->fetchAll();
		$yearlySales = 0;

		foreach ($sales as $monthlySale){
			$yearlySales += $monthlySale['amount'];
		}

		// $query = "SELECT * FROM cancelled_order WHERE EXTRACT(YEAR FROM date) = '$year';";
		// $sql = $connection->prepare($query);
		// $sql->execute();
		// $cancelledSales = $sql->fetchAll();

		// $yearlyCancelledSales = 0;
		// foreach ($cancelledSales as $monthlyCancelledSale){
		// 	$yearlyCancelledSales += $monthlyCancelledSale['total_cancelled'];
		// }

		return $yearlySales;
	}

	public function getProductLine(){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT * FROM products;");
		$sql->execute();
		$inventory = $sql->fetchAll();
		$countInventory = count($inventory);

		return $countInventory;
	}

	public function getStocksOnHand(){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT * FROM products;");
		$sql->execute();
		$inventory = $sql->fetchAll();
		$stocks = 0;

		foreach ($inventory as $inventoryStocks){
			$stocks += $inventoryStocks['product_quantity'];
		}

		return $stocks;
	}

	public function getCriticalItems(){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT * FROM products WHERE product_quantity <= 20;");
		$sql->execute();
		$inventory = $sql->fetchAll();
		$criticalItems = count($inventory);

		return $criticalItems;
	}

	public function getCritical(){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT * FROM products WHERE product_quantity <= 20;");
		$sql->execute();
		$inventory = $sql->fetchAll();

		return $inventory;
	}

	public function getCustomers(){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT * FROM users WHERE role = 'customer';");
		$sql->execute();
		$customer = $sql->fetchAll();
		$customers = count($customer);

		return $customers;
	}

	public function getTransactions(){
		date_default_timezone_set('Asia/Manila');
		$month = date("m");
		$year = date('Y');
		$day = date("d");

		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT * FROM transactions WHERE EXTRACT(DAY FROM date) = '$day' AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
		$sql->execute();
		$transaction = $sql->fetchAll();
		$transactions = count($transaction);

		return $transactions;
	}

	public function getUsers(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['userRole'])){
					$role = $_GET['role'];
					
					if ($role == 'staff') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT * FROM users WHERE role = 'staff';");
						$sql->execute();
						$users = $sql->fetchAll();
						$_SESSION['user_role'] = 'staff';

						return $users;
					} else if ($role == 'customer') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT * FROM users WHERE role = 'customer';");
						$sql->execute();
						$users = $sql->fetchAll();
						$_SESSION['user_role'] = 'customer';

						return $users;
					} else {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT * FROM users;");
						$sql->execute();
						$users = $sql->fetchAll();
						$_SESSION['user_role'] = 'all';

						return $users;
					}

				} else if (isset($_GET['deleteUserID'])){
					$userID = $_GET['deleteUserID'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("DELETE FROM users WHERE user_id = '$userID';");
					$sql->execute();

					$sql = $connection->prepare("SELECT * FROM users;");
					$sql->execute();
					$users = $sql->fetchAll();
					$_SESSION['user_role'] = 'all';

					return $users;

				} else if (isset($_GET['searchUsers'])){
					$role = $_GET['role'];
					$searchTag = $_GET['searchTag'];

					if ($role == 'staff') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT * FROM users WHERE role = 'staff' AND (fname LIKE '%$searchTag%' OR lname LIKE '%$searchTag%' OR user_id LIKE '%$searchTag%');");
						$sql->execute();
						$users = $sql->fetchAll();
						$_SESSION['user_role'] = 'staff';

						return $users;
					} else if ($role == 'customer') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT * FROM users WHERE role = 'customer' AND (fname LIKE '%$searchTag%' OR lname LIKE '%$searchTag%' OR user_id LIKE '%$searchTag%');");
						$sql->execute();
						$users = $sql->fetchAll();
						$_SESSION['user_role'] = 'customer';

						return $users;
					} else {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT * FROM users WHERE fname LIKE '%$searchTag%' OR lname LIKE '%$searchTag%' OR user_id LIKE '%$searchTag%';");
						$sql->execute();
						$users = $sql->fetchAll();
						$_SESSION['user_role'] = 'all';

						return $users;
					}

				} else {
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM users;");
					$sql->execute();
					$users = $sql->fetchAll();
					$_SESSION['user_role'] = 'all';

					return $users;
				}
			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getUserRole(){
		return $_SESSION['user_role'];
	}

	public function adminAddUser(){
		if ($_SESSION['role']=='admin') {
			if (isset($_POST['register_user'])) {
				$email = $_POST['email'];
				$_SESSION['email'] = $email;
				$password1 = $_POST['password_1'];
				$password2 = $_POST['password_2'];
				$firstname = $_POST['fname'];
				$lastname = $_POST['lname'];
				$phoneNum = $_POST['phoneNum'];
				$userRole= $_POST['userRole'];

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM users WHERE email = '$email';");
				$sql->execute();
				$user = $sql->fetchAll();
				$userCount = $sql->rowCount();		

				if ($userCount == 1){
					echo("Username/email already exists");
				} else {
					if (empty($email) or empty($password1) or empty($password2) or empty($firstname) or empty($lastname)or empty($phoneNum)or empty($userRole)) { 
						echo("PLEASE FILL UP ALL THE FIELDS"); 
					} else {
						if ($password1 == $password2){
							$password = md5($password1);
							$connection = $this->openConnection();
							$sql = $connection->prepare(
								"INSERT INTO users(email, password, role, phone_number, fname, lname) VALUES ('$email', '$password', '$userRole', '$phoneNum', '$lastname', '$firstname')");
							$sql->execute();

							header('location:adminManageUsers.php');
							
						} else {
							$_SESSION['message'] = "The two passwords do not match!";
							header('location:adminAddUser.php');
						}
					}
				}
			}
		}
	}

	public function getAdminProductCategory(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['categoryID'])){
					$categoryID = $_GET['categoryID'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM category WHERE category_id = '$categoryID'");
					$sql->execute();
					$categoryDetails = $sql->fetch();

					return $categoryDetails;
				}

				if (isset($_POST['removeCategory'])){
					$category_id = $_POST['categoryID'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("DELETE FROM category WHERE category_id = '$category_id'");
					$sql->execute();
					
					//$_SESSION['message'] = "Removed Successfully";
					header ('location:adminProducts.php');
				}
	
				if (isset($_POST['updateCategory'])){
					$category_id = $_POST['categoryID'];
					$category_name = $_POST['categoryName'];
	
					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE category SET category_name = '$category_name' WHERE category_id = '$category_id'");
	
					$sql->execute();
					
					//$_SESSION['message'] = "Updated Successfully";
					header ('location:adminProducts.php');
				}
	
				if (isset($_POST['addCategory'])){
					$targetDir = "thumbnails/";

					$categoryName = $_POST['categoryName'];

					$fileName = basename($_FILES["categoryThumbnail"]["name"]);

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM category WHERE thumbnail = '$fileName'");
					$sql->execute();
					$category = $sql->fetchAll();
					$categoryCount = $sql->rowCount();
					if ($categoryCount > 0) {
						$categoryCount += 1;
						$fileName = $categoryCount.$fileName;
					}

					//set file path and directory
					$targetFilePath = $targetDir.$fileName;
					$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

					//accepted file formats
					$allowTypes = array('jpg','png','jpeg','gif','pdf');

					if(in_array($fileType, $allowTypes)){
						// Upload file to server
						if(move_uploaded_file($_FILES["categoryThumbnail"]["tmp_name"], $targetFilePath)){
							// Insert image file and details into database
							$connection = $this->openConnection();
							$sql = $connection->prepare("INSERT INTO category (category_name, thumbnail) VALUES ('$categoryName', '$fileName')");
							$sql->execute();

							if($sql){
								$statusMsg = "The artwork has been uploaded successfully.";
							} else {
								$statusMsg = "File upload failed, please try again.";
							} 
						} else {
							$statusMsg = "Sorry, there was an error uploading your file.";
						}
					} else {
						$statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
					}

					header('location:adminProducts.php');
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getCategoryCount(){
		if ($_SESSION['authentication']) {
			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM category;");
			$sql->execute();
			$categoryCount = $sql->rowCount();

			return $categoryCount;
		} else {
			header ('location:login.php');
		}
	}

	public function getAdminProducts(){
		if ($_SESSION['authentication']) {
			$productID = $_GET['productID'];
			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT *, category.category_name FROM products INNER JOIN category ON products.product_category_id = category.category_id WHERE products.product_id = '$productID';");
			$sql->execute();
			$product = $sql->fetch();
			return $product;
		} else {
			header ('location:login.php');
		}
	}

	public function getNumberProductsPerCategory($categoryID){
		if ($_SESSION['authentication']) {
			$connection = $this->openConnection();
			$sql = $connection->prepare("SELECT * FROM products WHERE product_category_id = '$categoryID';");
			$sql->execute();
			$productCount = $sql->rowCount();

			return $productCount;
		} else {
			header ('location:login.php');
		}
	}

	public function getAdminProduct($categoryID){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT * FROM products WHERE product_category_id = '$categoryID';");
				$sql->execute();
				$products = $sql->fetchAll();
				return $products;
			}
		} else {
			header ('location:login.php');
		}
	}

	public function getAdminProductDetails(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['productID'])) {
					$productID = $_GET['productID'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,category.*,products.thumbnail as pthumbnail FROM products INNER JOIN category ON products.product_category_id = category.category_id WHERE products.product_id = '$productID';");
					$sql->execute();
					$product = $sql->fetch();
					return $product;
				}

				if (isset($_POST['deleteProduct'])) {
					$productID = $_POST['productID'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("DELETE FROM products WHERE product_id = '$productID'");
					$sql->execute();

					header ('location:adminProducts.php');
				}

				if (isset($_POST['updateProduct'])) {
					$productID = $_POST['productID'];
					$productCode = $_POST['productCode'];
					$productCategory = $_POST['productCategory'];
					$productName = $_POST['productName'];
					$productDescription = $_POST['productDescription'];
					$productPrice= $_POST['productPrice'];
					$productQuantity = $_POST['productQuantity'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("UPDATE products SET 
									product_code = '$productCode',
									product_name = '$productName',
									product_category_id = '$productCategory',
									product_name = '$productName',
									product_description = '$productDescription',
									product_price = '$productPrice',
									product_quantity = '$productQuantity'
									WHERE product_id = '$productID'; ");
					$sql->execute();

					header ('location:adminProducts.php');
				}
			} else {

			}
		} else {
			header ('location:login.php');
		}
	}
	
	public function adminAddProducts(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_POST['addProduct'])) {
					$productCode = $_POST['productCode'];
					$productCategory = $_POST['productCategory'];
					$productName = $_POST['productName'];
					$productDescription = $_POST['productDescription'];
					$productPrice= $_POST['productPrice'];
					$productQuantity = $_POST['productQuantity'];

					$targetDir = "thumbnails/";

					$fileName = basename($_FILES["productThumbnail"]["name"]);

					//CHECK IF THERE ARE SAME FILE NAME IN DATBASE 
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM products WHERE thumbnail = '$fileName'");
					$sql->execute();
					$product = $sql->fetchAll();
					$productCount = $sql->rowCount();
					if ($productCount > 0) {
						$productCount += 1;
						$fileName = $productCount.$fileName;
					}

					//set file path and directory
					$targetFilePath = $targetDir.$fileName;
					$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

					//accepted file formats
					$allowTypes = array('jpg','png','jpeg','gif','pdf');

					if(in_array($fileType, $allowTypes)){
						// Upload file to server
						if(move_uploaded_file($_FILES["productThumbnail"]["tmp_name"], $targetFilePath)){
							// Insert image file and details into database
							$connection = $this->openConnection();
							$sql = $connection->prepare("INSERT INTO products (product_code, product_category_id, product_name, product_description, product_price, product_quantity, thumbnail) 
														VALUES ('$productCode', '$productCategory', '$productName', '$productDescription', '$productPrice', '$productQuantity', '$fileName')");
							$sql->execute();

							if($sql){
								$statusMsg = "The artwork has been uploaded successfully.";
							} else {
								$statusMsg = "File upload failed, please try again.";
							} 
						} else {
							$statusMsg = "Sorry, there was an error uploading your file.";
						}
					} else {
						$statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
					}
					header('location:adminProducts.php');
				}
			} else {

			}
		} else {
			header ('location:login.php');
		}
	}

	public function getAdminTransactions($transactionProcess){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['betweenDates'])){
					$fromDate = $_GET['from'];
					$toDate = $_GET['to'];

					if ($transactionProcess == 'instore') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE online = '0' AND date BETWEEN '$fromDate' AND '$toDate' ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
	
						return $transaction;
					} else if ($transactionProcess == 'online') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE online = '1' AND date BETWEEN '$fromDate' AND '$toDate' ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
	
						return $transaction;
					}

				} else if (isset($_GET['searchTransactions'])) {
					$searchTag = $_GET['searchTag'];

					if ($transactionProcess == 'instore') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE online = '0' AND transaction_id = '$searchTag' ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
	
						return $transaction;
					} else if ($transactionProcess == 'online') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE online = '1' AND transaction_id = '$searchTag' ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
	
						return $transaction;
					}
				} else {
					if ($transactionProcess == 'instore') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE online = '0' ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
	
						return $transaction;
					} else if ($transactionProcess == 'online') {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE online = '1' ORDER BY transaction_id DESC;");
						$sql->execute();
						$transaction = $sql->fetchAll();
	
						return $transaction;
					}
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getAdminStockInHistory(){
		if ($_SESSION['authentication']){
			if ($_SESSION['role'] == 'admin' ) {
				if (isset($_GET['betweenDates'])){
					$fromDate = $_GET['from'];
					$toDate = $_GET['to'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,users.*,products.* FROM stock_in_history 
												INNER JOIN users ON stock_in_history.cashier_id = users.user_id
												INNER JOIN products ON stock_in_history.product_id = products.product_id
												WHERE date BETWEEN '$fromDate' AND '$toDate'
												ORDER BY stockin_id DESC;");
					$sql->execute();
					$stockInHistory = $sql->fetchAll();
	
					return $stockInHistory;

				} else {
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,users.*,products.* FROM stock_in_history 
												INNER JOIN users ON stock_in_history.cashier_id = users.user_id
												INNER JOIN products ON stock_in_history.product_id = products.product_id
												ORDER BY stockin_id DESC;");
					$sql->execute();
					$stockInHistory = $sql->fetchAll();
	
					return $stockInHistory;
				}

			}
		} else {
			header('location:login.php');
		}		
	} 

	public function getAdminTransactionProducts(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['transactionID'])) {
					$transactionID = $_GET['transactionID'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE transaction_id='$transactionID';");
					$sql->execute();
					$product = $sql->fetchAll();
		
					return $product;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getAdminTransactionDetails(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['transactionID'])) {
					$transactionID = $_GET['transactionID'];
					
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname)AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE transaction_id='$transactionID';");
					$sql->execute();
					$product = $sql->fetch();
		
					return $product;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	// ====================================== ANALYTICS DAILY ==================================================
	public function getDate() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];
					return $date;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getDailySale() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT date,SUM(amount) AS total FROM transactions WHERE date = '$date' AND state = 'completed';");
					$sql->execute();
					$dailySale = $sql->fetch();

					return $dailySale;
				} else {
					$date = date("Y-m-d");
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT date,SUM(amount) AS total FROM transactions WHERE date = '$date' AND state = 'completed';");
					$sql->execute();
					$dailySale = $sql->fetch();

					return $dailySale;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getDailyChart() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];

					if ($date == date("Y-m-d")) {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT SUM(amount) as total,date FROM `transactions` WHERE date >= DATE_ADD('2023-01-05', INTERVAL -6 DAY) AND date <= CURDATE() GROUP BY date ORDER BY date;");
						$sql->execute();
						$dailyChartData = $sql->fetchAll();
					} else {
						$connection = $this->openConnection();
						$sql = $connection->prepare("SELECT SUM(amount) as total,date FROM `transactions` WHERE date >= DATE_ADD('$date', INTERVAL -3 DAY) AND date <= DATE_ADD('$date', INTERVAL 3 DAY) GROUP BY date ORDER BY date;");
						$sql->execute();
						$dailyChartData = $sql->fetchAll();
					}


					return $dailyChartData;
				} else {
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(amount) as total,date FROM `transactions` WHERE date >= DATE_ADD('2023-01-05', INTERVAL -6 DAY) AND date <= CURDATE() GROUP BY date ORDER BY date;");
					$sql->execute();
					$dailyChartData = $sql->fetchAll();

					return $dailyChartData;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getTotalProducts() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = '$date';");
					$sql->execute();
					$dailyTotalProducts = $sql->fetch();

					return $dailyTotalProducts;
				} else {
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = CURDATE();");
					$sql->execute();
					$dailyTotalProducts = $sql->fetch();

					return $dailyTotalProducts;
				}
			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getTotalTransactions() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM transactions WHERE date='$date' AND state = 'completed';");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$transactions = count($transaction);
				
					return $transactions;
					
				} else {
					date_default_timezone_set('Asia/Manila');
					$month = date("m");
					$year = date('Y');
					$day = date("d");
				
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM transactions WHERE EXTRACT(DAY FROM date) = '$day' AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$transactions = count($transaction);

					return $transactions;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getDailyTopSelling() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {

				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = '$date' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
					$sql->execute();
					$topSelling = $sql->fetchAll();
				
					return $topSelling;
					
				} else {				
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = CURDATE() GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
					$sql->execute();
					$topSelling = $sql->fetchAll();
				
					return $topSelling;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getDailyTopSellingItem() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = '$date' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
					$sql->execute();
					$topSelling = $sql->fetch();
				
					return $topSelling;
					
				} else {				
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = CURDATE() GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
					$sql->execute();
					$topSelling = $sql->fetch();
				
					return $topSelling;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getDailySoldItems() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions on user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = '$date' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
					$sql->execute();
					$soldItem = $sql->fetchAll();
				
					return $soldItem;
					
				} else {				
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions on user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = CURDATE() GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
					$sql->execute();
					$soldItem = $sql->fetchAll();
				
					return $soldItem;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getDailyTransactions() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE transactions.date = '$date' ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();

					return $transaction;
					
				} else {				
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE transactions.date = CURDATE() ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();

					return $transaction;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	// ====================================== ANALYTICS MONTHLY ==================================================
	public function monthEquivalent($month){
		$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		$monthName = $months[$month - 1];

		return $monthName;
	}

	public function getYearDate() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					return $year;
				} else {
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					return $year;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getMonthDate() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					return $month;
				} else {
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					return $month;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getMonthlySale() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT CONCAT(EXTRACT(MONTH FROM date),'-',EXTRACT(YEAR FROM date)) AS monthYear,SUM(amount) AS total FROM transactions WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$monthlySale = $sql->fetch();

					return $monthlySale;
				} else {
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT CONCAT(EXTRACT(MONTH FROM date),'-',EXTRACT(YEAR FROM date)) AS monthYear,SUM(amount) AS total FROM transactions WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$monthlySale = $sql->fetch();

					return $monthlySale;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getMonthlyChartSales($month, $year) {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$m = $month;
					$y = $year;

					$connection = $this->openConnection();
					$query = "SELECT date,amount FROM transactions WHERE EXTRACT(MONTH FROM date) = '$m' AND EXTRACT(YEAR FROM date) = '$y' AND state = 'completed';";
					$sql = $connection->prepare($query);
					$sql->execute();
					$sales = $sql->fetchAll();
			
					$monthlySales = 0;
			
					foreach ($sales as $monthlySale){
						$monthlySales += $monthlySale['amount'];
					}

					return $monthlySales;
				} else {
					$m = $month;
					$y = $year;

					$connection = $this->openConnection();
					$query = "SELECT date,amount FROM transactions WHERE EXTRACT(MONTH FROM date) = '$m' AND EXTRACT(YEAR FROM date) = '$y' AND state = 'completed';";
					$sql = $connection->prepare($query);
					$sql->execute();
					$sales = $sql->fetchAll();
			
					$monthlySales = 0;
			
					foreach ($sales as $monthlySale){
						$monthlySales += $monthlySale['amount'];
					}

					return $monthlySales;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getTotalProductsMonthly() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['pickDate'])){
					$date = $_GET['day'];
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year';");
					$sql->execute();
					$dailyTotalProducts = $sql->fetch();

					return $dailyTotalProducts;
				} else {
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year';");
					$sql->execute();
					$dailyTotalProducts = $sql->fetch();

					return $dailyTotalProducts;
				}
			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getTotalTransactionsMonthly() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM transactions WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$transactions = count($transaction);
				
					return $transactions;
					
				} else {
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 
				
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM transactions WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$transactions = count($transaction);

					return $transactions;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getMonthlyTopSelling() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {

				if (isset($_GET['pickDate'])){
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
					$sql->execute();
					$topSelling = $sql->fetchAll();
				
					return $topSelling;
					
				} else {		
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
					$sql->execute();
					$topSelling = $sql->fetchAll();
				
					return $topSelling;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getMonthlyTopSellingItem() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
					$sql->execute();
					$topSelling = $sql->fetch();
				
					return $topSelling;
					
				} else {
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
					$sql->execute();
					$topSelling = $sql->fetch();
				
					return $topSelling;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getMonthlySoldItems() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions on user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
					$sql->execute();
					$soldItem = $sql->fetchAll();
				
					return $soldItem;
					
				} else {	
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions on user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
					$sql->execute();
					$soldItem = $sql->fetchAll();
				
					return $soldItem;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getMonthlyTransactions() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$date = $_GET['monthYear'];
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();

					return $transaction;
					
				} else {	
					$date = date("Y-m");
					$parts = explode('-', $date);
					$year = $parts[0]; 
					$month = $parts[1]; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();

					return $transaction;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	// ====================================== ANALYTICS YEARLY ==================================================

	public function getYearYearlyDate() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$year = $_GET['year'];
					return $year;

				} else {
					$year = date("Y");
					return $year;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getYearlySale() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$year = $_GET['year'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT CONCAT(EXTRACT(MONTH FROM date)) AS year,SUM(amount) AS total FROM transactions WHERE EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$yearlySale = $sql->fetch();

					return $yearlySale;
				} else {
					$year = date("Y");

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT CONCAT(EXTRACT(MONTH FROM date)) AS year,SUM(amount) AS total FROM transactions WHERE EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$yearlySale = $sql->fetch();

					return $yearlySale;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getYearlyChartSales() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				$connection = $this->openConnection();
				$query = "SELECT EXTRACT(YEAR FROM date) AS year, SUM(amount) AS total FROM transactions WHERE state = 'completed' GROUP BY EXTRACT(YEAR FROM date);";
				$sql = $connection->prepare($query);
				$sql->execute();
				$sales = $sql->fetchAll();

				return $sales;

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getTotalProductsYearly() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['pickDate'])){
					$year = $_GET['year'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(YEAR FROM date) = '$year';");
					$sql->execute();
					$yearlyTotalProducts = $sql->fetch();

					return $yearlyTotalProducts;
				} else {
					$year = date("Y");

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(YEAR FROM date) = '$year';");
					$sql->execute();
					$yearlyTotalProducts = $sql->fetch();

					return $yearlyTotalProducts;
				}
			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getTotalTransactionsYearly() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$year = $_GET['year'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM transactions WHERE EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$transactions = count($transaction);
				
					return $transactions;
					
				} else {
					$year = date("Y");
				
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM transactions WHERE EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$transactions = count($transaction);

					return $transactions;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getYearlyTopSelling() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {

				if (isset($_GET['pickDate'])){
					$year = $_GET['year'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
					$sql->execute();
					$topSelling = $sql->fetchAll();
				
					return $topSelling;
					
				} else {		
					$year = date("Y"); 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
					$sql->execute();
					$topSelling = $sql->fetchAll();
				
					return $topSelling;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getYearlyTopSellingItem() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$year = $_GET['year'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
					$sql->execute();
					$topSelling = $sql->fetch();
				
					return $topSelling;
					
				} else {
					$year = date("Y"); 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
					$sql->execute();
					$topSelling = $sql->fetch();
				
					return $topSelling;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getYearlySoldItems() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$year = $_GET['year'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions on user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
					$sql->execute();
					$soldItem = $sql->fetchAll();
				
					return $soldItem;
					
				} else {	
					$year = date("Y");

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions on user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND EXTRACT(YEAR FROM date) = '$year' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
					$sql->execute();
					$soldItem = $sql->fetchAll();
				
					return $soldItem;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getYearlyTransactions() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$year = $_GET['year'];

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE EXTRACT(YEAR FROM date) = '$year' ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();

					return $transaction;
					
				} else {	
					$year = date("Y");

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE EXTRACT(YEAR FROM date) = '$year' ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();

					return $transaction;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	// ====================================== ANALYTICS WEEKLY ==================================================
	public function formatWeek($weekYear) {
		$year = substr($weekYear, 0, 4);
		$week = substr($weekYear, 4);
		
		$formattedWeek = $year.' Week ' . $week;
		echo $formattedWeek;
	}

	public function formatWeek1($weekYear) {
		$year = substr($weekYear, 0, 4);
		$week = substr($weekYear, 4);
		
		$formattedWeek = $year.'-W'.$week;
		echo $formattedWeek;
	}

	public function getWeeklyDate() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$week = $_GET['week'];
					$parts = explode('-W', $week);
					$year = $parts[0]; 
					$weekNumber = $parts[1]; 

					$week = $year.$weekNumber;
					return $week;

				} else {
					$weekNumber = date('W');
					$year = date('Y');
					$week = $year . $weekNumber;

					return $week;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getWeeklySale() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$week = $_GET['week'];
					$parts = explode('-W', $week);
					$year = $parts[0]; 
					$weekNumber = $parts[1]; 

					$week = $year.$weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT YEARWEEK(date) week, SUM(amount) as total FROM transactions WHERE YEARWEEK(DATE, 1) = '$week' AND state = 'completed'");
					$sql->execute();
					$monthlySale = $sql->fetch();

					return $monthlySale;
				} else {
					$weekNumber = date('W');
					$year = date('Y');
					$week = $year . $weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT YEARWEEK(date) week, SUM(amount) as total FROM transactions WHERE YEARWEEK(DATE, 1) = '$week' AND state = 'completed'");
					$sql->execute();
					$monthlySale = $sql->fetch();

					return $monthlySale;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getWeeklyChartData() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {

				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT YEARWEEK(date) week, SUM(amount) as total FROM transactions WHERE state = 'completed' GROUP BY YEARWEEK(date,1) ORDER BY week DESC LIMIT 10;");
				$sql->execute();
				$weeklyChartData = $sql->fetchAll();

				return $weeklyChartData;

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getTotalProductsWeekly() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				if (isset($_GET['pickDate'])){
					$week = $_GET['week'];
					$parts = explode('-W', $week);
					$year = $parts[0]; 
					$weekNumber = $parts[1]; 

					$week = $year.$weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND YEARWEEK(DATE, 1) = '$week';");
					$sql->execute();
					$weeklyTotalProducts = $sql->fetch();

					return $weeklyTotalProducts;
				} else {
					$weekNumber = date('W');
					$year = date('Y');
					$week = $year . $weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND YEARWEEK(DATE, 1) = '$week';");
					$sql->execute();
					$weeklyTotalProducts = $sql->fetch();

					return $weeklyTotalProducts;
				}
			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getTotalTransactionsWeekly() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$week = $_GET['week'];
					$parts = explode('-W', $week);
					$year = $parts[0]; 
					$weekNumber = $parts[1]; 

					$week = $year.$weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM transactions WHERE YEARWEEK(DATE,1) = '$week' AND state = 'completed';");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$transactions = count($transaction);
				
					return $transactions;
					
				} else {
					$weekNumber = date('W');
					$year = date('Y');
					$week = $year . $weekNumber; 
				
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM transactions WHERE YEARWEEK(DATE,1) = '$week' AND state = 'completed';");
					$sql->execute();
					$transaction = $sql->fetchAll();
					$transactions = count($transaction);

					return $transactions;
				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getWeeklyTopSelling() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {

				if (isset($_GET['pickDate'])){
					$week = $_GET['week'];
					$parts = explode('-W', $week);
					$year = $parts[0]; 
					$weekNumber = $parts[1]; 

					$week = $year.$weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND YEARWEEK(DATE,1) = '$week' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
					$sql->execute();
					$topSelling = $sql->fetchAll();
				
					return $topSelling;
					
				} else {		
					$weekNumber = date('W');
					$year = date('Y');
					$week = $year . $weekNumber;  

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND YEARWEEK(DATE,1) = '$week' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
					$sql->execute();
					$topSelling = $sql->fetchAll();
				
					return $topSelling;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getWeeklyTopSellingItem() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$week = $_GET['week'];
					$parts = explode('-W', $week);
					$year = $parts[0]; 
					$weekNumber = $parts[1]; 

					$week = $year.$weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND YEARWEEK(DATE,1) = '$week' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
					$sql->execute();
					$topSelling = $sql->fetch();
				
					return $topSelling;
					
				} else {
					$weekNumber = date('W');
					$year = date('Y');
					$week = $year . $weekNumber;  

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*,transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND YEARWEEK(DATE,1) = '$week' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
					$sql->execute();
					$topSelling = $sql->fetch();
				
					return $topSelling;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getWeeklySoldItems() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$week = $_GET['week'];
					$parts = explode('-W', $week);
					$year = $parts[0]; 
					$weekNumber = $parts[1]; 

					$week = $year.$weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions on user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND YEARWEEK(DATE,1) = '$week' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
					$sql->execute();
					$soldItem = $sql->fetchAll();
				
					return $soldItem;
					
				} else {	
					$weekNumber = date('W');
					$year = date('Y');
					$week = $year . $weekNumber;  

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions on user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND YEARWEEK(DATE,1) = '$week' GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
					$sql->execute();
					$soldItem = $sql->fetchAll();
				
					return $soldItem;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}

	public function getWeeklyTransactions() {
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == 'admin') {
				//session scale to be displayed
				if (isset($_GET['pickDate'])){
					$week = $_GET['week'];
					$parts = explode('-W', $week);
					$year = $parts[0]; 
					$weekNumber = $parts[1]; 

					$week = $year.$weekNumber; 

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE YEARWEEK(DATE,1) = '$week' ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();

					return $transaction;
					
				} else {	
					$weekNumber = date('W');
					$year = date('Y');
					$week = $year . $weekNumber;

					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT *,CONCAT(users.fname,' ',users.lname) AS cashier_name FROM transactions INNER JOIN users ON transactions.cashier_id = users.user_id WHERE YEARWEEK(DATE,1) = '$week' ORDER BY transaction_id DESC;");
					$sql->execute();
					$transaction = $sql->fetchAll();

					return $transaction;

				}

			} else {

			}
		} else {
			header('location:login.php');
		}
	}
	// ====================================== CHART FUNCTIONS OVERALL ==================================================
	public function getMonthlySalesChart($month){
		$year = date('Y');

		$connection = $this->openConnection();
		$query = "SELECT date,amount FROM transactions WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year' AND state = 'completed';";
		$sql = $connection->prepare($query);
		$sql->execute();
		$sales = $sql->fetchAll();

		$monthlySales = 0;

		foreach ($sales as $monthlySale){
			$monthlySales += $monthlySale['amount'];
		}

		//CANCELLED ORDERS OR TRANSACTIONS
		// $query = "SELECT * FROM cancelled_order WHERE EXTRACT(MONTH FROM date) = '$month' AND EXTRACT(YEAR FROM date) = '$year';";
		// $sql = $connection->prepare($query);
		// $sql->execute();
		// $cancelledSales = $sql->fetchAll();

		//$monthlyCancelledSales = 0;

		// foreach ($cancelledSales as $monthlyCancelledSale){
		// 	$monthlyCancelledSales += $monthlyCancelledSale['total_cancelled'];
		// }

		return $monthlySales;//-$monthlyCancelledSales;
	}

	public function getYearlySalesChart(){
		$connection = $this->openConnection();
		$query = "SELECT EXTRACT(YEAR FROM date) AS year, SUM(amount) AS total FROM transactions WHERE state = 'completed' GROUP BY EXTRACT(YEAR FROM date);";
		$sql = $connection->prepare($query);
		$sql->execute();
		$sales = $sql->fetchAll();

		// $query = "SELECT * FROM cancelled_order WHERE EXTRACT(YEAR FROM date) = '$year';";
		// $sql = $connection->prepare($query);
		// $sql->execute();
		// $cancelledSales = $sql->fetchAll();

		// $yearlyCancelledSales = 0;
		// foreach ($cancelledSales as $monthlyCancelledSale){
		// 	$yearlyCancelledSales += $monthlyCancelledSale['total_cancelled'];
		// }

		return $sales;
	}

	public function getTopSelling(){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE transaction_id IS NOT NULL GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;");
		$sql->execute();
		$topSelling = $sql->fetchAll();

		// if (isset($_POST['betweenDates'])){
		// 	$fromDate = $_POST['from'];
		// 	$toDate = $_POST['to'];

		// 	$sql = $connection->prepare("SELECT transaction_num.date, SUM(transaction.quantity_bought) AS total_sold, SUM(transaction.total_price) AS total_sale, transaction.product_id, inventory.*, transaction_num.transacState FROM transaction INNER JOIN inventory ON transaction.product_id = inventory.product_id INNER JOIN transaction_num ON transaction.transaction_id = transaction_num.transaction_id WHERE transaction_num.transacState = 'completed' AND transaction_num.date BETWEEN '$fromDate' AND '$toDate' GROUP BY transaction.product_id ORDER BY SUM(transaction.quantity_bought) DESC LIMIT 5;");
		// 	$sql->execute();
		// 	$topSelling = $sql->fetchAll();

		// 	return $topSelling;
		// }

		return $topSelling;
	}

	public function getTopSellingItem(){
		$connection = $this->openConnection();
		$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE transaction_id IS NOT NULL GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 1;");
		$sql->execute();
		$topSelling = $sql->fetch();

		return $topSelling;
	}

	public function soldItems(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == "admin"){
				$connection = $this->openConnection();
				$sql = $connection->prepare("SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE transaction_id IS NOT NULL GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;");
				$sql->execute();
				$soldItem = $sql->fetchAll();

				// if (isset($_POST['betweenDates'])){
				// 	$fromDate = $_POST['from'];
				// 	$toDate = $_POST['to'];

				// 	$sql = $connection->prepare("SELECT transaction_num.date, SUM(transaction.quantity_bought) AS total_sold, SUM(transaction.total_price) AS total_sale, transaction.product_id, inventory.*, transaction_num.transacState FROM transaction INNER JOIN inventory ON transaction.product_id = inventory.product_id INNER JOIN transaction_num ON transaction.transaction_id = transaction_num.transaction_id WHERE transaction_num.transacState = 'completed' AND transaction_num.date BETWEEN '$fromDate' AND '$toDate' GROUP BY transaction.product_id ORDER BY SUM(transaction.quantity_bought) DESC;");
				// 	$sql->execute();
				// 	$topSelling = $sql->fetchAll();

				// 	return $topSelling;
				// }

				return $soldItem;
			}

		} else {
			header ('location:login.php');
		}
	}

	// ============================================= ADMIN PROFILE SETTINGS ================================================
	public function changePassword(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == "admin"){
				unset($_SESSION['message']);
				if (isset($_POST['save'])){
					$email = $_POST['email'];
					$oldPassword = md5($_POST['oldPassword']);
					$newPassword = $_POST['newPassword'];
					$newPassword1 = $_POST['newPassword1'];

					$activeUser = $_SESSION['id'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM users WHERE user_id = '$activeUser'");
					$sql->execute();
					$userinfo = $sql->fetch();

					if ($newPassword == $newPassword1 ){
						if (($oldPassword == $userinfo['password']) && ($email == $userinfo['email'])){
							$newPassword = md5($newPassword1);
							$connection = $this->openConnection();
							$sql = $connection->prepare("UPDATE users SET password='$newPassword' WHERE user_id = '$activeUser'");
							$sql->execute();

							$_SESSION['message'] = "CHANGE PASSWORD SUCCESSFUL!";
							header('location:adminChangePassword.php');
						} else {
							$_SESSION['message'] = "Old Password or Email is incorrect!";
							header('location:adminChangePassword.php');
						}
					} else{
						$_SESSION['message'] = "Two Passwords Do Not Match!";
						header('location:adminChangePassword.php');
					}
				}
			}
		} else {
			header ('location:login.php');
		}
	}

	public function changePasswordStaff(){
		if ($_SESSION['authentication']) {
			if ($_SESSION['role'] == "staff"){
				unset($_SESSION['message']);
				if (isset($_POST['save'])){
					$email = $_POST['email'];
					$oldPassword = md5($_POST['oldPassword']);
					$newPassword = $_POST['newPassword'];
					$newPassword1 = $_POST['newPassword1'];

					$activeUser = $_SESSION['id'];
					$connection = $this->openConnection();
					$sql = $connection->prepare("SELECT * FROM users WHERE user_id = '$activeUser'");
					$sql->execute();
					$userinfo = $sql->fetch();

					if ($newPassword == $newPassword1 ){
						if (($oldPassword == $userinfo['password']) && ($email == $userinfo['email'])){
							$newPassword = md5($newPassword1);
							$connection = $this->openConnection();
							$sql = $connection->prepare("UPDATE users SET password='$newPassword' WHERE user_id = '$activeUser'");
							$sql->execute();

							$_SESSION['message'] = "CHANGE PASSWORD SUCCESSFUL!";
							header('location:staffChangePassword.php');
						} else {
							$_SESSION['message'] = "Old Password or Email is incorrect!";
							header('location:staffChangePassword.php');
						}
					} else{
						$_SESSION['message'] = "Two Passwords Do Not Match!";
						header('location:staffChangePassword.php');
					}
				}
			}
		} else {
			header ('location:login.php');
		}
	}

	public function returnMessage(){
		return $_SESSION['message'];
	}
}
//npx tailwindcss -i ./input.css -o ./output.css --watch

// SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.* FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id WHERE transaction_id IS NOT NULL GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC LIMIT 5;
//overflow-auto h-48 max-h-full

// ===== addition for tailwind and fontawesome icons hehe
// <script src="assets/js/tailwind.js"></script>
// <link rel="stylesheet" href="assets/css/font-awesome.min.css">
// <link rel="stylesheet" href="assets/css/fonts.css">
//SELECT * FROM transactions WHERE YEARWEEK(`date`, 1) = YEARWEEK('2022-12-27', 1);
//SELECT * FROM transactions WHERE date >= DATE_SUB(NOW(), INTERVAL 1 WEEK);
//SELECT * FROM transactions WHERE WEEK(date) = WEEK("2022-12-31"); --- FINAL
//SELECT * FROM `transactions` WHERE date >= DATE_ADD("2023-01-05", INTERVAL -3 DAY) AND date <= DATE_ADD("2023-01-05", INTERVAL 3 DAY);
//SELECT SUM(amount) as total,date FROM `transactions` WHERE date >= DATE_ADD("2023-01-05", INTERVAL -3 DAY) AND date <= DATE_ADD("2023-01-05", INTERVAL 3 DAY) GROUP BY date ORDER BY date;
//SELECT SUM(user_cart_products.quantity_added) AS total_sold, transactions.date FROM user_cart_products INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = CURDATE();
//SELECT SUM(user_cart_products.quantity_added) AS total_sold, SUM(user_cart_products.total_price) AS total_sale, user_cart_products.product_id, products.*, transactions.date FROM user_cart_products INNER JOIN products ON user_cart_products.product_id = products.product_id INNER JOIN transactions ON user_cart_products.transaction_id = transactions.transaction_id WHERE user_cart_products.transaction_id IS NOT NULL AND transactions.date = CURDATE() GROUP BY user_cart_products.product_id ORDER BY SUM(user_cart_products.quantity_added) DESC;
// SELECT YEARWEEK(date) week, SUM(amount) as total FROM transactions WHERE YEARWEEK(DATE) = '202306' AND state = 'completed';
// SELECT YEARWEEK(date) week, SUM(amount) as total FROM transactions WHERE EXTRACT(YEAR from date) = '2023' AND state = 'completed' GROUP BY YEARWEEK(date);
?>