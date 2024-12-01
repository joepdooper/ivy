<?php

use Ivy\Item;
use Ivy\Template;
use Ivy\User;

?>

<div class="documentation">
    <div class="row">

        <div class="col-12 col-3-md">
            <div class="p-1">
                <ul>
                    <?php foreach ($tags as $tag): ?>
                        <li>
                            <input id="tag-<?= $tag->id; ?>" class="is-hidden tag-radio" type="radio" name="tag"
                                   <?php if ($documentation->subject === $tag->id): ?>checked<?php endif; ?>>
                            <label class="tag<?php if ($documentation->subject === $tag->id): ?> active<?php endif; ?>"
                                   for="tag-<?= $tag->id; ?>">
                                <div class="inner">
                                    <?= $tag->value; ?>
                                </div>
                            </label>
                            <ul>
                                <?php foreach ((new \Documentation\Item)->join('items', 'item_id', '=', 'id')->where('subject', $tag->id)->get()->all() as $link): ?>
                                    <?php if ($link->published || User::isLoggedIn()): ?>
                                        <li class="<?php if ($link->id === $item->id): ?>active<?php endif; ?>">
                                            <a href="<?= _BASE_PATH . 'documentation/' . $link->slug; ?>">
                                                <div class="inner"><?= $link->title; ?></div>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="col-12 col-9-md">
            <article>

                <?php if (User::isLoggedIn() && $item->author): ?>
                <form action="<?= _BASE_PATH . 'documentation/update/' . $item->id . Template::$url; ?>"
                      method="POST" enctype="multipart/form-data">
                    <?php endif; ?>

                    <div class="p-1">

                        <?php if (isset($documentation->subject)): ?>
                            <!-- Subject -->
                            <div class="inner">
                                <?php $tag = (new \Tag\Item)->where('id', $documentation->subject)->getRow()->single(); ?>
                                <?php Template::render(_PLUGIN_PATH . 'tag/template/tag.php', ['tag' => $tag, 'item' => $item]); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Titles -->
                        <div class="inner">
                            <h1><?php $item->author ? \Image\Image::set('title', $documentation->title, 'title') : print $documentation->title; ?></h1>
                            <h2><?php $item->author ? \Image\Image::set('subtitle', $documentation->subtitle, 'subtitle') : print $documentation->subtitle; ?></h2>
                        </div>

                    </div>

                    <?php if (User::isLoggedIn() && $item->author): ?>
                    <div class="p-1">
                        <div class="p-05">
                            <?php Template::render('include/item_admin_buttons.latte', ['item' => $item]); ?>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

                <div class="p-1">
                    <?php $items = (new Item)->where('parent', $item->id)->orderBy(['sort', 'date', 'id'])->get()->all(); ?>
                    <?php if ($items): ?>
                        <?php foreach ($items as $item): ?>
                            <?php if ($item->published || $item->author): ?>
                                <?php Template::render(_PLUGIN_PATH . $item->plugin_url . '/template/' . $item->file, ['item' => $item]); ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </article>
        </div>

    </div>
</div>
