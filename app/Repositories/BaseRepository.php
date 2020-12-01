<?php


namespace App\Repositories;


use App\Helper\ApiHelper;
use App\Http\Controllers\Api\BaseController;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseRepository implements RepositoryInterface
{
    /**
     * @var $model Illuminate\Database\Eloquent\Model
     */
    public $model;
    protected $rule;
    public $response;
    /**
     * Инициализация BaseController для отправки ответов
     */
    public function initialize_response()
    {
        $this->response = new BaseController();
    }

    /**
     * @return Illuminate\Database\Eloquent\Model
     * Базовый метод для получения всего по модели
     */
    public function all()
    {
        return $this->model::all();
    }

    /**
     * @return Illuminate\Database\Eloquent\Model
     * Базовый метод для получение всего по модели с проверкой по компании
     */
    public function allByCompany($array_id = null)
    {
        if (is_null($array_id) || is_bool($array_id)){
            $model_obj = $this->model::where( 'company_id',ApiHelper::getCompanyId() )->get();
        }else{
            $model_obj = $this->model::where( 'company_id',ApiHelper::getCompanyId() )->whereNotIn('id', $array_id)->get();
        }

        return $model_obj;
    }

    /**
     * @param $id
     * @return Illuminate\Database\Eloquent\Model
     * Базовый метод для поиска модели по $id
     */
    public function find($id)
    {
        $model_obj = $this->model::find($id);
        if ( is_null( $model_obj ) ) {
            return $this->response->sendError('Find error', __('messages.not_find_model', [ 'model' => $this->model , 'id' =>$id ] ) ,1);
        }

        return $model_obj;
    }

    /**
     * @param $id
     * @return Illuminate\Database\Eloquent\Model
     * Базовый метод для поиска модели через ORM метод get
     * Возвращает коллекцию
     */
    public function findGet($id)
    {
        $model_obj = $this->model::where('id',$id)->get();
        if (count($model_obj) == 0) {
            return $this->response->sendError('Find error', __('messages.not_find_model', [ 'model' => $this->model , 'id' =>$id ] ) ,1);
        }

        return $model_obj;
    }

    /**
     * @param $id
     * @return Illuminate\Database\Eloquent\Model
     * Базовый метод поиска модели по id и по компании
     */
    public function findByCompany($id)
    {
        $model_obj = $this->model::where('id',$id)->where( 'company_id',ApiHelper::getCompanyId() )->count();
        if ($model_obj === 0) {
            return $this->response->sendError('Find error', __('messages.not_find_model', [ 'model' => $this->model , 'id' =>$id ] ) ,1);
        }

        return $this->model::find($id);
    }

    /**
     * @param Request $data
     * @param null $exceptions
     * @return array
     * Базовый метод валидации
     * Возвращает отвалидированый массив с Request
     */
    public function validate(Request $data, $exceptions = null)
    {
        if ($exceptions == null) {
            $input = $data->all();
        } else {
            $input = $data->only($exceptions);
        }
        $validator = Validator::make($input,$this->rule);
        if( $validator->fails() ) {
            return $this->response->sendError('Find error',$validator->errors(),1);
        }

        return $input;
    }

    /**
     * @param $input_data
     * @param $data
     * @return mixed
     * Метод для добавления данных , в масиив после валидации
     */
    public function addToData($input_data, $data)
    {
        foreach ( $data as $key => $value ) {
            $input_data[$key] = $value;
        }

        return $input_data;
    }


    /**
     * @param $input
     * @return Illuminate\Database\Eloquent\Model
     * Базовый метод создания
     */
    protected function create($input)
    {
        /**
         * Создание модели
         */
        $model_obj = $this->model::create($input);

        return $model_obj;
    }

    /**
     * @param $id
     * @param $data
     * @param bool $find
     * @return Illuminate\Database\Eloquent\Model
     * Базовый метод обновления модели
     */
    protected function update($id, $data,$find=false)
    {
        if ( $find ){
            $model_obj = $this->find($id);
        }else{
            //$model_obj = $this->findByCompany($id);
            $model_obj = $this->find($id);
        }

        $model_obj->fill($data);
        $model_obj->save();

        return $model_obj;
    }

    /**
     * @param $id
     * @param bool $find
     * @return Illuminate\Database\Eloquent\Model
     * Базовый метод удаления модели
     */
    protected function destroy($id,$find=false,$delete_permission_object = true)
    {

        if ( $find ){
            $model_obj = $this->find($id);
        }else {
            $model_obj = $this->find($id);
//            $model_obj = $this->findByCompany($id);
        }

        $model_obj->delete();

        return $model_obj;
    }
}
