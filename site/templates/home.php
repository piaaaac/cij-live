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
			<div class="highlight">
				<p class="label font-sans-m color-orange">
					<!-- <?= ucfirst($p->programType()->value()) ?> -->
					NOW PLAYING
				</p>
				<div class="vspace"></div>
				<h1 class="title color-white font-bit-xl font-bold max-text-w">
					<?= $p->title() ?>
				</h1>
				<div class="vspace"></div>
				
				<div class="watch">
					<a class="huge-button" onclick="a.setMode('watching');">WATCH</a>
				</div>

			</div>

			<div class="close-programs"><a onclick="a.home();">x</a></div>
		</div>
		
		<?php $index = 1;
		foreach ($channels as $channel) {
			snippet("render-channel", ["channel" => $channel, "index" => $index]); 
			$index++;
		}
		?>

	</section>

	<div 
		id="logo-watching"
		class="test font-bit-l color-white"
		style="position: fixed; top: 20px; left: 20px;"
		onclick='a.setMode("navigation");'
	><a>= cij <span class="color-purple">stream</span></a></div>


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
	
	a.initBgVideo('<?= $p->vimeo()->value() ?>', '<?= $p->title() ?>');

</script>


<?php snippet("footer") ?>
