<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    
    public function get_categories(Request $request) {
        return Category::get();
    }
    public function get_category(Request $request, $id) {
        return Category::find($id);
    }
    public function create_category(Request $request) {
        if(auth()->user()->role != 'admin') {
            return Category::create($request->all());
        }
        else {
            return response("Access denied!", 401);
        }
    }
    public function update_category(Request $request, $id) {
        $category = Category::find($id);

        if(auth()->user()->role != 'admin') {
            $category->update($request->all());
            return response([
                'message' => 'Category updated'
            ]);
        }
        else {
            return response("Access denied!", 401);
        }
    }
    public function delete_category(Request $request, $id) {
        if(auth()->user()->role != 'admin') {
            return response("You are not admin!", 401);
        }
        return Category::destroy($id);
    }
}
