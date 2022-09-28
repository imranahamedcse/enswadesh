<?php


namespace Repository\Location;

use App\Models\Location\Area;
use Repository\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class AreaRepository extends BaseRepository
{

    function model()
    {
        return Area::class;
    }

    public function getAll(): Collection
    {
        return $this->model()::with('cities')->get();
    }

    public function areaByCityId($id): Collection
    {
        return $this->model()::with('cities')->where('city_id', $id)->get();
    }

    public function storeFile(UploadedFile $file)
    {
        return Storage::put('fileuploads/area', $file);
    }

    public function updateArea($id)
    {
        $area = $this->findById($id);
        Storage::delete($area->icon);
    }

    public function deleteArea($id)
    {
        $area = $this->findById($id);
        Storage::delete($area->icon);
        $area->delete();
    }
}
