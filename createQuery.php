<?php require_once "assets/core/init.php"; ?>

<?php
    if (isset($_POST['query'])) {
        $patientId = $_SESSION['us3rid'];
        $expertId = !empty($_POST['experts']) ? (int)sanitize('experts') : 0;
        $desc = sanitize('description');
        $visibility = (int)sanitize('visibility');

        if (strlen($desc) < 5) {
            $errors[] = "Please, explain yourself.";
        }

        if (empty($errors)) {
            if ($user->createQuery($patientId, $expertId, $desc, $visibility)) {
                $session->message("Thank you. Expert(s) will get back to you shortly.");
                redirectTo('./index.php');
            }
        }

    }


?>


<?php include_once "assets/inc/header.php"; ?>
<?php include_once "assets/inc/nav.php"; ?>
<!-- End of Navigation -->

<div class="container">
    <div class="col-md-6 mx-auto mt-5 mb-5">
        <?php echo success($session->message); ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Create New Request</h4>
                <small style="display: block;"><?php echo error($errors); ?></small>
                <hr>
                <form action="" method="post">

                    <div class="form-group">
                        <textarea name="description" id="description" cols="10" rows="5" class="form-control" placeholder="Please, enter the description of your condition..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="visible"><input onclick="expert()" type="radio" name="visibility" id="visible" value="1"> Visible</label>
                        <label for="hidden"><input onclick="expert()" type="radio" name="visibility" id="hidden" value="0" checked> Hidden</label>
                    </div>

                    <div class="form-group">
                        <select name="experts" class="form-control" id="experts">
                            <option value="0">-- Select Medical Adviser --</option>
                            <?php foreach($user->getExperts() as $experts): ?>
                                <option value="<?=$experts['id'];?>"><?='Dr. ' . $user->getExpertInfo($experts['id'])->name;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <hr>
                    <div class="form-group">
                        <button type="submit" name="query" class="btn btn-outline-success pull-right btn-sm">Submit <i class="fas fa-forward"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<?php include_once "assets/inc/footer.php"; ?>

<script>
    function expert() {
        let visible = document.getElementById('visible');
        let hidden = document.getElementById('hidden');
        let expert = document.getElementById('experts');
        if (visible.checked) {
            expert.value = '';
            expert.disabled = true;
        } else if (hidden.checked) {
            expert.disabled = false;
        }
    }
</script>
