<?php

$tasmota = new \Tasmota\Settings;
?>

<form action="<?= Path::get('BASE_PATH') . '/tasmota/post'; ?>" method="POST" enctype="multipart/form-data">

    <div class="p-1">
        <div class="p-05">
            <h1>tasmota</h1>
        </div>
    </div>

    <div class="p-1">
        <div class="p-05">

            <table>
                <thead>
                <tr>
                    <th>IP</th>
                    <th>cmnd</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tasmota->get()->all() as $row): ?>
                    <tr>
                        <td>
                            <input type="text" name="tasmota[<?= $row->id; ?>][ip]" placeholder="ip address"
                                   value="<?= $row->ip; ?>">
                        </td>
                        <td>
                            <input type="text" name="tasmota[<?= $row->id; ?>][cmnd]" placeholder="cmnd"
                                   value="<?= $row->cmnd; ?>">
                        </td>
                        <td>
                            <label for="response" class="close text-align-right">
                                <?= file_get_contents(Path::get('BASE_PATH') . "media/icon/" . "feather/code.svg"); ?>
                            </label>
                        </td>
                        <td>
                            <input type="hidden" name="tasmota[<?= $row->id; ?>][id]"
                                   value="<?= $row->id; ?>">
                            <?php \Ivy\Button::delete("tasmota[" . $row->id . "][delete]", "tasmota_" . $row->id); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">
                        <input type="text" name="tasmota[][ip]" placeholder="Add ip address">
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

<div class="p-1">
    <div class="p-05">
        <strong>API response:</strong>
    </div>
    <?php foreach ($tasmota->get()->all() as $row): ?>
        <?php if (!empty($row->ip)): ?>
            <div class="inner">
        <pre>
          <?= print_r($tasmota->device($row->ip, $row->cmnd)); ?>
        </pre>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
