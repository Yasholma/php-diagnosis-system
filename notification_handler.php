<?php require_once "assets/core/init.php"; ?>

<?php
    $expertId = 0;
    $uQueryId = (int)urlencode($_GET['id']);
    $uQueryData = $user->getSingleQuery($uQueryId);

    if ($uQueryData->expertId != 0) {
        $expertId = $uQueryData->expertId;
    }
    $expertReply = $user->getReply($expertId, $uQueryId);
?>


<?php include_once "assets/inc/header.php"; ?>
<?php include_once "assets/inc/nav.php"; ?>
<!-- End of Navigation -->

<div class="container" style="margin-bottom: 200px;">
    <div class="col-md-12 mx-auto mt-5 mb-5">
        <?php echo success($session->message); ?>
        <div class="row">
            <div class="col-md-8">
                <span class="text-info">On: <?=datetime_to_text($uQueryData->created_at);?></span>
                <a href="./notification.php" class="btn btn-sm btn-outline-warning pull-right ml-2"><i class="fas fa-arrow-circle-left"></i></a>
                <div class="card">
                    <div class="card-body">
                        <?=$uQueryData->description;?>
                    </div>
                </div>

                <form action="" class="mt-3">
                    <label for="reply">Reply: <i class="fas fa-arrow-down"></i></label>
                    <textarea name="reply" id="reply" rows="5" class="form-control"></textarea>
                    <button class="btn btn-block btn-sm btn-outline-success mt-2">Reply <i class="fas fa-reply"></i></button>
                </form>
            </div>
            <div class="col-md-4" style="overflow-y: auto;">
                <h4>Comments By Doctor(s)</h4>
                <?php foreach (!empty($expertReply) ? $expertReply : [] as $expReply): ?>
                    <div class="card bg-dark text-white p-2">
                        <?=$expReply->reply;?>
                    </div>
                    <div class="card-footer">
                        <small class="pull-right text-success" style="margin-top: -10px;">Dr. <?=$user->getExpertInfo($expReply->expertId)->name;?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>


<?php include_once "assets/inc/footer.php"; ?>

<script>

</script>
