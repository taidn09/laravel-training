<?php

namespace App\Http\Controllers\Admin;

use App\Models\Groups;
use App\Http\Requests\StoreGroupsRequest;
use App\Http\Requests\UpdateGroupsRequest;
use App\Http\Controllers\Controller;
class GroupsController extends Controller
{
    protected $groups = null;
    public function __construct(){
        $this->groups = new Groups();
    }
    public function filter(){
        $groups = Groups::all();
        $data['groups'] = $groups;
        return toJSON(true, '', $data);
    }

    public function store(){
        // $groups = Groups::all();
        // return toJSON(true, '', $groups);
    }
}
