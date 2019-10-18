<?php require_once "assets/core/init.php"; ?>
<?php
    if (!loggedIn()) {
        redirectTo('index.php');
    }

    $userId = $_SESSION['us3rid'];


    // Password Change Form Handling
    if (isset($_POST['changePassword'])) {
        $oldPass = hash('sha1', $_POST['old']);
        $newPassord = $_POST['new'];
        $confirm = $_POST['confirm'];

        if ($oldPass == "" || $newPassord == "") {
            $errors[] = "All fields are required.";
        }

        if (!$user->checkPassword($userId, $oldPass)) {
            $errors[] = "Old Password is incorrect";
        }

        if (strlen($newPassord) < 6) {
            $errors[] = "Password minimum length is 6";
        }

        if ($newPassord !== $confirm) {
            $errors[] = "Password confirmation failed";
        }

        if (empty($errors)) {
            $newPassordHashed = hash('sha1', $newPassord);
            $user->password = $newPassordHashed;
            if ($user->updatePassword($userId)) {
                $session->message("Password successfully changed.");
                redirectTo('profile.php?mode=changePassword');
            }
        }
    }

    // Latest News Form Handling
    if (isset($_POST['newsBtn'])) {
        $news = sanitize('news');

        if ($news == '') {
            $errors[] = "Please, news field is empty.";
        }

        if (strlen($news) < 10) {
            $errors[] = "Please, enter a valid news.";
        }

        if (empty($errors)) {
            if ($user->addNews($userId, $news)) {
                $session->message("Thank you for contributing.");
                redirectTo('profile.php?mode=addNews');
            }
        }


    }

    if (isset($_POST['messageBtn'])) {
        $message = sanitize('message');
        $userId = $_SESSION['us3rid'];

        if ($user->contactAdmin($message, $userId)) {
            $session->message("Your message has been sent.");
            redirectTo('profile.php?mode=contactAdmin');
        }
    }

?>

<?php include_once "assets/inc/header.php"; ?>
    <?php include_once "assets/inc/nav.php"; ?>
  <!-- End of Navigation -->

  <div class="container">
    <div class="row">
        <div class="col-md-9">
           <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">Profile Management</h1>
                </div>
                <div class="col-md-4 mt-4">
                    <?php if ($_GET['mode']): ?>
                        <a href="./profile.php" class="btn btn-sm btn-outline-secondary pull-right">Back to profile</a>
                    <?php endif; ?>
                </div>
           </div>
           <?php echo error($errors); echo success($session->message); ?>
            <hr>

            <div class="content">
                <?php if ($_GET['mode'] === "changePassword"): ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="card">
                                    <div class="card-header">Change Your Password</div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <label for="old">Old Password: <span><sup class="text-danger">*</sup></span></label>
                                                <input type="password" class="form-control" name="old" id="old">
                                            </div>

                                            <div class="form-group">
                                                <label for="new">New Password: <span><sup class="text-danger">*</sup></span></label>
                                                <input type="password" class="form-control" name="new" id="new">
                                            </div>

                                            <div class="form-group">
                                                <label for="confirm">Confirm Password: <span><sup class="text-danger">*</sup></span></label>
                                                <input type="password" class="form-control" name="confirm" id="confirm">
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" name="changePassword" class="btn btn-secondary pull-right">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($_GET['mode'] === "addNews"): ?>
                    <h1 class="display-5">Add News</h1>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="news">Latest News</label>
                            <textarea name="news" id="news" cols="30" rows="7" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                           <button class="btn btn-secondary pull-right" name="newsBtn">Send</button>
                        </div>
                    </form>
                <?php endif; ?>

                <?php if ($_GET['mode'] === "contactAdmin"): ?>
                    <h1>Contact Admin</h1>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="messageBtn" class="btn btn-primary pull-right">Send <i class="fas fa-send"></i></button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-3">
            <ul class="mt-4 list-group">
                <li class="list-group-item"><button onclick="showContent('changePassword');" class="btn btn-success btn-block">Change Password</button></li>
                <li class="list-group-item"><button onclick="showContent('addNews');" class="btn btn-primary btn-block">Add News</button></li>
                <li class="list-group-item"><button onclick="showContent('contactAdmin');" class="btn btn-warning btn-block">Contact Administrator</button></li>
            </ul>
        </div>
    </div>
  </div>

  <?php include_once "assets/inc/footer.php"; ?>

  <script>
    function showContent(mode) {
        // alert(JSON.stringify(mode));
        location.href = "profile.php?mode=" + mode;
        // $.ajax({
        //    url: "assets/ajax/profile.php",
        //    method: "get",
        //    data: {mode: mode},
        //    cache: false,
        //    success: function (data) {
        //         // location.href = "profile.php?mode=" + mode;
        //         $(".content").html(data);
        //     },
        //     error: function (err) { console.log(err) }
        // });
    }
  </script>

