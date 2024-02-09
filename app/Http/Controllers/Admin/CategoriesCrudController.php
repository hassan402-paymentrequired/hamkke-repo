<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrCreateCategory;
use App\Models\Category;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesCrudController extends Controller
{

    public function index()
    {
        $postCategories = Category::all();
        $postTypes = PostType::all();
        return view('posts.list-categories', compact('postCategories', 'postTypes'));
    }

    public function saveCategory(UpdateOrCreateCategory $request)
    {
        $categorySlug = Str::slug($request->get('name'));
        $navigationIcon = null;
        if($request->navigation_icon) {
            $navigationIcon = uploadFilesFromRequest($request, 'navigation_icon', 'categories-navigation-icon', strtolower("{$categorySlug}_navigation_icon"));
        }
        $category = Category::create([
            'post_type_id' => $request->get('post_type'),
            'name' => $request->get('name'),
            'slug' => $categorySlug,
            'description' => $request->get('description'),
            'navigation_icon' => $navigationIcon
        ]);
        flashSuccessMessage("Category:'{$category->name}' created successfully.");
        return back();
    }

    public function updateCategory(UpdateOrCreateCategory $request, Category $category)
    {
        $categorySlug = Str::slug($request->get('edit_category_name'));
        $navigationIcon = null;
        if($request->edit_category_navigation_icon) {
            $navigationIcon = uploadFilesFromRequest($request, 'edit_category_navigation_icon', 'categories-navigation-icon', strtolower("{$categorySlug}_navigation_icon"));
        }
        $category->update([
            'post_type_id' => $request->edit_category_post_type,
            'name' => $request->edit_category_name,
            'slug' => Str::slug($request->edit_category_name),
            'description' => $request->edit_category_description,
            'navigation_icon' => $navigationIcon ?: $category->navigation_icon
        ]);
        flashSuccessMessage("Category:'{$category->name}' updated successfully.");
        return back();
    }

    public function deleteCategory(Category $category)
    {
        $categoryName = $category->name;
        $postsCount = $category->posts()->count();
        if($category->posts()->count() > 0){
            flashErrorMessage("Unable to delete category '{$categoryName}'; It is attached to {$postsCount} posts");
            return back();
        }
        $category->delete();
        flashSuccessMessage("Category:'{$categoryName}' updated successfully.");
        return back();
    }
}
