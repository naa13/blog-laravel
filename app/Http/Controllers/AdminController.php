<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $count_article = DB::table('articles')->where('visibility','1')->count();
        $count_category = DB::table('categories')->count();
        $count_user = DB::table('users')->count();
        $count_ads = DB::table('ads')->count();
        $count_hide= DB::table('articles')->where('visibility','0')->count();
        $count_view= DB::table('articles')->sum('view');

        return view('admin.dashboard', [

            'count_article' => $count_article,
            'count_hide' => $count_hide,
            'count_user' => $count_user,
            'count_ads' => $count_ads,
            'count_view' =>$count_view
        ]);
    }
}
