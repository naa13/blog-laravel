<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use App\Article;
use App\Category;
use Goutte\Client;

class ArticleController extends Controller
{
    public function showList()
    {
        $articles = Article::all(); //hàm all lấy tất cả dữ liệu
        return view('admin.article.list', ['articles' => $articles]);//mảng articles lấy dữ liệu từ biến $
    }

    public function collabShowList()
    {
        $articles = Article::where("user_id", Auth::user()->id)->get();
        return view('collab.article.list', ['articles' => $articles]);
    }

    public function showAdd()
    {
        $categories = Category::all();
        return view('admin.article.add', ['categories' => $categories]);
    }
    public function collabShowAdd()
    {
        $categories =Category::all();
        return view('collab.article.add', ['categories' => $categories]);
    }

    public function showEdit($id)
    {
        $categories = Category::all();
        $article = Article::find($id);
        return view('admin.article.edit', compact('article', 'categories'));
    }

    // public function autoRSS()
    // {
    //     return view('admin.article.auto_rss');
    // }

    public function add(ArticleRequest $request)
    {
        $thumb = '404.jpg';
        if ($request->hasFile('thumb')) {
            $thumb = $this->uploadImage($request->file('thumb'));
            if (!$thumb) {
                return redirect('admin/article/add')->with([
                    'status' => 'danger',
                    'message' => __('app.add_failed')
                ]);
            }
        }
        Article::create([
            'title' => $request->title,
            'thumb' => $thumb,
            'slug' => str_slug($request->title),
            'summary' => $request->summary,
            'content' => $request->content,
            'source' => $request->source,
            'is_highlight' => $request->is_highlight,
            'visibility' =>$request->visibility,
            'tags' => implode(',', explode("-", str_slug($request->title))),
            'cat_id' => $request->cat_id,
            'user_id' => 1,
        ]);
        return redirect('admin/article/add')->with([
            'status' => 'success',
            'message' => __('app.added')
        ]);
    }

    public function edit(ArticleRequest $request, $id)
    {
        if ($request->hasFile('thumb')) {
            $thumb = $this->uploadImage($request->file('thumb'));
            if (!$thumb) {
                return redirect('admin/article/edit/'. $id)->with([
                    'status' => 'danger',
                    'message' => __('app.edited_failed')
                ]);
            }
            Article::updateOrCreate(
                ['id'=>$id],
                [
                    'title' => $request->title,
                    'thumb' => $thumb,
                    'slug' => str_slug($request->title),
                    'summary' => $request->summary,
                    'content' => $request->content,
                    'source' => $request->source,
                    'is_highlight' => $request->is_highlight,
                    'visibility' =>$request->visibility,
                    'tags' => implode(',', explode("-", str_slug($request->title))),
                    'cat_id' => $request->cat_id,
                    'user_id' => Auth::user()->id,
                ]
            );
        } else {
            Article::updateOrCreate(
                ['id'=>$id],
                [
                    'title' => $request->title,
                    'slug' => str_slug($request->title),
                    'summary' => $request->summary,
                    'content' => $request->content,
                    'source' => $request->source,
                    'is_highlight' => $request->is_highlight,
                    'tags' => implode(',', explode("-", str_slug($request->title))),
                    'cat_id' => $request->cat_id,
                    'user_id' => 1,
                ]
            );
        }

        return redirect('admin/article/edit/'. $id)->with([
            'status' => 'success',
            'message' => __('app.edited')
        ]);
    }

    public function delete($id)
    {
        try {
            Article::destroy($id);
            return redirect('admin/article')->with([
                'status' => 'success',
                'message' => __('app.deleted')
            ]);
        } catch (\Exception $e) {
            return redirect('admin/article')->with([
                'status' => 'danger',
                'message' => __('app.delete_failed')
                // 'message' => $e->getMessage()
            ]);
        }
    }
    public function block($id)
    {
        $article = Article::find($id);
        // echo $article;die();
        if ($article->visibility == 0) {
            $article->visibility = 1;
            $article->save();

            return redirect('admin/article')->with([
                'status' => 'success',
                'message' => __('app.show')
            ]);
        } else {
            $article->visibility = 0;
            $article->save();

            return redirect('admin/article')->with([
                'status' => 'success',
                'message' => __('app.hide')
            ]);
        }
    }

    public function collabShowEdit($id)
    {
        $categories = Category::all();
        $article = Article::find($id);
        return view('collab.article.edit', compact('article', 'categories'));
    }

    // public function autoRSS()
    // {
    //     return view('admin.article.auto_rss');
    // }

    public function collabAdd(ArticleRequest $request)
    {
        $thumb = '404.jpg';
        if ($request->hasFile('thumb')) {
            $thumb = $this->uploadImage($request->file('thumb'));
            if (!$thumb) {
                return redirect('collab/article/add')->with([
                    'status' => 'danger',
                    'message' => __('app.add_failed')
                ]);
            }
        }
        Article::create([
            'title' => $request->title,
            'thumb' => $thumb,
            'slug' => str_slug($request->title),
            'summary' => $request->summary,
            'content' => $request->content,
            'source' => $request->source,
            'is_highlight' => $request->is_highlight,
            'status' => $request->status,
            'tags' => implode(',', explode("-", str_slug($request->title))),
            'cat_id' => $request->cat_id,
            'user_id' => Auth::id(),
        ]);
        return redirect('collab/article/add')->with([
            'status' => 'success',
            'message' => __('app.added')
        ]);
    }

    public function collabEdit(ArticleRequest $request, $id)
    {
        if ($request->hasFile('thumb')) {
            $thumb = $this->uploadImage($request->file('thumb'));
            if (!$thumb) {
                return redirect('collab/article/edit/'. $id)->with([
                    'status' => 'danger',
                    'message' => __('app.edited_failed')
                ]);
            }
            Article::updateOrCreate(
                ['id'=>$id],
                [
                    'title' => $request->title,
                    'thumb' => $thumb,
                    'slug' => str_slug($request->title),
                    'summary' => $request->summary,
                    'content' => $request->content,
                    'source' => $request->source,
                    'is_highlight' => $request->is_highlight,
                    'tags' => implode(',', explode("-", str_slug($request->title))),
                    'cat_id' => $request->cat_id,
                    'user_id' => Auth::id(),
                ]
            );
        } else {
            Article::updateOrCreate(
                ['id'=>$id],
                [
                    'title' => $request->title,
                    'slug' => str_slug($request->title),
                    'summary' => $request->summary,
                    'content' => $request->content,
                    'source' => $request->source,
                    'is_highlight' => $request->is_highlight,
                    'tags' => implode(',', explode("-", str_slug($request->title))),
                    'cat_id' => $request->cat_id,
                    'user_id' => Auth::id(),
                ]
            );
        }

        return redirect('collab/article/edit/'. $id)->with([
            'status' => 'success',
            'message' => __('app.edited')
        ]);
    }

    public function CollabDelete($id)
    {
        try {
            Article::destroy($id);
            return redirect('collab/article')->with([
                'status' => 'success',
                'message' => __('app.deleted')
            ]);
        } catch (\Exception $e) {
            return redirect('collab/article')->with([
                'status' => 'danger',
                'message' => __('app.delete_failed')
                // 'message' => $e->getMessage()
            ]);
        }
    }
    private function uploadImage($file)
    {
        $ext = $file->getClientOriginalExtension();
        if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
            $name = $file->getClientOriginalName();
            do {
                $img = str_random(30).'_'.$name;
            } while (file_exists(public_path('upload/article/'). $img));
            $file->move(public_path('upload/article/'), $img);

            return $img;
        }
        return false;
    }
}
