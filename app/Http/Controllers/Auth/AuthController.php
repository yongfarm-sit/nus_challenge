<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dcblogdev\MsGraph\Facades\MsGraph;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function connect()
    {
        try {
            return MsGraph::connect();
        } catch (\Exception $e) {

            \Log::error('Microsoft Authentication Error: ' . $e->getMessage());
            \Log::error('Error Trace: ' . $e->getTraceAsString());
            
            return back()->withErrors([
                'msg' => 'Authentication failed: ' . $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        return MsGraph::disconnect();
    }
}
