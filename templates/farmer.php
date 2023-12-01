<?php 
    $active = 2;
    include("../middleware/buyer_header.php");
    html($active);
?>

<style>
    div.container{
        min-height: 80vh;
    }
</style>






<div class="container mt-5">

  
 

  <!-- Product Cards Container -->
  <div class="row mt-4">
   <?php
   $objects->query = "SELECT * FROM users WHERE type = 'farmer'";
   $farmers = $objects->query_all();
   foreach($farmers as $farmer){ ?>
        <div class="col-md-3 mb-3">
            <!-- Product Card -->
            <div class="card">
                <img src="../images/users/<?php echo $farmer["image"] ?>" class="card-img-top" alt="User Image">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $farmer["username"] ?></h5>
                    <p class="card-text"><?php echo $farmer["email"] ?></p>
                    <p class="card-text"><?php echo $farmer["address"] ?>, <?php echo $farmer["local_govt"] ?>, <?php echo $farmer["state"] ?>, Nigeria</p>
                </div>
                <div class="card-footer">
                    <center><a type="button" href="buyer.php?farmer_id=<?php echo $farmer["id"] ?>" class="btn btn-success">Buy Products</a></center>
                </div>
            </div>
        </div>
   <?php }
   ?>
    

    <!-- Repeat the above col-md-3 structure for each product card -->

  </div>
</div>
<?php include("../middleware/footer.php");?>