<?php
 
namespace App\Repositories; 

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }
    
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getForComboBox()
    {
       // return $this->startConditions()->all();

       $fields = implode(', ', [
           'id',
           'CONCAT (id, ". ", title) AS id_title',
       ]);

       $result[] = $this->startConditions()->all();
       $result[] = $this
        ->startConditions()
        ->select('blog_categories.*',
            DB::raw('CONCAT (id, ". ", title) AS id_title'))
        ->toBase()
        ->get();

        $result[] = $this
            ->startConditions()
            ->selectRaw($fields)
            ->toBase()
            ->get();
    }

    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($columns)
            
            ->paginate($perPage);

        return $result;
    }

}