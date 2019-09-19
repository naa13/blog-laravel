<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CollaborateController extends Controller
{
    public function dashboard()
    {
        $count_article = DB::table('articles')->where('user_id',Auth::id())->count();
        $count_views= DB::table('articles')->where('user_id',Auth::id())->sum('view');
       // $count_views=$count_view->count();
        return view('collab.dashboard', [
            'count_article' => $count_article,
            'count_views' => $count_views,
        ]);
    }
}

