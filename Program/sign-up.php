<?php
include("DBConnection.php");
$msg="";

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $firstName = trim($_POST["firstName"] ?? "");
        $lastName = trim($_POST["lastName"] ?? "");
        $username = trim($_POST["username"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";
        $confirmPassword = $_POST["confirmPassword"] ?? "";
        $account_type = trim($_POST["accountType"] ?? "");

    if(empty($firstName)){
        $msg="Enter The Name";
    }elseif(empty($lastName)){
        $msg="Enter Your Last Name";
    }elseif(empty($username)){
        $msg="Enter Your Username";
    }elseif(empty($password)){
        $msg="Enter The Password";
    }elseif(empty($confirmPassword)){
        $msg="Confirm Your Password";
    }elseif($confirmPassword!=$password){
        $msg="Passwords Mismatch";
    }elseif(empty($email)){
        $msg="Enter An Email";
    }elseif(empty($account_type)){
        $msg="Choose Your Account`s Type";
    }elseif($account_type != "employer" && $account_type != "seeker"){
        $msg="Choose Your Account Type";
    }else{            
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        try{
            $sqlstamnt = $conn->prepare("INSERT INTO users 
                                (first_name, last_name, username, email, password_hash, account_type) 
                                        VALUES (?, ?, ?, ?, ?, ?)");
            $sqlstamnt->bind_param("ssssss", $firstName, $lastName, $username, $email, $hash, $account_type);
            $sqlstamnt->execute();
            
            $msg="Registered Successfully";
        }catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                if(str_contains($e->getMessage(), "email")){
                    $msg="Email Already Registered";
                }elseif(str_contains($e->getMessage(), "username") ){
                    $msg="Username Already Taken";
                }
            }else{
                $msg="Something Wrong Happened, Try Again Later";
            }
        }
    }
}          

mysqli_close($conn);
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
    <link rel="stylesheet" href="./sign-up.css">
</head>
<body>
     <header class="header">
        <nav class="navbar">
        <div class="container">
            <div class="row">
                <div class="col">
             <div class="logo">
            <span class="icon">
                <img src="./Images/logo.png" alt="">
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
    <section class="Register">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="Register-title">Take the next step in your career</h2>
                <div class="Register-card">
                    <form action="" class="Sign" method="post">
                        <div class="account-type">
    <span class="account-type-title">Account type</span>
    <div class="account-options">
        <label class="type-option">
            <input type="radio" name="accountType" value="seeker" required checked>
            <span class="type-box">
                <i class="fa-regular fa-user"></i> Seeker
            </span>
        </label>
        <label class="type-option">
            <input type="radio" name="accountType" value="employer">
            <span class="type-box">
                <i class="fa-regular fa-building"></i> Employer
            </span>
        </label>
    </div>
</div>
    <div class="input-group">
        <span class="input-icon"><i class="fa-solid fa-user"></i></span>
        <input type="text" class="text" id="firstName" name="firstName"
               placeholder="First Name" autocomplete="given-name" required>
    </div>

    <div class="input-group">
        <span class="input-icon"><i class="fa-solid fa-user"></i></span>
        <input type="text" class="text" id="lastName" name="lastName"
               placeholder="Last Name" autocomplete="family-name" required>
    </div>

    <div class="input-group">
        <span class="input-icon"><i class="fa-solid fa-at"></i></span>
        <input type="text" class="text" id="username" name="username"
               placeholder="Username" autocomplete="username" required>
    </div>

    <div class="input-group">
        <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
        <input type="email" class="text" id="email" name="email"
               placeholder="Email" autocomplete="email" required>
    </div>

    <div class="input-group">
        <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
        <input type="password" class="text" id="password" name="password"
               placeholder="Password" autocomplete="new-password" required>
    </div>

    <div class="input-group">
        <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
        <input type="password" class="text" id="confirmPassword" name="confirmPassword"
               placeholder="Confirm Password" autocomplete="new-password" required>
    </div>
    <?php 
        if(!empty($msg)){
            echo $msg;
        } 
    ?>
    <button type="submit" class="btn-Register">Create Account</button>
</form>
                </div>
                <a href="./login.php" class="btn-login">already have an account?</a>
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
                    <p>created by I&A&S&A   </p>
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