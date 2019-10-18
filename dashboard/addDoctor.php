<?php include_once '../assets/core/init.php'; ?>
<?php admin(); ?>
<?php
    if (isset($_POST['addDoctor'])) {
        $username = sanitize('username');
        $password = hash('sha1', 'expert');

        $allName = sanitize('name');
        $name = ucwords($allName, ' ');
        $email = sanitize('email');
        $phone = sanitize('phone');
        $specialty = sanitize('specialty');

        if (strlen($name) < 10) {
            $errors[] = "Please, enter a valid name.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please, enter a valid email address";
        }

        if (strlen($phone) != 11) {
            $errors[] = "Please, enter a valid phone number";
        }

        if (strlen($specialty) < 3) {
            $errors[] = "Please, enter a valid specialty";
        }

        if (empty($errors)) {
            $user->username = $username;
            $user->password = $password;
            $user->usergroup = "expert";
            if ($user->createUser()) {
                $userId = $user->id;
                if ($user->addDoctor($userId, $name, $email, $phone, $specialty)) {
                    $session->message("Doctor has been added successfully.");
                    redirectTo('./doctor.php');
                }
            }
        }
    }

?>
<?php include_once 'includes/_header.php'; ?>
    <div class="wrapper">

        <!-- Navbar -->
        <?php include_once 'includes/_navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-warning elevation-4">
            <!-- Sidebar -->
            <?php include_once 'includes/_sidebar.php'; ?>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark display-5">Doctors</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Doctors</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <?=error($errors);?>
                        </div>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <div id="addDoctor">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="username">Username <span class="text-danger"><sup>*</sup></span></label>
                                    <input type="text" name="username" id="username" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger"><sup>*</sup></span></label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger"><sup>*</sup></span></label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone <span class="text-danger"><sup>*</sup></span></label>
                                    <input type="tel" name="phone" id="phone" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="specialty">Specialty <span class="text-danger"><sup>*</sup></span></label>
                                    <input type="text" name="specialty" id="specialty" class="form-control">
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-4 ml-auto">
                                        <button type="submit" name="addDoctor" class="btn btn-block btn-success"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Footer -->
        <?php include_once 'includes/_footer.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <i class="fa fa-user fa-lg"></i>
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
<?php include_once 'includes/_scripts.php'; ?>