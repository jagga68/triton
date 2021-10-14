<?php

namespace App\Services;

class PromotionCalculator
{
    public function calculatePriceAfterPromotion(... $prices)
    {
        $start = 0;
        foreach($prices as $price)
        {
            $start+=$price;
        }
        return $start - ($start * $this->getPromotionPercentage() / 100);
    }

    public function getPromotionPercentage()
    {
        return (int) \file_get_contents('promotions.txt');
    }
}

?>