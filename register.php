<?php require_once "assets/core/init.php"; ?>
<!-- Login Handling -->
<?php
    if (isset($_POST['register'])) {
        $name = sanitize('name');
        $username = sanitize('username');
        $password = $_POST['password'];
        $c_pass = $_POST['confirm'];
        $email = sanitize('email');
        $phone = sanitize('phone');
        $gender = sanitize('gender');

        if ($name == "" | $username == "" || $password == "" || $c_pass == "" || $phone == "" || $gender == "") {
            $errors[] = "All fields are required.";
        }

        if (strlen($username) < 4) {
            $errors[] = "Please, enter a valid username";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please, enter a valid email address";
        }

        if (strlen($password) < 6) {
            $errors[] = "Password minimum length is 6";
        }

        if (strlen($phone) < 11 || strlen($phone) > 11) {
            $errors[] = "Please, enter a valid phone number";
        }

        if ($user->checkUsername($username)) {
            $errors[] = "This username already exist. Please, try another.";
        }

        if ($password !== $c_pass) {
            $errors[] = "Password does not match.";
        }

        if (empty($errors)) {
            $hashed = hash('sha1', $password);
            // User account
            $user->username = $username;
            $user->password = $hashed;
            $user->usergroup = "patient";

//            Profile
            $user->name = $name;
            $user->email = $email;
            $user->phone = $phone;
            $user->gender = $gender;

            if ($user->createUser()) {
                $userId = $user->id;
                if ($user->createProfile($userId)) {
                    $session->message("Thank you for registering.");
                    redirectTo('index.php');
                }
            }
        }

    }


?>


<?php include_once "assets/inc/header.php"; ?>
<?php include_once "assets/inc/nav.php"; ?>
<!-- End of Navigation -->

<div class="container">
    <div class="col-md-4 mx-auto mt-3 mb-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Register Here!!!</h4>
                <small style="display: block;"><?php echo error($errors); ?></small>
                <hr>
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="name" id="name" value="<?php echo stickyForm('name'); ?>" class="form-control" placeholder="Enter Full Name">
                    </div>

                    <div class="form-group">
                        <input type="text" name="username" id="username" value="<?php echo stickyForm('username'); ?>" class="form-control" placeholder="Enter Username">
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                    </div>

                    <div class="form-group">
                        <input type="password" name="confirm" id="confirm" class="form-control" placeholder="Confirm Password">
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" id="email" value="<?php echo stickyForm('email'); ?>" class="form-control" placeholder="Enter Email Address">
                    </div>

                    <div class="form-group">
                        <input type="tel" name="phone" id="phone" value="<?php echo stickyForm('phone'); ?>" class="form-control" placeholder="Enter Mobile Number">
                    </div>

                    <div class="form-group">
                        <label for="male"><input type="radio" name="gender" id="male" value="Male"> Male</label>
                        <label for="female"><input type="radio" name="gender" id="female" value="Female"> Female</label>
                    </div>


                    <hr>
                    <div class="form-group">
                        <button type="submit" name="register" class="btn btn-outline-success pull-right btn-sm">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once "assets/inc/footer.php"; ?>
