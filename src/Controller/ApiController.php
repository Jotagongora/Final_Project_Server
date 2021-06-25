<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = $request->request;

        $user = new User();


        $user->setName($data->get('name'));
        $user->setLastname($data->get('lastname'));
        $user->setUsername($data->get('username'));
        $user->setEmail($data->get('email'));
        $user->setPassword($data->get('password'));
        $user->setRoles(['ROLE_USER']);
        
        $entityManager->persist($user);

        $entityManager->flush();

        return $response = new RedirectResponse('http://localhost:3000/');
        
    }
    
}
