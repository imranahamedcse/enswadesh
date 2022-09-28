<?php

namespace Repository\Interaction;

use Repository\BaseRepository;
use App\Models\Interaction\Like;

class LikeRepository extends BaseRepository
{
    public function model()
    {
       return Like::class;
    }

    public function getLikesByInteractionID($id)
    {
        return $this->model()::where('interaction_id', $id)->count();
        // return $this->model()::where('interaction_id', $id)->get();
    }
    public function create($request)
    {
        $like = $this->model()::where('interaction_id', $request->interaction_id)->where('user_id', $request->user_id)->first();
        if($like != null){
            $this->model()::destroy($like->id);
            return 0;
        }
        else{
            $this->model()::create($request->all());
            return 1;
        }
    }
}
