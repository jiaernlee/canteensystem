<footer class="bg-dark text-white text-center py-3 d-flex  justify-content-center align-items-center">       
    <small>&copy;JiaErn2024 For educational purposes only <?php echo isset($_SESSION['user_info']) && ! $_SESSION['user_info']['isAdmin'] ? " | <i>Feedbacks? <a data-bs-toggle='offcanvas' href='#offcanvasExample' role='button' aria-controls='offcanvasExample'>Tell us</a></i>" : "" ?></small> 
</footer>

<div class="offcanvas offcanvas-start " tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title" id="offcanvasExampleLabel">Feedback Form</h3>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="alert alert-primary">
        <h4>We value your feedback.</h4>
        <p>Please complete the following form and help us improve our customer experience. <br> <small><i>scale 1 to 5, from least to most satisfied</i></small></p>
    </div>
    <form action="/controllers/feedbacks/submit.php" method="post" class="alert alert-light">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_info']['id']?>">
        <div class="form-group mb-3">
            <label class="text-primary">How satisfied are you with our <mark>product</mark>?</label>
            <div class="radio-group">
                <label><input type="radio" name="product_satisfaction" value="1"> 1</label>
                <label><input type="radio" name="product_satisfaction" value="2"> 2</label>
                <label><input type="radio" name="product_satisfaction" value="3"> 3</label>
                <label><input type="radio" name="product_satisfaction" value="4"> 4</label>
                <label><input type="radio" name="product_satisfaction" value="5"> 5</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="text-primary">How satisfied are you with our <mark>service</mark>?</label>
            <div class="radio-group">
                <label><input type="radio" name="service_satisfaction" value="1"> 1</label>
                <label><input type="radio" name="service_satisfaction" value="2"> 2</label>
                <label><input type="radio" name="service_satisfaction" value="3"> 3</label>
                <label><input type="radio" name="service_satisfaction" value="4"> 4</label>
                <label><input type="radio" name="service_satisfaction" value="5"> 5</label>
            </div>
        </div>

        <div class="form-group mb-3 ">
            <label class="text-primary">How satisfied are you with our <mark>team</mark>?</label>
            <div class="radio-group">
                <label><input type="radio" name="team_satisfaction" value="1"> 1</label>
                <label><input type="radio" name="team_satisfaction" value="2"> 2</label>
                <label><input type="radio" name="team_satisfaction" value="3"> 3</label>
                <label><input type="radio" name="team_satisfaction" value="4"> 4</label>
                <label><input type="radio" name="team_satisfaction" value="5"> 5</label>
            </div>
        </div>

        <div class="form-group mb-3">
            <label>Tell us how we can improve</label>
            <textarea name="improvement_suggestions" rows="5" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-outline-primary">Submit</button>
    </form>
  </div>
</div>