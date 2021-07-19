<?php

namespace App\Controller;

use App\Entity\AddedGame;
use App\Entity\Comment;
use App\Entity\Games;
use App\Entity\Photos;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\AddedGameRepository;
use App\Repository\GamesRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Service\GameNormalize;
use App\Service\UserNormalize;
use ContainerZ3R1Te2\getGameNormalizeService;
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
     * @Route("/Friend/{id}", name="fget", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function showFriend(UserNormalize $userNormalize, User $user): Response
    {
        return $this->json($userNormalize->userNormalize($user));
    }

    /**
     * @Route("/games", name="games", methods={"GET"})
     */
    public function games(GamesRepository $gamesRepository, GameNormalize $gameNormalize): Response
    {
        $games = $gamesRepository->findAll();

        return $this->json($games);
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
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
    public function addPost(Request $request, EntityManagerInterface $entityManager, UserNormalize $userNormalize, SluggerInterface $slug, GamesRepository $gamesRepository): Response
    {
        $data = $request->request;

        $now = new \DateTimeImmutable();

        $post = new Post();

        $gameId = $gamesRepository->find($data->get('game'));

        $post->setTitle($data->get('newTitlePost'));
        $post->setContentText($data->get('newContentPost'));
        $post->setGameId($gameId);
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
     * @Route("/addComment", name="comment", methods={"POST"})
     */
    public function addComment(Request $request, EntityManagerInterface $entityManager, UserNormalize $userNormalize, PostRepository $postRepository): Response
    {
        $data = $request->request;

        $comment = new Comment();

        $post = $postRepository->find($data->get('postId'));

        $now = new \DateTimeImmutable();


        $comment->setContentText($data->get('commentInput'));
        $comment->setAuthorId($this->getUser());
        $comment->setPostId($post);
        $comment->setCreatedAt($now);

        
        $entityManager->persist($comment);

        $entityManager->flush();

        return $this->json($userNormalize->userNormalize($this->getUser()));
    }

    /**
     * @Route("/addLike", name="like", methods={"POST"})
     */
    public function newLike(Request $request, EntityManagerInterface $entityManager,UserNormalize $userNormalize, PostRepository $postRepository): Response
    {
        $data = $request->request;

        $post = $postRepository->find($data->get('post'));

        $post->addLike($this->getUser());

        $entityManager->persist($post);

        $entityManager->flush();

        return $this->json($userNormalize->userNormalize($this->getUser()));
    }

     /**
     * @Route("/addGame", name="add_game", methods={"POST"})
     */
    public function addGameLibrary(Request $request, EntityManagerInterface $entityManager, GamesRepository $gamesRepository, AddedGameRepository $addedGameRepository): Response
    {
        $response = new Response;

        $data = $request->request;

        $gameId = $gamesRepository->find($data->get('gameId'));

        $gameAlreadyExist = $addedGameRepository->findByGameId($gameId);

        if ($gameAlreadyExist === null) {

        $game = new AddedGame();

        $now = new \DateTimeImmutable();

        $game->setUserId($this->getUser());
        $game->setGameId($gameId);
        $game->setAddedGameDate($now);


        $entityManager->persist($game);

        $entityManager->flush();

        } else {
            return $this->json($data);
        }

        return $response->setStatusCode(Response::HTTP_CREATED) ;
        
    }

    /**
     * @Route("/edit", name="edit", methods={"POST"})
     */
    public function editProfile(Request $request, EntityManagerInterface $entityManager,UserNormalize $userNormalize, SluggerInterface $slug): Response
    {
        $data = $request->request;

        if($data->get('username')) {
            $username = $data->get('username');

    
            
            $user = $this->getUser();

            $user->setUsernam($username);

            $entityManager->persist($user);

            $entityManager->flush();
        }

        
        
        if($request->files->has('file-avatar')) {
            $imageFile = $request->files->get('file-avatar');

            $imageOriginalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            $safeImageFilename = $slug->slug($imageOriginalFilename);

            $imageNewOriginalFilename = $safeImageFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            $user = $this->getUser();

            $user->setAvatar($imageNewOriginalFilename);

            $entityManager->persist($user);

            $entityManager->flush();

            try {
                $imageFile->move($request->server->get('DOCUMENT_ROOT') . DIRECTORY_SEPARATOR . 'profile/profile_img',
                $imageNewOriginalFilename
                
            );

            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }

        }

        if($request->files->has('file-upload')) {
            $imageFile = $request->files->get('file-upload');

            $imageOriginalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            $safeImageFilename = $slug->slug($imageOriginalFilename);

            $imageNewOriginalFilename = $safeImageFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            $user = $this->getUser();

            $user->setBgImage($imageNewOriginalFilename);

            $entityManager->persist($user);

            $entityManager->flush();

            try {
                $imageFile->move($request->server->get('DOCUMENT_ROOT') . DIRECTORY_SEPARATOR . 'profile/profile_img',
                $imageNewOriginalFilename
                
            );

            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }

        }

        return $this->json($userNormalize->userNormalize($this->getUser()));
    }
    
    
    /**
     * @Route("/photos", name="photos", methods={"POST"})
     */
    public function sendPhoto(Request $request, EntityManagerInterface $entityManager,UserNormalize $userNormalize, SluggerInterface $slug): Response
    { 
        
        if($request->files->has('file-upload')) {

            $imageFile = $request->files->get('file-upload');

            $imageOriginalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            $safeImageFilename = $slug->slug($imageOriginalFilename);

            $imageNewOriginalFilename = $safeImageFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            $photo = new Photos;

            $photo->setImage($imageNewOriginalFilename);

            $photo->setUser($this->getUser());

            $entityManager->persist($photo);

            $entityManager->flush();

            try {
                $imageFile->move($request->server->get('DOCUMENT_ROOT') . DIRECTORY_SEPARATOR . 'photos/photo_img',
                $imageNewOriginalFilename
                
            );

            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }

        }

        return $this->json($userNormalize->userNormalize($this->getUser()));
    }
    
}
