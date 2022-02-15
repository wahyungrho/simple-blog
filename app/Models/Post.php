<?php

namespace App\Models;

use CodeIgniter\Model;

class Post extends Model
{
    protected $table            = 'post';
    protected $primaryKey       = 'idpost';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'idpost',
        'title',
        'content',
        'date',
        'username',
    ];
}
