<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Auth as ModelsAuth;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->auth = new ModelsAuth();
    }
    public function index()
    {
        $logged_on = session()->get('logged_on');

        if ($logged_on) {
            # code...
            return redirect()->to('home');
        }

        return view('auth/sign_in');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = md5($this->request->getPost('password'));

        $validation = \Config\Services::validation();

        $valid          = $this->validate([
            'username'     => [
                'rules'         => 'required',
                'label'         => 'Username',
                'errors'        => [
                    'required'  => '{field} tidak boleh kosong !',
                ]
            ],
            'password'  => [
                'rules'         => 'required',
                'label'         => 'Password',
                'errors'        => [
                    'required'  => '{field} tidak boleh kosong !',
                ]
            ],
        ]);

        // validation process
        if (!$valid) {
            # code...
            // if validation failed and error
            $message          = [
                'errorlogin'        =>     '<div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                ' . $validation->listErrors() . '
                                            </div>'
            ];

            session()->setFlashdata($message);
            return redirect()->to('/')->withInput();
        } else {
            // if validation success
            // get count row
            $num_rows = $this->auth->where('username', $username)->countAllResults();

            // check row data
            if ($num_rows == 1) {
                # code...
                // if data row is 1

                // set key and value for select data at database
                $condition      = [
                    'username'  => $username,
                    'password'  => $password,
                ];

                // query get data user first row
                $userloggedon   = $this->auth->where($condition)
                    ->first();

                // if data user first not null
                if ($userloggedon) {
                    # code...
                    // set condition for save to session
                    $data       = [
                        'username'      => $userloggedon['username'],
                        'name'          => $userloggedon['name'],
                        'role'          => $userloggedon['role'],
                        'logged_on'     => true,
                    ];

                    // save to session
                    session()->set($data);

                    // and then redirect to dashboard
                    return redirect()->to('/home');
                } else {
                    // if data user first null
                    $message          = [
                        'errorlogin'        =>     '<div class="alert alert-danger alert-dismissible">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                        Maaf, email atau password salah !
                                                    </div>'
                    ];

                    session()->setFlashdata($message);
                    return redirect()->to('/')->withInput();
                }
            } else {
                // if data row null get error
                $message          = [
                    'errorlogin'        =>     '<div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    Maaf, akun tersebut belum terdaftar !
                                                </div>'
                ];

                session()->setFlashdata($message);
                return redirect()->to('/')->withInput();
            }
        }
    }

    public function logout()
    {
        session()->destroy();

        return  redirect()->to('/');
    }
}
