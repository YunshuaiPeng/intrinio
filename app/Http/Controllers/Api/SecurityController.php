<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SecurityResource;
use App\Models\Security;

class SecurityController extends Controller
{
    public function index()
    {
        return SecurityResource::collection(Security::all());
    }
}
