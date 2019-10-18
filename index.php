<?php require_once "assets/core/init.php"; ?>

<?php
    $page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 5;
    $items_total_count = $user->countAll();
    $paginate = new Paginate($page, $items_per_page, $items_total_count);
?>

<!-- Login Handling -->
<?php
    if (isset($_POST['login'])) {
        $username = sanitize('username');
        $password = sanitize('password');
        $hashed = hash('sha1', $password);
        $error = 0;

        if (strlen($username) < 0 || $username == "") {
            $errors[] = "Username is required";
            $error = 1;
        }

        if (strlen($password) < 0 || $password == "") {
            $errors[] = "Password is required";
            $error = 1;
        }

        if (empty($errors)) {
            if ($user->login($username, $hashed)) {
                $usergroup = $_SESSION['us3rgr0up'];
                if ($usergroup === 'patient' || $usergroup === 'expert') {
                    redirectTo('index.php');
                } else {
                    redirectTo('dashboard');
                }
            } else {
                $errors[] = "Your details couldn't not be validated";
            }
        }

    }


?>

<?php include_once "assets/inc/header.php"; ?>
    <?php include_once "assets/inc/nav.php"; ?>
  <!-- End of Navigation -->

  <div class="container">
    <div class="row mt-4">
      <div class="col-md-8">

          <h1 class="border-bottom border-success display-5">Related Posts<?php if (loggedIn() && isPatient()): ?> <a href="createQuery.php" class="btn btn-sm btn-danger pull-right mt-3">Create Query</a> <?php endif; ?></h1>
          <?php if (!loggedIn()): ?>
              <small class="text-danger">Please, <a href="#loginForm">login</a> or <a href="register.php">register</a> to seek for advice.</small>
          <?php endif; ?>
          <?php echo success($session->message); ?>

<!--          Pagination        -->
          <div class="row">
              <div class="col-md-8 mx-auto">
                  <nav class="justify-content-center pagination-sm pagination navigation">
                      <ul class="pagination">
                          <li class="page-item <?=$paginate->has_previous() ? '' : 'disabled'; ?>">
                              <a href="index.php?page=<?=$paginate->has_previous() ? $paginate->previous() : $paginate->current_page;?>" class="page-link" aria-label="Previous">
                                  <span aria-hidden="true">&laquo;</span>
                                  <span class="sr-only">Previous</span>
                              </a>
                          </li>
                          <?php for ($i = 1; $i <= $paginate->page_total(); $i++) : ?>
                              <?php if ($i == $paginate->current_page) : ?>
                                  <li class="active page-item"><a class="page-link" href="index.php?page=<?=$i;?>"><?=$i;?></a></li>
                              <?php else : ?>
                                  <li class="page-item"><a class="page-link" href="index.php?page=<?=$i;?>"><?=$i;?></a></li>
                              <?php endif; ?>
                          <?php endfor; ?>
                          <li class="page-item <?=$paginate->has_next() ? '' : 'disabled'; ?>">
                              <a href="index.php?page=<?=$paginate->has_next() ? $paginate->next() : $paginate->current_page;?>" class="page-link" aria-label="Next">
                                  <span aria-hidden="true">&raquo;</span>
                                  <span class="sr-only">Next</span>
                              </a>
                          </li>
                      </ul>
                  </nav>
              </div>
          </div>

        <?php foreach (!empty($user->getAllVisibleQueries($items_per_page, $paginate->offset())) ? $user->getAllVisibleQueries($items_per_page, $paginate->offset()) : [] as $queries): ?>
            <div class="card mb-3">
              <div class="card-body">
                <?=excerpt($queries['description'], 30);?>
              </div>
              <span class="card-footer">
                <small>By <span class="text-muted"><em><?=$user->getUser($queries['patientId'])->name;?></em></span> On <span class="text-muted"><?=datetime_to_text($queries['created_at']);?></span></small>
                  <a href="post_view.php?postId=<?=$queries['id'];?>" class="btn btn-xs btn-link pull-right">Continue reading <i class="fa fa-arrow-right"></i></a>
              </span>
            </div>
        <?php endforeach; ?>

<!--          Pagination            -->
          <div class="row">
              <div class="col-md-8 mx-auto">
                  <nav class="justify-content-center pagination navigation">
                      <ul class="pagination">
                          <li class="page-item <?=$paginate->has_previous() ? '' : 'disabled'; ?>">
                              <a href="index.php?page=<?=$paginate->has_previous() ? $paginate->previous() : $paginate->current_page;?>" class="page-link" aria-label="Previous">
                                  <span aria-hidden="true">&laquo;</span>
                                  <span class="sr-only">Previous</span>
                              </a>
                          </li>
                          <?php for ($i = 1; $i <= $paginate->page_total(); $i++) : ?>
                              <?php if ($i == $paginate->current_page) : ?>
                                  <li class="active page-item"><a class="page-link" href="index.php?page=<?=$i;?>"><?=$i;?></a></li>
                              <?php else : ?>
                                  <li class="page-item"><a class="page-link" href="index.php?page=<?=$i;?>"><?=$i;?></a></li>
                              <?php endif; ?>
                          <?php endfor; ?>
                          <li class="page-item <?=$paginate->has_next() ? '' : 'disabled'; ?>">
                              <a href="index.php?page=<?=$paginate->has_next() ? $paginate->next() : $paginate->current_page;?>" class="page-link" aria-label="Next">
                                  <span aria-hidden="true">&raquo;</span>
                                  <span class="sr-only">Next</span>
                              </a>
                          </li>
                      </ul>
                  </nav>
              </div>
          </div>

      </div>
      <div class="col-md-4">
        <?php if (!loggedIn()): ?>
            <div class="card">
              <div class="card-body">
                <h4 class="card-title text-center" id="loginForm">Login Here!!!</h4>
                  <small style="display: block;"><?php echo error($errors); ?></small>
                <hr>
                <form action="" method="post">
                  <div class="form-group">
                    <input type="text" name="username" id="username" class="form-control form-control-sm" placeholder="Enter Username...">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Enter Password...">
                  </div>
                  <div class="form-group">
                    <button type="submit" name="login" class="btn btn-outline-success btn-block btn-sm">Login</button>
                  </div>
                </form>
              </div>
            </div>
        <?php else: ?>
            <div class="card card-header bg-info text-center mb-2"><h4 class="text-white">Latest Information</h4></div>
            <div class="card mb-2">
                <?php foreach(!empty($user->getPublishedNews()) ? $user->getPublishedNews() : [] as $ns): ?>
                    <div class="card-body border-bottom">
                        <?=$ns->news;?>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
      </div>
    </div>
  </div>


  <?php include_once "assets/inc/footer.php"; ?>

