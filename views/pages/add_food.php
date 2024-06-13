<?php
$title = "Add food";
function get_content(){
    require_once '../../controllers/connection.php';

    if (isset($_SESSION) && !$_SESSION['user_info']['isAdmin']) {
        header('Location: /views/pages/home.php');
    }

    $query = "SELECT * FROM categories;";
    $cat_result = mysqli_query($cn, $query);
    $categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC); 

    // Check if a category filter is set
    $selected_category = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    // Modify query to filter foods by category if a category is selected
    if ($selected_category) {
        $foods_query = "
            SELECT foods.*, categories.name as category_name 
            FROM foods 
            JOIN categories ON foods.category_id = categories.id
            WHERE foods.category_id = '$selected_category'
        ";
    } else {
        $foods_query = "
            SELECT foods.*, categories.name as category_name 
            FROM foods 
            JOIN categories ON foods.category_id = categories.id
        ";
    }

    $foods_result = mysqli_query($cn, $foods_query);
    $foods = mysqli_fetch_all($foods_result, MYSQLI_ASSOC);
?>
<link rel="stylesheet" href="../../css/dashboard.css">

<div class="container pt-3 pb-5 dashboard-section mb-5 my-md-5">
    <div class="row mx-auto">
        <div class="col-md-8 mx-auto">
            <h1><b>Add</b></h1>

            <form method="POST" action="/controllers/foods/add.php" enctype="multipart/form-data">
                <div class="mb-3 form-floating">
                    <input type="text" name="food_name" class="form-control" placeholder="Food Name" id="floatingInput1"/>
                    <label for="floatingInput1">Food Name</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="number" name="price" class="form-control" placeholder="Price" id="floatingInput2"/>
                    <label for="floatingInput2">Price</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="text" name="description" class="form-control" placeholder="Description" id="floatingInput"/>
                    <label for="floatingInput">Description</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="imge">Image</label>
                    <input type="file" name="image" class="form-control" id="imge"/>
                </div>   
                <div class="mb-3">
                    <label class="form-label" for="category_id">Category</label>
                    <select class="form-select" name="category_id" id="category_id">
                        <option selected disabled>Choose a category</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['id'] ?>">
                                <?php echo $category['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>                         
                <button class="btn btn-outline-primary">Add food +</button>
            </form>
            <br>
            <hr>

            <div class="d-flex mt-5 row gap-2">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h5 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Foods
                    </button>
                    <form method="GET" action="" class=" form-control">
                        <div class="mb-3">
                            <label class="form-label" for="filter_category_id">Filter by Category</label>
                            <select class="form-select" name="category_id" id="filter_category_id" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category['id'] ?>" <?php echo $selected_category == $category['id'] ? 'selected' : '' ?>>
                                        <?php echo $category['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>

                    </h5>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body d-flex overflow-x-scroll gap-2">
                    <?php foreach($foods as $food): ?>
                        <div class="d-flex flex-column col-md-4 p-4 foods justify-content-center">
                            <h6><?php echo $food['name']; ?> | <?php echo $food['category_name']; ?></h6> <!-- Display the category name here -->
                            <p><small><i><?php echo $food['description']?></i></small></p>
                            <img src="<?php echo $food['image']; ?>" class="img-fluid mb-2" style="width: 200px;"/>
                            RM<?php echo $food['price']; ?><br>
                            <div class="align-middle my-2">
                                <a class="btn btn-outline-success ms-3" href="../../controllers/votes/actions.php?id=<?php echo $food['id']?>&a=1&cat=<?php echo $food['category_id']?>" data-toggle="tooltip" data-placement="bottom" title="Add to today's vote option">+</a>    
                                <button class="btn btn-outline-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample-<?php echo $food['id']?>" aria-expanded="false" aria-controls="collapseExample"><i class="bi bi-pencil"></i></button>
                                <a href="/controllers/foods/delete.php?id=<?php echo $food['id']?>" class="btn btn-outline-danger" title="Delete">x</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    </div>
                </div>
            </div>
            <div class="mb-5 mt-3">
            <?php foreach($foods as $food): ?>
                <div class="collapse" id="collapseExample-<?php echo $food['id']?>">
                <div class="card card-body container edit-card">
                    <form method="POST" action="/controllers/foods/update.php" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $food['id']?>" name="food_id">
                        <div class="mb-3 form-floating">
                            <input type="text" name="food_name" class="form-control" placeholder="Food Name" id="floatingInput1" value="<?php echo $food['name']?>"/>
                            <label for="floatingInput1">Food Name</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="number" name="price" class="form-control" placeholder="Price" id="floatingInput2" value="<?php echo $food['price']?>"/>
                            <label for="floatingInput2">Price</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" name="description" class="form-control" placeholder="Description" id="floatingInput" value="<?php echo $food['description']; ?>"/>
                            <label for="floatingInput">Description</label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control"/>
                            <img src="<?php echo $food['image']?>" class="img-fluid" style="height:200px"/>
                        </div>  
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id">
                                <option selected disabled>Choose a category</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category['id'] ?>" <?php echo $food['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                        <?php echo $category['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>                         
                        <button class="btn btn-success">Confirm</button>
                    </form>
                </div>
                </div>
            </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>  
</div>

<?php 
    }   
    require_once '../template/layout.php'
?>
