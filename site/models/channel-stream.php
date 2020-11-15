<?php

class ChannelStreamPage extends Page {
  	
  public function getFirstDraftVideo () {

		$firstItem = $this->schedule()->toStructure()->filter(function ($item) {
			return $item->isActive()->toBool();
		})->first();
		$a = $firstItem->toArray();
		$id = $a["videoitem"][0];
		$firstVideo = page("videos")->drafts()->findById($id);

    return $firstVideo;
  }

}