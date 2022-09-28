<?php

namespace App\Http\Controllers\API\ShopingFriend;

use App\Models\InviteFriend;
use Illuminate\Http\Request;
use Repository\User\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JsonResponseTrait;
use Illuminate\Support\Facades\Notification;
use Repository\ShopingFriend\ShopingFriendRepository;
use App\Notifications\Shop\ShopingFriendRequestInvitation;
use Repository\ShopingFriend\ShopingInviteFriendRepository;

class ShopingFriendController extends Controller
{
    use JsonResponseTrait;

    public $shopingFriendRepo;
    public $userRepo;
    public $shopingFriendInvitationRepo;

    public function __construct(ShopingFriendRepository $shopingFriendRepository,
                                UserRepository $userRepository,
                                ShopingInviteFriendRepository $shopingInviteFriendRepository)
    {
        $this->shopingFriendRepo = $shopingFriendRepository;
        $this->userRepo          = $userRepository;
        $this->shopingFriendInvitationRepo  =  $shopingInviteFriendRepository;
    }

    public function index()
    {
        $friends = $this->shopingFriendRepo->getFriends();
        return $this->json('Friends list', $friends);
    }

    public function unfriend($id)
    {
        $friends = $this->shopingFriendRepo->unfriend($id);
        return $this->json('Unfrined successfully', $friends);
    }

    public function findFriends()
    {
        $friends = $this->shopingFriendRepo->findFriends();
        return $this->json('Friends list', $friends);
    }

    public function sendRequest($id)
    {
        $friends = $this->shopingFriendRepo->sendRequest($id);
        return $this->json('Send Request', $friends);
    }

    public function requestFriends()
    {
        $friends = $this->shopingFriendRepo->requestFriends();
        return $this->json('Friends list', $friends);
    }

    public function acceptRequest($id)
    {
        $friends = $this->shopingFriendRepo->acceptRequest($id);
        return $this->json('Accept friend request', $friends);
    }

    public function deleteRequest($id)
    {
        $friends = $this->shopingFriendRepo->deleteRequest($id);
        return $this->json('Delete friend request', $friends);
    }

    // public function requestFriend()
    // {
    //     $followers = $this->shopingFriendRepo->getFollowers();
    //     $following = $this->shopingFriendRepo->getFollowing();

    //     return $this->json('List of following', $following);
    // }

    public function shopingFriendSearch($keyword)
    {
        // return $keyword;
        $user = $this->userRepo->getUserBySearch($keyword);
        return $this->json('User Friend', $user);
    }

    public function sentShopingFriendRequest(Request $request)
    {
        $user = $this->shopingFriendRepo->create($request->except('user_id') + [
                'user_id'      =>  Auth::id()
            ]);
        return $this->json('Request sent',[
            'user_id'       =>  $user['user_id'],
            ]);
    }

    public function sentShopingFriendInvitation(Request $request)
    {
        $sentInvitation =   $this->shopingFriendInvitationRepo->create($request->except('user_id') + [
            'user_id'   => Auth::id(),
            'token'     => $this->shopingFriendInvitationRepo->generateToken()
            ]);

        Notification::route('mail', $sentInvitation['contact_field'],$sentInvitation)->notify(new ShopingFriendRequestInvitation($sentInvitation));

        return $this->json('Invitation request sent',[
            'data'  => $sentInvitation
        ]);
    }
}
