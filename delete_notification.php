<?php require_once "assets/core/init.php"; ?>

<?php
    if (!loggedIn()) { redirectTo('./index.php'); }
    if (isset($_GET['id'])) {
        $queryId = (int)urlencode($_GET['id']);

        if ($user->deleteQuery($queryId) && $user->deleteReply($queryId)) {
            $session->message("Query has been successfully deleted.");
            redirectTo('./notification.php');
        }

    }

?>
