<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users;
use App\Models\Groups;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    protected $users = null;
    public function __construct(){
        $this->users = new Users();
    }
    public function index(){
        $title = 'Quản lý nhân viên';
        $groups = new Groups();
        $userGroups = $groups->all();
        return view('admin.users.list', compact('title', 'userGroups'));    
    }
    public function filter(Request $request){
        $keywords = $request->post('keywords');
        $group_id = $request->post('group_id');
        $is_blocked = $request->post('is_blocked');
        $sortType = $request->post('sortType');
        $sortField = $request->post('sortField');
        $limit = $request->post('limit');
        $page = $request->get('page');

        $dataFilter = [
            'keywords' => $keywords,
            'group_id' => $group_id,
            'is_blocked' => $is_blocked,
            'sortType' => $sortType,
            'sortField' => $sortField,
            'limit' => $limit,
            'page' => $page,
        ];
        // DB::enableQueryLog();
        $result = $this->users->filter($dataFilter);
        // dd(DB::getQueryLog());
        return toJSON(true, 'success', $result);
    }

    public function detail($id){
        // Xử lý slug SEO
        // dd(Str::slug('Hello world'));

        // Show query
        // DB::enableQueryLog();
        $user = $this->users->findById($id);
        // dd(DB::getQueryLog());
        if(!empty($user)){
            return toJSON(true, 'success', ['user' => $user]);
        }
        return toJSON(false, 'Không tìm thấy người dùng', null);
    }

    public function store(UsersRequest $request){
        $fullname = $request->post('fullname');
        $username = $request->post('username');
        $password = $request->post('password');
        $phone = $request->post('phone');
        $email = $request->post('email');
        $group_id = $request->post('group_id');
        $is_blocked = $request->post('is_blocked');
        $profile_img = $request->post('profile_img');
        $data = [
                'fullname' => $fullname,
                'phone' => $phone,
                'email' => $email,
                'group_id' => $group_id,
                'profile_img' => $profile_img,
                'is_blocked' => $is_blocked,
                'username' => $username,
                'password' => md5($password),
            ];
        $this->users->storeUser($data);
        return toJSON(true, 'Thêm mới nhân viên thành công', null);
    }
    public function update($id, UsersRequest $request){
        $fullname = $request->post('fullname');
        $password = $request->post('password');
        $phone = $request->post('phone');
        $email = $request->post('email');
        $group_id = $request->post('group_id');
        $is_blocked = $request->post('is_blocked');
        $profile_img = $request->post('profile_img');
        $data = [
                'fullname' => $fullname,
                'phone' => $phone,
                'email' => $email,
                'group_id' => $group_id,
                'profile_img' => $profile_img,
                'is_blocked' => $is_blocked,
            ];
        if($password !== ''){
            $data['password'] = md5($password);
        }
        $this->users->updateUser($id, $data);
        return toJSON(true, 'Cập nhật nhân viên thành công', null);
    }
    public function block($id, Request $request){
        $is_blocked = $request->post('is_blocked');
        $data= [
            'is_blocked' => $is_blocked,
            'blocked_at' => date('Y-m-d H:i:s')
        ];
        $this->users->updateUser($id, $data);
        return toJSON(true, 'Đã '. ($is_blocked == 1 ? 'chặn' : 'bỏ chăn') . ' 1 nhân viên', null);
    }
    public function delete($id){
        $data= [
            'is_deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s')
        ];
        $this->users->updateUser($id, $data);
        return toJSON(true, 'Đã xóa 1 nhân viên', null);
    }
    public function forceDelete($id){
        $this->users->deleteUser($id);
        return toJSON(true, 'Đã xóa vĩnh viễn 1 nhân viên', null);
    }
}
