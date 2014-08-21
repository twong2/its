<?php
	if (!isUser() && !isAdmin()) {
		header('Location: ?noAuth');
		exit;
	} // END if (!isUser() && !isAdmin())
        
        //current URL of the Page. reviewUpdate.php redirects back to this URL
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

	$con = mysqli_connect($db_host, $db_username, $db_password,$db_name);
	$username = '';
	if (!empty($_SESSION['username'])) {
		$username = $_SESSION['username'];
	} // END if (!empty($_SESSION['username']))

	//People cannot check out without logging in
	if (!isUser()) {
            if(empty ($username)){
                    header('Location:' .getCASServer() . '/cas/login?service=' . getCASLoginPage() . '?section=' . $section);
            }//END if(empty ($username))
	}//END if (!isUser())
?>
<div id="right">
	<h1>
		Customer Order Reviews
	</h1>
	<p></p>
	<style>
		 .fieldLabel {
		 	background-color: #CCCCCC;
		 	font-weight: bold;
		 }
	</style>
        
        <link href="?section=style" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/request.js"></script>
    <script>
        function setLeftNavHeight() {
                document.getElementById("leftnav").style.height = document.getElementById('content').offsetHeight + "px";
        } // END function setLeftNavHeight()

        function toggleView(currentView) {
                var approvalDivObj = document.getElementById("approvalDiv");
                hideObj(approvalDivObj);
                var formsDivObj = document.getElementById("formsDiv");
                hideObj(formsDivObj);
//                var adminDivObj = document.getElementById("adminDiv");
//                hideObj(adminDivObj);

                var approvalTabObj = document.getElementById("approvalTab");
                showBorder(approvalTabObj);
                var formsTabObj = document.getElementById("formsTab");
                showBorder(formsTabObj);
//                var adminTabObj = document.getElementById("adminTab");
//                showBorder(adminTabObj);

                var currentDivObj = document.getElementById(currentView + "Div");
                showObj(currentDivObj);

                var currentTabObj = document.getElementById(currentView + "Tab");
                hideBorder(currentTabObj);
        } // END function toggleView(currentView)

        function hideObj(currentObj) {
                currentObj.style.position = "absolute";
                currentObj.style.visibility = "hidden";
        } // END function hideObj(currentObj)

        function showObj(currentObj) {
                currentObj.style.position = "relative";
                currentObj.style.visibility = "visible";
        } // END function showObj(currentObj)

        function hideBorder(currentObj) {
                currentObj.style.borderBottom = "none";
        } // END function hide(currentObj)

        function showBorder(currentObj) {
                currentObj.style.borderBottom = "1px solid #bbb";
        } // END function show(currentObj)
    </script>

<div id="main">
        <div id="content">

                <!-- InstanceBeginEditable name="main_content" -->
                <ul class="topNav">
                        <li>
                                <a id="approvalTab" href="javascript: toggleView('approval');" class="active">Awaiting approvals</a>
                        </li>
                        <li>
                                <a id="formsTab" href="javascript: toggleView('forms');">Finished Orders</a>
                        </li>
<!--					<li>
                                <a id="adminTab" href="javascript: toggleView('admin');">Admin</a>
                        </li>-->
                </ul>
                <div id="approvalDiv">
                <h2>
                        Awaiting approvals
                </h2>
                    <?php
                        if (getStatus($con, $order_header = "For Review" )){
                            echo
                                '<table width="100%">' . PHP_EOL .
                                '<tr valign="top">' . PHP_EOL .
                                '	<td width="25%">' . PHP_EOL .
                                '		' . $headerHTML . PHP_EOL .
                                '		' . $orderTotalHTML . PHP_EOL .
                                '               ' . $statusHTML . PHP_EOL .
                                '		' . $orderIdHTML . PHP_EOL .
                                '               ' . $customerName . PHP_EOL .
                                '	</td>' . PHP_EOL .
                                '	<td>' . PHP_EOL .
                                '		' . $lineItems . PHP_EOL .
                                '	</td>' . PHP_EOL .
                                '</tr>' . PHP_EOL .
                                '</table>' . PHP_EOL .
                                '<hr>' . PHP_EOL;
                        }
                    ?>
                </div><!-- id=approvalDiv-->

                <div id="formsDiv">
                <h2>
                        Finished Orders
                </h2>
                </div><!-- id=formsDiv-->

<!--				<div id="adminDiv">
                <h2>
                        Admin Menu
                </h2>
                </div> id=adminDiv-->

        
