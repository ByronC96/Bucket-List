<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/{url}", name="fallback", requirements={"url"=".*"})
     */
    public function index(): RedirectResponse
    {
        return new RedirectResponse('/');
    }
}