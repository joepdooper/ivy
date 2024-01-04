<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$gig = (new \Gig\Item)->where('id', $item->table_id)->getRow()->data();
?>

<div class="<?php if($item->class): print $item->class; else:?>item item-gig col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $item->id; ?>">
	<div class="inner">

		<form action="<?php print _BASE_PATH . 'gig/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">

			<article>
				<div class="outer">
					<!-- Subject -->
					<?php if(isset($gig->subject)): ?>
						<div class="inner">
							<div class="tag">
								<?php $tag = (new \Tag\Item)->where('id', $gig->subject)->getRow()->data();?>
								<?php include _PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . 'tag/template/tag.php'); ?>
							</div>
						</div>
					<?php endif; ?>
					<!-- Titles -->
					<div class="inner d-flex align-items-baseline justify-content-between">
						<div class="gigdate">
							<?php if($item->author): ?>
								<?php $page->setDate('date',date('Y-m-d',strtotime($gig->datetime)),'date'.$item->id); ?>
							<?php else: ?>
								<h2><?php print date('d.m.y',strtotime($gig->datetime)); ?></h2>
							<?php endif; ?>
						</div>
						<div class="gigtime">
							<?php if($item->author): ?>
								<?php $page->setTime('time',date('H:i',strtotime($gig->datetime)),'time'.$item->id); ?>
							<?php else: ?>
								<small>
									<?php print date('H:i',strtotime($gig->datetime)); ?>
								</small>
							<?php endif; ?>
						</div>
					</div>
					<div class="inner">
						<div class="gigvenue">
							<?php if($item->author): ?>
								<?php \Text\Item::set('venue',$gig->venue,'venue'.$item->id)?>
							<?php else: ?>
								<p>
									<?php print $gig->venue; ?>
								</p>
							<?php endif; ?>
						</div>
						<div class="gigaddress">
							<?php if($item->author): ?>
								<?php \Text\Item::set('address',$gig->address,'address'.$item->id)?>
							<?php else: ?>
								<p>
									<?php print $gig->address; ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</article>

			<?php
			if ($auth->isLoggedIn()):
				include $page->setTemplateFile('buttons/item_admin_buttons.php');
			endif;
			?>

		</form>

	</div>
</div>
