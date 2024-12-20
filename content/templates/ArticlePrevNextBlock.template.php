<div class="navblock-prevnext">
    <?php if (! is_null($PrevContent)) { ?>
    <a class="navblock-prevnext-link prev" href="<?php echo $PrevContent->url ?>" title="<?php echo $PrevContent->title ?>"><span class="navblock-prevnext-arrow prev">←</span><span class="navblock-prevnext-anchor prev"><?php echo $PrevContent->title ?></span></a>
    <?php } ?>
    <?php if (! is_null($NextContent)) { ?>
    <a class="navblock-prevnext-link next" href="<?php echo $NextContent->url ?>" title="<?php echo $NextContent->title ?>"><span class="navblock-prevnext-anchor next"><?php echo $NextContent->title ?></span><span class="navblock-prevnext-arrow next">→</span></a>
    <?php } ?>
</div>