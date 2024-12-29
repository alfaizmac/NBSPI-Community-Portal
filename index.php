<?php
session_start(); // Start the session to use session variables
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | NBSPI Community Portal</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/skolcon.ico" type="image/x-icon">
    <link href="css/style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body class="no-padding">
    <main class="login">
        <div class="login__column">
            <img src="images/logo223.png" alt="Logo" title="Logo" class="login__logo" />
        </div>
        <section class="login__column">
            <div class="login__section login__sign-in">
                 <h1 class="logintitle__text">Login</h1>
                
                <!-- Display error message if credentials are wrong -->
                <?php
                    if (isset($_SESSION['error_message'])) {
                        echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
                        unset($_SESSION['error_message']); // Clear the error message after displaying it
                    }
                ?>
                
                <form action="login.php" method="POST" class="login__form"> 
                    
                    <div class="login__input-container">
                        <input 
                            type="text" 
                            name="username" 
                            placeholder="Username" 
                            required 
                            class="login__input"
                        />
                    </div>
                    <div class="login__input-container">
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Password" 
                            required 
                            class="login__input"
                        />
                    </div>
                    <div class="login__input-container">
                        <input
                            type="submit"
                            value="Log in"
                            class="login__input login__input--btn"
                        />
                    </div>
                </form>
            </div>
            <div class="login__section login__sign-up">
                <span class="login__text">
                    Don't have an account? 
                    <a href="registration.php" class="login__link">
                        Sign up
                    </a>
                </span>
            </div>
        </section>
    </main>
    <footer class="footer">
        <nav class="footer__nav">
            <ul class="footer__list">
                <li class="footer__list-item"><a href="#" class="footer__link">About Us</a></li>
            </ul>
        </nav>
        <span class="footer__copyright">© 2024 NBSPI Community Portal</span>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
    <script>
        $(document).ready(function(){
            // Fade out the error message after 3 seconds
            $(".error-message").fadeOut(3000);
        });
    </script>
</body>
</html>
