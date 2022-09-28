<?php

namespace App\Http\Controllers\Backend\Interaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repository\Interaction\InteractionRepository;

class InteractionController extends Controller
{
    public $interactionRepo;

    public function __construct(InteractionRepository $interactionRepository)
    {
        $this->interactionRepo = $interactionRepository;
    }

    public function videos()
    {
        $videos = $this->interactionRepo->getInteractionsByCategoryID(1);
        return view('backend.interaction.video.index',compact('videos'));
    }

    public function showVideo($id)
    {
        $video = $this->interactionRepo->findByID($id);
        return $video;
    }

    public function templates()
    {
        $templates = $this->interactionRepo->getInteractionsByCategoryID(2);
        return view('backend.interaction.template.index',compact('templates'));
    }

    public function stories()
    {
        $stories = $this->interactionRepo->getInteractionsByCategoryID(5);
        return view('backend.interaction.stories.index',compact('stories'));
    }
    public function real_experiences()
    {
        $real_experiences = $this->interactionRepo->getInteractionsByCategoryID(3);
        return view('backend.interaction.real_experiences.index',compact('real_experiences'));
    }
    public function memes()
    {
        $memes = $this->interactionRepo->getInteractionsByCategoryID(4);
        return view('backend.interaction.memes.index',compact('memes'));
    }

    public function statusUpdate(Request $request, $id)
    {
        $this->interactionRepo->updateByID($id, $request->all());
        //save logs
        $this->interactionRepo->storeLog($id, 'Status Updated', 'updated');
        notify()->success('Status Successfully Updated.', 'Updated');
    }

    public function destroy($id)
    {
        //
    }
}
