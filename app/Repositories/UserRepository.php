<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     * @param $model
     */
    public function __construct($model)
    {
        /**
         * Присвоение модели с которой будет работа
         */
        $this->model = $model;
        /**
         * Инициализация правил для валидации
         */
        $this->rule();
        /**
         * Инициализация BaseController для отправки ответов
         */
        $this->initialize_response();
    }

    /**
     * @param null $rule
     * установка правил валидации
     */
    public function rule($rule = null)
    {
        if ($rule == null) {
            $this->rule = [
                "name"          => "required",
                "password"      => "required|min:6",
                "email"         => "required",
            ];
        }else{
            $this->rule = $rule;
        }
    }

    public function checkAndCreate($data)
    {
        if($this->model::where('email',$data["email"])->count() > 0) {
            return $this->response->sendError('Find error', 'User exist!',1);
        }

        $data = $this->addToData($data,[ 'password' => Hash::make($data["password"]) , 'company_id' => '1' , "role_id" => '1']);

        $user = $this->create($data);

        return $user;
    }

    public function checkAndUpdate($id, $data)
    {
        $user = $this->update($id,$data);

        return $user;
    }

    public function checkAndDestroy($id)
    {
        $user = $this->destroy($id);

        return $user;
    }
}
