<nav class="navbar navbar-expand-lg bg-blur">
  <div class="container-fluid gap-5">
  <?php if (isset($_SESSION['user_info'])):?>
    <a class="navbar-brand" href="/views/pages/<?php echo $_SESSION['user_info']['isAdmin'] ? "dashboard" : "home" ?>.php"><?php echo isset($_SESSION['user_info'])? "Home" : ""?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">   
        <?php if(isset($_SESSION['user_info']) && !$_SESSION['user_info']['isAdmin']):?>     
        <a class="nav-link" href="/views/pages/home.php">Home</a>
        <a class="nav-link" href="/views/pages/my_orders.php">My orders</a>
        <?php endif?>

        <?php if(isset($_SESSION['user_info']) && $_SESSION['user_info']['isAdmin']):?>
        <a class="nav-link" href="/views/pages/dashboard.php">Dashboard</a>
        <a class="nav-link" href="/views/pages/add_food.php">Add Food</a>
        <?php endif?>

        <a class="nav-link" href="/views/pages/vote.php">Vote</a>

        <?php if(isset($_SESSION['user_info']) && $_SESSION['user_info']['isAdmin']):?>
        <a class="nav-link" href="/views/pages/feedback.php">Feedbacks</a>
        <?php endif?>

        <a class="nav-link" href="/controllers/users/process_logout.php">Logout</a>        
      </div>
    </div>
    <?php endif;?>
  </div>
</nav>