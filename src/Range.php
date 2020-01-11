<?php

namespace MichaelKing0\BaseRanges;

class Range
{
    private $base;
    private $amount;
    private $maxNumber;
    private $maxBits;

    public function __construct($base, $amount, $maxNumber = null, $maxBits = null)
    {
        $this->base = $base;
        $this->amount = $amount;
        $this->maxNumber = $maxNumber;
        $this->maxBits = $maxBits;
    }

    public function getMaxPages()
    {
        $highestNumber = 0;

        if ($this->maxNumber) {
            $highestNumber = $this->maxNumber;
        }

        if ($this->maxBits) {
            $number = $this->base ** $this->maxBits;

            if ($number > $highestNumber) {
                $highestNumber = $number;
            }
        }

        return ceil($highestNumber / $this->amount);
    }

    public function getRange($offset = 0)
    {
        $range = [];

        $number = 1 + ($this->amount * $offset);
        $i = 0;
        while ($i < $this->amount) {
            $baseNumber = base_convert($number, 10, $this->base);

            if ($this->maxBits) {
                $baseNumber = str_pad($baseNumber, $this->maxBits, '0', STR_PAD_LEFT);
            }

            if ($this->maxBits && strlen($baseNumber) > $this->maxBits) {
                break;
            }

            if ($this->maxNumber && $number > $this->maxNumber){
                break;
            }

            $range[] = $baseNumber;
            $number++;
            $i++;
        }

        if (count($range) === 0) {
            return null;
        }

        return $range;
    }

    public function getPrevPage($currentPage)
    {
        if ($currentPage === 1) {
            return null;
        }

        return $currentPage - 1;
    }

    public function getNextPage($currentPage)
    {
        if ($currentPage >= $this->getMaxPages()) {
            return null;
        }

        return $currentPage + 1;
    }
}