<?php
	// use to display "no history" message
	$order_history = false;

	$contact_info = array(
		'customer_id' => '',
		'first_name' => '',
		'last_name' => '',
	);
	//DB tables needed for pulling information
	$contact_info_sql =
		"SELECT customer_id" . // specify which fields you are going to use
		" FROM contact_info " .
                " WHERE uh_username = '$username' ;";
        
	if ($contact_info_results = mysqli_query($con, $contact_info_sql)) {
		// only expecting one row. Use IF instead of WHILE.
		// If you want to use the table column name, use mysqli_fetch_assoc instead of mysqli_fetch_array.
		if ($contact_info_row = mysqli_fetch_assoc($contact_info_results)) {
			$contact_info = $contact_info_row;
			// DEBUG - see that we got the contact_info correctly
			// print_r($contact_info); exit;
		} // END if ($contact_info_row = mysqli_fetch_array($contact_info_results))
	} // END if ($contact_info)
        
        $order_review_sql =
                "SELECT order_id, tech_id" .
                " FROM order_review" ;
                if (!isAdmin()) {
                $order_review_sql .= " WHERE tech_id = " . $contact_info['customer_id'] . ";";
                }
        if ($order_review_info_results = mysqli_query($con, $order_review_sql)) {
		while ($order_review_info_row = mysqli_fetch_array($order_review_info_results)) {
			$order_review_info[] = $order_review_info_row['order_id'];
		} // END if ($contact_info_row = mysqli_fetch_array($contact_info_results))
	} // END if ($contact_info)
        foreach($order_review_info as $order_id){
            
        
	$order_header_sql =
		"SELECT customer_id, order_id, order_date, status " . 
		" FROM orders_header " .
		" WHERE order_id = " . $order_id . ";";
	// echo 'order header sql: ' . $order_header_sql; exit;
        
	$orders = array();
	if ($order_header_results = mysqli_query($con, $order_header_sql)){
		while($order_header_row = mysqli_fetch_assoc($order_header_results)){
			$orders[] = $order_header_row;
		} // END while($order_header_row = mysqli_fetch_assoc($order_header_results))
	} // END if ($order_header_results)
        
        $headerHTML = '';
        $orderTotalHTML = '';
        $statusHTML = '';
        $orderIdHTML = '';
        $lineItems = '';
        
	// check if there's an order header, which means likely there is a related order
	foreach ($orders as $order_header) {
		$order_items_sql =
			"SELECT product_id, price, quantity " .
			" FROM order_items " .
			" WHERE order_id = " . $order_header['order_id'] . ";";
//                echo 'order item sql: ' . $order_items_sql; exit;
		if ($order_items_query = mysqli_query($con, $order_items_sql)) {

            //Redeclared contact_info sql table to get customer name
            $customer_info_sql = 
                "SELECT customer_id, first_name, last_name " . // specify which fields you are going to use
		" FROM contact_info " .
		" WHERE customer_id = " .$order_header['customer_id'] . ";";
//            echo $customer_info_sql; exit();
            if ($customer_info_results = mysqli_query($con, $customer_info_sql)) {
                    if ($customer_info_row = mysqli_fetch_assoc($customer_info_results)) {
                            $customer_info = $customer_info_row;
                    } // END if ($contact_info_row = mysqli_fetch_array($contact_info_results))
            } // END if ($contact_info)
//            echo $customer_info['customer_id']; exit();

			// get order line items
			$orderTotal = 0;
			$lineItems =
				'<table width="100%">' . PHP_EOL .
				'<tr class="fieldLabel">' . PHP_EOL .
				'	<td width="60%">' . PHP_EOL .
				'		Product Name' . PHP_EOL .
				'	</td>' . PHP_EOL .
                                '       <td>' . PHP_EOL .
				'		Quantity ' . PHP_EOL .
				'	</td>' . PHP_EOL .
				'	<td>' . PHP_EOL .
				'		Price: ' . PHP_EOL .
				'	</td>' . PHP_EOL .
				'</tr>' . PHP_EOL;
			while ($order_row = mysqli_fetch_assoc($order_items_query)) {
				$orderTotal += $order_row['price']*$order_row['quantity']; 
				$headerHTML =
					'<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
					'		Ordered date:' . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
					'		' . date("F j, Y, H:i A", strtotime($order_header['order_date'])) . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL;

				$orderTotalHTML =
					'<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
					'		Total: ' . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
					'		$' . $orderTotal . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL;
                                $statusHTML = 
                                        '<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
					'		Status:' . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
					'		' . getStatus($con, $order_header) . PHP_EOL .
//                                        '' . $status_info . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL .
                                        '<form method="post" action="?section=reviewUpdate">' . PHP_EOL .
                                        'Submit for <input type="submit" name="statusCode" value="Pending">' . PHP_EOL .
                                        '</p>' . PHP_EOL .
                                        '<input type="hidden" name="order_id" value="'.$order_header['order_id'].'" />' . PHP_EOL .
                                        '<input type="hidden" name="return_url" value="'.$current_url.'" />' . PHP_EOL .
                                        '</form>' . PHP_EOL;
                                
				$orderIdHTML =
					'<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
					'		Order ID:' . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
					'		' . $order_header['order_id'] . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL;

                                $customerName =
                                        '<table width="100%">' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td class="fieldLabel">' . PHP_EOL .
                                        '		Order for: ' . PHP_EOL .
                                        '	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'<tr>' . PHP_EOL .
					'	<td>' . PHP_EOL .
                        		'		' . $customer_info['first_name'] . PHP_EOL .
                        		'		' . $customer_info['last_name'] . PHP_EOL .
                                        '	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL .
					'</table>' . PHP_EOL;
                                
				$lineItems .=
					'<tr>' . PHP_EOL .
					'	<td>'. PHP_EOL .
					'		' . getProductName($con, $order_row['product_id']) . PHP_EOL .
					'	</td>' . PHP_EOL .
                                        '       <td align="center">'. PHP_EOL .
					'		' . $order_row['quantity'] . PHP_EOL .
					'	</td>' . PHP_EOL .
					'	<td align="right">' . PHP_EOL .
					'		$' . $order_row['price'] . PHP_EOL .
					'	</td>' . PHP_EOL .
					'</tr>' . PHP_EOL;
			} // END while ($order_row = mysqli_fetch_assoc($order_items_query))
			$lineItems .= '</table>' . PHP_EOL;
		} // END if ($order_items_query = mysqli_query($con, $order_items_sql))
	echo
		'<table width="100%">' . PHP_EOL .
		'<tr valign="top">' . PHP_EOL .
		'	<td width="25%">' . PHP_EOL .
		'		' . $headerHTML . PHP_EOL .
		'		' . $orderTotalHTML . PHP_EOL .
                '               ' . $statusHTML . PHP_EOL .
		'		' . $orderIdHTML . PHP_EOL .
                '               ' . $customerName . PHP_EOL .
		'	</td>' . PHP_EOL .
		'	<td>' . PHP_EOL .
		'		' . $lineItems . PHP_EOL .
		'	</td>' . PHP_EOL .
		'</tr>' . PHP_EOL .
		'</table>' . PHP_EOL .
		'<hr>' . PHP_EOL;

	} // END foreach ($orders as $order_header)
        }

	function getProductName($con, $productId) {
		$productName = ''; // or, you can put "Product not found" as the default returned value
		$productsSql =
			"SELECT product_name " .
			" FROM products " .
			" WHERE product_id = '$productId' " .
			" LIMIT 1;"; // expecting only one row
		if ($productsResult = mysqli_query($con, $productsSql)) {
			// expecting one row, use IF instead of WHILE
			if ($productRow = mysqli_fetch_assoc($productsResult)) {
				if (!empty($productRow['product_name'])) {
					$productName = $productRow['product_name'];
				} // END if (!empty($productRow['product_name']))
			} // END if ($productRow = mysqli_fetch_assoc)
		} // END if ($productsResult)
		return $productName;
	} // END function getProductName($productId)
        
        function getStatus($con, $order_header){
//            print_r ($order_header);
            $status_info = '';
            $status_sql = 
                "SELECT *" .
                " FROM order_statuses" .
                " WHERE status_id = " . $order_header['status'] . ";";
            if ($status_results = mysqli_query($con, $status_sql)) {
                if ($status_info_row = mysqli_fetch_assoc($status_results)) {
                    $status_info = $status_info_row['status_report'];
                } // END if ($contact_info_row = mysqli_fetch_array($contact_info_results))
            } // END if ($contact_info)
            return $status_info;
        } // END function getStatus($con, $order_header)
        
        mysqli_close($con);
            ?>

        </div> <!-- left -->
        
        </div><!-- id=content -->
		</div><!-- id=shodowl -->
	</div><!-- id=shodowr -->
