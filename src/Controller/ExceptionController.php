<?php

namespace App\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseExceptionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController extends BaseExceptionController
{
    /**
     * {@inheritdoc}
     */
    public function showException(Request $request, \Exception $exception, DebugLoggerInterface $logger = null)
    {
        // Personnalisez le code ici si nécessaire

        return parent::showException($request, $exception, $logger);
    }
}
