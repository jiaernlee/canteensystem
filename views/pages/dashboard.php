<?php
$title = "Dashboard";

function get_content() {
    require_once '../../controllers/connection.php';
    
    $selected_date = isset($_POST['menu_date']) ? $_POST['menu_date'] : date('Y-m-d');

?>
<head>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<div class="container my-5">
    <h1>Welcome, <?php echo $_SESSION['user_info']['username'] ?></h1>
    
    <!-- Date Picker Form -->
    <form method="post" class="my-3">
        <label for="menu_date"></label>
        <input type="date" id="menu_date" name="menu_date" value="<?php echo $selected_date; ?>" style="border: 1px solid #ECB819; border-radius: 10px; padding:5px;">
        <button type="submit" class="btn btn-outline-primary">View Menu</button>
    </form>
</div>

<?php
    $query = "SELECT categories.name AS category_name, 
    foods1.name AS food_name_1, foods1.image AS food_image_1, foods1.price AS food_price_1, foods1.description AS food_description_1,
    foods2.name AS food_name_2, foods2.image AS food_image_2, foods2.price AS food_price_2, foods2.description AS food_description_2,
    foods3.name AS food_name_3, foods3.image AS food_image_3, foods3.price AS food_price_3, foods3.description AS food_description_3
    FROM menus
    JOIN categories ON menus.category_id = categories.id
    LEFT JOIN foods AS foods1 ON menus.food_id_1 = foods1.id
    LEFT JOIN foods AS foods2 ON menus.food_id_2 = foods2.id
    LEFT JOIN foods AS foods3 ON menus.food_id_3 = foods3.id
    WHERE menus.menu_date = '$selected_date';";

    $result = mysqli_query($cn, $query);
    $menus = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="dashboard-section container mb-5">
    <h5>Menu</h5>
    <div class="row">
    <?php if(empty($menus)): ?>
            <div class="alert alert-warning my-5">No menu found.</div>
    <?php else: ?>
        <?php foreach ($menus as $menu): ?>   
        <div class="col-md-4 row mx-auto ">
            <h6><?php echo  $menu['category_name'] ; ?></h6>
            <hr>
            <?php for ($i = 1; $i < 4; $i++):
                $food_name = 'food_name_' . $i;
                $food_image = 'food_image_' . $i;
                $food_price = 'food_price_' . $i;
                $food_desc = 'food_description_' . $i;

                if (!empty($menu[$food_name])): 
            ?>
                <div class="col-md-5 mb-3 foods p-3">
                    <h6><?php echo $menu[$food_name]; ?></h6>
                    <p><small>RM <?php echo  $menu[$food_price]?></small></p>
                    <p><small>** <?php echo  $menu[$food_desc]?></small></p>
                    <img src="<?php echo  $menu[$food_image]?>" alt="" style="width:80px; height:80px">
                </div>
                <?php endif;?>
            <?php endfor; ?>
        </div>
        <?php endforeach; ?>
    <?php endif;?>
    </div>
        
    <?php
    $query = "SELECT foods.id,foods.name, SUM(product_orders.quantity) AS total_quantity
    FROM product_orders
    JOIN orders ON product_orders.order_id = orders.id
    JOIN foods ON product_orders.food_id = foods.id
    WHERE orders.purchase_date = '$selected_date'
    GROUP BY foods.id, foods.name, foods.image, foods.price;"; 
    
    $result = mysqli_query($cn, $query);
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(!empty($orders)):
    ?>

    <div class="row mx-auto mb-5 row-gap-2 p-5">
        <h5>Orders</h5>

        <div class=" dashboard-section p-3">
        <ul class="d-flex row">
            <?php  foreach ($orders as $order) : ?>
                    <li>
                        <h6><?php echo $order['name'] ?> : <span class="fs-4"><?php echo $order['total_quantity']?></span></h6>
                    </li>
            <?php endforeach; ?>
        </ul>
        </div>
    </div>
    <?php endif;?>
</div>

<?php
}
require_once '../template/layout.php';
?>
