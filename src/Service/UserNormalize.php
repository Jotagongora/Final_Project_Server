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

        // $avatar = '';
        // if($employee->getAvatar()) {
        //     $avatar = $this->urlHelper->getAbsoluteUrl('/employee/avatar/'.$employee->getAvatar());
        // }
        return [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'username' => $user->getUsernam(),
            'friends' => $friends,
            'posts' => $user->getPosts()
        ];
    }
}