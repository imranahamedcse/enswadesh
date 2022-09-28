<?php

namespace Repository\Interaction;

use Repository\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Models\Interaction\Interaction;
use Illuminate\Support\Facades\Storage;
use App\Models\Interaction\InteractionLog;

class InteractionRepository extends BaseRepository
{
    function model()
    {
        return Interaction::class;
    }

    //get my contributions.
    public function getMyContributions()
    {
        return $this->model()::where('user_id', auth()->user()->id)->get();
    }

    //get all interaction category wise / all videos.
    public function getInteractionsByCategoryID($category_id)
    {
        return $this->model()::where('interaction_category_id', $category_id)->get();
    }

    //get all Approved interaction category wise / all videos.
    public function getApprovedInteractionsByCategoryID($category_id)
    {
        return $this->model()::where('interaction_category_id', $category_id)->where('status', 'Approved')->get();
    }

    public function storeFile(UploadedFile $file, $path)
    {
        return Storage::put('uploads/interaction/' . $path, $file);
    }

    //find or fail interaction Category wise / find video
    public function findInteractionByCategoryID($category_id, $id)
    {
        return $this->model()::where('interaction_category_id', $category_id)->find($id);
    }

    //show single interaction category wise
    public function showInteraction($id)
    {
        return $this->model()::where('status', 'Approved')->with('file')->find($id);
        // return 'success';
    }

    public function storeLog($interaction_id, $message, $type = "general")
    {
        InteractionLog::create([
            'interaction_id' => $interaction_id,
            'user_id' => Auth::id(),
            'log' => $message,
            'type' => $type
        ]);
    }

}
