<?php

namespace App\Http\Controllers\Backend\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery\DeliveryMember;
use App\Models\Delivery\DeliveryMemberAssign;
use App\Models\User;
use App\Models\Location\Market;

class MemberAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = DeliveryMemberAssign::select(
            'delivery_member_assigns.id',
            'users.name',
            'users.phone_number',
            'markets.name as market_name',
            'markets.address as market_address',
            'delivery_member_assigns.description',
        )
        ->join('users','delivery_member_assigns.user_id', "=", 'users.id')
        ->join('markets','delivery_member_assigns.market_id', "=", 'markets.id')
        ->get();
        return view('backend.delivery.assign.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select(
            'users.id',
            'users.name',
            'users.phone_number',
        )
        ->join('delivery_members','delivery_members.user_id', "=", 'users.id')
        ->get();
        $markets = Market::all();
        return view('backend.delivery.assign.create', compact('users','markets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $row = new DeliveryMemberAssign;
        $row->user_id = $request->user_id;
        $row->market_id = $request->market_id;
        $row->description = $request->description;
        $row->save();
        notify()->success('Member assign successfully added.', 'Add');
        return redirect('backend/delivery-member-assign');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = DeliveryMemberAssign::find($id);
        // dd($member);
        $users = User::select(
            'users.id',
            'users.name',
            'users.phone_number',
        )
        ->join('delivery_members','delivery_members.user_id', "=", 'users.id')
        ->get();
        $markets = Market::all();
        return view('backend.delivery.assign.create', compact('users','markets','member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $row = DeliveryMemberAssign::find($id);
        $row->user_id = $request->user_id;
        $row->market_id = $request->market_id;
        $row->description = $request->description;
        $row->save();
        notify()->success('Member assign successfully edited.', 'Update');
        return redirect('backend/delivery-member-assign');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DeliveryMemberAssign::destroy($id);
        notify()->success('Member assign successfully deleted.', 'Deleted');
        return redirect()->back();
    }
}
