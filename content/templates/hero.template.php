<?php
/**
 * @var \Stradow\Framework\Render\Interface\GlobalStateInterface $GlobalState
 */
?>
<section id="mainp" class="pd50 tx-center bg-purple1">
    <div class="container cont-800">
        <h1><?php echo $GlobalState->getTitle(); ?></h1>
        <p><?php echo $GlobalState->getProperty('description'); ?></p>
    </div>
</section>
<div id="firsttag" class="rgbseparator rgbfusion"></div>