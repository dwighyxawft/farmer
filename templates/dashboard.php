<?php 
    $active = 1;
    include("../middleware/auth_header.php");
    html($active);
?>

<style>
    div.container{
        min-height: 80vh;
    }
</style>

<main>
<div class="container mt-5">
<div class="row">
    <!-- First div with three col-md-4 columns -->
    <div class="col-md-4 d-flex align-items-stretch">
      <!-- First card with balance -->
      <div class="card flex-fill">
        <div class="card-body">
          <h5 class="card-title">Available Balance</h5>
          <h6 class="card-text pb-2">&#8358;  <?php echo $user["balance"];?>.00</h6>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#withdrawalModal">Withdraw</button>
        </div>
      </div>
    </div>

    <div class="col-md-4 d-flex align-items-stretch">
      <!-- Second card with withdrawal button -->
      <div class="card flex-fill">
        <div class="card-body pt-3">
          <a class="btn btn-success" href="#orderHistory">Order History</a> <br> <br>
          <a class="btn btn-secondary" href="#withdrawalHistory">Withdrawal History</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 d-flex align-items-stretch">
      <!-- Third card with extended text -->
      <div class="card flex-fill">
        <div class="card-body">
          <p>
            Join us in revolutionizing the way farmers and buyers interact, making the journey from farm to table an experience of shared prosperity and sustainable growth.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Second div for the withdrawal history table -->
  <div class="row mt-4">
    <h4>Withdrawal History</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Account Name</th>
            <th>Bank Name</th>
            <th>Account Number</th>
            <th>Amount</th>
            <th>Report</th>
          </tr>
        </thead>
        <tbody>
          <!-- Add your order history data dynamically here -->
          <?php
            $objects->query = "SELECT * FROM withdrawal WHERE user_id = '$user_id'";
            if($objects->total_rows() > 0){
                $histories = $objects->query_all();
                foreach($histories as $history){ ?>
                <tr>
                  <td><?php echo $history["account_name"];?></td>
                  <td><?php echo $history["bank_name"];?></td>
                  <td><?php echo $history["account_number"];?></td>
                  <td><?php echo $history["amount"];?></td>
                  <td><?php echo $history["report"];?></td>
                </tr>
               <?php }
            }else{ ?>
                <tr>
                  <td colspan="5">
                    <center><h4>You have no withdrawal history</h4></center>
                  </td>
                </tr>
           <?php }
          ?>
          <!-- Add more rows as needed -->
        </tbody>
      </table>
  </div>

  <!-- Third div for order history table -->
  <div class="row mt-4">
    <h4>Order History</h4>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name of Buyer</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Amount Each</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>

          <?php
              $objects->query = "SELECT * FROM orders WHERE farmer_id = '$user_id' AND status = 'completed'";
              if($objects->total_rows() > 0){
                  $histories = $objects->query_all();
                  foreach($histories as $history){ ?>
                  <tr>
                    <td><?php echo $history["buyer_name"];?></td>
                    <td><?php echo $history["product_name"];?></td>
                    <td><?php echo $history["quantity"];?></td>
                    <td><?php echo $history["amount"];?></td>
                    <td><?php echo $history["total"];?></td>
                  </tr>
                <?php }
              }else{ ?>
                  <tr>
                    <td colspan="5">
                      <center><h4>You have no order history</h4></center>
                    </td>
                  </tr>
            <?php }
            ?>
          <!-- Add more rows as needed -->
        </tbody>
      </table>
  </div>

 
</div>

<!-- Withdrawal Modal -->
<div class="modal" tabindex="-1" role="dialog" id="withdrawalModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Withdrawal Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Withdrawal Form Fields -->
        <form class="needs-validation" id="withdraw" method="post">
          <div class="form-group mb-3">
            <strong><label for="accountBank">Account Bank</label></strong>
            <select name="accountBank" id="accountBank" class="form-control">
            <?php

                require '../paystack/src/autoload.php';

                use Yabacon\Paystack;

                // Set your Paystack secret key
                $secretKey = 'sk_live_58af92d67a993c890713ac20e639ec442169b2ec';

                $paystack = new Paystack($secretKey);

                try {
                    $banks = $paystack->bank->getList();

                    foreach ($banks->data as $bank) { ?>
                        <option value="<?php echo $bank->code; ?>"><?php echo $bank->name; ?></option>
                    <?php }
                    
                } catch (\Yabacon\Paystack\Exception\ApiException $e) {
                    // Handle API errors
                    echo 'Error: ' . $e->getMessage();
                }
            ?>

            </select>
          </div>
          <div class="form-group mb-3">
            <strong><label for="accountNumber">Account Number</label></strong>
            <input type="number" class="form-control" name="accountNumber" required>
          </div>
          <div class="form-group mb-3">
            <strong><label for="accountName">Account Name</label></strong>
            <input type="text" class="form-control" name="accountName" id="acct_name">
          </div>
          <div class="form-group mb-3">
            <strong><label for="amount">Amount</label></strong>
            <input type="number" class="form-control" name="amount" id="amount" required>
          </div>
          <div class="form-group mb-3">
            <strong><label for="report">Report</label></strong>
            <textarea class="form-control" name="report" rows="3" required></textarea>
          </div>
          <input type="hidden" name="code" id="code" value="">
          <input type="hidden" name="page" value="user">
          <input type="hidden" name="action" value="withdraw">
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

</main>
<script>
  $("#withdraw").on("submit", function(e){
    e.preventDefault();
    if($("#acct_name").val().length < 1){
      $.ajax({
        url: "../controllers/ajax.php",
        type: "post",
        data: $(this).serialize(),
        dataType: "json", 
        success: function(data){
          if(data.status){
                $("#acct_name").val(data.data.details.account_number);
                $("#code").val(data.data.recipient_code);
                
          }else{
            alert("Bank Details not valid")
          }
        }
      })
    }else{
      $.ajax({
        url: "../controllers/ajax.php",
        type: "post",
        data: $(this).serialize(),
        dataType: "json", 
        success: function(data){
          if(data.status){
            alert("Withdrawal was successful");
          }else{
            alert(data.msg);
          }
        }
      })
        
    }
  })
</script>



<?php include("../middleware/footer.php");?>