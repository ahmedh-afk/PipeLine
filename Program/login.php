<?php
    session_start();
    include("DBConnection.php"); 
    $msg="";

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $login=trim($_POST["login"] ?? "");
        $password=$_POST["password"] ?? "";
        if(empty($login)){
            $msg="Enter Your Username/Email";
        }elseif(empty($password)){
            $msg="Enter Your Password";
        }else{
            $sqlstamnt = $conn->prepare("SELECT 
            user_id, username, password_hash, account_type
            FROM users WHERE email = ? OR username = ?");
            $sqlstamnt->bind_param("ss",$login,$login);
            $sqlstamnt->execute();
            $result=$sqlstamnt->get_result();
            $row=$result->fetch_assoc();
            if($row && password_verify($password,$row["password_hash"])){
                $_SESSION["user_id"]=$row["user_id"];
                $_SESSION["account_type"]=$row["account_type"];
                header("Location: index.php");
                exit;
            }else{
                $msg="Wrong Username/Email Or Password";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
     <!-- CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css"
     integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous"
     referrerpolicy="no-referrer">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./sign-in.css">
</head>
<body>
     <header class="header">
        <nav class="navbar">
        <div class="container">
            <div class="row">
                <div class="col">
             <div class="logo">
            <span class="icon">
                <img src="./images/logo.png" alt="">
            </span>
            <div class="text-logo">
                <h1>PipleLine</h1>
            <p>Get your dream job</p>
            </div>
        </div>
        </div>
        <div class="col">
            <ul class="nav">
                <li><a href="./index.php">Home</a></li>
                <li class="about-page"> <a href="./About.html">About</a></li>
                <li> <a href="">Find a Job</a></li>
                <li> <a href="">Contact</a></li>
            </ul>
            </div>
            <div class="col">
                <a class="btn" href="./login.php">Sign in</a>
                <a class="btn" href="">Post a Job</a>
            </div>
            </div>
        </div>
       </nav>
    </header>
    <section class="login">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="login-title">LOGIN</h2>
                <div class="login-card">
                    <form action="" class="Sign" method="POST">
                        <div class="input-group">
                            <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" class="text" id="login" name="login"
                                   placeholder="Username or Email" autocomplete="username" required>
                        </div>

                        <div class="input-group">
                            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="text" name="password"
                                   placeholder="Password" autocomplete="current-password" required>
                        </div>

                        <div class="options">
                            <label class="remember">
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                            <a href="" class="forgot">Forgot Password?</a>
                        </div>
                        <?php
                            if(!empty($msg)){
                                echo $msg;
                            }
                        ?>
                        <button type="submit" class="btn-login">Log in</button>
                    </form>
                </div>
                <h5>Dont Have An Account?</h5>
                <a href="./sign-up.php" class="btn-register">Create New Account</a>
            </div>
        </div>
    </div>
</section>
    <Footer class="end">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="head">
                        <h5>About Us</h5>
                    </div>
                    <div class="body">
                        <p>PipleLine connects people
                        <br> with the companies hiring
                        <br> near them, from a first job to
                        <br> a senior role.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="head">
                        <h5>Contact Info</h5>
                    </div>
                    <div class="body">
                        <ul>
                        <li>
                        <p>Address: 210 Example Street, Suite
                        <br> 4, Springfield</p>
                        </li>
                        <li>
                            <a href="">Phone: +1 (555) 010-0142</a>
                        </li>
                        <li>
                            <a href="">Email: hello@example.com</a>
                        </li>
                    </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="head">
                        <h5>Important Link</h5>
                    </div>
                    <div class="body">
                        <ul>
                        <li>
                        <a href="">Find a Job</a>
                        </li>
                        <li>
                            <a href="">Job Details</a>
                        </li>
                        <li>
                            <a href="">About Us</a>
                        </li>
                        <li>
                            <a href="">Career Blog</a>
                        </li>
                        <li>
                            <a href="">Contact Us</a>
                        </li>
                    </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="head">
                         <h5>Newsletter</h5>
                    </div>
                    <div class="body">
                            <p>Weekly job alerts and career tips.
                        <br> Unsubscribe at any time.</p>
                        <form class="email" method="post" action="https://themebubble.com/demo/webify/organic/?na=s">
                                    <input class="mail" type="email" required placeholder="Enter your Email" id="ne">
                                    <button type="submit" class="btn">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container1">
            <div class="row">
                <div class="col">
                    <span class="logo-img">
                        <img src="./images/logo.png" alt="">
                    </span>
                </div>
                <div class="col">
                    <span class="num">5000+</span>
                    <p>Open Roles</p>
                </div>
                <div class="col">
                    <span class="num">451</span>
                    <p>Hiring Companies</p>
                </div>
                <div class="col">
                    <span class="num">568</span>
                    <p>Hired This Month</p>
                </div>
            </div>
        </div>
        <hr class="border">
        <div class="container1">
            <div class="row1">
                <div class="col">
                    <p class="fuck">Copyright ©2026 All rights reserved</p>
                </div>
                <div class="col">
                    <p>created by I&A&S&A</p>
                </div>
                <div class="col">
                     <span class="icon-bttn1">
                    <i class="fa-brands fa-facebook"></i>
                </span>
                <span class="icon-bttn2">
                    <i class="fa-brands fa-google"></i>
                </span>
                <span class="icon-bttn3">
                    <i class="fa-brands fa-instagram"></i>
                </span>
               <span class="icon-bttn4">
                <i class="fa-brands fa-x-twitter"></i>
            </span> 
                </div>
            </div>
        </div>
    </Footer>
</body>
</html>