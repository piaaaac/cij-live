<?php

$channels = page('channels')->children();
$json = [
	// "test" => [
	// 	"mao" => 4,
	// 	"bao" => "66"
	// ]
];

foreach($channels as $ch) {

	$channelData = [
    'type'  => $ch->channelType()->value(),
    'title' => (string)$ch->title(),
	];

	if ($ch->channelType()->value() == "videos") {

		$channelData["videos"] = [];
		// kill($ch->videoList()->to);
		foreach ($ch->videoList()->toPages() as $v) {
			$channelData["videos"][] = $v->content()->toArray();
		}

	} elseif ($ch->channelType()->value() == "stream") {
		$channelData["streamInfo"] = $ch->streamInfo()->vlaue();
	}

  $json[] = $channelData;

}

echo json_encode($json);

// function my_json_encode($data) {
//   if( json_encode($data) === false ) {
//     throw new Exception( json_last_error() );
//   }
// }

// try {
//   my_json_encode($json);
// }
// catch(Exception $e ) {
//   kill($e);
// }




