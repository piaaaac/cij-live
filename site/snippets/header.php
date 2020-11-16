<?php
$url = "https://stream.tcij.org";
$urlSocialImg = $url. "/assets/images/cij-stream-social-card.jpg";
$title = $site->title();
$desc = $site->siteDescription()->value();
?>

<!DOCTYPE html><html><head>

  <title><?= $title ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="description" content="<?= $desc ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <!-- TWITTER -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@cijlogan" />
  <meta name="twitter:title" content="<?= $title ?>" />
  <meta name="twitter:description" content="<?= $desc ?>" />
  <meta name="twitter:image" content="<?= $urlSocialImg ?>" />

  <!-- OG -->
  <meta property="og:url" content="<?= $url ?>" />
  <meta property="og:image" content="<?= $urlSocialImg ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= $title ?>" />
  <meta property="og:description" content="<?= $desc ?>" />

  <!-- Matomo? -->

  <!-- Favicon -->
  <!-- <link rel="apple-touch-icon" sizes="57x57" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-57x57.png"> -->
  <!-- <link rel="apple-touch-icon" sizes="76x76" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-76x76.png"> -->
  <!-- <link rel="apple-touch-icon" sizes="120x120" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-120x120.png"> -->
  <!-- <link rel="apple-touch-icon" sizes="144x144" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-144x144.png"> -->
  <!-- <link rel="icon" type="image/png" sizes="96x96" href="<?= $kirby->url('assets') ?>/favicon/1/favicon-96x96.png"> -->
  <!-- via https://www.emergeinteractive.com/insights/detail/the-essentials-of-favicons/ -->
  <link rel="apple-touch-icon" sizes="60x60" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $kirby->url('assets') ?>/favicon/1/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?= $kirby->url('assets') ?>/favicon/1/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= $kirby->url('assets') ?>/favicon/1/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= $kirby->url('assets') ?>/favicon/1/favicon-16x16.png">
  <link rel="manifest" href="<?= $kirby->url('assets') ?>/favicon/1/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?= $kirby->url('assets') ?>/favicon/1/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <!-- Vendor -->
  <script src="<?= $kirby->url('assets') ?>/lib/jquery-3.5.1/jquery-3.5.1.min.js"></script>
  <script src="https://player.vimeo.com/api/player.js"></script>

  <!-- Style -->
  <link rel="stylesheet" type="text/css" href="<?= $kirby->url("assets") ?>/css/bootstrap-custom.css">
  <link rel="stylesheet" type="text/css" href="<?= $kirby->url("assets") ?>/css/index.css">

</head>
<body>

