<?php

namespace HexGad\Articles\Http\Controllers;

use HexGad\Articles\Models\Article;
use HexGad\Articles\Http\DataTables\ArticlesDataTable;
use HexGad\Articles\Http\Requests\StoreArticlesRequest;
use HexGad\Articles\Http\Requests\UpdateArticlesRequest;
use App\Exceptions\ApiException;

use HexGad\Categories\Models\Category;
use HexGad\Forms\Models\Form;
use HexGad\Pixels\Models\Pixel;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ArticlesDataTable $datatable
     * @return Renderable|JsonResponse
     */
    public function index(ArticlesDataTable $datatable): Renderable|JsonResponse
    {
        return $datatable->render('articles::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $categories = Category::pluck('name', 'id');
        $forms = Form::pluck('title', 'id');
        $pixels = Pixel::pluck('name', 'id');

        return view('articles::create', compact('categories', 'forms', 'pixels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticlesRequest $request
     *
     * @return JsonResponse
     * @throws ApiException
     */
    public function store(StoreArticlesRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if($article = Article::create($data)){
            $article->addMedia($request->file('image'))->toMediaCollection('articles');
            return response()->json($article);
        }

        throw new ApiException;
    }

    /**
     * Show the specified resource.
     *
     * @param Article $article
     *
     * @return Renderable
     */
    public function show(Article $article): Renderable
    {
        return view('articles::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     *
     * @return Renderable
     */
    public function edit(Article $article): Renderable
    {
        $categories = Category::pluck('name', 'id');
        $forms = Form::pluck('title', 'id');
        $pixels = Pixel::pluck('name', 'id');

        return view('articles::edit', compact('article', 'categories', 'forms', 'pixels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticlesRequest $request
     * @param Article $article
     *
     * @return JsonResponse
     * @throws ApiException
     */
    public function update(UpdateArticlesRequest $request, Article $article): JsonResponse
    {
        if($article->update($request->validated()))
            return response()->json($article);

        throw new ApiException;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     *
     * @return JsonResponse
     * @throws ApiException
     */
    public function destroy(Article $article): JsonResponse
    {
        if($article->delete())
            return response()->json($article);

        throw new ApiException;
    }
}
