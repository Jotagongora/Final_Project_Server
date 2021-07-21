<?php

namespace App\Service;

use App\Entity\Games;
use App\Entity\User;
use Symfony\Component\HttpFoundation\UrlHelper;


class GamePostsNormalize {
    private $urlHelper;

    public function __construct(UrlHelper $urlHelper) {
        $this->urlHelper = $urlHelper;
    }
    /**
     * Normalize a Game
     * 
     * @param Games
     * 
     * @return array/null
     */
    public function gameNormalize (Games $games): ? array {
        $gamePosts = [];
        $user = [];
        
        foreach ($games->getPostsGame() as $post) {

            $comments = [];

            foreach($post->getPostComments() as $comment) {
                array_unshift($comments, [
                    'comment_id' => $comment->getId(),
                    'author' => $comment->getAuthorId()->getUsernam(),
                    'author_id' => $comment->getAuthorId()->getId(),
                    'content_text' => $comment->getContentText(),
                    'created_at' => $comment->getCreatedAt()
                ]); 
            };

            $postImg = "";

            if($post->getPostImage()) {
                $postImg = $this->urlHelper->getAbsoluteUrl('/post/post_img/'.$post->getPostImage());
            }

            $avatar = "";

            $user = $post->getAuthorId();

            if($user != null && $user->getAvatar()) {
                $avatar = $this->urlHelper->getAbsoluteUrl('/profile/profile_img/'.$user->getAvatar());
            }

            $author = "";
            $author_id = "";
            
            if ($user != null) {
                $author = $user->getUsernam();
                $author_id = $user->getId();
            }

            array_unshift($gamePosts, [
                'author' => $author,
                'author_id' => $author_id,
                'title' => $post->getTitle(),    
                'created_at' => $post->getCreatedAt(),
                'content_text' => $post->getContentText(),
                'post_img' => $postImg,
                'post_avatar' => $avatar,
                'post_id' => $post->getId(),
                'likes' => count($post->getLikes()),
                'comments' => $comments
            ]);
        };
        
        // $avatar = '';
        // if($employee->getAvatar()) {
        //     $avatar = $this->urlHelper->getAbsoluteUrl('/employee/avatar/'.$employee->getAvatar());
        // }
        return [
            'id' => $games->getId(),
            'title' => $games->getTitle(),
            'gameImg' => $games->getGameUrl(),
            'releaseDate' => $games->getReleaseD(),
            'genre' => $games->getGenre(),
            'posts' => $gamePosts
        ];
    }
}