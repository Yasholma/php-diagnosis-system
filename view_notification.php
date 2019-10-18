<?php require_once "assets/core/init.php"; ?>

<?php
    $expertId = 0;
    $uQueryId = (int)urlencode($_GET['id']);
    $uQueryData = $user->getSingleQuery($uQueryId);

    if (isset($_POST['replyBtn'])) {
        $doctorId = $_SESSION['us3rid'];
        $reply = sanitize('reply');

        if ($user->reply($doctorId, $uQueryId, $reply)) {
            $session->message("Thank you for your time.");
            redirectTo('./notification.php');
        }
    }


?>


<?php include_once "assets/inc/header.php"; ?>
<?php include_once "assets/inc/nav.php"; ?>
<!-- End of Navigation -->

<div class="container">
    <div class="col-md-12 mx-auto mt-5 mb-5">
        <?php echo success($session->message); ?>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <span class="text-info mb-5">On: <?=datetime_to_text($uQueryData->created_at);?></span> By: <span class="text-info"><strong><?=$user->getUser($uQueryData->patientId)->name;?></strong></span>
                <a href="./notification.php" class="btn btn-sm btn-outline-warning pull-right ml-2"><i class="fas fa-arrow-circle-left"></i></a>
                <div class="card">
                    <div class="card-body">
                        <?=$uQueryData->description;?>
                    </div>
                </div>

                <form action="" class="mt-3" method="post">
<!--                    <input type="hidden" name="patientId" value="--><?//=$uQueryData->patientId;?><!--">-->
                    <label for="reply">Reply: <i class="fas fa-arrow-down"></i></label>
                    <textarea name="reply" id="reply" rows="3" class="form-control"></textarea>
                    <button type="submit" name="replyBtn" class="btn btn-sm btn-outline-success mt-2 pull-right mb-5">Reply <i class="fas fa-reply"></i></button>
                </form>
            </div>
        </div>

    </div>
</div>



<?php include_once "assets/inc/footer.php"; ?>
