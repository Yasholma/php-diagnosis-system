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
                            <h1 class="m-0 text-dark display-5">Doctors</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Messages</li>
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (!empty($user->getMessages()) ? $user->getMessages() : [] as $ns): ?>
                                        <tr>
                                            <td><?php
                                                    if ($user->getExpertInfo($ns->userId)->name != "") {
                                                        echo $user->getExpertInfo($ns->userId)->name;
                                                    } else {
                                                        echo $user->getUser($ns->userId)->name;
                                                    }
                                                ?>
                                            </td>
                                            <td><?=$ns->message;?></td>
                                            <td><?=datetime_to_text($ns->created_at);?></td>
                                            <td>
                                                <a href="deleteNews.php?id=<?=$ns->id;?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-xs btn-outline-danger"><i class="fa fa-recycle"></i></a>
                                            </td>
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
