<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Template;
global $auth;
$content = Template::$content;
$content->data = (new \Gig\Item)->where('id', $content->table_id)->getRow()->data();
?>

<div class="<?php if($content->class): print $content->class; else:?>item item-gig col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $content->id; ?>">
	<div class="inner">

		<?php if ($auth->isLoggedIn() && $content->author): ?>
			<form action="<?php print _BASE_PATH . 'gig/update/' . $content->id . Template::$url; ?>" method="POST" enctype="multipart/form-data">
		<?php endif; ?>

			<div class="item-wrap bg-secondary">
				<article>
					<div class="outer">
						<!-- Subject -->
						<?php if(isset($content->data->subject)): ?>
							<div class="inner">
								<div class="tag">
									<?php $tag = (new \Tag\Item)->where('id', $content->data->subject)->getRow()->data();?>
									<?php include _PUBLIC_PATH . Template::file(_PLUGIN_PATH . 'Tag/template/tag.php'); ?>
								</div>
							</div>
						<?php endif; ?>
						<!-- Titles -->
						<div class="inner d-flex align-items-baseline justify-content-between">
							<div class="gigdate">
								<?php if ($auth->isLoggedIn() && $content->author): ?>
									<input class="editor form-control" type="date" id="date_<?php echo $content->id; ?>" name="date" value="<?php echo date('Y-m-d',strtotime($content->data->datetime)); ?>">
								<?php else: ?>
									<h2><?php print date('d.m.y',strtotime($content->data->datetime)); ?></h2>
								<?php endif; ?>
							</div>
							<div class="gigtime">
								<?php if ($auth->isLoggedIn() && $content->author): ?>
									<input class="editor form-control" type="time" id="time_<?php echo $content->id; ?>" name="time" value="<?php echo date('H:i',strtotime($content->data->datetime)); ?>">
								<?php else: ?>
									<small>
										<?php print date('H:i',strtotime($content->data->datetime)); ?>
									</small>
								<?php endif; ?>
							</div>
						</div>
						<div class="inner">
							<div class="gigvenue">
								<?php if ($auth->isLoggedIn() && $content->author): ?>
									<?php \Text\Item::set('venue',$content->data->venue,'venue'. $content->id)?>
								<?php else: ?>
									<p>
										<?php print $content->data->venue; ?>
									</p>
								<?php endif; ?>
							</div>
							<div class="gigaddress">
								<?php if ($auth->isLoggedIn() && $content->author): ?>
									<?php \Text\Item::set('address',$content->data->address,'address'. $content->id)?>
								<?php else: ?>
									<p>
										<?php print $content->data->address; ?>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</article>
			</div>

			<?php if ($auth->isLoggedIn() && $content->author): ?>
				<?php include Template::file('include/item_admin_buttons.php'); ?>
				</form>
			<?php endif; ?>

	</div>
</div>
