<?php

namespace App\Http\Controllers;
use App\Models\Todo;

class TodoController extends Controller
{
    function index()
    {

        return Todo::all();
    }
}
