<?php
$documentation = (new \Documentation\Item)->where('id', $item->table_id)->getRow()->single();
$tag = (new \Tag\Item)->where('id', $documentation->subject)->getRow()->single();
?>

<div class="item item-documentation col-12 <?php if (!$item->parent): ?>col-6-md col-4-lg<?php endif; ?>"
     id="item-<?= $item->id; ?>">

    <a href="<?= _BASE_PATH . 'documentation/' . $item->slug; ?>" class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">
                <?= $documentation->title; ?>
            </h2>
            <p><?= $documentation->subtitle; ?></p>
            <div class="card-actions justify-end">
                <div class="badge badge-outline"><?= $tag->value; ?></div>
            </div>
        </div>
    </a>

    <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
        <form action="<?= _BASE_PATH . 'documentation/update/' . $item->id; ?>" method="POST"
              enctype="multipart/form-data">
            <?php \Ivy\Template::render('include/item_admin_buttons.latte', ['item' => $item]); ?>
        </form>
    <?php endif; ?>

</div>
