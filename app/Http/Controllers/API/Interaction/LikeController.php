<?php

namespace App\Http\Controllers\API\Interaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Repository\Interaction\LikeRepository;
use App\Http\Controllers\JsonResponseTrait;
use App\Http\Resources\Interaction\LikeResource;

class LikeController extends Controller
{

    use JsonResponseTrait;

    public $likeRepo;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepo = $likeRepository;
    }

    public function getLikes($interaction_id)
    {
        $likes = $this->likeRepo->getLikesByInteractionID($interaction_id);

        return $this->json(
            'Likes',$likes
            // LikeResource::collection($likes)
        );
    }

    public function store(Request $request)
    {
        // $like = $this->likeRepo->create($request->all());

        // return $this->json(
        //     "Liked",
        //     $like
        // );
        
        return $this->likeRepo->create($request);
        
    }

    public function destroy($id)
    {
        $like = $this->likeRepo->deletedByID($id);

        return $this->json(
            "disLiked",
            $like
        );
    }


}
