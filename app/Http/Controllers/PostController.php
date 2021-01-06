<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdatePost;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        //$posts = Post::get();
        $posts = Post::orderBy('id', 'ASC')->paginate();

        // return view('admin.posts.index', [
        //     'posts' => $posts
        // ]);
        /** OU */

        return view('admin.posts.index', compact('posts'));$posts = Post::paginate();
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request)
    {
        $data = $request->all();

        if ($request->image->isValid()) {

            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();

            $image = $request->image->storeAs('posts', $nameFile);
            $data['image'] = $image;
        }

        //Post::create($request->all());
        Post::create($data);

        return redirect()
                ->route('posts.index')
                ->with('message', 'Post criado com sucesso!');
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('posts.index');
        }

        return view('admin.posts.show', compact('post'));
    }

    public function destroy($id)
    {
        if (!$post = Post::find($id)) {
            return redirect()->route('posts.index');
        }

        if (Storage::exists($post->image)) {
            Storage::delete($post->image);
        }

        $post->delete();

        return redirect()
                ->route('posts.index')
                ->with('message', 'Post deletado com sucesso!');
    }

    public function edit($id)
    {
        if (!$post = Post::find($id)) {
            //return redirect()->route('posts.index');
            return redirect()->back();
        }

        return view('admin.posts.edit', compact('post'));
    }

    public function update(StoreUpdatePost $request, $id)
    {
        if (!$post = Post::find($id)) {
            //return redirect()->route('posts.index');
            return redirect()->back();
        }

        $data = $request->all();

        if ($request->image && $request->image->isValid()) {

            if (Storage::exists($post->image)) {
                Storage::delete($post->image);
            }

            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();

            $image = $request->image->storeAs('posts', $nameFile);
            $data['image'] = $image;
        }

        $post->update($data);

        return redirect()
                ->route('posts.index')
                ->with('message', 'Alterado com sucesso!');

    }

    public function search(Request $request)
    {
        //$filters = $request->all();
        $filters = $request->except('_token');

        $posts = Post::where('title', '=', $request->search)
                        ->orWhere('content', 'LIKE', "%{$request->search}%")
                        ->paginate();

        return view('admin.posts.index', compact('posts', 'filters'));

        //dd("Pesquisando por {$request->search}");
    }
}
