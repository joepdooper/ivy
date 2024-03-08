<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$gig = (new \Gig\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="<?php if(\Ivy\Template::$content->class): print \Ivy\Template::$content->class; else:?>item item-gig col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print \Ivy\Template::$content->id; ?>">
	<div class="inner">

		<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
			<form action="<?php print _BASE_PATH . 'gig/update/' . \Ivy\Template::$content->id . \Ivy\Template::$url; ?>" method="POST" enctype="multipart/form-data">
		<?php endif; ?>

			<div class="item-wrap bg-secondary">
				<article>
					<div class="outer">
						<!-- Subject -->
						<?php if(isset($gig->subject)): ?>
							<div class="inner">
								<div class="tag">
									<?php $tag = (new \Tag\Item)->where('id', $gig->subject)->getRow()->data();?>
									<?php include _PUBLIC_PATH . \Ivy\Template::setTemplateFile(_PLUGIN_PATH . 'Tag/template/tag.php'); ?>
								</div>
							</div>
						<?php endif; ?>
						<!-- Titles -->
						<div class="inner d-flex align-items-baseline justify-content-between">
							<div class="gigdate">
								<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
									<input class="editor form-control" type="date" id="date_<?php echo \Ivy\Template::$content->id; ?>" name="date" value="<?php echo date('Y-m-d',strtotime($gig->datetime)); ?>">
								<?php else: ?>
									<h2><?php print date('d.m.y',strtotime($gig->datetime)); ?></h2>
								<?php endif; ?>
							</div>
							<div class="gigtime">
								<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
									<input class="editor form-control" type="time" id="time_<?php echo \Ivy\Template::$content->id; ?>" name="time" value="<?php echo date('H:i',strtotime($gig->datetime)); ?>">
								<?php else: ?>
									<small>
										<?php print date('H:i',strtotime($gig->datetime)); ?>
									</small>
								<?php endif; ?>
							</div>
						</div>
						<div class="inner">
							<div class="gigvenue">
								<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
									<?php \Text\Item::set('venue',$gig->venue,'venue'.\Ivy\Template::$content->id)?>
								<?php else: ?>
									<p>
										<?php print $gig->venue; ?>
									</p>
								<?php endif; ?>
							</div>
							<div class="gigaddress">
								<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
									<?php \Text\Item::set('address',$gig->address,'address'.\Ivy\Template::$content->id)?>
								<?php else: ?>
									<p>
										<?php print $gig->address; ?>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</article>
			</div>

			<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
				<?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
				</form>
			<?php endif; ?>

	</div>
</div>
