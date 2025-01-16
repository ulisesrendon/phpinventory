<div class="container">
    <?php foreach ($Collection->Contents as $content) { ?>
    <div class="card-blogpost bg-white">
        <a href="<?php echo $content->url ?>">
            <img width="480" height="270" src="https://neuralpin.com/media/covers/default.480.jpg"
                alt="<?php echo $content->title ?>" loading="lazy" title="<?php echo $content->title ?>">
            <div class="blogpost-title"><?php echo $content->title ?></div>
            <div class="blogpost-descrip"><?php echo $content->title ?></div>
        </a>
    </div>
    <?php } ?>
</div>