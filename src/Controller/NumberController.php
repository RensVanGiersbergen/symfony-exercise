<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\NumberGenerator;

class NumberController
{
    // Dependency injection of the NumberGenerator service
    public function __construct(private NumberGenerator $numberGenerator)
    {
    }

    // Endpoint: Generate a random number (between min and max)
    #[Route('/number/{min}/{max}', requirements: ['min' => '\d+', 'max' => '\d+'])]
    public function number(int $min = 0, int $max = 100): Response
    {
        // Input validation
        if ($min >= $max) {
            return new Response(
                '<html><body>Error: min should be less than max</body></html>',
                400
            );
        }

        $number = $this->numberGenerator->generate($min, $max);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    // Endpoint: API that returns a random number between 1 and 100 in JSON format
    #[Route('/api/number')]
    public function apiNumber(): Response
    {
        $number = $this->numberGenerator->generate(1, 100);

        return new Response(
            json_encode(['number' => $number, 'min' => 1, 'max' => 100]),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}