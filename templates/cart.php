<!-- A farmers product will be here --><!-- Farmers product to be bought will be here -->
<?php 
    $active = 2;
    include("../middleware/buyer_header.php");
    html($active);
?>

<style>
    div.container{
        height: 80vh;
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
        <div class="col-md-12">
            <a class="btn btn-info mt-2" href="../controllers/payment.php">Buy Now</a>
             <!-- Product Cards Container -->
            <div class="row mt-4">
                

                <?php 
                    $objects->query = "SELECT * FROM orders WHERE status = 'pending' AND buyer_id = '$user_id'";
                    $orders = $objects->query_all();
                    if(count($orders) > 0){
                        foreach($orders as $order){
                            $product_id = $order["product_id"];
                            $objects->query = "SELECT * FROM products WHERE id = '$product_id'";
                            $product = $objects->query_result(); ?>  
                            <!-- Product Card -->
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="../images/products/<?php echo $product["image"];?>" class="card-img-top" alt="Product Image">
                                    <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $product["name"];?></h5>
                                    <p class="card-text">Quantity Ordered: <b><?php echo $order["quantity"];?> kg</b></p>
                                    <h6 class="card-text">Amount Per Kilo: &#8358; <?php echo $product["amount"];?>.00</h6>
                                    </div>
                                    <div class="card-footer">
                                    <center class="px-5">
                                        <button disabled="disabled" class="btn btn-default btn-outline-dark rounded btn-sm"><?php echo $order["total"];?></button> &nbsp; &nbsp;
                                        <button class="btn btn-danger deleteProduct btn-sm" data-id="<?php echo $order["id"];?>">Delete</button>
                                    </center>
                                    </div>
                                </div>
                            </div>

                <?php        }
                    }else{ ?>
                         <div class="col-md-12 mb-3">
                                <div class="card shadow-sm">
                                    <h5 class="text-center py-2">You have no orders yet</h5>
                                </div>
                            </div>
                <?php    }
                ?>
                

                <!-- Repeat the above col-md-4 structure for each product card -->

            </div>
        </div>
    </div>

 
</div>
<?php
   require('../paystack/src/autoload.php');
   use Yabacon\Paystack;
    if(isset($_GET["reference"])){
     
        
        // Set your Paystack secret key
        $secretKey = 'sk_live_58af92d67a993c890713ac20e639ec442169b2ec';
        
        $paystack = new Paystack($secretKey);
        

        // Retrieve the payment callback data
        $paymentCallback = $paystack->transaction->verify([
            'reference' => $_GET['reference'], // Get the reference from the query parameters
        ]);
        
        // Check if the payment was successful
        if ($paymentCallback->data->status === 'success') {
            // Payment successful, update your database or perform necessary actions
            $objects->query = "SELECT * FROM orders WHERE buyer_id = '$user_id' AND status = 'pending'";
            $order = $objects->query_result();
            $farmer_id = $order["farmer_id"];
            $amount_paid = $paymentCallback->data->amount;
            $objects->query = "SELECT * FROM users WHERE id = '$farmer_id'";
            $farmer = $objects->query_result();
            $farmer_balance = $farmer["balance"];
            $new_balance = $farmer_balance + $amount_paid;
            $objects->query = "UPDATE user SET balance = '$new_balance' WHERE id = '$farmer_id'";
            if($objects->execute_query()){
                $objects->query = "UPDATE orders SET status = 'completed' WHERE (buyer_id = '$farmer_id' AND status='pending') AND (farmer_id = '$farmer_id')";
                if($objects->execute_query()){
                    echo "<script>alert('Payment was successful')</script>";
                }
            }

        } else {
            // Payment failed, handle accordingly
            echo 'Payment failed: ' . $paymentCallback->data->gateway_response;
        }
    }
    
?>
<?php include("../middleware/footer.php");?>