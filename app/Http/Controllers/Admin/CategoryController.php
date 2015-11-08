<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    public function showList()
    {
        $categories = Cagetory::newest()->paginate(10);
        return view('admin.category', [
            'active' => 'category',
            'categories' => $categories
            ]);
    }
    
    public function submit(Request $request)
    {
        $text = $request->input('text');
        if (!$text) {
            return redirect()->route('admin_category_list');
        }
        Category::create(['text' => $text]);
        return redirect()->route('admin_category_list');
    }

    public function edit(Request $request)
    {
        $text = $request->input('text');
        if (mb_strlen($text) > 6) {
            return redirect()->route('admin_category_list');
        }
        $category = Cagetory::find($id);
        if (!$text || !$category) {
            return redirect()->route('admin_category_list');
        }
        $category->text = $text;
        $category->save();
        return redirect()->route('admin_category_list');
    }
}
