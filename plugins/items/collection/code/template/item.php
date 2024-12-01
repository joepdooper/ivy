<?php
$code = (new \Code\Item)->where('id', $item->table_id)->getRow()->single();
$languages = ['css', 'php', 'javascript', 'shell', 'sql'];
?>

<div class="item item-code col-12 <?php if (!$item->parent): ?>col-6-md col-4-lg<?php endif; ?>"
     id="item-<?= $item->id; ?>">
    <div class="inner">

        <?php if (\Ivy\User::isLoggedIn() && $item->author): ?>
            <form action="<?= _BASE_PATH . 'code/update/' . $item->id . \Ivy\Template::$url; ?>" method="POST"
                  enctype="multipart/form-data">
                <label>
                    <select name="language">
                        <?php foreach ($languages as $language): ?>
                            <option <?php if ($code->language == $language): ?>selected<?php endif; ?>
                                    value="<?= $language; ?>"><?= $language; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>
                    <textarea class="bg-secondary" name="code"><?= $code->code; ?></textarea>
                </label>
                <?php \Ivy\Template::render('include/item_admin_buttons.latte', ['item' => $item]); ?>
            </form>
        <?php else: ?>
            <pre><code data-language="<?= $code->language; ?>"><?= $code->code; ?></code></pre>
        <?php endif; ?>

    </div>
</div>
