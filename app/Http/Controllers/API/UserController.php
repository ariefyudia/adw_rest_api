<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\api\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends BaseController
{
    public function index()
    {
        $success = DB::table('users')->get();

        return $this->sendResponse($success, 'List user');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|min:4|max:100',
            'password' => 'required|min:8|max:100',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['username'] = str_replace(' ', '', $input['name']);
        $input['created_by'] = $user->id;
        $input['updated_by'] = $user->id;
        $input['password'] = bcrypt($input['password']);
        $data = User::create($input);
        $success['user'] =  $data;

        return $this->sendResponse($success, 'Berhasil registrasi');
    }

    public function show(string $id)
    {
        $user = auth()->user();

        $data = User::find($id);

        return $this->sendResponse($data, 'Berhasil tampilkan detail');
    }
}
