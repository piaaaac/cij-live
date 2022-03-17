<?php snippet("header") ?>

<?php 

$channels = new Pages();
$firstVideo = null;
$firstVideoVimeoId = null;
$thereIsLive = false;
$firstTitle = "";
$defaultLabel = "NOW PLAYING";
$streamLabel = $defaultLabel;
$streamLabels = ["now" => "NOW PLAYING", "coming" => "COMING UP"];

$liveChannel = page("channels")->children()->filterBy("template", "channel-stream")->first();
if ($liveChannel->streamActive()->toBool() && $liveChannel->streamId()->isNotEmpty()) {
	$thereIsLive = true;
	$streamLabelKey = $liveChannel->streamLabel()->value();
	$streamLabel = $streamLabels[$streamLabelKey];
	$firstVideo = $liveChannel->getFirstDraftVideo();
	$firstTitle = ($firstVideo !== null) ? $firstVideo->title()->value() : "Live session";
	$firstVideoVimeoId = $liveChannel->streamId()->value();
	$channels->add($liveChannel);
} else {
	$fitstChannel = page("channels")->children()->filterBy("template", "channel")->first();
	$firstVideo = $fitstChannel->videoList()->toPages()->first();
	$firstTitle = $firstVideo->title()->value();
	$firstVideoVimeoId = $firstVideo->vimeo()->value();
}
$channels->add(page("channels")->children()->listed()->filterBy("template", "channel"));

// $cssVariable = 'style="--chn: '. $channels->count() .';"';
 // style="--chn: <?= $channels->count() 0px;"
?>
<style>
	:root {
		--chn: <?= $channels->count() ?>;
	}
