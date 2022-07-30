<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MemberDetailsResource;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(MemberResource::collection(Member::paginate(10))->response()->getData());
    }

    public function all()
    {
        $members = Member::all();
        return response()->json( [
            'data' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'nullable|email',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $task = Member::create([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return response()->json($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::firstWhere(['id' => $id]);
        return response()->json(new MemberDetailsResource($member));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMemberRequest  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $member=Member::find($id);
        $member->update($request->all());
        return response()->json(new MemberResource($member));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Member::destroy($id);
        return response()->json([
            'success' => true
        ]);
    }
}
