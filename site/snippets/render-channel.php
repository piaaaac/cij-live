<?php 

/**
 * @param $channel 	— Kirby page
 * @param $index 		— Channel number (1-based)
 */


$template = $channel->template()->name();

$onChannelClick = "";
if ($template == "channel") {
	$firstVideo = $channel->videoList()->toPages()->first();
	$onChannelClick = "onclick=\"a.changeVideo('". $firstVideo->vimeo()->value() ."', '". $firstVideo->title() ."');\"";
} elseif ($template == "channel-stream") {
	$onChannelClick = "onclick=\"alert('Live stream will start.');\"";
}
?>

<div id="channel-<?= $index ?>" class="column" data-channel-number="">
	<div class="rotated-bar">
		<a class="font-bit-xl color-white" <?= $onChannelClick ?>>
			<?= $index ?>&nbsp;&nbsp;&nbsp;<?= $channel->title() ?>
		</a>
		<a class="font-bit-xl color-white" onclick="a.toggleSchedule('channel-<?= $index ?>');">
			<span class="arrow"></span>
		</a>
	</div>
	<div class="schedule">
		
		<?php if ($template == "channel-stream"): ?>
		
			<?php foreach ($channel->schedule()->toStructure() as $item): ?>
				
				<?php 
				$vId = $item->videoItem()->yaml()[0];
				$v = kirby()->page($vId);
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
					</div>
					<div class="right">
						<p class="font-sans-s color-purple mb-2 pb-1">INFO</p>
					</div>
				</div>
			<?php endforeach ?>
		
		<?php elseif ($template == "channel"): ?>

			<?php foreach ($channel->videoList()->toPages() as $v): ?>
				<div class="schedule-item">
					<div class="left">
						<p class="font-sans-s color-purple mb-2 pb-1"><?= $v->programType()->upper() ?></p>
						<a class="font-sans-m color-white clickable-title"
							onclick="a.changeVideo('<?= $v->vimeo()->value() ?>', '<?=$v->title() ?>', true);"
						><?= $v->title() ?></a>
					</div>
					<div class="right">
						<p class="font-sans-s color-purple mb-2 pb-1">INFO</p>
					</div>
				</div>
			<?php endforeach ?>
		
		<?php endif ?>

	</div>
</div>








