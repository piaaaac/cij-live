<?php snippet("header") ?>

<main>
	
	<section id="bg">
		<div id="bg-video" class="blurred"></div>
	</section>
	
	<section id="ui">

		<div id="left" class="column">
			<div class="rotated-bar">
				<a class="font-xl" onclick="a.home();">
					<span class="color-white">cij</span>
					<span class="color-orange">live</span>
				</a>
			</div>
		</div>

		<div id="home" class="column expanded">
			<h1 class="color-orange"><?= page("programs")->childrenAndDrafts()->shuffle()->first()->title() ?></h1>
		</div>
		
		<div id="channel-1" class="column">
			<div class="rotated-bar">
				<a class="font-xl color-orange" onclick="a.channels(['channel-1']);">Channel 1</a>
			</div>
		</div>
		<div id="channel-2" class="column">
			<div class="rotated-bar">
				<a class="font-xl color-orange" onclick="a.channels(['channel-2']);">Channel 2</a>
			</div>
		</div>
		<div id="channel-3" class="column">
			<div class="rotated-bar">
				<a class="font-xl color-orange" onclick="a.channels(['channel-3']);">Channel 3</a>
			</div>
		</div>

	</section>


</main>

<?= js("assets/js/index.js") ?>
<?php snippet("footer") ?>
