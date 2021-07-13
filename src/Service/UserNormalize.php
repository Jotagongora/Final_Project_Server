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
                    'author' => $comment->getAuthorId()->getUsernam(),
                    'content_text' => $comment->getContentText(),
                    'created_at' => $comment->getCreatedAt()
                ]);   
            
            }

            array_unshift($posts, [
                'title' => $post->getTitle(),    
                'created_at' => $post->getStartAt(),
                'content_text' => $post->getContentText(),
                'post_img' => $postImg,
                'post_avatar' => $avatar,
                'post_id' => $post->getId(),
                'comments' => $comments
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
            'avatar' => $avatar,
            'friends' => $friends,
            'posts' => $posts
        ];
    }
}