<?php include_once '../assets/core/init.php'; ?>

<?php 
    if(!loggedIn()) {
        redirectTo('../index.php');
    }

    if ($_GET['id']) {
        $newsId = urlencode($_GET['id']);
        if ($user->publish($newsId)) {
            $session->message("News has been published.");
            redirectTo('news.php');
        }
    }

?>