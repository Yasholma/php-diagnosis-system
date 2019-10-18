<?php require_once "assets/core/init.php"; ?>

<?php

?>


<?php include_once "assets/inc/header.php"; ?>
<?php include_once "assets/inc/nav.php"; ?>
<!-- End of Navigation -->

<div class="container">
    <div class="col-md-10 mx-auto mt-3 mb-5">
        <?php echo success($session->message); ?>
        <?php if ($_SESSION['us3rgr0up'] != 'expert'): ?>
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Query</th>
                            <th>Experts</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (!empty($user->getQuery($_SESSION['us3rid'])) ? $user->getQuery($_SESSION['us3rid']) : [] as $uQuery): ?>
                            <tr>
                                <td>2 May, 2014</td>
                                <td><?=excerpt($uQuery->description, 5);?></td>
                                <td><?=!empty($user->getExpertInfo($uQuery->expertId)->name) ? 'Dr. ' . $user->getExpertInfo($uQuery->expertId)->name : 'No Doctor';?></td>
                                <td>
                                    <a href="notification_handler.php?id=<?=$uQuery->id;?>" class="btn btn-xs btn-outline-success"><i class="fas fa-eye"></i></a>
                                    <a href="notification_handler.php?id=<?=$uQuery->id;?>" class="btn btn-xs btn-outline-primary"><i class="fas fa-reply"></i></a>
                                    <a href="delete_notification.php?id=<?=$uQuery->id;?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-xs btn-outline-danger"><i class="fas fa-recycle"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <h2 class="display-5">Dr. <?=$user->getExpertInfo($_SESSION['us3rid'])->name;?></h2>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="130">Patient Name</th>
                        <th>Description</th>
                        <th width="110"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (!empty($user->getQuery4Expert($_SESSION['us3rid'])) ? $user->getQuery4Expert($_SESSION['us3rid']) : [] as $expertQuery): ?>
                        <tr>
                            <td><?=$user->getUser($expertQuery->patientId)->name;?></td>
                            <td style="overflow-y: auto;"><?=excerpt($expertQuery->description, 20);?></td>
                            <td>
                                <a href="view_notification.php?id=<?=$expertQuery->id;?>" class="btn btn-xs btn-outline-info"><i class="fa fa-reply"></i></a>
                                <a href="view_notification.php?id=<?=$expertQuery->id;?>" class="btn btn-xs btn-outline-success"><i class="fa fa-eye"></i></a>
                                <a onclick="return confirm('Are you sure you want to delete this?');" href="delete_notification.php?id=<?=$expertQuery->id;?>" class="btn btn-xs btn-outline-danger"><i class="fa fa-recycle"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</div>





<?php include_once "assets/inc/footer.php"; ?>

<script>

</script>
