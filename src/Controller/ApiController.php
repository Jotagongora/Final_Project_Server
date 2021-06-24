<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/api", name="api_")
     */
class ApiController extends AbstractController
{
    /**
     * @Route("/", name="cget", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json([
            'method' => 'CGET',
            'description' => 'Devuelve el listado del recurso completo'

        ]);
    }

    /**
     * @Route("/{id}", name="get", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function show(int $id): Response
    {
        return $this->json([
            'method' => "GET",
            'description' => "Devuelve un único recurso"

        ]);
    }

    /**
     * @Route("", name="post", methods={"POST"})
     */
    public function add(): Response 
    {
        return $this-> json([
            'method' => "POST",
            'description' => "Crea un recurso"
        ]);
    }
}
