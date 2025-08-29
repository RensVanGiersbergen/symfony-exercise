<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\NumberGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NumberController extends AbstractController
{
    // Dependency injection of the NumberGenerator service
    public function __construct(private NumberGenerator $numberGenerator)
    {
    }

    // Page: Generate a random number (between min and max)
    #[Route('/number/{min}/{max}', name: 'number', requirements: ['min' => '\d+', 'max' => '\d+'])]
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

        return $this->render('number/index.html.twig', [
            'number' => $number,
            'min' => $min,
            'max' => $max,
        ]);
    }

    // Endpoint: API that returns a random number between min and max in JSON format
    #[Route('/api/number/{min}/{max}', name: 'api_number')]
    public function apiNumber(int $min = 0, int $max = 100): Response
    {
        // Input validation
        if ($min >= $max) {
            return new Response(
                json_encode(['error' => 'min should be less than max']),
                400,
                ['Content-Type' => 'application/json']
            );
        }

        $number = $this->numberGenerator->generate($min, $max);

        return new Response(
            json_encode(['number' => $number, 'min' => $min, 'max' => $max]),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}