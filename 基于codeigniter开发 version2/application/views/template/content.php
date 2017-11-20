<h2><?php echo $title; ?></h2>

<?php foreach ($notes as $note): ?>

    <div class="main">
        <?php echo $note; ?>
    </div>

    <p><a href="
    <?php
    	$note0 = base64_encode($note);
    	echo ('view/'.$username.'/'.$note0);
    ?>">View article</a></p>


<?php endforeach; ?>