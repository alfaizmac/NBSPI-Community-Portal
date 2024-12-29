<?php
$post_id = $_GET['post_id'];
$curr_us = $_GET['curr_us'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Detail | NBSPI Community Portal</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/skolcon.ico" type="image/x-icon">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    /* Body and Main Container */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center; /* Center everything horizontally */
        align-items: center; /* Center everything vertically */
        height: 100vh; /* Full viewport height */
        background-color: #f4f4f4;
    }

    main {
        width: 80%; /* Set the width to 80% of the screen */
        max-width: 1200px; /* Maximum width */
        margin: 0 auto; /* Center the main container */
    }

    /* Carousel Styling */
    .carousel {
        position: relative;
        overflow: hidden;
        width: 100%; /* Use full width for the carousel */
        height: 550px;
        margin-top: 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: center; /* Center the carousel horizontally */
    }

    .carousel__track-container {
        position: relative;
        overflow: hidden;
        height: 100%;
        width: 100%;
    }

    .carousel__track {
        display: flex;
        transition: transform 0.5s ease-in-out;
        height: 100%;
    }

    .carousel__slide {
        min-width: 100%;
        height: auto;
        display: flex;
        justify-content: center; /* Center the image horizontally */
    }

    .carousel__slide img {
        max-width: 100%; /* Allow image to scale but not exceed its natural size */
        height: auto; /* Maintain aspect ratio */
        margin: 0 10px; /* Add margin to separate images */
    }

    .carousel__button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        z-index: 10;
    }

    .carousel__button--left {
        left: 10px;
    }

    .carousel__button--right {
        right: 10px;
    }

    /* Post Details Styling */
    .photo__info {
        background-color: #fff;
        overflow-y: auto;
        max-height: 300px;
        margin: 20px 0; /* Add margin to separate from carousel */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .photo__header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .photo__avatar {
        width: 50px; /* Set a fixed size for the user's profile picture */
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .photo__header .photo__username {
        font-weight: bold;
    }

    .photo__description {
        display: flex;
        align-items: center;
        font-size: 1.1rem;
        color: #555;
        margin-top: 10px;
    }

    .photo__details {
        margin-top: 10px;
        margin-bottom: 20px; /* Add margin to the bottom for spacing */
    }

    /* Comments Section */
    .photo__comments {
        list-style: none;
        padding: 0;
    }

    .photo__comment {
        display: flex;
        justify-content: space-between; /* Align content to both sides */
        margin-bottom: 10px;
    }

    .comment__container {
        display: flex;
        align-items: center;
    }

    .comment__avatar {
        width: 40px; /* Set a fixed size for commenter's profile picture */
        height: 40px;
        border-radius: 50%;
    }

    .comment__details {
        margin-left: 10px;
    }

    .photo__likes {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }

    .photo__time-ago {
        display: block;
        margin-top: 5px;
        font-size: 0.9rem;
        color: #888;
    }

    /* Add styling for the timestamp */
    .photo__comment-timestamp {
        font-size: 0.9rem;
        color: #888;
        margin-left: auto; /* Push the timestamp to the far right */
        align-self: center; /* Vertically align it in the middle */
    }

    /* Center everything inside the photo details */
    .photo__container {
        display: flex;
        flex-direction: column;
        align-items: center; /* Center the content vertically */
        margin-top: 20px;
    }
</style>
</head>
<body>
<nav class="navigation">
    <a href="feed.php?username=<?php echo $curr_us; ?>">
        <img 
            src="images/navLogo22.png"
            alt="logo"
            title="logo"
            class="navigation__logo"
        />
    </a>
    <div class="navigation__icons">
        <a href="profile.php" class="navigation__link">
            <i class="fa fa-user-o"></i>
        </a>
    </div>
</nav>
<main class="image-detail">
<?php
include_once 'connect.php';

$result = mysqli_query($conn, "SELECT
                                    username,
                                    photo,
                                    likes,
                                    comments,
                                    description,
                                    datediff(now(), time_stamp) AS created_at
                                FROM posts
                                WHERE post_id = $post_id");

$row = mysqli_fetch_array($result);

$username = $row['username']; 
$photos = explode(',', $row['photo']); // Assuming photo column contains comma-separated image URLs
$likes = $row['likes'];
$comments = $row['comments'];
$description = $row['description'];
$created_at = $row['created_at'];

$result2 = mysqli_query($conn, "SELECT profile_picture FROM users WHERE username = '$username'");
$row2 = mysqli_fetch_array($result2);
$profile_picture = $row2['profile_picture'];
?>
<section class="image">
    <table>
        <tr>
            <td><div style="width:100px"></div></td>
            <td>
                <div class="carousel">
                    <div class="carousel__track-container">
                        <ul class="carousel__track">
                            <?php foreach ($photos as $photo) { ?>
                                <li class="carousel__slide">
                                    <img 
                                        src="<?php echo $photo; ?>"
                                        style="max-width: 100%; height: auto; object-fit: contain;" 
                                    />
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <button class="carousel__button carousel__button--left">‹</button>
                    <button class="carousel__button carousel__button--right">›</button>
                </div>
                <div class="photo__details">
                    <div class="photo__header">
                        <img 
                            src="<?php echo ($profile_picture == null) ? 'images/avatar.svg' : $profile_picture; ?>"
                            class="photo__avatar"
                        />
                        <div>
                            <span class="photo__username"><?php echo $username; ?></span>
                            <span class="photo__description"><?php echo $description; ?></span>
                        </div>
                    </div>
                    Comments
                    <div class="photo__info">
                        <ul class="photo__comments" id="commentlist">
                            <?php
                            $result3 = mysqli_query($conn, "SELECT
                                                                c.commentername,
                                                                c.comment_text,
                                                                c.time_stamp,
                                                                u.profile_picture AS commenter_picture
                                                            FROM comments c
                                                            JOIN users u ON c.commentername = u.username
                                                            WHERE c.post_id = $post_id
                                                            ORDER BY c.time_stamp");
                            
                            while ($row3 = mysqli_fetch_array($result3)) {
                                $commentername = $row3['commentername'];
                                $comment_text = $row3['comment_text'];
                                $time_stamp = $row3['time_stamp']; // Get the comment timestamp
                                $commenter_picture = $row3['commenter_picture'];
                            ?>
                                <li class="photo__comment">
                                    <div class="comment__container">
                                        <img 
                                            src="<?php echo ($commenter_picture == null) ? 'images/avatar.svg' : $commenter_picture; ?>"
                                            class="comment__avatar"
                                        />
                                        <div class="comment__details">
                                            <span class="photo__comment-author"><?php echo $commentername; ?></span>
                                            <span><?php echo $comment_text; ?></span>
                                        </div>
                                    </div>
                                    <!-- Add timestamp here -->
                                    <span class="photo__comment-timestamp"><?php echo $time_stamp; ?></span>
                                </li> 
                            <?php
                            }
                            ?>   
                        </ul>
                    </div>
                
                    <div class="photo__icons">
                        <span class="photo__icon">
                            <i class="fa fa-heart-o heart fa-lg"></i>
                        </span>
                        <span class="photo__icon">
                            <i class="fa fa-comment-o fa-lg"></i>
                        </span>
                    </div>
                    <span class="photo__likes"><?php echo $likes; ?> likes</span>
                    <span class="photo__time-ago"><?php echo $created_at; ?> ago</span>
                    <div class="photo__add-comment-container">
                        <form action="comment.php?post_id=<?php echo $post_id; ?>&username=<?php echo $curr_us; ?>&return_to=image_detail" method="post">
                            <textarea type="text" name="comment" placeholder="Add a comment..." class="photo__add-comment"></textarea>
                            <button class="w3-circle w3-blue" style="width:50px;height:50px;position: absolute; right: 0;">></button>
                        </form> 
                    </div>
                </div>
            </td>
        </tr>
    </table>
</section>
</main>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const carousel = document.querySelector(".carousel__track");
    const slides = Array.from(carousel.children);
    const nextButton = document.querySelector(".carousel__button--right");
    const prevButton = document.querySelector(".carousel__button--left");
    let currentIndex = 0;

    nextButton.addEventListener("click", () => {
        if (currentIndex < slides.length - 1) {
            currentIndex++;
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }
    });

    prevButton.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }
    });
});
</script>
</body>
</html>
