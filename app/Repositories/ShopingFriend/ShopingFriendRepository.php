<?php

namespace Repository\ShopingFriend;

use App\Models\ShopingFriend;
use App\Models\User;
use Repository\BaseRepository;

class ShopingFriendRepository extends BaseRepository
{
    public function model()
    {
        return ShopingFriend::class;
    }

    public function getFriends()
    {
        $fnds = [];
        $friends = $this->model()::with('friend')->where('user_id',auth()->user()->id)->where('friend_id', '!=', null)->get();
        $users = $this->model()::with('user_')->where('friend_id',auth()->user()->id)->where('user_id', '!=', null)->get();

        if(count($friends) > 0){
            foreach($friends as $friend)
                $fnds[] = $friend;
        }
        if(count($users) > 0){
            foreach($users as $user)
                $fnds[] = $user;
        }

        return $fnds;
    }

    public function unfriend($id)
    {
        return $this->model()::find($id)->delete();
    }

    public function findFriends()
    {
        return User::select('id','name')->get();
    }

    public function sendRequest($id)
    {
        $this->model()::create([
            'user_id' => auth()->user()->id,
            'request_id' => $id,
        ]);
    }

    public function requestFriends()
    {
        return $this->model()::with('request')->where('request_id',auth()->user()->id)->get();
    }

    public function acceptRequest($id)
    {
        $row = $this->model()::find($id);
        $row->update([
            'friend_id' => auth()->user()->id,
            'request_id' => null
        ]);
    }

    public function deleteRequest($id)
    {
        return $this->model()::find($id)->delete();
    }

    public function getFollowing()
    {
        return $this->model()::where('user_id',auth()->user()->id)->get();
    }

}
