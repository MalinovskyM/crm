<?php


namespace App\Helper;


use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiHelper
{
    public static function getCompanyId()
    {
        return User::find(Auth::id())->company->id;
    }

    public static function getCompanyUser()
    {
        $company = Company::find(self::getCompanyId());
        return $company;
    }

    public static function getUserRoleById()
    {
        $user = User::find( Auth::id() )->role_id;

        return $user;
    }

    public static function customMultiSort($array,$field,$sort = SORT_DESC) {
        $sortArr = array();
        foreach($array as $key=>$val){
            $sortArr[$key] = $val[$field];
        }

        array_multisort($sortArr ,$sort,$array);

        return $array;
    }
}
