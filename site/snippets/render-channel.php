<?php 

/**
 * @param $channel 	— Kirby page
 * @param $index 		— Channel number (1-based)
 */


$template = $channel->template()->name();

$onChannelClick = "";
if ($template == "channel") {
	
	if ($channel->videoList()->toPages()->count() > 0) {
		
		$validItems = $channel->videoList()->toPages()->filter(function ($p) {
			return $p->vimeo()->isNotEmpty();
		});
		
		// $firstVideo = $channel->videoList()->toPages()->first();
		$firstVideo = $validItems->first();

		$onChannelClick = "onclick=\"a.changeVideo('". $firstVideo->vimeo()->value() ."', '". $firstVideo->title() ."', '". $index ."');\"";
	}
} elseif ($template == "channel-stream") {
	// $onChannelClick = "onclick=\"alert('". $index ."');\"";
	$vimeoId = $channel->streamId()->value();
	$title = $channel->getFirstDraftVideo()->title()->value();
	$onChannelClick = "onclick=\"a.changeVideo('". $vimeoId ."', '". $title ."', '". $index ."');\"";
}
?>

<div id="channel-<?= $index ?>" class="column" data-channel-number="">
	<div class="rotated-bar">
		<a class="title font-bit-xl color-white" <?= $onChannelClick ?>>
			<?= $index ?>&nbsp;&nbsp;&nbsp;<?= $channel->title() ?>
		</a>
		<a class="arrow-wrapper font-bit-xl color-white-50 hover-white" onclick="a.toggleSchedule('channel-<?= $index ?>');">
			<span class="arrow "></span>
		</a>
	</div>
	<div class="schedule">
		
		<?php if ($template == "channel-stream"): ?>
		
			<div class="schedule-title">
				<h2 class="font-bit-xl color-white">Upcoming live sessions</h2>
			</div>

			<?php foreach ($channel->schedule()->toStructure() as $item): ?>

				<?php 
				if ($item->isActive()->toBool() === false) {
					continue;
				}
				$vId = $item->videoItem()->yaml()[0];
				$v = kirby()->page($vId);
				$descId = "desc-". $vId;
				$descId = "ch-$index-" . str_replace("/", "-", $descId);
				?>

				<div class="schedule-item stream">
					<div class="left">
						<p class="font-sans-s mb-2 pb-1">
							<span class="color-orange">
								<?= $item->itemdate()->toDate('M j') ." ". 
										$item->itemtimefrom()->toDate('G.i') ."-". 
										$item->itemtimeto()->toDate('G.i')
								?>
							</span>
							&nbsp;&nbsp;&nbsp;
							<span class="color-purple"><?= $v->programType()->upper() ?></span>
						</p>
						<span class="font-sans-m color-white"
							onclick="alert('Nothing here');"
						><?= $v->title() ?></span>
						<div class="description font-sans-m color-white" id="<?= $descId ?>"><?= $v->description()->kt() ?></div>
					</div>
					<div class="right">
						<?php if ($v->description()->isNotEmpty()): ?>
							<p class="font-sans-s color-purple mb-2 pb-1"><a data-toggle-desc="<?= $descId ?>"></a></p>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach ?>
		
		<?php elseif ($template == "channel"): ?>

			<?php foreach ($channel->videoList()->toPages() as $v): ?>

				<?php 
				$descId = "desc-". $v->id();
				$descId = "ch-$index-" . str_replace("/", "-", $descId);
				?>

				<div class="schedule-item">
					<div class="left">
						<p class="font-sans-s color-purple mb-2 pb-1"><?= $v->programType()->upper() ?></p>

						<!--  
						<a class="font-sans-m color-white clickable-title"
							onclick="a.changeVideo('<?= $v->vimeo()->value() ?>', '<?=$v->title() ?>', '<?= $index ?>', true);"
						><?= $v->title() ?></a>
						-->
						
						<p class="font-sans-m color-white"><?= $v->title() ?></p>
						<div class="description font-sans-m color-white" id="<?= $descId ?>"><?= $v->description()->kt() ?></div>
						<p class="mt-2 pt-2"><a class="button"
									onclick="a.changeVideo('<?= $v->vimeo()->value() ?>', '<?=$v->title() ?>', '<?= $index ?>', true);">
									WATCH NOW</a></p>

					</div>
					<div class="right">
						<?php if ($v->description()->isNotEmpty()): ?>
							<p class="font-sans-s color-purple mb-2 pb-1"><a data-toggle-desc="<?= $descId ?>"></a></p>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach ?>
		
		<?php endif ?>

	</div>
</div>








