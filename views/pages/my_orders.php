<?php
    $title = 'My Orders';
    function get_content(){
        require_once '../../controllers/connection.php';
        $user_id = $_SESSION['user_info']['id'];

        $selected_date = isset($_POST['menu_date']) ? $_POST['menu_date'] : date('Y-m-d');

        $date = new DateTime($selected_date);
        $date->modify('+1 day');
        $next_day_date = $date->format('Y-m-d');
?>

<head>
    <link rel="stylesheet" href="../../css/receipt.css">
</head>

<div class="container">
    <form method="post" class="my-3">
        <label for="menu_date">Select Date:</label>
        <input type="date" id="menu_date" name="menu_date" value="<?php echo $selected_date; ?>" class="form-control" style="width: auto; display: inline-block; border: 1px solid #ECB819; border-radius: 10px; padding:5px;">
        <button type="submit" class="btn btn-outline-primary">View receipt</button>
    </form>

    <?php

    $query = "SELECT orders.id, orders.total, orders.purchase_date, 
    foods.name AS name, foods.price AS price, product_orders.quantity 
    FROM product_orders
    JOIN orders on product_orders.order_id = orders.id
    JOIN foods on product_orders.food_id = foods.id
    WHERE orders.user_id = $user_id AND orders.purchase_date = '$selected_date'"; 

    $result = mysqli_query($cn, $query);
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $grouped_orders = [];
    foreach ($orders as $order) {
        $order_id = $order['id'];
        if (!isset($grouped_orders[$order_id])) {
            $grouped_orders[$order_id] = [
                'total' => $order['total'],
                'purchase_date' => $order['purchase_date'],
                'items' => []
            ];
        }
        $grouped_orders[$order_id]['items'][] = [
            'name' => $order['name'],
            'price' => $order['price'],
            'quantity' => $order['quantity']
        ];
    }
    // var_dump($grouped_orders)
    ?>

    <div class="d-flex justify-content-center align-items-center flex-column">
        <?php if(empty($grouped_orders)): ?>
            <div class="alert alert-warning my-5">No orders found.</div>
        <?php else: ?>
            <?php foreach($grouped_orders as $order_id => $order_data): ?>
            <div class="receipt border border-dashed p-4 bg-white rounded-3 shadow mb-4">
                <div class="receipt-header text-center mb-4">
                    <h4 class="pt-2">YOUR CANTEEN</h4>
                    <p class="mb-1"><small>123 Street, XXX, XXXXX</small></p>
                    <p class="mb-1"><small>Phone: (+60) 123-4567</small></p>
                    <p class="mb-0"><small>Ordered Date: <?php echo $order_data['purchase_date']?></small></p>
                    <p class="mb-0"><small>Get food by: <?php echo $next_day_date?></small></p>
                </div>
                <div class="receipt-body text-center mb-4">
                    <h5 class="border-bottom pb-2 mb-4">Receipt</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($order_data['items'] as $item): ?>
                            <tr>
                                <td><small><?php echo $item['name']; ?></small></td>
                                <td><small><?php echo $item['quantity']; ?></small></td>
                                <td><small>RM<?php echo $item['price']; ?></small></td>
                                <td><small>RM<?php echo intval($item['price']) * intval($item['quantity']); ?></small></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="receipt-footer text-center">
                    <h3 class="h6 fw-bold">Total: RM<?php echo $order_data['total']; ?></h3>
                    <p class="pt-3">Thank you for ordering</p>
                </div>
                <small><i><a href="/controllers/orders/delete.php?id=<?php echo $order_id; ?>" >Delete order</a></i></small>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<?php
    }
    require_once '../template/layout.php';
?>
