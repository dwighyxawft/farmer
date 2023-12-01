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
    div.col-md-6{
        height: 80vh;
    }
    .custom-shadow {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.25), 0 6px 20px rgba(0, 0, 0, 0.19);
    }

</style>

<main>
    <div class="container">
        <div class="row mb-2">
            <!-- First column with login card -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                
                <div class="card custom-shadow border-0 px-3 py-4"> <!-- Shadow and no border applied to the card -->
                        <h5>Login</h5>
                        <div class="card-body bg-white">
                            <form class="needs-validation" method="post" id="login">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"> <!-- Bigger input field -->
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">User Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="buyer">Buyer</option>
                                        <option value="farmer">Farmer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"> <!-- Bigger input field -->
                                </div>
                                <div class="alert alert-danger mb-3 d-none" id="alertDiv">
                                    <p class="alert_text"></p>
                                </div>
                                <input type="hidden" name="page" value="user">
                                <input type="hidden" name="action" value="login">
                                <button type="submit" class="btn btn-dark">Login</button>
                                <p class="py-3">Don't have an account <a href="signup.php" class="text-decoration-none text-success">Register here</a></p>
                            </form>
                        </div>
                </div>
                


            </div>
            <!-- Second column with desktop-only image -->
                <div class="col-md-6 d-none d-md-flex align-items-center">
                    <img src="../images/public/login.png" alt="Desktop Image" class="img-fluid h-75">
                </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        $("#login").on("submit", function(e){
            e.preventDefault();
            console.log("Whats wrong");
            $.ajax({
                url: "../controllers/ajax.php",
                type: "post",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data){
                    if(data.status){
                        alert("Welcome "+ data.name);
                        if(data.type == "buyer"){
                            location.href = "farmer.php"
                        }else{
                            location.href = "dashboard.php"
                        }
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