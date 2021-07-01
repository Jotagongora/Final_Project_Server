<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\UrlHelper;
use App\Entity\Post;

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

        foreach($user->getFriends() as $friend) {
            array_push($friends, [
                'id' => $friend->getId(),    
                'name' => $friend->getName(),
                'username' => $friend->getUsernam()
                ]);
            }

        foreach($user->getUsers() as $friend) {
            array_push($friends, [
                'id' => $friend->getId(),    
                'name' => $friend->getName(),
                'username' => $friend->getUsernam() 
                ]);
            }

        foreach($user->getPosts() as $post) {
             $postImg = '';
        if($post->getPostImage()) {
            $postImg = $this->urlHelper->getAbsoluteUrl('/post/post_img/'.$post->getPostImage());
        }

            array_push($posts, [
                'title' => $post->getTitle(),    
                'created_at' => $post->getStartAt(),
                'content_text' => $post->getContentText(),
                'post_img' => $postImg
                ]);
            }

       

        // $avatar = '';
        // if($employee->getAvatar()) {
        //     $avatar = $this->urlHelper->getAbsoluteUrl('/employee/avatar/'.$employee->getAvatar());
        // }
        return [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'username' => $user->getUsernam(),
            'friends' => $friends,
            'posts' => $posts
        ];
    }
}