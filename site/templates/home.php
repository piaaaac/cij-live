<?php snippet("header") ?>

<?php 

$channels = new Pages();
$channels->add(page("channels")->children()->filterBy("template", "channel-stream")->first());
$channels->add(page("channels")->children()->filterBy("template", "channel"));

$p = page("videos")->children()->shuffle()->first();
$defaultChannel = 2;

?>

<main>
	
	<section id="bg">
		<div id="bg-video" class=""></div>
	</section>
	
	<section id="ui">

		<div id="left" class="column">
			<div class="rotated-bar">
				<div></div>
				<a class="font-bit-xl" onclick="a.home();">
					<span class="color-white">cij</span>
					<span class="color-purple">stream</span>
				</a>
			</div>
		</div>

		<div id="home" class="">
			
			<div class="highlight-container">
				<div class="highlight">
					<p class="label font-sans-m color-orange">
						<!-- <?= ucfirst($p->programType()->value()) ?> -->
						<span class="small-channel-num"></span>
						<span>NOW PLAYING</span>
					</p>
					<div class="vspace"></div>
					<h1 class="title color-white font-bit-xl font-bold max-text-w">
						<?= $p->title() ?>
					</h1>
					<!-- <div class="vspace"></div> -->
					
					<div class="watch">
						<a class="huge-button" onclick="a.setMode('watching');">WATCH</a>
					</div>

				</div>
			</div>

			<div class="close-programs"><a onclick="a.home();">x</a></div>

			<div id="now-playing-small" class="test font-sans-m color-white">
				<p class="font-sans-s mb-2 pb-1">
					<span class="small-channel-num"></span>
					<span class="label color-orange">NOW PLAYING</span>
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

	<div id="logo-watching"
			 class="test font-bit-l color-white"
			 onclick='a.setMode("navigation");'>
			 <a>= cij <span class="color-purple">stream</span></a>
	</div>

	<div id="bottom-left">
		<img class="logan-logo" src="<?= $kirby->url('assets') ?>/images/logan-symposyum-2020-logo.svg" />
		
		<!--  
		<p class="mt-3"><a class="color-white font-sans-m" onclick="a.about();">About</a></p>
		<p class="mt-2"><a class="color-white-50 font-sans-m" href="https://tcij.org/logan-symposium/collective-intelligence/">Center for Investigative Journalism</a></p>
		-->

		<p class="mt-3">
			<a class="color-white hover-purple font-sans-m mr-3" onclick="a.about();">About</a>
			<a class="color-white hover-purple font-sans-m mr-3" href="https://tcij.org/logan-symposium/collective-intelligence/" target="_blank">tcij.org</a>
		</p>

	</div>

</main>



<?= js("assets/js/index.js") ?>

<script>
	
	var a = new App();
	var channels;
	
	$(document).ready(function() {
		var callUrl = "<?= $site->url() ?>/channels.json";
		$.get(callUrl, null, function (result) {
			console.log(result);
			a.channelsData = result;
		});
	});
	
	a.initBgVideo('<?= $p->vimeo()->value() ?>', '<?= $p->title() ?>', '1');

</script>


<?php snippet("footer") ?>
