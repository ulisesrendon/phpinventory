<nav>
    <?php foreach($Contents as $content): ?>
    <a href="<?php echo $content->url ?>"><?php echo $content->title ?></a>
    <?php endforeach; ?>
</nav>