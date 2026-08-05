<?php include __DIR__ . "/header.php"; ?>
<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . "/sidebar.php"; ?>
        <div class="col py-3">
            <?= $content ?>
        </div>
    </div>
</div>
<?php include __DIR__ . "/footer.php"; ?>