</style>
<main>
	
	<section id="bg">
		<div id="bg-video" class=""></div>
	</section>
	
	<section id="ui">

		<div id="top-left">
			<a class="font-bit-xl" onclick="a.home();">
				<span class="color-purple">cij</span>
				<span class="color-white">stream</span>
			</a>
		</div>

		<div id="home" class="">
			
			<div class="highlight-container">
				<div class="highlight">
					<p class="label color-orange">
						<span class="small-channel-num"></span>
						<span class="orange-label">NOW PLAYING</span>
					</p>
					<div class="vspace"></div>
					<h1 class="title color-white max-text-w">
						<?= $firstTitle ?>
					</h1>
					<!-- <div class="vspace"></div> -->
					
					<div class="watch">
						<a class="huge-button" onclick="a.setMode('watching');">WATCH</a>
					</div>

				</div>
			</div>

			<!-- <div class="close-programs"><a onclick="a.home();">x</a></div> -->

			<div id="now-playing-small" class="test font-sans-m color-white">
				<p class="font-sans-s mb-2 pb-1">
					<span class="small-channel-num"></span>
					<span class="label color-orange orange-label">NOW PLAYING</span>
				</p>
				<p class="font-sans-m color-white">
					<a class="title" onclick='a.setMode("watching");'></a>
				</p>
			</div>

		</div>
		
		<?php $index = 1;
		foreach ($channels as $channel) {
			snippet("render-channel", ["channel" => $channel, "index" => $index]); 
			$index++;
		}
		?>

	</section>

	<div id="grad-watching"></div>

	<div id="logo-watching" class="font-bit-xl">
		<a onclick='a.setMode("navigation");'>
			<!-- <span class="color-white d-none d-lg-inline">=</span> -->
			<span class="hamburger d-none d-lg-inline"><img src="<?= $kirby->url("assets") ?>/images/hamburger.svg" /></span>
			<span class="color-purple">cij</span>
			<span class="color-white">stream</span>
		</a>
	</div>

	<div id="now-playing-watching">
		<div class="texts font-sans-s color-white pt-1">
			<span class="small-channel-num"></span>
			<span class="label color-orange orange-label">NOW PLAYING</span>
			<span class="title color-white ml-2"></span>
		</div>
	</div>

	<div id="bottom-left">
		<img class="logan-logo" src="<?= $kirby->url('assets') ?>/images/logan-symposyum-2020-logo.svg" />
		
		<!--  
		<p class="mt-3"><a class="color-white font-sans-m" onclick="a.about();">About</a></p>
		<p class="mt-2"><a class="color-white-50 font-sans-m" href="https://tcij.org/logan-symposium/collective-intelligence/">Center for Investigative Journalism</a></p>
		-->

		<p class="mt-3">
			<a class="color-white hover-purple font-sans-m mr-3" onclick="a.toggleAbout();">About</a>
			<a class="color-white hover-purple font-sans-m mr-3" href="https://tcij.org/logan-symposium/collective-intelligence/">tcij.org</a>
		</p>
		<p class="mt-2">
			<a class="color-white-30 hover-purple font-sans-s mr-3" href="https://tcij.org/about/legal/" target="_blank">Privacy</a>
			<a class="credits color-white-30 font-sans-s mr-3" href="https://alexpiacentini.com" target="_blank">Site: <span>AP</span></a>
		</p>

	</div>

	<?php /* ABOUT MARKUP
	<p class="d-flex">
	<span class="scn mr-3 mt-1">1</span>
	<span>Live stream of the main stage sessions on November 16-19, 2020</span>
	</p>
	<p class="d-flex">
	<span class="scn mr-3 mt-1">2</span>
	<span>Sessions: Recordings of the main stage sessions available on demand</span>
	</p>
	<p class="d-flex">
	<span class="scn mr-3 mt-1">3</span>
	<span>Open Lab: Commissioned and curated videos from the (link: https://openlab.tcij.org/ text: CIJ Open Lab) database</span>
	</p>
	<p class="d-flex">
	<span class="scn mr-3 mt-1">4</span>
	<span>Archive: Staff picks from previous editions of the CIJ Logan Symposium</span>
	</p>
	*/ ?>
	<section id="about">
		<div class="content-wrapper">
			<h2 class="font-bit-xl color-white mb-5"><?= page("about")->title() ?></h2>
			<div class="text font-sans-m color-white mb-5"><?= page("about")->text()->kt() ?></div>
		</div>
		<a class="close-x font-bit-xl" onclick="a.toggleAbout();">x</a>
	</section>

	<!-- Mobile -->

	<div id="mob-menu">
		<p class="font-sans-s color-orange"><span class="small-channel-num">3</span></p>
		<a class="font-sans-m color-purple" onclick="a.toggleAbout();">About</a>
		<a class="font-sans-m color-purple" href="https://tcij.org">tcij.org</a>
		<span>&nbsp;</span>
	</div>

	<div id="mob-menu-btn"><a class="font-bit-xl color-white" onclick="a.toggleMobMenu();"></a></div>
	
</main>

<?= js("assets/js/index.js") ?>

<script>
	
	var a = new App();
	var channels;
	a.defaultOrangeLabel = '<?= $defaultLabel ?>';
	a.liveStream = {
		"isActive": <?= $thereIsLive ? "true" : "false" ?>,
		"orangeLabel": '<?= $streamLabel ?>',
		"vimeoId": <?= $thereIsLive ? '"'. $firstVideoVimeoId .'"' : "null" ?>,
		"channelNum": <?= $thereIsLive ? '"1"' : "null" ?>, // Live is always the first channel
	}
	// a.liveStreamVimeoId = '<?= $thereIsLive ? $firstVideoVimeoId : "null" ?>';
	// a.liveStreamLabel = '<?= $streamLabel ?>';
	// a.thereIsLive = <?= $thereIsLive ? "true" : "false" ?>;
	
	$(document).ready(function() {
		var callUrl = "<?= $site->url() ?>/channels.json";
		$.get(callUrl, null, function (result) {
			console.log(result);
			a.channelsData = result;
		});
	});
	
	a.initBgVideo('<?= $firstVideoVimeoId ?>', '<?= $firstTitle ?>', '1');

</script>


<?php snippet("footer") ?>
