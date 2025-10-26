<?php
$bandsintown = new bandsintown\Settings;
$gig = (new \Ivy\Plugin)->where('name', "Gig")->fetchOne();
?>

<form action="<?= Path::get('BASE_PATH') . '/bandsintown/post'; ?>" method="POST" enctype="multipart/form-data">

    <div class="p-1">
        <div class="p-05">
            <h1>bandsintown API</h1>
        </div>
    </div>

    <div class="p-1">
        <div class="p-05">

            <table>
                <thead>
                <tr>
                    <th>Artists</th>
                    <th>API key</th>
                    <th>Response</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bandsintown->get()->all() as $row): ?>
                    <tr>
                        <td>
                            <label>
                                <input type="text" name="bandsintown[<?= $row->id; ?>][artists]"
                                       placeholder="artists" value="<?= $row->artists; ?>">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" name="bandsintown[<?= $row->id; ?>][key]" placeholder="API key"
                                       value="<?= $row->key; ?>">
                            </label>
                        </td>
                        <td>
                            <label for="response" class="close text-align-right">
                                <?= file_get_contents(Path::get('BASE_PATH') . "media/icon/" . "feather/code.svg"); ?>
                            </label>
                        </td>
                        <td>
                            <input type="hidden" name="bandsintown[<?= $row->id; ?>][id]"
                                   value="<?= $row->id; ?>">
                            <?php \Ivy\Button::delete("bandsintown[" . $row->id . "][delete]", "bandsintown_" . $row->id); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">
                        <label>
                            <input type="text" name="bandsintown[][artists]" placeholder="Add artist">
                        </label>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>

    <div class="p-1">
        <div class="p-05 text-center">
            {button type:submit, text:text('button.save')}
        </div>
    </div>

</form>

<?php if ($gig->active): ?>
    <form action="<?= Path::get('BASE_PATH') . '/bandsintown/render'; ?>" method="POST" enctype="multipart/form-data">
        <div class="p-1">
            <div class="p-05 text-center">
                <p>Render (new) bandsintown data into gig items, with tag:</p>
                <?php $option = \Ivy\DB::$connection->select('SELECT * FROM `tag`'); ?>
                <div class="select-container">
          <span class="select-arrow">
            <?= file_get_contents(Path::get('BASE_PATH') . "media/icon/" . "feather/chevron-down.svg"); ?>
          </span>
                    <label>
                        <select name="subject">
                            <?php foreach ($option as $value): ?>
                                <option value="<?= $value['id']; ?>" <?= (isset($subject->id) && ($subject->id == $value['id'])) ? 'selected="selected"' : ''; ?>><?= $value['value']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
            </div>
            <div class="inner text-align-center">
                {button type:submit, text:text('button.render_gigs')}
            </div>
        </div>
    </form>
<?php endif; ?>

<div class="p-1">
    <div class="p-05">
        <strong>API response:</strong>
    </div>
    <?php foreach ($bandsintown->get()->all() as $row): ?>
        <div class="inner">
      <pre>
        <?= print_r($bandsintown->list($row->key, $row->artists, 'all'), true); ?>
      </pre>
        </div>
    <?php endforeach; ?>
</div>
