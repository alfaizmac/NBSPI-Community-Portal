<html>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Navbar Styles */
        .navigation {
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 999;
        }

        .navigation__logo {
            height: 40px;
        }

        .navigation__icons i {
            font-size: 24px;
            margin: 0 15px;
            color: #555;
        }

        /* Container and Content Styles */
        .container {
            margin-top: -100px;
            margin-bottom: 10px;
        }

        .col-sm-8 {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .your-class {
            margin-top: 20px;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            resize: none;
            margin-bottom: 15px;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        .post-button {
            background-color: #3897f0;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }

        .post-button:hover {
            background-color: #3578e5;
        }

        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            .container {
                margin-top: 60px;
            }

            .col-sm-8 {
                padding: 15px;
            }

            .navigation__logo {
                height: 35px;
            }
        }
    </style>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/skolcon.ico" type="image/x-icon">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body style="margin-top:50px">

    <?php
        $curr_us = $_GET['username'];
    ?>
    <nav class="navigation">
        <a href="feed.php?username=<?php echo $curr_us?>">
            <img 
                src="images/navLogo22.png"
                alt="logo"
                title="logo"
                class="navigation__logo"
            />
        </a>
    </nav>

    <div class="container">
    <div class="row">
        <div class="col-sm-2">
        
        </div>
        <div class="col-sm-8">
        
        <h1>Create Post</h1>
    <div class="your-class">
    
    <form action="submit-post.php" method="post" enctype="multipart/form-data">
        <textarea cols="40" name="discription" rows="10" style="position:relative; width:100%;"placeholder="What's on your mind?"></textarea><br>
        <label>Select images to upload.</label><br><br>
        <input type="file" name="filesToUpload[]" id="filesToUpload" multiple>
        <input type="hidden" id="user_name" name="user_name" value="<?php echo $curr_us?>">
        <input type="submit" value="Post" style="float:right; background-color: #3897f0; color:#fff" name="submit">
    </form>
    </div>
    </div>

        </div>
        <div class="col-sm-2">
        
        </div>
    </div>
    </div>


    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous">
    </script>
    <script src="js/app.js"></script>

    </body>
    </html>
