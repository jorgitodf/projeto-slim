<?php

namespace App\Models;

class Posts extends Model
{
    protected $table = "posts";

    public function posts()
    {
        $this->sql = "SELECT p.*, u.* FROM {$this->table} p INNER JOIN users u ON (u.id = p.user)";

        return $this;
    }
}