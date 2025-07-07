<?php if ($pager->getPageCount() > 1): ?>
    <ul class="pagination">
        <?php if ($pager->hasPrevious()) : ?>
            <li><a href="<?= $pager->getPrevious() ?>">&laquo;</a></li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <?php if ($link['active']): ?>
                <li class="active"><span><?= $link['title'] ?></span></li>
            <?php else: ?>
                <li><a href="<?= $link['uri'] ?>"><?= $link['title'] ?></a></li>
            <?php endif ?>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li><a href="<?= $pager->getNext() ?>">&raquo;</a></li>
        <?php endif ?>
    </ul>
<?php endif ?>
