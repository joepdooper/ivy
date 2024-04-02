<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

use Ivy\Profile;
use Ivy\Template;

global $auth;

$content = Template::$content;
$content->data = (new \Article\Item)->where('id', $content->table_id)->getRow()->data();
?>

<div class="<?php if($content->style): print $content->style; else:?>item item-article col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $content->id; ?>">
    <div class="inner">

        <a class="item-wrap bg-secondary" href="<?php print _BASE_PATH . 'article/' . $content->id; ?>">
            <?php if(!empty($content->data->image)): ?>
                <?php \Image\Item::set('image', $content->data->image); ?>
            <?php endif; ?>
            <article>
                <div class="outer">
                    <!-- Subject -->
                    <div class="inner">
                        <div class="tag">
                            <?php
                            $tag = (new \Tag\Item)->where('id', $content->data->subject)->getRow()->data();
                            print $tag->value;
                            ?>
                        </div>
                    </div>
                    <!-- Titles -->
                    <div class="inner">
                        <h1><?php print $content->data->title; ?></h1>
                        <h2><?php print $content->data->subtitle; ?></h2>
                    </div>
                    <!-- Author -->
                    <div class="inner">
                        <?php
                        $author = (new Profile)->where('id', $content->user_id)->getRow()->data();
                        $author->date = $content->date;
                        include Template::file('include/author.php', $author);
                        ?>
                    </div>
                </div>
            </article>
        </a>

        <?php if ($auth->isLoggedIn() && $content->author): ?>
            <form action="<?php print _BASE_PATH . 'article/update/' . $content->id; ?>" method="POST" enctype="multipart/form-data">
                <?php include Template::file('include/item_admin_buttons.php', $content); ?>
            </form>
        <?php endif; ?>

    </div>
</div>
