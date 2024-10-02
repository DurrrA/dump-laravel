<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class articleController extends Controller
{
    // public function index() {
    //     $user = Auth::user();
    //     if ($user->role !== 'expert' && Article::count() > 5 && !$user->subscription) {
    //         return redirect()->route('subscription.create');
    //     }

    //     $articles = Article::all();
    //     return view('articles.index', compact('articles'));
    // }

    // Show individual article
    public function show($id) {
        $article = Article::findOrFail($id);
        $article->incrementViews();

        return view('articles.show', compact('article'));
    }

    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $articles = $query->paginate(5);

        return view('articles.show', compact('articles'));
    }

    // Show the form for creating a new article
    public function create()
    {
        return view('articles.create');
    }

    // Store a newly created article in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create($validated);

        return redirect()->route('articles.show')->with('success', 'Article created successfully.');
    }


    // Show the form for editing the specified article
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    // Update the specified article in storage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article = Article::findOrFail($id);
        $article->update($validated);

        return redirect()->route('articles.show')->with('success', 'Article updated successfully.');
    }

    // Remove the specified article from storage
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.show')->with('success', 'Article deleted successfully.');
    }

    public function expertArticles()
    {
        $articles = auth()->user()->articles()->orderBy('created_at', 'desc')->get();

        return view('articles.expert', compact('articles'));
    }
}
