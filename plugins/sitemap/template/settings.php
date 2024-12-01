<?php

$sitemaps = (new Sitemap\Settings)->get()->all();
?>

<form action="<?= _BASE_PATH . '/sitemap/post'; ?>" method="POST" enctype="multipart/form-data">

    <div class="p-1">
        <div class="p-05">
            <h1>Sitemap</h1>
        </div>
    </div>

    <div class="p-1">
        <div class="p-05">

            <table>
                <thead>
                <tr>
                    <th></th>
                    <th>url</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sitemaps as $row): ?>
                    <tr>
                        <td>
                            <?php
                            \Ivy\Button::switch(
                                'sitemap[' . $row->id . '][bool]',
                                $row->bool
                            );
                            ?>
                        </td>
                        <td>
                            <input type="text" name="sitemap[<?= $row->id; ?>][url]" placeholder="url"
                                   value="<?= $row->url; ?>">
                        </td>
                        <td>
                            <input type="hidden" name="sitemap[<?= $row->id; ?>][id]"
                                   value="<?= $row->id; ?>">
                            <?php \Ivy\Button::delete("sitemap[" . $row->id . "][delete]", "sitemap_" . $row->id); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">
                        <input type="text" name="sitemap[][url]" placeholder="Add sitemap">
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>

    <div class="p-1">
        <div class="p05 text-center">
            <?php \Ivy\Button::submit('Save'); ?>
        </div>
    </div>

</form>
