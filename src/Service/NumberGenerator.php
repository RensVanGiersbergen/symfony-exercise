<?php

namespace App\Service;

class NumberGenerator
{
    public function generate(int $min = 0, int $max = 100): int
    {
        return random_int($min, $max);
    }
}
