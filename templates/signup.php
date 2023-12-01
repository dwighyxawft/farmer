<?php 
    $active = 3;
    include("../middleware/header.php");
    html($active);
?>

<style>
    div.container{
        height: 80vh;
    }
    div.row{
        height: 80vh;
    }
    .col-md-6, .card-body {
      height: 80vh; /* Set the height as needed */
      overflow-y: scroll; /* Enable vertical scrolling */
      scrollbar-width: thin; /* For Firefox */
    }

    .col-md-6::-webkit-scrollbar, .card-body::-webkit-scrollbar {
      width: 5px; /* Set the width of the scrollbar */
    }

    .col-md-6::-webkit-scrollbar-thumb, .card-body::-webkit-scrollbar-thumb {
      background-color: transparent; /* Set the color of the scrollbar thumb */
    }

    .col-md-6::-webkit-scrollbar-track, .card-body::-webkit-scrollbar-track {
      background-color: transparent; /* Set the color of the scrollbar track */
    }
    .custom-shadow {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.25), 0 6px 20px rgba(0, 0, 0, 0.19);
    }

</style>

<main>
    <div class="container">
        <div class="row mb-2">
             <!-- First column with desktop-only image -->
             <div class="col-md-6 d-none d-md-flex align-items-center">
                    <img src="../images/public/signup.png" alt="Desktop Image" class="img-fluid">
                </div>
            <!-- First column with login card -->
            <div class="col-md-6 d-flex justify-content-center">
                
                <div class="card custom-shadow border-0 px-3 py-4 w-75 mt-4"> <!-- Shadow and no border applied to the card -->
                        <h5>Signup</h5>
                        <div class="card-body bg-white">
                            <form class="needs-validation" method="post" id="login">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="name"> <!-- Bigger input field -->
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"> <!-- Bigger input field -->
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" name="phone" id="phone"> <!-- Bigger input field -->
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">User Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="buyer">Buyer</option>
                                        <option value="farmer">Farmer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="state" class="form-label">State of Residence</label>
                                    <input type="text" class="form-control" name="state" id="state"> <!-- Bigger input field -->
                                </div>
                                <div class="mb-3">
                                    <label for="govt" class="form-label">Local Government</label>
                                    <input type="text" class="form-control" name="govt" id="govt"> <!-- Bigger input field -->
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" id="address"> <!-- Bigger input field -->
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="pass_1" id="password"> <!-- Bigger input field -->
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="pass_2" id="confirm_password"> <!-- Bigger input field -->
                                </div>
                                <div class="alert alert-danger mb-3 d-none" id="alertDiv">
                                    <p class="alert_text"></p>
                                </div>
                                <input type="hidden" name="page" value="user">
                                <input type="hidden" name="action" value="signup">
                                <button type="submit" class="btn btn-dark">Signup</button>
                                <p class="py-3">Already have an account <a href="login.php" class="text-decoration-none text-success">Login here</a></p>
                            </form>
                        </div>
                </div>
                


            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        $("#login").on("submit", function(e){
            e.preventDefault();
            alert("submitted")
            $.ajax({
                url: "../controllers/ajax.php",
                type: "post",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data){
                    if(data.status){
                        location.href = "login.php";
                    }else{
                        $("#alertDiv").removeClass("d-none");
                        $(".alert_text").text(data.msg);
                    }
                }
            })
        })
    })
</script>



<?php include("../middleware/footer.php");?>