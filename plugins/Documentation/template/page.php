<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$documentation = (new \Documentation\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="documentation">
	<div class="row">

		<div class="col-12 col-md-3">
			<div class="outer">
				<ul>
					<?php foreach ((new \Tag\Item)->get()->data() as $tag): ?>
						<li>
							<input id="tag-<?php print $tag->id; ?>" class="d-none tag-radio" type="radio" name="tag" <?php if($documentation->subject === $tag->id): ?>checked<?php endif; ?>>
							<label class="tag<?php if($documentation->subject === $tag->id): ?> active<?php endif; ?>" for="tag-<?php print $tag->id; ?>">
								<div class="inner">
									<?php print $tag->value; ?>
								</div>
							</label>
							<ul>
								<?php foreach ((new \Documentation\Item)->where('subject',$tag->id)->get()->data() as $link): ?>
									<?php if((new \Ivy\Item)->where('id',$link->item_id)->getRow()->data->published): ?>
										<li class="<?php if($link->item_id === \Ivy\Template::$content->id): ?>active<?php endif; ?>">
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

				<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
					<form action="<?php print _BASE_PATH . 'documentation/update/' . \Ivy\Template::$content->id . \Ivy\Template::$url; ?>" method="POST" enctype="multipart/form-data">
					<?php endif; ?>

					<div class="outer">

						<?php if(isset($documentation->subject)): ?>
							<!-- Subject -->
							<div class="inner">
								<?php $tag = (new \Tag\Item)->where('id', $documentation->subject)->getRow()->data();?>
								<?php include _PUBLIC_PATH . \Ivy\Template::setTemplateFile(_PLUGIN_PATH . 'Tag/template/tag.php'); ?>
							</div>
						<?php endif; ?>

						<!-- Titles -->
						<div class="inner">
							<h1><?php \Ivy\Template::$content->author ? \Text\Item::set('title',$documentation->title,'title') : print $documentation->title; ?></h1>
							<h2><?php \Ivy\Template::$content->author ? \Text\Item::set('subtitle',$documentation->subtitle,'subtitle') : print $documentation->subtitle; ?></h2>
						</div>

					</div>

					<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
						<div class="outer">
							<div class="inner">
								<?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
							</div>
						</div>
					</form>
				<?php endif; ?>

                <div class="outer">
                    <?php $items = (new \Ivy\Item)->where('parent',\Ivy\Template::$content->id)->orderBy(['sort', 'date', 'id'],'asc')->get()->data(); ?>
                    <?php if($items): ?>
                        <?php foreach($items as $item):?>
                            <?php if($item->published || $item->author): ?>
                                <?php include _PUBLIC_PATH . \Ivy\Template::setTemplateFile(_PLUGIN_PATH . $item->plugin_url. '/template/' . $item->file, $item); ?>
                            <?php endif; ?>
                        <?php endforeach;?>
                    <?php endif; ?>
                </div>

			</article>
		</div>

	</div>
</div>
