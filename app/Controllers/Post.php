<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Post as ModelsPost;

class Post extends BaseController
{
    public function __construct()
    {
        $this->post = new ModelsPost();
    }
    public function index()
    {
        $logged_on         = session()->get('logged_on');

        if (!$logged_on) {
            # code...
            return redirect()->to('/');
        }

        $data = [
            'title'        => 'Post - Blog Lumut Dev',
            'datapost'      => $this->post->findAll(),
        ];

        return view('blog/blog_page', $data);
    }

    public function formadd()
    {
        if (!session()->get('logged_on')) {
            # code...
            return redirect()->to('/');
        }

        $data           = [
            'title'         => 'Tambah Post - Blog Lumut Dev',

        ];
        return view('blog/blog_formadd', $data);
    }

    public function addpost()
    {
        if (!session()->get('logged_on')) {
            # code...
            return redirect()->to('/');
        }

        $username = session()->get('username');
        $title    = $this->request->getPost('title');
        $content  = $this->request->getPost('content');

        $validation = \Config\Services::validation();

        $valid      = $this->validate([
            'title' => [
                'rules'     => 'required',
                'label'     => 'Judul Artikel',
                'errors'     => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ],
            'content' => [
                'rules'     => 'required',
                'label'     => 'Konten Artikel',
                'errors'     => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ]
        ]);

        if (!$valid) {
            # code...
            $message          = [
                'errorpost'        =>     '<div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                ' . $validation->listErrors() . '
                                            </div>'
            ];

            session()->setFlashdata($message);
            return redirect()->to('/post/formadd')->withInput();
        } else {
            $insert = $this->post->insert([
                'title' => $title,
                'content'   => $content,
                'date' => date('Y-m-d H:i:s'),
                'username' => $username,
            ]);

            if ($insert) {
                # code...
                $message = [
                    'successpost' => '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button> 
                                <h5><i class="icon fas fa-check fas-sm"></i>Berhasil !</h5>
                                Artikel berhasil ditambahkan ...
                                </div>',
                ];

                session()->setFlashdata($message);
                return redirect()->to('/post');
            } else {
                $message = [
                    'errorpost' => '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button> 
                                <h5><i class="icon fas fa-check fas-sm"></i>Berhasil !</h5>
                                Artikel gagal ditambahkan ...
                                </div>',
                ];

                session()->setFlashdata($message);
                return redirect()->to('/post/formadd')->withInput();
            }
        }
    }

    public function formupdate($id)
    {
        if (!session()->get('logged_on')) {
            # code...
            return redirect()->to('/');
        }

        $rowData = $this->post->find($id);

        if ($rowData) {
            # code...
            $data = [
                'id'       => $id,
                'titles'     => $rowData['title'],
                'content'     => $rowData['content'],
                'title'         => 'Update Post - Blog Lumut Dev',
            ];

            return view('blog/blog_formupdate', $data);
        } else {
            exit('Data tidak ditemukan !');
        }
    }

    public function updatepost()
    {
        if (!session()->get('logged_on')) {
            # code...
            return redirect()->to('/');
        }

        $id = $this->request->getPost('id');
        $title    = $this->request->getPost('title');
        $content  = $this->request->getPost('content');

        $validation = \Config\Services::validation();

        $valid      = $this->validate([
            'title' => [
                'rules'     => 'required',
                'label'     => 'Judul Artikel',
                'errors'     => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ],
            'content' => [
                'rules'     => 'required',
                'label'     => 'Konten Artikel',
                'errors'     => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ]
        ]);
        if (!$valid) {
            # code...
            $message          = [
                'errorpost'        =>     '<div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                ' . $validation->listErrors() . '
                                            </div>'
            ];

            session()->setFlashdata($message);
            return redirect()->to('/post/formupdate/' . $id . '')->withInput();
        } else {
            $update = $this->post->update($id, [
                'title' => $title,
                'content'   => $content,
            ]);

            if ($update) {
                # code...
                $message = [
                    'successpost' => '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button> 
                                <h5><i class="icon fas fa-check fas-sm"></i>Berhasil !</h5>
                                Artikel berhasil diubah ...
                                </div>',
                ];

                session()->setFlashdata($message);
                return redirect()->to('/post');
            } else {
                $message = [
                    'errorpost' => '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button> 
                                <h5><i class="icon fas fa-check fas-sm"></i>Berhasil !</h5>
                                Artikel gagal diubah ...
                                </div>',
                ];

                session()->setFlashdata($message);
                return redirect()->to('/post/formupdate/' . $id . '')->withInput();
            }
        }
    }

    public function delete($id)
    {

        if (!session()->get('logged_on')) {
            # code...
            return redirect()->to('/');
        }
        $rowData = $this->post->find($id);

        if ($rowData) {
            # code...
            $this->post->delete($id);

            $pesan = [
                'successpost' => '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button> 
                            <h5><i class="icon fas fa-check fas-sm"></i>Berhasil !</h5>
                            Artikel berhasil dihapus ...
                            </div>',
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/post');
        } else {
            exit('Data tidak ditemukan !');
        }
    }
}
