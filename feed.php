<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home | NBSPI Community Portal</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/skolcon.ico" type="image/x-icon">
        <link href="css/style.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head> 
    <body>
    <?php
        include_once 'connect.php'; // Database connection
        $us = $_GET['username']; // Get the current username
        include_once 'post.php';
    ?>
<br>
<nav class="navigation">
    <a href="feed.php?username=<?php echo $us ?>">
        <img 
            src="images/navLogo2.png"
            alt="logo"
            title="logo"
            class="navigation__logo"
        />
    </a>
    <form action="explore.php?curr=<?php echo $us ?>&for=_&get=search" class="navigation__search-container" method="post">
        <div class="navigation__search-container">
            <i class="fa fa-search"></i>
            <input type="text" name="search_for" placeholder="Search">
            <input type="submit" id="search" name="search" value="Search">
        </div>
    </form>
    <div class="navigation__icons">
        <?php
            // Fetch the profile picture of the current user
            $result = mysqli_query($conn, "SELECT profile_picture FROM users WHERE username = '$us'");
            $row = mysqli_fetch_array($result);
            $profile_picture = $row['profile_picture'] ? $row['profile_picture'] : "images/avatar.svg";
        ?>
        <a href="profile.php?curr_us=<?php echo $us ?>&profile_for=<?php echo $us ?>" class="navigation__link">
            <img 
                src="<?php echo $profile_picture; ?>" 
                alt="Profile" 
                class="navigation__profile-picture" 
                style="width:30px; height:30px; border-radius:50%;"
            />
        </a>
    </div>
</nav>

        <main class="feed">
    <?php
    // Fetch all posts from the database, including the description and photos
    $result = mysqli_query($conn, "SELECT 
                                        posts.post_id AS post_id,
                                        posts.photo AS photo,
                                        posts.username AS poster,
                                        posts.time_stamp AS time_stamp,
                                        posts.description AS description,
                                        users.profile_picture AS profile_picture,
                                        (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) AS likes_count,
                                        (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.post_id) AS comments_count,
                                        (SELECT 1 FROM likes WHERE likes.post_id = posts.post_id AND likes.likername = '$us') AS is_liked
                                    FROM posts
                                    LEFT JOIN users ON posts.username = users.username
                                    ORDER BY posts.time_stamp DESC");

    while ($row = mysqli_fetch_array($result)) {
        $post_id = $row['post_id'];
        $photos = explode(',', $row['photo']); // Split photo paths for multiple images
        $poster = $row['poster'];
        $profile_picture = $row['profile_picture'] ? $row['profile_picture'] : "images/avatar.svg";
        $time_stamp = $row['time_stamp'];
        $description = $row['description'];
        $likes_count = $row['likes_count'];
        $comments_count = $row['comments_count'];
        $is_liked = $row['is_liked'];
    ?>
<section class="photo">
    <header class="photo__header" style="display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center;">
            <div class="photo__header-column">
                <img
                    class="photo__avatar"
                    src="<?php echo $profile_picture; ?>"
                    style="width:30px;height:30px;"
                />
            </div>
            <div class="photo__header-column" style="margin-left: 10px;">
                <a href="profile.php?curr_us=<?php echo $us ?>&profile_for=<?php echo $poster ?>">
                    <?php echo $poster; ?>
                </a>
            </div>
        </div>
        <div>
            <a class="photo__time-ago" style="font-size: 12px; color: gray; text-decoration: none;">
                <?php echo $time_stamp; ?> 
            </a>
        </div>
    </header>
    <div class="photo__file-container">
        <?php if (count($photos) > 1) { 
            $unique_id = "carousel_" . $post_id; // Unique ID for each carousel
        ?>
        <div class="carousel" id="<?php echo $unique_id; ?>">
            <div class="carousel__track-container">
                <ul class="carousel__track">
                    <?php foreach ($photos as $photo) { ?>
                    <li class="carousel__slide">
                        <a href="image-detail.php?post_id=<?php echo $post_id ?>&curr_us=<?php echo $us ?>"> 
                            <img class="photo__file" src="<?php echo $photo; ?>" />
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <button class="carousel__button carousel__button--left" data-carousel-id="<?php echo $unique_id; ?>">‹</button>
            <button class="carousel__button carousel__button--right" data-carousel-id="<?php echo $unique_id; ?>">›</button>
        </div>
        <?php } else { ?>
        <a href="image-detail.php?post_id=<?php echo $post_id ?>&curr_us=<?php echo $us ?>"> 
            <img class="photo__file" src="<?php echo $photos[0]; ?>" />
        </a>
        <?php } ?>
    </div>
    <div class="photo__info">
        <div class="photo__icons">
            <span class="photo__icon">
                <a href="like.php?is_liked=<?php echo $is_liked ?>&post_id=<?php echo $post_id ?>&username=<?php echo $us ?>">
                    <?php 
                        if ($is_liked == 1) {
                            echo "<i class='fa fa-heart fa-lg heart-red'></i>";
                        } else {
                            echo "<i class='fa fa-heart-o fa-lg'></i>";
                        }
                    ?>
                </a> 
            </span>
            <span class="photo__icon">
                <a href="image-detail.php?post_id=<?php echo $post_id ?>&curr_us=<?php echo $us ?>"> 
                    <i class="fa fa-comment-o fa-lg"></i> <?php echo $comments_count; ?> comments
                </a>
            </span>
        </div>
        <span class="photo__likes"><?php echo $likes_count; ?> likes</span>
        <p class="photo__description">
            <strong><?php echo $poster; ?></strong> <?php echo $description; ?>
        </p>
    </div>
</section>

<style>
/* Same CSS as before */
.carousel {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 400px; /* Ensures consistent carousel height */
}

.carousel__track-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    height: 100%; /* Matches the carousel height */
}

.carousel__track {
    display: flex;
    transition: transform 0.5s ease-in-out;
    height: 100%;
}

.carousel__slide {
    min-width: 100%;
    height: 100%; /* Matches the carousel height */
}

.photo__file {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures consistent cropping */
    max-height: 400px; /* Limits the maximum height */
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
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const carousels = document.querySelectorAll(".carousel");

        carousels.forEach((carousel) => {
            const track = carousel.querySelector(".carousel__track");
            const slides = Array.from(track.children);
            const nextButton = carousel.querySelector(".carousel__button--right");
            const prevButton = carousel.querySelector(".carousel__button--left");
            let currentIndex = 0;

            nextButton.addEventListener("click", () => {
                if (currentIndex < slides.length - 1) {
                    currentIndex++;
                    track.style.transform = `translateX(-${currentIndex * 100}%)`;
                }
            });

            prevButton.addEventListener("click", () => {
                if (currentIndex > 0) {
                    currentIndex--;
                    track.style.transform = `translateX(-${currentIndex * 100}%)`;
                }
            });
        });
    });
</script>



    <?php } ?>
</main>

        <footer class="footer">
            <nav class="footer__nav">
                <ul class="footer__list">
                    <li class="footer__list-item"><a href="#" class="footer__link">About Us</a></li>
                </ul>
            </nav>
            <span class="footer__copyright">© 2024 NBSPI COMMUNITY PORTAL</span>
        </footer>
        <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
        <script src="js/app.js"></script>
    </body>
</html>
