<?php snippet("header") ?>

<?php 

$p = page("programs")->children()->shuffle()->first();

?>

<main>
	
	<section id="bg">
		<div id="bg-video" class=""></div>
	</section>
	
	<section id="ui">

		<div id="left" class="column">
			<div class="rotated-bar">
				<a class="font-bit-xl" onclick="a.home();">
					<span class="color-white">cij</span>
					<span class="color-purple">stream</span>
				</a>
			</div>
		</div>

		<div id="home" class="column expanded">
			<div class="highlight">
				<p class="font-sans-m color-orange">
					<?= ucfirst($p->programType()->value()) ?>
				</p>
				<div class="vspace"></div>
				<h1 class="color-white font-bit-xxl font-bold max-text-w">
					<?= $p->title() ?>
				</h1>
				<div class="vspace"></div>
				<a class="button" onclick="a.setMode('watching');">Watch now</a>
			</div>
		</div>
		
		<div id="channel-1" class="column">
			<div class="rotated-bar">
				<a class="font-bit-xl color-orange" onclick="a.channels(['channel-1']);">Channel 1</a>
			</div>
		</div>
		<div id="channel-2" class="column">
			<div class="rotated-bar">
				<a class="font-bit-xl color-orange" onclick="a.channels(['channel-2']);">Channel 2</a>
			</div>
		</div>
		<div id="channel-3" class="column">
			<div class="rotated-bar">
				<a class="font-bit-xl color-orange" onclick="a.channels(['channel-3']);">Channel 3</a>
			</div>
		</div>

	</section>


</main>

<?= js("assets/js/index.js") ?>

<script>
	
	var a = new App();
	a.initBgVideo({id: '<?= $p->vimeo()->value() ?>'});

</script>


<?php snippet("footer") ?>
