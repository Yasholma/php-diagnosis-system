<?php include_once '../assets/core/init.php'; ?>
<?php admin(); ?>
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
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Admin</li>
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
                            <div class="col-md-7 mr-auto">
                                <?=success($session->message);?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Date Join</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (!empty($user->getPatients()) ? $user->getPatients() : [] as $exp): ?>
                                            <tr>
                                                <td><?=$user->getUser($exp['userId'])->name;?></td>
                                                <td><?=$user->getUsername($exp['userId'])->username;?></td>
                                                <td><?=$exp['email'];?></td>
                                                <td><?=$exp['phone'];?></td>
                                                <td><?=datetime_to_text($exp['created_at']);?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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
