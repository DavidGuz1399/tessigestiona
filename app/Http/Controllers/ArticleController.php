<?php

namespace Tessigestiona\Http\Controllers;

use Illuminate\Http\Request;
use Tessigestiona\Article;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return Article::with('category')->get();
        }else{
            return view('home');
        }
        // $article=Article::with('category')->get();
        // return $article;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article=new Article();
        $article->category_id=$request->category_id;
        $article->registry_number=$request->registry_number;
        $article->name=$request->name;
        $article->quantity=$request->quantity;
        $article->save();
        return $article;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article=Article::find($id);
        $article->category_id=$request->category_id;
        $article->registry_number=$request->registry_number;
        $article->name=$request->name;
        $article->quantity=$request->quantity;
        $article->save();
        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article=Article::find($id);
        $article->delete();
    }
    public function filterArticle(Request $request){
        return Article::with('category')->whereBetween('created_at', array($request->dateStart, $request->dateEnd))->get();
    }
}
