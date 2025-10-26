<?php

use Ivy\Template;
use Ivy\User;
use Serdie\Player;
use Serdie\WordList;

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->post('/wordlist/post', '\Serdie\WordList@post');

        $router->post('/player/post', '\Serdie\Player@post');

        $router->get('/serdie/wordlist', function () {
            $wordlist = (new Wordlist)->get()->all();
            Template::render(_PLUGINS_PATH . 'serdie/template/wordlist.php', ['wordlist' => $wordlist], 'main');
        });

        $router->get('/serdie/player', function () {
            $player = (new Player)->get()->all();
            Template::render(_PLUGINS_PATH . 'serdie/template/player.php', ['player' => $player], 'main');
        });

    }
}