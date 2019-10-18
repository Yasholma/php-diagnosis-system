<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="" id="logo" class="img-fluid ml-5" alt="" width="38px;"> <h5 class="mt-3" style="display: inline;">Diagnosis System</h5>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php"><i class="fa fa-home"></i>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="">Doctors</a>
                </li>
                <li class="nav-item mr-2">
                    <a class="nav-link" href="">FAQs</a>
                </li> -->
                <?php if (loggedIn()): ?>
                    <?php if (!isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="notification.php"><i class="fas fa-info"></i> Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./profile.php"><i class="fas fa-atom"></i> <?=ucfirst($user->getUsername($_SESSION['us3rid'])->username);?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./dashboard"><i class="fas fa-dashboard"></i> Dashboard</a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($page == 'register.php'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php"><i class="fas fa-lock"></i> Login</a>
                        </li>
                    <?php elseif ($page == 'index.php'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="register.php"><i class="fas fa-user"></i> Register</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>