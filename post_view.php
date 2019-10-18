<?php require_once "assets/core/init.php"; ?>

<?php

    if (isset($_GET['postId'])) {
        $postId = urlencode($_GET['postId']);
        $post = $user->getSingleQuery($postId);

        $page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
        $items_per_page = 5;
        $items_total_count = $comments->countAll($postId);
        $paginate = new Paginate($page, $items_per_page, $items_total_count);

        $allComments = $comments->count($items_per_page, $paginate->offset(), $postId);

    } else {
        redirectTo('./index.php');
    }

    if (isset($_POST['commentBtn'])) {
        $comment = sanitize('comment');
        if (strlen($comment) > 200) {
            $errors[] = "Comment is too long.";
        }

        if ($comment == "") {
            $errors[] = "Comment field is empty";
        }

        if (empty($errors)) {
            $comments->comment = $comment;
            $comments->userId = $_SESSION['us3rid'];
            $comments->postId = $postId;

            if ($comments->createComment()) {
                $session->message("Comment added successfully.");
                redirectTo("post_view.php?postId={$postId}");
            }
        }

    }

?>

<?php include_once "assets/inc/header.php"; ?>
<?php include_once "assets/inc/nav.php"; ?>
<!-- End of Navigation -->

<div class="container">
    <div class="row mt-1">
        <div class="col-md-2 ml-auto">
            <a href="./index.php" class="btn btn-outline-info btn-block btn-sm"><i class="fas fa-backward"></i> Back</a>
        </div>
    </div>
    <div class="row mt-1">
        <?php echo error($errors); echo success($session->message); ?>
        <div class="col-md-10">
            <div class="jumbotron-custom">
                <h1 class="display-3"></h1>
                <p><?=$post->description;?></p>
                <hr>
                <div class="row">
                    <small class="ml-3 text-info">Posted By: <?=$user->getUser($post->patientId)->name;?></small>
                </div>
            </div>
        </div>
    </div>
    <?php if (loggedIn() && !isPatient()): ?>
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <textarea name="comment" id="comment" placeholder="Enter comment here. Please be brief and no bad words..." cols="30" rows="4" class="form-control"></textarea>
                    <button type="submit" name="commentBtn" class="btn btn-outline-success btn-sm mt-1 pull-right">Submit</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <h4>Comments</h4>
            <?php foreach (!empty($allComments) ? $allComments : [] as $cmt): ?>
                <div class="card p-3 bg-dark text-white mb-2">
                    <p><?=$cmt->comment;?></p>
                    <hr>
                    <small><?=($cmt->userId == $_SESSION['us3rid']) ? 'Self' : "Dr. " . $user->getExpertInfo($cmt->userId)->name;?> ~ <span class="text-info"><em>On: <?=date_to_text($cmt->created_at);?></em></span></small>
                </div>
            <?php endforeach; ?>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <nav class="justify-content-center pagination pagination-sm navigation">
                        <ul class="pagination">
                            <li class="page-item <?=$paginate->has_previous() ? '' : 'disabled'; ?>">
                                <a href="post_view.php?postId=<?=$postId;?>&page=<?=$paginate->has_previous() ? $paginate->previous() : $paginate->current_page;?>" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $paginate->page_total(); $i++) : ?>
                                <?php if ($i == $paginate->current_page) : ?>
                                    <li class="active page-item"><a class="page-link" href="post_view.php?postId=<?=$postId;?>&page=<?=$i;?>"><?=$i;?></a></li>
                                <?php else : ?>
                                    <li class="page-item"><a class="page-link" href="post_view.php?postId=<?=$postId;?>&page=<?=$i;?>"><?=$i;?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <li class="page-item <?=$paginate->has_next() ? '' : 'disabled'; ?>">
                                <a href="post_view.php?postId=<?=$postId;?>&page=<?=$paginate->has_next() ? $paginate->next() : $paginate->current_page;?>" class="page-link" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="fixed-bottom">-->
<!--    --><?php //include_once "assets/inc/footer.php"; ?>
<!--</div>-->

