<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



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
     * @Route("/register", name="post", methods={"POST"})
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {
        $data = $request->request;

        $user = new User();


        $user->setName($data->get('name'));
        $user->setLastname($data->get('lastname'));
        $user->setUsernam($data->get('username'));
        $user->setEmail($data->get('email'));
        $plainPassword = $data->get('password');
        
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);

        $user->setRoles(['ROLE_USER']);
        
        $entityManager->persist($user);

        $entityManager->flush();

        return $response = new RedirectResponse('http://localhost:3000/Login');
        
    }
    
}
