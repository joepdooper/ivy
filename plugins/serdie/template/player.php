<form action="<?= Path::get('BASE_PATH') . 'player/post'; ?>" method="POST" enctype="multipart/form-data">

    <div class="p-1">
        <div class="p-05">
            <h1>Player</h1>
        </div>
    </div>

    <div class="p-1">
        <div class="p-05">

            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($player as $row): ?>
                    <tr>
                        <td><input type="text" name="serdie_player[<?= $row->id; ?>][name]"
                                   value="<?= $row->name; ?>"></td>
                        <td>
                            <input type="hidden" name="serdie_wordlist[<?= $row->id; ?>][id]"
                                   value="<?= $row->id; ?>">
                            <?php \Ivy\Button::delete("serdie_wordlist[" . $row->id . "][delete]", "serdie_wordlist_" . $row->id); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">
                        <input type="text" name="serdie_wordlist[][word]" placeholder="Add word" autofocus>
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
