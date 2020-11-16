<?php

class ChannelStreamPage extends Page {
  	
  public function getFirstDraftVideo () {

		$validItems = $this->schedule()->toStructure()->filter(function ($item) {
			return $item->isActive()->toBool();
		});

		if ($validItems->count() == 0) {
			return null;
		}

		$firstItem = $validItems->first();
		$a = $firstItem->toArray();
		$id = $a["videoitem"][0];
		$firstVideo = page("videos")->drafts()->findById($id);

    return $firstVideo;
  }

}