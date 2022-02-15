<?php

namespace App\Controllers;

use App\Models\Post;

class Home extends BaseController
{
    public function __construct()
    {
        $this->post = new Post();
    }
    public function index()
    {
        $logged_on         = session()->get('logged_on');

        if (!$logged_on) {
            # code...
            return redirect()->to('/');
        }

        $data = [
            'title'        => 'Beranda - Blog Lumut Dev',
            'datapost'     => $this->post->findAll(),
        ];

        return view('home/home_page', $data);
    }
}
