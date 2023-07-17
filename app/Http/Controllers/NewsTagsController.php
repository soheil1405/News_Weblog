<?php

namespace App\Http\Controllers;

use App\Models\news_tags;
use App\Http\Requests\Storenews_tagsRequest;
use App\Http\Requests\Updatenews_tagsRequest;

class NewsTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storenews_tagsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(news_tags $news_tags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(news_tags $news_tags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatenews_tagsRequest $request, news_tags $news_tags)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(news_tags $news_tags)
    {
        //
    }
}
