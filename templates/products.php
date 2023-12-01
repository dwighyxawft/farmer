<?php 
    $active = 2;
    include("../middleware/auth_header.php");
    html($active);
?>

<style>
    div.container{
        min-height: 80vh;
    }
</style>






<div class="container mt-5">
  <!-- Upload Product Button -->

  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadProductModal">Upload Product</button>

  <!-- Upload Product Modal -->
  <div class="modal" tabindex="-1" role="dialog" id="uploadProductModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Upload Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Withdrawal Form Fields -->
            <form action="../controllers/product.php" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <strong><label for="image">Product Image</label></strong>
                <input type="file" class="form-control" name="image" accept="image/*" required>
            </div>
            <div class="form-group mb-3">
                <strong><label for="name">Product Name</label></strong>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group mb-3">
                <strong><label for="quantity">Qunatity in Kilos </label></strong>
                <input type="number" class="form-control" name="quantity" required>
            </div>
            <div class="form-group mb-3">
                <strong><label for="amount">Amount Per Kilo</label></strong>
                <input type="number" name="amount" id="" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        </div>
    </div>
  </div>

  <!-- Search Form -->
 

  <!-- Product Cards Container -->
  <div class="row mt-4">
    <?php
      $objects->query = "SELECT * FROM products WHERE farmer_id = '$user_id'";
      if($objects->total_rows() > 0){
        $products = $objects->query_all();
        foreach($products as $product){ ?>
          <div class="col-md-3 mb-3">
            <!-- Product Card -->
            <div class="card">
              <img src="../images/products/<?php echo $product["image"]; ?>" class="card-img-top" alt="Product Image">
              <div class="card-body text-center">
                <h5 class="card-title"><?php echo $product["name"]; ?></h5>
                <p class="card-text">Quantity Available: <?php echo $product["quantity"]; ?> kg</p>
                <p class="card-text">Amount: &#8358; <?php echo $product["amount"]; ?>.00</p>
              </div>
              <div class="card-footer">
                <center><button type="button" class="btn btn-danger deleteProduct" data-id="<?php echo $product["id"]; ?>">Delete</button></center>
              </div>
            </div>
          </div>
     <?php   }
      }else{ ?>
              <div class="col-md-12 mb-3">
                <!-- Product Card -->
                <div class="card shadow-sm py-2">
                    <center><h4>You have not uploaded any product for sale</h4></center>
                </div>
              </div>
    <?php  }
    ?>
    

    

    <!-- Repeat the above col-md-3 structure for each product card -->

  </div>
</div>
<script>
  var deletes = document.querySelectorAll(".deleteProduct");
  deletes.forEach(function(delete){
    delete.addEventListener("click", function(){
      var id = delete.getAttribute("data-id");
      $.ajax({
        url: "../controllers/ajax.php",
        type: "post",
        data: {page: "user", action: "delete_product", id: id},
        dataType: "json",
        success: function(data){
          if(data.status){
            delete.parentNode.parentNode.parentNode.addClass("d-none");
          }
        }
      })
    })
  })
</script>
<?php include("../middleware/footer.php");?>