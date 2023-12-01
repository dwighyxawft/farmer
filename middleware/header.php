<?php function html($active){ ?>
            <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="../css/bootstrap.min.css">
                    <link rel="stylesheet" href="../css/pkgs/font-awesome-4.7.0/css/font-awesome.min.css">
                    <link rel="stylesheet" href="../css/style.css">
                    <script src="../js/jquery-3.5.1.min.js"></script>
                    <script src="../js/popper2.js"></script>
                    <script src="../js/bootstrap.min.js"></script>
                    <title>Gram</title>
                </head>
                <body>
                <style>
                    .navbar-custom .navbar-nav > li > a.active {
                        color: lightgreen; /* Change the color to whatever you prefer */
                        font-weight: bold;
                    }
                </style>
                <nav class="navbar navbar-expand-sm navbar-custom bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand text-light" href="#">Farmers commercial Management System</a>
                    </div>
                </nav>
<?php } ?>