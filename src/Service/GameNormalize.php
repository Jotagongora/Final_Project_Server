<?php

namespace App\Service;

use App\Entity\Games;
use Symfony\Component\HttpFoundation\UrlHelper;


class GameNormalize {
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
        
        foreach ($games->getPostsGame() as $post) {
            array_push($gamePosts, [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'image' => $post->getGameUrl(),
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
            'releaseDate' => $games->getReleaseDate(),
            'genre' => $games->getGenre(),
            'posts' => $gamePosts
        ];
    }
}