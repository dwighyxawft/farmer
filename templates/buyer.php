<!-- Farmers product to be bought will be here -->
<?php 
    $active = 2;
    include("../middleware/buyer_header.php");
    html($active);
    if(!isset($_GET["farmer_id"])){
        echo $objects->redirect("templates/farmer.php");
    }
    $id = $_GET["farmer_id"];
    $objects->query = "SELECT * FROM users WHERE id = '$id'";
    $farmer = $objects->query_result();
    $objects->query = "SELECT * FROM products WHERE farmer_id = '$id'";
    $products = $objects->query_all();
?>

<style>
    div.container{
        height: 90vh;
    }
    .col-md-9 {
      height: 80vh; /* Set the height as needed */
      overflow-y: scroll; /* Enable vertical scrolling */
      scrollbar-width: thin; /* For Firefox */
    }

    .col-md-9::-webkit-scrollbar {
      width: 5px; /* Set the width of the scrollbar */
    }

    .col-md-9::-webkit-scrollbar-thumb {
      background-color: transparent; /* Set the color of the scrollbar thumb */
    }

    .col-md-9::-webkit-scrollbar-track {
      background-color: transparent; /* Set the color of the scrollbar track */
    }
</style>






<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <img src="../images/users/<?php echo $farmer["image"];?>" alt="Farmers Image" class="card-img-top img-fluid rounded-circle">
                </div>
                <div class="card-body">
                    <center>
                        <h4 class="py-3"><?php echo $farmer["username"];?></h4>
                        <h6 class="pb-2"><?php echo $farmer["email"];?></h6>
                        <p class="pb-2"><?php echo $farmer["address"];?>, <?php echo $farmer["local_govt"];?>, <?php echo $farmer["state"];?>, Nigeria</p>
                    </center>
                </div>
                <div class="card-footer">
                    <center><a href="contact.php?user_id=<?php echo $farmer["id"];?>" class="btn btn-primary">Message</a></center>
                </div>
            </div>
        </div>
        <div class="col-md-9">
             <!-- Product Cards Container -->
            <div class="row mt-4">
                <?php
                    if(count($products) > 0){
                        foreach($products as $product){ ?>
                        <div class="col-md-4 mb-3">
                            <!-- Product Card -->
                            <div class="card">
                                <img src="../images/products/<?php echo $product["image"];?>" class="card-img-top" alt="Product Image">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $product["name"];?></h5>
                                    <p class="card-text">Quantity Available: <?php echo $product["quantity"];?> kg</p>
                                    <p class="card-text">Amount: &#8358; <?php echo $product["amount"];?>.00</p>
                                </div>
                                <div class="card-footer">
                                    <center class="px-5">
                                            <form class="product-form" method="post">
                                                <div class="input-group">
                                                    <input type="hidden" name="product_id" value="<?php echo $product["id"];?>">
                                                    <input type="hidden" name="product_name" value="<?php echo $product["name"];?>">
                                                    <input type="hidden" name="product_amount" value="<?php echo $product["amount"];?>">
                                                    <input type="hidden" name="buyer_name" value="<?php echo $user["username"];?>">
                                                    <input type="hidden" name="farmer" value="<?php echo $farmer["id"];?>">
                                                    <input type="number" class="form-control form-control-sm w-25" name="quantity" placeholder="Quantity">
                                                    <input type="hidden" name="page" value="user">
                                                    <input type="hidden" name="action" value="add_product">
                                                    <button type="submit" class="btn-sm btn-success btn"><i class="fa fa-shopping-cart"></i></button>
                                                </div>
                                            </form>
                                    </center>
                                </div>
                            </div>
                        </div>
                <?php    }
                    }
                ?>
                
                
                

                <!-- Repeat the above col-md-4 structure for each product card -->

            </div>
        </div>
    </div>
    
    <script>
        var forms = document.querySelectorAll(".product-form");
        forms.forEach(function(form){
            form.addEventListener("submit", function(e){
                e.preventDefault();
                console.log("submitted")
                $.ajax({
                    url: "../controllers/ajax.php",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(data){
                        if(data.status){
                            alert("The product has been added to the cart");
                        }
                    }
                })
            })
        })
    </script>
 
</div>

<?php include("../middleware/footer.php");?>