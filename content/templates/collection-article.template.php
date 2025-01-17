<div class="container">
    <?php foreach ($Collection->Contents as $Content) { ?>
    <div class="card-blogpost bg-white">
        <a href="<?php echo $Content->url ?>">
            <img width="480" height="270" src="<?php echo $Config['site_url'] ?>/<?php echo $Content->properties->coverSmall ?? 'media/covers/default.480.jpg' ?>"
                alt="<?php echo $Content->title ?>" loading="lazy" title="<?php echo $Content->title ?>">
            <div class="blogpost-title"><?php echo $Content->title ?></div>
            <div class="blogpost-descrip"><?php echo $Content->properties->description ?? $Content->title ?></div>
        </a>
    </div>
    <?php } ?>
</div>