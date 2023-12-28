<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$docs = (new docs\Item)->where('id', $item->table_id)->getRow()->data();
?>

<div class="docs">
	<div class="row">

		<div class="col-12 col-md-3">
			<div class="outer">
				<ul>
					<?php foreach ((new tag\Item)->get()->data() as $tag): ?>
						<li>
							<input id="tag-<?php print $tag->id; ?>" class="visually-hidden tag-radio" type="radio" name="tag" <?php if($docs->subject === $tag->id): ?>checked<?php endif; ?>>
							<label class="tag<?php if($docs->subject === $tag->id): ?> active<?php endif; ?>" for="tag-<?php print $tag->id; ?>">
								<div class="inner">
									<?php print $tag->value; ?>
								</div>
							</label>
							<ul>
								<?php foreach ((new docs\Item)->where('subject',$tag->id)->get()->data() as $link): ?>
									<?php if((new \Ivy\Item)->where('id',$link->item_id)->getRow()->data->published): ?>
									<li class="<?php if($link->item_id === $item->id): ?>active<?php endif; ?>">
										<a href="<?php print _BASE_PATH . 'docs/' . $link->item_id; ?>">
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

				<?php if ($item->author): ?>
					<form action="<?php print _BASE_PATH . 'docs/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">
					<?php endif; ?>

					<div class="outer">

						<?php if(isset($docs->subject)): ?>
							<!-- Subject -->
							<div class="inner">
								<?php $tag = (new tag\Item)->where('id', $docs->subject)->getRow()->data();?>
								<?php include _PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . 'tag/template/tag.php'); ?>
							</div>
						<?php endif; ?>

						<!-- Titles -->
						<div class="inner">
							<h1><?php $item->author ? text\Item::set('title',$docs->title,'title') : print $docs->title; ?></h1>
							<h2><?php $item->author ? text\Item::set('subtitle',$docs->subtitle,'subtitle') : print $docs->subtitle; ?></h2>
							<?php
							if ($auth->isLoggedIn()):
								include $page->setTemplateFile('buttons/item_admin_buttons.php');
							endif;
							?>
						</div>

					</div>

					<?php if($item->author): ?>
					</form>
				<?php endif; ?>

				<div class="outer">
					<?php $items = (new \Ivy\Item)->where('parent',$item->id)->orderBy(['sort', 'date', 'id'],'asc')->get()->data(); ?>
					<?php if($items): ?>
						<?php foreach($items as $item):?>
							<?php if($item->published || $item->author): ?>
								<?php include _PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . $item->plugin . '/template/' . $item->item_template_file); ?>
							<?php endif; ?>
						<?php endforeach;?>
					<?php endif; ?>
				</div>

				<?php include $page->setTemplateFile('content/add.php'); ?>

			</article>
		</div>

	</div>
</div>
