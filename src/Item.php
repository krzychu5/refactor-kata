<?php

use App\ItemInterface;
namespace App;
interface InterfaceItem
{
  public function getNewQualityStrategy(int $sell_in, int $quality);
}
    class DefaultProductStrategy implements InterfaceItem {
      public function getNewQualityStrategy(int $sell_in, int $quality){
        if($sell_in <= 0){
          $result = $quality - 2;
        } else {
          $result = $quality - 1;
        }

        return $result;
      }
    }

    class AgedBrieProductStrategy implements InterfaceItem {
      public function getNewQualityStrategy(int $sell_in, int $quality){
        if($sell_in <= 0){
          $result = $quality + 2;
        } else {
          $result = $quality + 1;
        }

        return $result;
      }
    }

    class SulfurasProductStrategy implements InterfaceItem {
      public function getNewQualityStrategy(int $sell_in, int $quality){
        $result = 80;
        return $result;
      }
    }

    class BackstagePassesProductStrategy implements InterfaceItem {
      public function getNewQualityStrategy(int $sell_in, int $quality){
        if ($sell_in <= 0)
            $step = (-1) * $quality;
        else if ($sell_in <= 5)
            $step = 3;
        else if ($sell_in <= 10)
            $step = 2;
        else
            $step = 1;


        $result = $quality + $step;
        return $result;
      }
    }

//wzorzec strategi pozwala łatiwej zaimplementować nowe kategorie :)
    class NewCategoryProductStrategy implements InterfaceItem {
      public function getNewQualityStrategy(int $sell_in, int $quality){
        $result = $quality *2;
        return $result;
      }
    }

final class Item
{
    public $name;
    public $sell_in;
    public $quality;
    public $minQuality = 0;

    function __construct($name, $sell_in, $quality)
    {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString()
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

    public function nameContains(string $contain)
    {
        $name = str_replace(' ', '', strtoupper($this->name));
        $contain = str_replace(' ', '', strtoupper($contain));
        return(strpos($name, $contain) !== false)?true:false;
    }

    public function getNewSellIn()
    {
        if ($this->nameContains('Sulfuras'))
            return $this->sell_in;
        else
            return $this->sell_in - 1;
    }
    public function getMaxQuality()
    {
        if ($this->nameContains('Sulfuras'))
            return 80;
        else
            return 50;
    }

    public function getNewQuality(){
      if ($this->nameContains('Aged Brie'))
        $qualityNew = new AgedBrieProductStrategy();
      elseif ($this->nameContains('Sulfuras'))
        $qualityNew = new SulfurasProductStrategy();
      elseif ($this->nameContains('Backstage passes'))
        $qualityNew = new  BackstagePassesProductStrategy();
      elseif ($this->nameContains('new category'))
        $qualityNew = new  NewCategoryProductStrategy();
      else
        $qualityNew = new DefaultProductStrategy();

        $quality = $qualityNew->getNewQualityStrategy($this->sell_in, $this->quality);
        $min = $this->minQuality;
        $max = $this->getMaxQuality();

        if ($quality <= $min)
            $quality = $min;
        else if ($quality >= $max)
            $quality = $max;


        return $quality;

    }

}
