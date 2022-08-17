<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="app_sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request): Response
    {
        $hostname = $request->getSchemeAndHttpHost();

        $url = [];

        $url[] = ['loc' => $this->generateUrl('app_home')];
        $url[] = ['loc' => $this->generateUrl('app_candidature')];
        $url[] = ['loc' => $this->generateUrl('app_contact')];
        $url[] = ['loc' => $this->generateUrl('app_us')];

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $url,
                'hostname' => $hostname]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
