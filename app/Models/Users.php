<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    public $timestamps = true;
    const _PER_PAGE = 20;
    public function filter($dataFilter){
        $keywords = $dataFilter['keywords'];
        $group_id = $dataFilter['group_id'];
        $is_blocked = $dataFilter['is_blocked'];
        $page = $dataFilter['page'];
        $limit = $dataFilter['limit'];
        $sortField = $dataFilter['sortField'];
        $sortType = $dataFilter['sortType'];

        $sortFields = [ 'id', 'fullname', 'phone', 'email', 'group_name' ];

        $page = empty($page) || !is_numeric($page) ? 1 : $page;
        $limit = empty($limit) || !is_numeric($limit) ? self::_PER_PAGE : $limit;
        $sortField = in_array(strtolower($sortField), $sortFields) ? $sortField : 'fullname';

        $sql = DB::table("$this->table AS u")
        ->leftJoin('groups AS g', 'u.group_id', '=', 'g.id')->where('u.is_deleted', '=', 0)
        ->where(function (Builder $query) use($is_blocked, $group_id) {
            if($is_blocked !== null && $is_blocked !== ''){
                $query->where('u.is_blocked', '=', $is_blocked);
            }
            if($group_id !== null && $group_id !== '') {
                $query->where('u.group_id', '=', $group_id);
            }
        })
        ->where(function (Builder $query) use($keywords) {
            $query->where('u.fullname', 'LIKE', "%$keywords%")
            ->orWhere('u.email', 'LIKE', "%$keywords%")
            ->orWhere('u.phone', 'LIKE', "%$keywords%");
        })->select('u.*', 'g.name as group_name');

        $totalPage = $sql->count();
        // DB::enableQueryLog();
        $users = $sql->offset(($page - 1) * $limit)->limit($limit)->orderBy($sortField, $sortType)->get();
        // dd(DB::getQueryLog());
        return ['totalRecords' => $totalPage, 'users' => $users];
    }

    public function findById($id){
        $user = DB::table("$this->table AS u")
        ->leftJoin('groups AS g', 'u.group_id', '=', 'g.id')
        ->where('u.id', '=', $id)->select('u.*', 'g.name as group_name')->limit(1)->first();
        return $user;
    }
    public function storeUser($data){
        return Users::create($data);
    }
    public function updateUser($id, $data){
        return Users::find($id)->update($data);
    }
    public function deleteUser($id){
        return Users::destroy($id);
    }
}
