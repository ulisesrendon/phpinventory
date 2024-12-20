
<ul class="breadcrumb-block">
<?php foreach ($BreadCrumb as $Item) { ?>
    <?php if ($Item->isLast) { ?>
    <li><?php echo $Item->anchor ?></li>
    <?php } else { ?>
    <li><a href="<?php echo $Item->url ?>"><?php echo $Item->anchor ?></a></li>
    <?php } ?>
<?php } ?>
</ul>