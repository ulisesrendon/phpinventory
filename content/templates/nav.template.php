<nav>
    <?php foreach ($Collection->Contents as $content) { ?>
    <a href="<?php echo $content->url ?>"><?php echo $content->title ?></a>
    <?php } ?>
</nav>