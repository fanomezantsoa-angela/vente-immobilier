<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Exception;
class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response("login succefull");
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        try{
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
              
        return response("logout success");
        }
        catch(Exception $e){
            return response()->json(['error' => $e->getMessage()]);
    
           
        }
    }

}
