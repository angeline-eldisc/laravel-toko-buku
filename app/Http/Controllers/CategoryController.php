<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Category;
use Auth;
use Str;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(function($request, $next) {
            if(Gate::allows('manage-categories')) {
                return $next($request);
            }

            abort(403, 'Anda tidak memiliki cukup hak akses.');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterKeyword =  $request->get('name');

        if($filterKeyword && $filterKeyword != NULL) {
            $categories = Category::where('name', 'LIKE', "%$filterKeyword%")->paginate(10);
        } else {
            $categories = Category::paginate(10);
        }

        return view('categories.index', compact(['categories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:20',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $name = $request->name;

        if($request->file('image')) {
            $file = $request->file('image');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak;
            $request->file('image')->move("images/categories", $fileName);
            $image = $fileName;
        } else {
            $image = NULL;
        }

        Category::create([
            'name' => $request->get('name'),
            'slug' => Str::slug($name, '-'),
            'image' => $image,
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('categories.create')->with('sukses', 'Category successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact(['category']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact(['category']));
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
        $this->validate($request, [
            'name' => 'required|min:3|max:20',
            'image' => 'image|mimes:jpeg,png,jpg',
            'slug' => [
                'required',
                Rule::unique('categories')->ignore($category->slug, 'slug')
            ]
        ]);

        $category = Category::findOrFail($id);
        $name = $request->name;
        $image_lama = $category->image;

        if($request->file('image')) {
            $imageLama = public_path("images/categories/".$category->image);
            if($category->image && file_exists($imageLama)){
                unlink($imageLama);
            }

            $file = $request->file('image');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak;
            $request->file('image')->move("images/categories", $fileName);
            $image = $fileName;
        } else {
            $image = $image_lama;
        }
        
        $category->update([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'image' => $image,
            'updated_at' => Auth::user()->id
        ]);

        return redirect()->route('categories.edit', $category->id)->with('sukses', 'Category successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.index')->with('sukses', 'Category successfully moved to trash.');
    }

    public function trash() {
        $deleted_category = Category::onlyTrashed()->paginate(10);
        return view('categories.trash',  ['categories' => $deleted_category]);
    }

    public function restore($id) {
        $category = Category::withTrashed()->findOrFail($id);

        if($category->trashed()) {
            $category->restore();
        } else {
            return redirect()->route('categories.trash')->with('warning', 'Category is not in the trash.');
        }

        return redirect()->route('categories.trash')->with('sukses', 'Category successfully restored.');
    }

    public function deletePermanent($id) {
        $category = Category::withTrashed()->findOrFail($id);

        if(!$category->trashed()) {
            return redirect()->route('categories.index')->with('warning', 'Can not delete permanent active category.');
        } else {
            $imageLama = public_path("images/categories/".$category->image);
            if($category->image && file_exists($imageLama)){
                unlink($imageLama);
            }
            $category->forceDelete();
        }

        return redirect()->route('categories.index')->with('sukses', 'Category permanently deleted.');
    }

    public function ajaxSearch(Request $request) {
        $keyword = $request->get('q');
        $categories = Category::where('name', 'LIKE', "%$keyword%")->get();
        return $categories;
    }
}
