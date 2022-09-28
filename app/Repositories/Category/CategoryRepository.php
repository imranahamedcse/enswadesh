<?php

namespace Repository\Category;
use Storage;
use Repository\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Models\General\Category\Category;

class CategoryRepository extends BaseRepository {

    public function model()
    {
        return Category::class;
    }

    public function storeFile(UploadedFile $file)
    {
        return Storage::put('fileuploads/categories', $file);
    }

    public function updateCategoryIcon($id)
    {
        $categoryIcon = $this->findByID($id);
        Storage::delete($categoryIcon->icon);
    }

    public function getAllCategoriesByLevel($level_one = 1, $level_two=2)
    {
        return $this->model()::where('level', $level_one)->orWhere('level', $level_two)->get();
    }

    public function storeCategory(array $data, $icon)
    {
        $level = $this->model()::where('id', $data['parent_id'])->first();
        if($level ? $level->level == 3 : 0)
        {
            notify()->warning('Product Category level will be less then or equle 3.', 'Added');
            return back();
        }else{
            $parent_id = $data['parent_id'];
            if($parent_id != null){
                $parent_id = $data['parent_id'];
            }else{
                $parent_id=0;
            }
            $category = $this->create([
                'name'              => $data['name'],
                'description'       => $data['description'],
                'shop_id'           => $data['shop_id'],
                'icon'              => $icon,
                'user_id'           => Auth::id(),
                'parent_id'         => $data['parent_id'],
                'level'             => $level ? $level->level+1 : 1
            ]);
            notify()->success('Product Category Successfully Added.', 'Added');
            return $category;
        }

    }

    public function updateCategory($id, array $data, $icon)
    {
        $level = $this->model()::where('id', $data['parent_id'])->first();
        if($level ? $level->level == 3 : 0)
        {
            notify()->warning('Product Category level will be less then or equle 3.', 'Added');
            return back();
        }
        $category = $this->updateByID($id,[
            'name'              => $data['name'],
            'icon'              => $icon,
            'description'       => $data['description'],
            'parent_id'         => $data['parent_id'],
            'level'             => $level ? $level->level+1 : 1
        ]);
        notify()->success('Product Category Successfully Updated.', 'Updated');
        return $category;
    }

    public function deleteCategory($id)
    {
        $categoryIcon=$this->findByID($id);
        Storage::delete($categoryIcon->icon);
        $categoryIcon->delete();
    }
}