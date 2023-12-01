<?php
$active = 3;
include("../middleware/buyer_header.php");
html($active);
?>

<?php
// Logic to determine if a specific user is selected or not
$userSelected = isset($_GET['user_id']);
if($userSelected){
    $id = $_GET["user_id"];
    $objects->query = "SELECT * FROM users WHERE id = '$id'";
    $details = $objects->query_result();
}

?>

<style>
    .user-card {
        text-decoration: none;
        color: black;
    }
    .online-status {
        color: green;
    }
    .offline-status {
        color: red;
    }
    .message-box-sender {
        background-color: #4CAF50;
        width: 70%;
        margin-left: 30%;
        text-align: right;
        color: white;
    }
    .message-box-receiver {
        background-color: #D5D8DC;
        width: 70%;
        margin-right: 30%;
    }
    .messages-container {
        height: 80vh;
        overflow-y: scroll;
        scrollbar-width: none;
    }
    .messages-container::-webkit-scrollbar {
        display: none;
    }
    .centered-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
    .col-md-3, .col-md-9 {
        height: 80vh;
        overflow-y: scroll; /* This enables scrolling */
        scrollbar-width: thin; /* For Firefox */
        -ms-overflow-style: none; /* For Internet Explorer and Edge */
    }

    .col-md-3::-webkit-scrollbar, .col-md-9::-webkit-scrollbar  {
        width: 0; /* This hides the scrollbar in WebKit-based browsers (Chrome, Safari) */
    }



</style>

<main class="container mt-4">

    <div class="row">
        <!-- Friends List (col-md-3) -->
        <div class="col-md-3">
            <?php 
                $objects->query = "SELECT * FROM users WHERE id != '$user_id'";
                $total = $objects->total_rows();
                $friends = $objects->query_all();
                if($total > 0){
                    foreach($friends as $friend){
                        $friend_id = $friend["id"];
                        $objects->query = "SELECT * FROM users WHERE id = '$friend_id'";
                        $friend_details = $objects->query_result();
            ?>
                <a href="contact.php?user_id=<?php echo $friend_details["id"]; ?>" class="card user-card mb-3">
                    <div class="card-body d-flex align-items-center pe-3">
                        <img src="../images/users/<?php echo $friend_details["image"]; ?>" alt="User Name" class="rounded-circle" width="40">
                        <?php echo $friend_details["username"]; ?>
                    </div>
                </a>
            <?php
                    }
                }else{
            ?>
                <div class="card-body d-flex justify-content-between align-items-center pe-3">
                    <strong>You have no friends for now</strong>
                </div>
            <?php
                }
            ?>
        </div>

        <!-- Messages (col-md-9) -->
        <div class="col-md-9">
            <?php if ($userSelected): ?>
                <!-- User Header -->
                <div class="header d-flex justify-content-between align-items-center mb-4">
                    <a href="user.php?user_id=1" class="d-flex align-items-center text-decoration-none text-dark">
                        <img src="../images/users/<?php echo $details["image"];?>" alt="User Name" class="rounded-circle" width="40">
                        <?php echo $details["username"];?>
                    </a>
                    <?php
                    $objects->query = "SELECT * FROM messages WHERE (sender_id = '$user_id' AND receiver_id = '$id') OR (sender_id = '$id' AND receiver_id = '$user_id')";
                    $total_messages = $objects->total_rows();
                    ?>
                    <span><?php echo $total_messages; ?> messages</span>
                </div>
                <!-- Messages Container -->
                <div class="messages-container mb-4" id="messageBox">
                    <?php
                    $objects->query = "SELECT * FROM messages WHERE (sender_id = '$user_id' AND receiver_id = '$id') OR (sender_id = '$id' AND receiver_id = '$user_id')";
                    $messages = $objects->query_all();
                    foreach($messages as $message){
                        $sender_id = $message["sender_id"];
                        $receiver_id = $message["receiver_id"];
                        if($sender_id == $user_id && $receiver_id == $id){
                            echo '
                            <div class="message-box-sender p-3 mb-3 rounded">
                                '.$message["content"].'
                            </div>';
                        }else{
                            echo '<!-- Receiver Message -->
                            <div class="message-box-receiver p-3 mb-3 rounded">
                                '.$message["content"].'
                            </div>';
                        }
                    ?>
                    <?php
                    }
                    ?>
                </div>
                <!-- Message Input Field -->
                <form id="message" method="post" class="my-3">
                        <input type="hidden" name="page" value="user">
                        <input type="hidden" name="action" value="message">
                        <input type="hidden" name="friend" value="<?php echo $id;?>">
                    <div class="input-group">
                        <input type="text" class="form-control" name="content" id="content" placeholder="Type your message...">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Send</button>
                        </div>
                    </div>
                </form>
                <?php else: ?>
                    <div class="centered-content px-3 px-sm-5">
                        <h2 class="text-center">Discover & Connect</h2>
                        <p class="text-center">
                            Dive deep into our community and explore the myriad of opportunities. Meeting new people isn't just about networking, but uncovering insights that can pave a way for both personal and professional growth. Whether you're looking to learn from the best or find your next big career opportunity, our platform empowers you to take that leap.
                        </p>
                    </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    // JavaScript to handle responsiveness for mobile
    if (window.innerWidth <= 768) {
        if (window.location.search) {
            document.querySelector('.col-md-3').style.display = 'none';
        } else {
            document.querySelector('.col-md-9').style.display = 'none';
        }
    }
    
    $("form#message").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url: "../controllers/ajax.php",
            type: "post",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data){
                if(data.status){
                    var html = `<div class="message-box-sender p-3 mb-3 rounded">
                                ${document.querySelector("#content").value}
                            </div>`;
                    document.querySelector("#messageBox").insertAdjacentHTML("beforeend", html);
                    $("#content").val();
                }
            }
        })
    })
</script>


<?php include("../middleware/footer.php");?>
