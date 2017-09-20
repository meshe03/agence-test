<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;

class UsersController extends Controller{
    
    public function index(){
        $users = User::join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
                    ->where([
                        ['permissao_sistema.in_ativo', 'S'],
                        ['permissao_sistema.co_sistema', 1]
                    ])
                    ->whereIn('permissao_sistema.co_tipo_usuario', [0,1,2])
                    ->get();
        
        return view('users.index', compact('users'));
    }
}
