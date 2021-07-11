<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use App\Service\UserNormalize;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
     * @Route("/api", name="api_")
     */
class ApiController extends AbstractController
{
    /**
     * @Route("/", name="cget", methods={"GET"})
     */
    // public function index(UserNormalize $userNormalize): Response
    // {
    //     return-$$this->jason($userNormalize->userNormalize($user));

    // }

    /**
     * @Route("/{id}", name="get", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function showFriends(UserNormalize $userNormalize, User $user): Response
    {
        return $this->json($userNormalize->userNormalize($user));
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

     /**
     * @Route("/addPost", name="post", methods={"POST"})
     */
    public function addPost(Request $request, EntityManagerInterface $entityManager, UserNormalize $userNormalize, SluggerInterface $slug): Response
    {
        $data = $request->request;

        $now = new \DateTimeImmutable();

        $post = new Post(); 

        $post->setTitle($data->get('newTitlePost'));
        $post->setContentText($data->get('newContentPost'));
        $post->setAuthorId($this->getUser());
        $post->setStartAt($now);

        if($request->files->has('postImage')) {
            $imageFile = $request->files->get('postImage');

            $imageOriginalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            $safeImageFilename = $slug->slug($imageOriginalFilename);

            $imageNewOriginalFilename = $safeImageFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            $post->setPostImage($imageNewOriginalFilename);

            try {
                $imageFile->move($request->server->get('DOCUMENT_ROOT') . DIRECTORY_SEPARATOR . 'post/post_img',
                $imageNewOriginalFilename
                
            );

            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }
        }

        


        
        $entityManager->persist($post);

        $entityManager->flush();

        return $this->json($userNormalize->userNormalize($this->getUser()));

        
    }

     /**
     * @Route("/addComment", name="post", methods={"POST"})
     */
    public function addComment(Request $request, EntityManagerInterface $entityManager, UserNormalize $userNormalize): Response
    {
        $data = $request->request;

        $comment = new Comment();

        $now = new \DateTimeImmutable();


        $comment->setContentText($data->get('commentInput'));
        $comment->setAuthorId($this->getUser());
        $comment->setPostId($data->get('postAuthorId'));
        $comment->setCreatedAt($now);

        dump($data);

        
        $entityManager->persist($comment);

        $entityManager->flush();

        return $this->json($userNormalize->userNormalize($this->getUser()));
    }
    
    
}
