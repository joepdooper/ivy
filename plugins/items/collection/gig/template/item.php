<?php
$gig = (new \Gig\Item)->where('id', $item->table_id)->getRow()->single();
$tag = (new \Tag\Item)->where('id', $gig->subject)->getRow()->single();
?>

<div class="item item-gig col-12 <?php if (!$item->parent): ?>col-6-md col-4-lg<?php endif; ?>"
     id="item-<?= $item->id; ?>">

    <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
    <form action="<?= _BASE_PATH . 'gig/update/' . $item->id . \Ivy\Template::$url; ?>" method="POST"
          enctype="multipart/form-data">
        <?php endif; ?>

        <div class="block bg-white dark:bg-gray-800">
            <div class="p-5">
                <!-- Subject -->
                <?php \Ivy\Template::render(_PLUGIN_PATH . 'tag/template/tag.php', ['item' => $item, 'tag' => $tag]); ?>
                <!-- Titles -->
                <div class="gigdate">
                    <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
                        <label for="date_<?= $item->id; ?>"></label><input class="editor form-control" type="date"
                                                                           id="date_<?= $item->id; ?>"
                                                                           name="date"
                                                                           value="<?= date('Y-m-d', strtotime($gig->datetime)); ?>">
                    <?php else: ?>
                        <h5><?= date('d.m.y', strtotime($gig->datetime)); ?></h5>
                    <?php endif; ?>
                </div>
                <div class="gigtime">
                    <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
                        <label for="time_<?= $item->id; ?>"></label><input class="editor form-control" type="time"
                                                                           id="time_<?= $item->id; ?>"
                                                                           name="time"
                                                                           value="<?= date('H:i', strtotime($gig->datetime)); ?>">
                    <?php else: ?>
                        <small>
                            <?= date('H:i', strtotime($gig->datetime)); ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="gigvenue">
                    <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
                        <?php \Image\Image::set('venue', $gig->venue, 'venue' . $item->id); ?>
                    <?php else: ?>
                        <p>
                            <?= $gig->venue; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="gigaddress">
                    <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
                        <?php \Image\Image::set('address', $gig->address, 'address' . $item->id); ?>
                    <?php else: ?>
                        <p>
                            <?= $gig->address; ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
        <?php \Ivy\Template::render('include/item_admin_buttons.latte', ['item' => $item]); ?>
    </form>
<?php endif; ?>

</div>
