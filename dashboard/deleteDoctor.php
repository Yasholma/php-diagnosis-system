<?php include_once '../assets/core/init.php'; ?>
<?php admin(); ?>
<?php
    if (isset($_GET['id'])) {
        $expId = (int)urlencode($_GET['id']);
        if ($user->delete($expId) && $user->deleteProfile($expId)) {
            $session->message("Successfully deleted.");
            redirectTo('./doctor.php');
        }
    }


