<?php

namespace App\Http\Controllers;

class GamesController extends Controller
{
    public function index()
    {
        return view('games.index');
    }

    public function quiz()
    {
        return view('games.quiz');
    }

    public function word()
    {
        return view('games.word');
    }

    public function sim()
    {
        return view('games.sim');
    }
}


