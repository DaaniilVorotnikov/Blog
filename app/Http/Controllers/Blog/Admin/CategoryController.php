<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\Admin\BaseController;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Support\Str;


class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private $blogCategoryRepository;

     public function __construct()
     {
         parent:: __construct();
         $this->blogCategoryRepository = app(BlogCategoryRepository::class);
     }


    public function index()
    {
       $dsd = BlogCategory::all();
       $paginator =  $this->blogCategoryRepository->getAllWithPaginate(15);

       //dd($dsd, $paginator);

       return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $item = new BlogCategory();
      
        $categoryList = 
            $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit', 
            compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryUpdateRequest $request)
    {
        $data = $request->input();
        if(empty($data['slug'])){
            $data['slug'] = Str::slug($data['title']);
        }

        //Создаст объект и добавит в БД

        $item = (new BlogCategory())->create($data);


        if($item){
            return redirect()->route('blog.admin.category.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        } else{
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
            ->withInput();
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
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, BlogCategoryRepository $categoryRepository)
    {
      // $item = BlogCategory::findOrFail($id);
       // dd($item);

       $item = $categoryRepository->getEdit($id);

       if(empty($item)){
           abort(404);
       }

       $categoryList 
        = $this->blogCategoryRepository->getForComboBox();

       return view('blog.admin.categories.edit', 
       compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {      
        // $rules = [
        //     'title' => 'required|min:5|max:200',
        //     'slug' => 'max:200',
        //     'description' => 'string|max:500|min:3',
        //     'parent_id' => 'required|integer|exists:blog_categories',
        // ];

      //  $validatedData = $this->validate($request, $rules);

        //$validatedData = $request->validate($rules);

        // $validator = Validator::make($request->all(), $rules);
        // $validatedData[] = $validator->validate();
        // $validatedData[] = $validator->validated(); 
        // $validatedData[] = $validator->failed();
        // $validatedData[] = $validator->errors();
        // $validatedData[] = $validator->fails();

    //    dd($validatedData);

       $item = $this->blogCategoryRepository->getEdit($id);
      // dd($item);
       if (empty($item)){
           return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
       }

       $data = $request->all();
       if (empty($data['slug'])){
           $data['slug'] =Str::slug($data['title']);
       }
     
       $result = $item->update($data);

       if($result){
           return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
       } else{
           return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd(__METHOD__);
    }
}
