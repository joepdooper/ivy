<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Item;
use Ivy\Template;
global $auth;
$content = Template::$content;
$content->data = (new \Documentation\Item)->where('id', Template::$content->table_id)->getRow()->data();
?>

<div class="documentation">
	<div class="row">

		<div class="col-12 col-md-3">
			<div class="outer">
				<ul>
					<?php foreach ((new \Tag\Item)->get()->data() as $tag): ?>
						<li>
							<input id="tag-<?php print $tag->id; ?>" class="d-none tag-radio" type="radio" name="tag" <?php if($content->data->subject === $tag->id): ?>checked<?php endif; ?>>
							<label class="tag<?php if($content->data->subject === $tag->id): ?> active<?php endif; ?>" for="tag-<?php print $tag->id; ?>">
								<div class="inner">
									<?php print $tag->value; ?>
								</div>
							</label>
							<ul>
								<?php foreach ((new \Documentation\Item)->where('subject',$tag->id)->get()->data() as $link): ?>
									<?php if((new Item)->where('id',$link->item_id)->getRow()->data->published): ?>
										<li class="<?php if($link->item_id === Template::$content->id): ?>active<?php endif; ?>">
											<a href="<?php print _BASE_PATH . 'documentation/' . $link->item_id; ?>">
												<div class="inner"><?php print $link->title; ?></div>
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

		<div class="col-12 col-md-9">
			<article>

				<?php if ($auth->isLoggedIn() && Template::$content->author): ?>
					<form action="<?php print _BASE_PATH . 'documentation/update/' . Template::$content->id . Template::$url; ?>" method="POST" enctype="multipart/form-data">
					<?php endif; ?>

					<div class="outer">

						<?php if(isset($content->data->subject)): ?>
							<!-- Subject -->
							<div class="inner">
								<?php $tag = (new \Tag\Item)->where('id', $content->data->subject)->getRow()->data();?>
								<?php include _PUBLIC_PATH . Template::file(_PLUGIN_PATH . 'Tag/template/tag.php'); ?>
							</div>
						<?php endif; ?>

						<!-- Titles -->
						<div class="inner">
							<h1><?php Template::$content->author ? \Text\Item::set('title',$content->data->title,'title') : print $content->data->title; ?></h1>
							<h2><?php Template::$content->author ? \Text\Item::set('subtitle',$content->data->subtitle,'subtitle') : print $content->data->subtitle; ?></h2>
						</div>

					</div>

					<?php if ($auth->isLoggedIn() && Template::$content->author): ?>
						<div class="outer">
							<div class="inner">
								<?php include Template::file('include/item_admin_buttons.php'); ?>
							</div>
						</div>
					</form>
				<?php endif; ?>

                <div class="outer">
                    <?php $items = (new Item)->where('parent', Template::$content->id)->orderBy(['sort', 'date', 'id'],'asc')->get()->data(); ?>
                    <?php if($items): ?>
                        <?php foreach($items as $item):?>
                            <?php if($item->published || $item->author): ?>
                                <?php include _PUBLIC_PATH . Template::file(_PLUGIN_PATH . $item->plugin_url. '/template/' . $item->file, $item); ?>
                            <?php endif; ?>
                        <?php endforeach;?>
                    <?php endif; ?>
                </div>

			</article>
		</div>

	</div>
</div>
