<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\UrlHelper;


class FriendNormalize {
    private $urlHelper;

    public function __construct(UrlHelper $urlHelper) {
        $this->urlHelper = $urlHelper;
    }
    /**
     * Normalize a Friend
     * 
     * @param User
     * 
     * @return array/null
     */
    public function friendNormalize (User $user): ? array {
        $friends = [];
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

        // $avatar = '';
        // if($employee->getAvatar()) {
        //     $avatar = $this->urlHelper->getAbsoluteUrl('/employee/avatar/'.$employee->getAvatar());
        // }
        return $friends;
    }
}