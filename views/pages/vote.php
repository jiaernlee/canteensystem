<?php
    $title = "Vote";
    function get_content(){
        require_once '../../controllers/connection.php';

        if (!isset($_SESSION['user_info']['voted'])) {
            $_SESSION['user_info']['voted'] = false;
        }

        $user_id = $_SESSION['user_info']['id'];
?>

<link rel="stylesheet" href="../../css/dashboard.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="d-flex container row mx-auto w-100">
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
WHERE menus.menu_date = CURDATE();";

$result = mysqli_query($cn, $query);
$menus = mysqli_fetch_all($result, MYSQLI_ASSOC);

if($menus && isset($_SESSION['user_info']) && !$_SESSION['user_info']['isAdmin']):
?>
<div class="dashboard-section container mx-auto d-flex flex-column justify-content-center align-items-center my-5 p-5" style="height:80vh;">
<h1>Vote is closed</h1>
<a href="home.php" class="btn btn-outline-primary">Go to order</a>
</div>
<?php else:
?>
<div class=" mt-5 dashboard-section">

<h1><?php echo date("Y-m-d")?> 's Vote </h1>
<div class="d-flex <?php echo $_SESSION['user_info']['isAdmin'] ? "home-menu" : "" ?> ">
<?php
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($cn, $category_query);
$categories = mysqli_fetch_all($category_result, MYSQLI_ASSOC);

foreach ($categories as $category):
    $category_id = $category['id'];
    $category_name = $category['name'];

    $food_query = "SELECT foods.id AS food_id, foods.name, foods.price, foods.description, foods.image
    FROM foods
    WHERE category_id = $category_id AND isActive = 1;
    ";
    $food_result = mysqli_query($cn, $food_query);
    $foods = mysqli_fetch_all($food_result, MYSQLI_ASSOC);


    $check_query = "SELECT id FROM votes WHERE user_id = $user_id AND category_id = $category_id AND vote_date = CURDATE()";
    $check_result = mysqli_query($cn, $check_query);
    $has_voted = mysqli_fetch_assoc($check_result);
    $vote_id = $has_voted ? $has_voted['id'] : null;
?>
<div class="dashboard-section p-5 col-md-4">
    <form action="" method="POST" id="poll_form_<?php echo $category_id?>" data-id="<?php echo $category_id?>" data-user-id="<?php echo $user_id?>" data-vote-id="<?php echo $vote_id?>">
        <h2 class="px-4"><b><?php echo $category_name; ?> vote</b></h2>
        <div class="radio p-4">
            <?php foreach($foods as $food): ?>
            <label><h6><input type="radio" name="poll_option_<?php echo $category_id?>" class="poll_option" value="<?php echo $food['name']?>">  <?php echo $food['name']?>, RM<?php echo $food['price']?></h6></label>
            <?php if(isset($_SESSION['user_info']) && $_SESSION['user_info']['isAdmin']):?>
            <a class="btn btn-outline-danger" href="../../controllers/votes/actions.php?id=<?php echo $food['food_id']?>&a=0&cat=<?php echo $category_id?>">x</a>
            <?php endif;?>
            <br>
            <small>  **<?php echo $food['description']?></small>
            <br>
            <img src="<?php echo $food['image']?>" class="img-fluid mb-5" style="height: 200px;"/>
            <?php endforeach;?>
        </div>
        <?php if(! $has_voted && ! $_SESSION['user_info']['isAdmin']):?>
        <button class="btn btn-outline-success voting" type="submit" data-vote="not_voted">Vote</button>
        <?php elseif($has_voted && ! $_SESSION['user_info']['isAdmin']): ?>
        <button class="btn btn-outline-warning edit-voting" type="submit" data-vote="voted">Edit Vote</button>
        <?php else:?>
        <!-- <a class="btn btn-outline-warning" href="#">Post</a> -->
        <a class="btn btn-outline-danger" href="../../controllers/votes/clear.php?cat=<?php echo $category_id?>">Clear</a>
        <?php endif;?>
    </form>
</div>
<?php endforeach; 
?>
</div>
</div>
</div>

<?php if(isset($_SESSION['user_info']) && $_SESSION['user_info']['isAdmin']):?>
<div class="my-5 row container mx-auto">
    <h4 class="dashboard-section">Poll Result</h4>
    <?php foreach ($categories as $category): ?>
        <div class="dashboard-section col-md-4">
            <h6><?php echo $category['name']; ?></h6>
            <canvas id="chart_<?php echo $category['id']; ?>"></canvas>
            <?php
            $category_id = $category['id'];
            $result_query = " SELECT 
            foods.name, 
            foods.price, 
            foods.description, 
            foods.image, 
            COUNT(votes.id) AS vote_count
            FROM foods 
            LEFT JOIN votes 
            ON foods.id = votes.food_id
            WHERE foods.category_id = $category_id  AND foods.isActive = 1 AND votes.vote_date = CURDATE()
            GROUP BY foods.id
            ";
            $result_result = mysqli_query($cn, $result_query);
            $results = mysqli_fetch_all($result_result, MYSQLI_ASSOC);
            $labels = [];
            $data = [];
            foreach ($results as $result) {
                $labels[] = $result['name'];
                $data[] = $result['vote_count'];
            }
            ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var ctx = document.getElementById('chart_<?php echo $category['id']; ?>').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar', 
                            data: {
                                labels: <?php echo json_encode($labels); ?>,
                                datasets: [{
                                    label: 'Votes',
                                    data: <?php echo json_encode($data); ?>,
                                    backgroundColor: 'rgba(86, 141, 51, 0.5)',
                                    borderColor: 'rgba(86, 141, 51, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                </script>
        </div>
    <?php endforeach; ?>
</div>

<div class="container dashboard-section row mx-auto mb-5">
<div>
    <form action="/controllers/menus/insert.php" method="POST">
        <div class="d-flex row">
        <?php  
            $category_query = "SELECT * FROM categories";
            $category_result = mysqli_query($cn, $category_query);
            $categories = mysqli_fetch_all($category_result, MYSQLI_ASSOC);
            
            foreach ($categories as $category):
                $category_id = $category['id'];
                $category_name = $category['name'];

                $result_query = " SELECT 
                foods.name, 
                foods.id,
                COUNT(votes.id) AS vote_count
                FROM foods 
                LEFT JOIN votes ON foods.id = votes.food_id
                WHERE foods.category_id = $category_id AND foods.isActive = 1
                GROUP BY foods.id
                ORDER BY vote_count DESC
                LIMIT 3
                ";
                $result_result = mysqli_query($cn, $result_query);
                $results = mysqli_fetch_all($result_result, MYSQLI_ASSOC);
                
                // var_dump($results)
                
        ?>
            <div class="dashboard-section col-md-4">
                <h6>Top 3 Results for <?php echo $category_name?></h6>
                <hr>
                <ul class="d-flex row">
                    <?php if (!empty($results)) : 
                        foreach ($results as $i => $result) : ?>
                            <li>
                                <?php //var_dump($result); echo $i;?>
                                <h6><?php echo $result['name'] ?></h6>
                                <input type="hidden" name="category_<?php echo $category_id ?>_food_<?php echo $i + 1 ?>" value="<?php echo $result['id'] ?>">
                            </li>
                        <?php endforeach; 
                    endif; ?>
                </ul>
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="menu_date" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="d-flex w-100">
        <button type="submit" class="btn btn-outline-success w-100">Post</button>
        </div>
    </form>
</div>
<?php endif;?>
<?php endif;?>
</div>

<?php 
}
    require_once '../template/layout.php'
?>

<script>
document.querySelectorAll('form[id^="poll_form_"]').forEach(form => {
    form.addEventListener('submit', function(event){
        event.preventDefault();

        let formId = form.getAttribute('data-id');
        let userId = form.getAttribute('data-user-id');
        let options = document.getElementsByName('poll_option_' + formId);
        let selectedOption = null;

        for(let option of options){
            if(option.checked){
                selectedOption = option.value;
                break;
            }
        }

        let voteStatus = form.querySelector('button').getAttribute('data-vote');
        if (voteStatus === 'voted') {
            let voteId = form.getAttribute('data-vote-id');
            window.location.href = '/controllers/votes/edit.php?v=' + voteId + '&f=' + formId + '&n=' + selectedOption + '&u=' + userId;
        } else {
            window.location.href = '/controllers/votes/vote.php?f=' + formId + '&n=' + selectedOption + '&u=' + userId;
        }
    });
});
</script>
