<?php require_once "../core/init.php"; ?>

<?php if ($_GET['mode'] === "changePassword"): ?>
    <?php ob_start(); ?>
        
    <?php echo ob_get_clean(); ?>
<?php endif; ?>

<?php if ($_GET['mode'] === "addNews"): ?>
    <?php ob_start(); ?>
        <h1>Add News</h1>
    <?php echo ob_get_clean(); ?>
<?php endif; ?>

<?php if ($_GET['mode'] === "contactAdmin"): ?>
    <?php ob_start(); ?>
        <h1>Contact Admin</h1>
    <?php echo ob_get_clean(); ?>
<?php endif; ?>
