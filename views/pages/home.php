<?php
    $title = "Dashboard";
    function get_content(){
        require_once '../../controllers/connection.php';
        
        if(isset($_GET['id']) && isset($_GET['qt'])){
            $_SESSION['cart'][$_GET['id']] = $_GET['qt'];
            // header("Location: /views/pages/home.php");
        }
?>
<head>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<div class="container my-5">
    <h1>Welcome, <?php echo $_SESSION['user_info']['username'] ?></h1>
</div>
<?php
    $query = "SELECT categories.name AS category_name, 
    foods1.id AS food_id_1, foods1.name AS food_name_1, foods1.image AS food_image_1, foods1.price AS food_price_1, foods1.description AS food_description_1,
    foods2.id AS food_id_2, foods2.name AS food_name_2, foods2.image AS food_image_2, foods2.price AS food_price_2, foods2.description AS food_description_2,
    foods3.id AS food_id_3, foods3.name AS food_name_3, foods3.image AS food_image_3, foods3.price AS food_price_3, foods3.description AS food_description_3
    FROM menus
    JOIN categories ON menus.category_id = categories.id
    LEFT JOIN foods AS foods1 ON menus.food_id_1 = foods1.id
    LEFT JOIN foods AS foods2 ON menus.food_id_2 = foods2.id
    LEFT JOIN foods AS foods3 ON menus.food_id_3 = foods3.id
    WHERE menus.menu_date = CURDATE();";

    $result = mysqli_query($cn, $query);
    $menus = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<div class="my-5">
    <div class="mx-auto row w-100 container">
        <div class="col-md-6 d-flex flex-column dashboard-section home-menu">
            <?php if($menus) : 
                 $date = new DateTime();
                 $date->modify('+1 day');
                 $next_day_date = $date->format('Y-m-d');
            ?>
                <div>
                <h4><?php echo $next_day_date?> 's Menu</h4>
                <?php foreach ($menus as $menu): ?>   
                <div class="dashboard-section row mx-auto ">
                    <h6><?php echo  $menu['category_name'] ; ?></h6>
                    <hr>
                    <?php for ($i = 1; $i < 4; $i++):
                        $food_id = 'food_id_' . $i ;
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
                            <form action="/controllers/cart/add.php" class="d-flex my-2" method="POST">
                                <input type="hidden"  name="id" value="<?php echo $menu[$food_id]?>">
                                <input type="number" placeholder="Amount" style="border-radius: 5px; " class="form-control" name="quantity">
                                <button type="submit" class="btn btn-outline-success">Order</button>
                            </form>
                        </div>
                        <?php endif;?>
                    <?php endfor; ?>
                </div>
                <br>
                <?php endforeach; ?>
                 </div>
            <?php else:?>
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
            <h1>Oops, no menu yet.</h1>
            <a class="btn btn-outline-danger" href="vote.php">Vote now</a>
            </div>
            <?php endif;?>
        </div>
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center dashboard-section">
            <?php
            if (isset($_SESSION['cart'])) {
                $cart_items = $_SESSION['cart'];
                $food_ids = array_keys($cart_items);
            
                $query = "SELECT * FROM foods WHERE id IN (" . implode(',', $food_ids) . ")";
                $result = mysqli_query($cn, $query);
                $foods = mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
            ?>
            <?php if (!empty($foods)): ?>
                <h2 class="py-4">My Cart</h2>
                <table class="table table-responsive table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $total = 0;
                            foreach ($foods as $food): 
                                $food_id = $food['id'];
                                $quantity = $cart_items[$food_id];
                                $subtotal = $food['price'] * $quantity;
                                $total += $subtotal;
                        ?>
                        <tr>
                            <td><a href="/controllers/cart/delete.php?id=<?php echo $food_id?>" class="btn btn-outline-danger remove">X</a></td>
                            <td><?php echo $food['name']; ?></td>
                            <td class="price"><?php echo $food['price']; ?></td>
                            <td>
                                <form action="">
                                    <input class="form-control quantity_form" type="number" value="<?php echo $quantity?>" name="quantity" data-id="<?php echo $food_id?>">
                                </form>
                            </td>
                            <td class="subtotal"><?php echo $subtotal; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>
                                <a href="/controllers/cart/empty.php" class="btn btn-outline-danger">Empty Cart</a>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-outline-success" id="checkoutBtn">
                                    Checkout
                                </button>
                            </td>
                            <td class="fw-bold" id="total"><?php echo $total; ?></td>
                        </tr>
                    <tbody>
                </table>
            <?php else: ?>
                <h1 class="text-center">Cart is empty.</h1>
            <?php endif; ?>           
        </div>
    </div>
</div>

<?php
}
require_once '../template/layout.php';
?>

<script>

    document.getElementById("checkoutBtn").addEventListener("click", function(){
        let total = document.getElementById("total").innerHTML;

        if(confirm(`Are you sure to checkout with total price ${total} ?`)){
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/controllers/orders/checkout.php';

            let inputTotal = document.createElement('input');
            inputTotal.type = 'hidden';
            inputTotal.name = 'total';
            inputTotal.value = total;

            form.appendChild(inputTotal);
            document.body.appendChild(form);
            form.submit();
            alert(`Your order has been submitted`)
        }
    })

    let quantities = document.querySelectorAll(".quantity_form");
    let removes = document.querySelectorAll(".remove");
    let delURL = [];

    removes.forEach(function(remove){
        delURL.push(remove.getAttribute("href"))
    });

    quantities.forEach(function(quantity_form, i) {
    quantity_form.addEventListener("input", function(event) {
        let quantity = quantity_form.value;
        let id = quantity_form.getAttribute("data-id");
        if(quantity<1){
            if(confirm("Are you sure you want to remove this item?")==true){
                window.location.href = delURL[i];
            } else quantity_form.value = 1 ;
        }
        else{
            window.location.href = "/views/pages/home.php?qt=" + quantity + "&id=" + id ;
        }
    
    })});

</script>
