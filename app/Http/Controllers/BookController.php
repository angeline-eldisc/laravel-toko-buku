<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Book;
use Auth;
use Str;

class BookController extends Controller
{
    public function __construct() {
        $this->middleware(function($request, $next) {
            if(Gate::allows('manage-books')) {
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
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';
        
        if($status) {
            $books = Book::with('categories')->where('title', "LIKE", "%$keyword%")->where('status', strtoupper($status))->paginate(10);
        } else {
            $books = Book::with('categories')->where('title', "LIKE", "%$keyword%")->paginate(10);
        }
        
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
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
            'title' => 'required|min:5|max:200',
            'cover' => 'required|image|mimes:jpeg,png,jpg',
            'description' => 'required|min:20|max:1000',
            'stock' => 'required|integer|numeric|digits_between:0,10',
            'author' => 'required|min:3|max:100',
            'publisher' => 'required|min:3|max:200',
            'price' => 'required|integer|numeric|digits_between:0,10'
        ]);

        $book = Book::all();

        if($request->file('cover')) {
            $file = $request->file('cover');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('cover')->move("images/book-covers", $fileName);
            $cover = $fileName;
        } else {
            $cover = NULL;
        }

        $book = Book::create([
            'title' => $request->get('title'),
            'slug' => Str::slug($request->get('title')),
            'description' => $request->get('description'),
            'author' => $request->get('author'),
            'publisher' => $request->get('publisher'),
            'cover' => $cover,
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'status' => $request->get('save_action'),
            'created_by' => Auth::user()->id,
        ]);

        $book->categories()->attach($request->get('categories'));

        if($request->get('save_action') == "PUBLISH") {
            return redirect()->route('books.create')->with('sukses', 'Book successfully saved and published.');
        } else {
            return redirect()->route('books.create')->with('sukses', 'Book saved as draft.');
        }
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
        $book = Book::findOrFail($id);
        return view('books.edit', compact(['book']));
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
            'title' => 'required|min:5|max:200',
            'slug' => [
                'required',
                Rule::unique('books')->ignore($book->slug, 'slug')
            ],
            'cover' => 'image|mimes:jpeg,png,jpg',
            'description' => 'required|min:20|max:1000',
            'stock' => 'required|integer|numeric|digits_between:0,10',
            'author' => 'required|min:3|max:100',
            'publisher' => 'required|min:3|max:200',
            'price' => 'required|integer|numeric|digits_between:0,10'
        ]);

        $book = Book::findOrFail($id);
        $title = $request->title;
        $cover_lama = $book->cover;

        if($request->file('cover')) {
            $coverLama = public_path("/images/book-covers/".$book->cover);
            if($book->cover && file_exists($coverLama)){
                unlink($coverLama);
            }

            $file = $request->file('cover');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak;
            $request->file('cover')->move("images/book-covers", $fileName);
            $cover = $fileName;
        } else {
            $cover = $cover_lama;
        }

        $book->update([
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'description' => $request->get('description'),
            'author' => $request->get('author'),
            'publisher' => $request->get('publisher'),
            'cover' => $cover,
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'status' => $request->get('status'),
            'updated_by' => Auth::user()->id,
        ]);

        $book->categories()->sync($request->get('categories'));

        return redirect()->route('books.edit', $book->id)->with('sukses', 'Book successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('sukses', 'Book moved to trash.');
    }

    public function trash() {
        $books = Book::onlyTrashed()->paginate(10);
        return view('books.trash', compact(['books']));
    }

    public function restore($id) {
        $book = Book::withTrashed()->findOrFail($id);

        if($book->trashed()) {
            $book->restore();
            return redirect()->route('books.trash')->with('sukses', 'Book successfully restored.');
        } else {
            return redirect()->route('books.trash')->with('warning',  'Book is not in trash.');
        }
    }

    public function deletePermanent($id) {
        $book = Book::withTrashed()->findOrFail($id);

        if(!$book->trashed()) {
            return redirect()->route('books.trash')->with('warning',  'Book is not in trash.');
        } else {
            $book->categories()->detach();
            $book->forceDelete();
        }

        return redirect()->route('books.trash')->with('sukses', 'Book permanently deleted.');
    }
}
