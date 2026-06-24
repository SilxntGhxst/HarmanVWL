<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{
    #[Route('/cambiar-idioma/{_locale}', name: 'app_switch_locale', requirements: ['_locale' => 'en|es'])]
    public function switchLocale(Request $request, string $_locale): Response
    {
        // Store the requested locale in the session
        $request->getSession()->set('_locale', $_locale);

        // Redirect to the referring page, or home if there is no referer
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('app_home');
    }
}
