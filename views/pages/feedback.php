<?php
$title = "Feedbacks";
function get_content(){
  require_once '../../controllers/connection.php';

  $query = "SELECT * FROM feedbacks ORDER BY id DESC ";
  $result = mysqli_query($cn, $query);
  $feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);

  $product_satisfaction = [0, 0, 0, 0, 0]; 
  $service_satisfaction = [0, 0, 0, 0, 0];
  $team_satisfaction = [0, 0, 0, 0, 0];

  foreach ($feedbacks as $feedback) {
    $product_satisfaction[$feedback['product_satisfaction'] - 1]++;
    $service_satisfaction[$feedback['service_satisfaction'] - 1]++;
    $team_satisfaction[$feedback['team_satisfaction'] - 1]++;
  }
?>
<link rel="stylesheet" href="../../css/dashboard.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<h1 class="container py-4">View feedbacks here</h1>

<div class="dashboard-section container py-3 mb-4 d-flex row mx-auto" style="height:70vh; overflow-y: scroll;">
<div class="col-md-8 row mx-auto d-flex  justify-content-center align-items-center gap-2 py-4 ">
  <div class="col-5 border p-3">
    <canvas id="productChart">
    </canvas>
  </div>
  <div class="col-5 border p-3">
    <canvas id="serviceChart">
    </canvas>
  </div>
  <div class="col-5 border p-3">
    <canvas id="teamChart">
    </canvas>
  </div>
</div>

<div class="col-md-4 container mx-auto d-flex align-items-start flex-column p-3 gap-3">
  <?php foreach($feedbacks as $feedback):
    $user_id= $feedback['user_id'] ;
    $user_query = "SELECT username FROM users WHERE id = $user_id";
    $user_result = mysqli_query($cn, $user_query);
    $user = mysqli_fetch_array($user_result, MYSQLI_ASSOC);
  ?>
  <div class="d-flex flex-column justify-content-center align-items-start comments">
  <h6 class="pt-2"><i><?php echo $user['username']?> :</i></h6>
  <p><?php echo $feedback['improvement_suggestions']?></p>
  </div>
  <?php endforeach;?>
</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {

    let productCtx = document.getElementById('productChart');
    new Chart(productCtx, {
      type: 'pie',
      data: {
        labels: ['Very Unsatisfied', 'Unsatisfied', 'Neutral', 'Satisfied', 'Very Satisfied'],
        datasets: [{
          label: 'Product Satisfaction',
          data: <?php echo json_encode($product_satisfaction); ?>,
          backgroundColor: [
            'rgba(255, 0, 0, 0.5)', // Red
            'rgba(255, 165, 0, 0.5)', // Orange
            'rgba(255, 255, 0, 0.5)', // Yellow
            'rgba(0, 255, 0, 0.5)', // Lime
            'rgba(0, 0, 255, 0.5)' // Blue
          ],
          borderColor: [
            'rgba(255, 0, 0, 1)', // Red
            'rgba(255, 165, 0, 1)', // Orange
            'rgba(255, 255, 0, 1)', // Yellow
            'rgba(0, 255, 0, 1)', // Lime
            'rgba(0, 0, 255, 1)' // Blue
          ],
          borderWidth: 1
        }]
      },
      options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Product Satisfaction'
            }
          }
        }
    });

    let serviceCtx = document.getElementById('serviceChart');
    new Chart(serviceCtx, {
      type: 'pie',
      data: {
        labels: ['Very Unsatisfied', 'Unsatisfied', 'Neutral', 'Satisfied', 'Very Satisfied'],
        datasets: [{
          data: <?php echo json_encode($service_satisfaction); ?>,
          backgroundColor: [
            'rgba(255, 0, 0, 0.5)',
            'rgba(255, 165, 0, 0.5)', 
            'rgba(255, 255, 0, 0.5)', 
            'rgba(0, 255, 0, 0.5)', 
            'rgba(0, 0, 255, 0.5)' 
          ],
          borderColor: [
            'rgba(255, 0, 0, 1)', 
            'rgba(255, 165, 0, 1)', 
            'rgba(255, 255, 0, 1)', 
            'rgba(0, 255, 0, 1)',
            'rgba(0, 0, 255, 1)' 
          ],
          borderWidth: 1
        }]},
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Service Satisfaction'
            }
          }
        }
    });

    let teamCtx = document.getElementById('teamChart');
    new Chart(teamCtx, {
      type: 'pie',
      data: {
        labels: ['Very Unsatisfied', 'Unsatisfied', 'Neutral', 'Satisfied', 'Very Satisfied'],
        datasets: [{
          label: 'Team Satisfaction',
          data: <?php echo json_encode($team_satisfaction); ?>,
          backgroundColor: [
            'rgba(255, 0, 0, 0.5)', 
            'rgba(255, 165, 0, 0.5)', 
            'rgba(255, 255, 0, 0.5)', 
            'rgba(0, 255, 0, 0.5)',
            'rgba(0, 0, 255, 0.5)'           
          ],
          borderColor: [
            'rgba(255, 0, 0, 1)', 
            'rgba(255, 165, 0, 1)', 
            'rgba(255, 255, 0, 1)', 
            'rgba(0, 255, 0, 1)', 
            'rgba(0, 0, 255, 1)' 
          ],
          borderWidth: 1
        }]
      },
      options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Team Satisfaction'
            }
          }
        }
    });
  });
</script>

</div>

<?php
}
require_once '../template/layout.php';
?>
