<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function all();

    public function find($id);

    public function validate(Request $data,$exceptions = null);
}

