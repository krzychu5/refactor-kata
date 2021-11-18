<?php

namespace App;

final class GildedRose
{
    public function updateQuality($item)
    {
        $item->quality = $item->getNewQuality();
        $item->sell_in = $item->getNewSellIn();
    }

}
