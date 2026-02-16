<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $company = Company::create([
            'name' => $request->company_name,
            'slug' => strtolower(str_replace(' ', '-', $request->company_name)),
            'email' => $request->email,
        ]);

        RoleService::seedCompanyRoles($company);

        $user = User::create([
            'company_id' => $company->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Owner');

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
}
