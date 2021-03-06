<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\UrlHelper;
use App\Entity\Post;
use App\Entity\Comment;

class UserNormalize {
    private $urlHelper;

    public function __construct(UrlHelper $urlHelper) {
        $this->urlHelper = $urlHelper;
    }
    /**
     * Normalize an User
     * 
     * @param User
     * 
     * @return array/null
     */
    public function userNormalize (User $user): ? array {
        $friends = [];
        $posts = [];
        $friends2 = [];
        $games = [];
        $photos = [];
        
        foreach ($user->getAddedGames() as $game) {
            array_push($games, [
                'added_id' => $game->getId(),
                'id' => $game->getGameId()->getId(),
                'title' => $game->getGameId()->getTitle(),
                'image' => $game->getGameId()->getGameUrl(),
            ]);
        };

        foreach($user->getFriends() as $friend) {

            foreach($friend->getUsers() as $friend2) {
                array_push($friends2, [
                    'id' => $friend2->getId(),
                    'name' => $friend2->getName(),
                    'username' => $friend2->getUsernam()
                ]);
            };

            array_push($friends, [
                'id' => $friend->getId(),    
                'name' => $friend->getName(),
                'username' => $friend->getUsernam(),
                'avatar' => $this->urlHelper->getAbsoluteUrl('/profile/profile_img/'.$friend->getAvatar()),
                'friends' => $friends2
                ]);
            }

        foreach($user->getUsers() as $friend) {

            foreach($friend->getFriends() as $friend2) {
                array_push($friends2, [
                    'id' => $friend2->getId(),
                    'name' => $friend2->getName(),
                    'username' => $friend2->getUsernam()
                ]);   
            };

            array_push($friends, [
                'id' => $friend->getId(),    
                'name' => $friend->getName(),
                'username' => $friend->getUsernam(),
                'avatar' => $this->urlHelper->getAbsoluteUrl('/profile/profile_img/'.$friend->getAvatar()),
                'friends' => $friends2
                ]);
            }

            $avatar = "";
            if($user->getAvatar()) {
                $avatar = $this->urlHelper->getAbsoluteUrl('/profile/profile_img/'.$user->getAvatar());
            } 

        foreach($user->getPosts() as $post) {
             $postImg = '';
             
            
             $comments = [];

        if($post->getPostImage()) {
            $postImg = $this->urlHelper->getAbsoluteUrl('/post/post_img/'.$post->getPostImage());
        }

            foreach($post->getPostComments() as $comment) {
                
                array_unshift($comments, [
                    'comment_id' => $comment->getId(),
                    'author' => $comment->getAuthorId()->getUsernam(),
                    'author_id' => $comment->getAuthorId()->getId(),
                    'content_text' => $comment->getContentText(),
                    'created_at' => $comment->getCreatedAt()
                ]);   
            
            }


            array_unshift($posts, [
                'author' => $post->getAuthorId()->getUsernam(),
                'author_id' => $post->getAuthorId()->getId(),
                'title' => $post->getTitle(),    
                'created_at' => $post->getCreatedAt(),
                'content_text' => $post->getContentText(),
                'post_img' => $postImg,
                'post_avatar' => $avatar,
                'post_id' => $post->getId(),
                'likes' => count($post->getLikes()),
                'comments' => $comments
                ]);
            }
        
        foreach($user->getPhotos() as $photo) {
            array_unshift($photos, [
                'image' => $this->urlHelper->getAbsoluteUrl('/photos/photo_img/'.$photo->getImage())
            ]);
        }
        
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'username' => $user->getUsernam(),
            'avatar' => $avatar,
            'photos' => $photos,
            'bg_image' => $this->urlHelper->getAbsoluteUrl('/profile/profile_img/'.$user->getBgImage()),
            'library' => $games,
            'friends' => $friends,
            'posts' => $posts
        ];
    }
}