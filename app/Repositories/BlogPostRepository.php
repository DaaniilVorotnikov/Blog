<?php
namespace App\Repositories; 

use App\Models\BlogPost as Model;


class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id'
        ];

        $result = $this->startConditions()
                        ->select($columns)
                        ->orderBy('id', 'DESC')
                        ->paginate(100);
    
        return $result;
    }
}