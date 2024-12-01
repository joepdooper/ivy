<form action="<?= _BASE_PATH . 'wordlist/post'; ?>" method="POST" enctype="multipart/form-data">

    <div class="p-1">
        <div class="p-05">
            <h1>Wordlist</h1>
        </div>
    </div>

    <div class="p-1">
        <div class="p-05">

            <table>
                <thead>
                <tr>
                    <th>Word</th>
                    <th>Category</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($wordlist as $row): ?>
                    <tr>
                        <td><input type="text" name="serdie_wordlist[<?= $row->id; ?>][word]"
                                   value="<?= $row->word; ?>"></td>
                        <td><input type="text" name="serdie_wordlist[<?= $row->id; ?>][category]"
                                   value="<?= $row->category; ?>"></td>
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
            <?php \Ivy\Button::submit('Save'); ?>
        </div>
    </div>

</form>
