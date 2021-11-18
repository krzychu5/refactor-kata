<?php

namespace App;

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

    public function getMaxQuality()
    {
        if ($this->nameContains('Sulfuras'))
            return 80;
        else
            return 50;
    }

    public function sellDateHasPassed()
    {
        return $this->sell_in <= 0;
    }

    public function getNewQuality()
    {
        $min = $this->minQuality;
        $max = $this->getMaxQuality();
        $step = $this->getQualityStep();
        $new = $this->quality + $step;

        if ($new <= $min)
            $new = $min;
        else if ($new >= $max)
            $new = $max;

        return $new;
    }

    public function getNewSellIn()
    {
        if ($this->nameContains('Sulfuras'))
            return $this->sell_in;
        else
            return $this->sell_in - 1;
    }

    public function getQualityStep()
    {
        $step = (-1);

        if ($this->sellDateHasPassed())
            $step *= 2;

        if ($this->nameContains('Aged Brie'))
            $step *= (-1);

        if ($this->nameContains('Sulfuras'))
            $step = 0;

        if ($this->nameContains('Backstage passes'))
        {
            if ($this->sell_in <= 0)
                $step = (-1) * $this->quality;
            else if ($this->sell_in <= 5)
                $step = 3;
            else if ($this->sell_in <= 10)
                $step = 2;
            else
                $step = 1;
        }

        return $step;
    }


}
