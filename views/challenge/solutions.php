<?php foreach ($solutions as $solution) { ?>
    <div class="solution">
        <h3><?= $solution->title; ?></h3>
        <div><?= $solution->description; ?></div>
    </div>
<?php }
