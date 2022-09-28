<?php

namespace App\Http\Controllers\Backend\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery\DeliveryMember;
use App\Models\User;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = User::select(
            'delivery_members.id',
            'users.name',
            'users.phone_number',
            'users.email',
            'delivery_members.description',
        )
        ->join('delivery_members','delivery_members.user_id', "=", 'users.id')
        ->orderByDesc('delivery_members.id')
        ->get();
        return view('backend.delivery.member.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('backend.delivery.member.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $row = new DeliveryMember;
        $row->user_id = $request->user_id;
        $row->description = $request->description;
        $row->save();
        notify()->success('Member successfully added.', 'Add');
        return redirect('backend/delivery-member');
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
        $member = DeliveryMember::find($id);
        // dd($member);
        $users = User::all();
        return view('backend.delivery.member.create', compact('users','member'));
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
        $row = DeliveryMember::find($id);
        $row->user_id = $request->user_id;
        $row->description = $request->description;
        $row->save();
        notify()->success('Member successfully edited.', 'Update');
        return redirect('backend/delivery-member');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DeliveryMember::destroy($id);
        notify()->success('Member successfully deleted.', 'Deleted');
        return redirect()->back();
    }
}
