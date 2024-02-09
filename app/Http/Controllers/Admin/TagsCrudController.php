<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagsCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return view('posts/list-tags', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagsRequest $request)
    {
        $tagSlug = Str::slug($request->get('name'));
        $tag = Tag::create([
            'name' => $request->get('name'),
            'slug' => $tagSlug
        ]);
        flashSuccessMessage("Tag::{$tag->name} Created successfully");
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $tagSlug = Str::slug($request->get('edit_tag_name'));
        $tag->update([
            'name' => $request->get('edit_tag_name'),
            'slug' => $tagSlug
        ]);
        flashSuccessMessage("Tag::{$tag->name} Updated successfully");
        return back();
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $tag)
    {
        $tagName = $tag->name;
        $tag->delete();
        flashSuccessMessage("Tag:: {$tagName} deleted successfully");
        return back();
    }
}
