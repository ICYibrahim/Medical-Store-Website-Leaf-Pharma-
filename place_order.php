<?php
include("userfunction/myfunction.php");
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$form = $_POST['form'];
$cart = $_POST['cart'];

// 1️⃣ Convert form
$form_data = [];
foreach ($form as $field) {
  $form_data[$field['name']] = $field['value'];
}
$_SESSION['delivery_charge'] = 250;
$delivery_charge = $_SESSION['delivery_charge'];

$firstname = $form_data['firstname'];
$lastname = $form_data['lastname'];
$address = $form_data['address'];
$phone = $form_data['phonenumber'];
$email = $form_data['email'];
$payment_method = $form_data['payment_method'];
$city = $form_data['city'];
$monument = $form_data['monument'];

// 2️⃣ Calculate total
$subtotal_amount = 0;
foreach ($cart as $item) {
  $subtotal_amount += $item['ProductPrice'] * $item['Quantity'];
}
$grand_total = $subtotal_amount + $delivery_charge;

// 3️⃣ Insert order with prepared statement
$customer_name = $firstname . " " . $lastname;
$full_address = $address . ", " . $city . ", Near " . $monument;

$order_id = placeorder($grand_total, $payment_method, $full_address, $phone, $email, $customer_name, 'tbl_orders');

if ($order_id) {
    // 4️⃣ Insert each item and prepare items array for confirmation
    $purchased_items = []; // Array to store all purchased items
    
    foreach ($cart as $item) {
      $product_id = $item['ProductCode'];
      $product_name = $item['ProductName'];
      $quantity = $item['Quantity'];
      $unit_price = $item['ProductPrice'];
      $S_product_total_price = $quantity * $unit_price;

      insertOrderItem($cartID, $order_id, $product_id, $product_name, $quantity, $unit_price, $S_product_total_price, $subtotal_amount, $delivery_charge, $grand_total, 'tbl_order_items');
      
      // Add item to purchased items array
      $purchased_items[] = [
          'product_name' => $product_name,
          'quantity' => $quantity,
          'unit_price' => $unit_price,
          'item_total' => $S_product_total_price
      ];
    }

    // ✅ Empty cart ONCE
    $conn->query("DELETE FROM tbl_cart WHERE cartID = '$cartID'");
    
    // 🎉 STORE CONFIRMATION IN SESSION (WITH ITEMS)
    $_SESSION['order_confirmation'] = [
        'order_id' => $order_id,
        'customer_name' => $customer_name,
        'total_amount' => $grand_total,
        'subtotal_amount' => $subtotal_amount,
        'delivery_charge' => $delivery_charge,
        'email' => $email,
        'phone' => $phone,
        'address' => $full_address,
        'payment_method' => $payment_method,
        'purchased_items' => $purchased_items, // Include all items here
        'order_date' => date('Y-m-d H:i:s') // Add order timestamp
    ];
    
    // ✅ Return JSON response for AJAX
    echo json_encode([
        'status' => 'success',
        'order_id' => $order_id,
        'message' => 'Order placed successfully!',
        'redirect_url' => 'order-confirmation.php' // Optional: specify redirect URL
    ]);
    
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to place order'
    ]);
}