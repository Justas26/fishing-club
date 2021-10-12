<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Reservoir;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Str;

use function PHPSTORM_META\map;

class MemberController extends Controller
{
    const RESULTS_IN_PAGE = 9;
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $members = Member::orderBy('surname')->paginate(self::RESULTS_IN_PAGE)->withQueryString();
        $reservoirs = Reservoir::all();
        if ($request->filter && 'reservoir' == $request->filter) {
            $members = Member::where('reservoir_id', $request->reservoir_id)->paginate(self::RESULTS_IN_PAGE)->withQueryString();
        }
        return view('member.index', ['reservoirs' => $reservoirs, 'members' => $members]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reservoirs = Reservoir::orderBy('title')->paginate(self::RESULTS_IN_PAGE)->withQueryString();
        return view('member.create', ['reservoirs' => $reservoirs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:3', 'max:100'],
                'surname' => ['required', 'min:3', 'max:150'],
                'live' => ['required', 'min:5', 'max:50'],
                'expierence' => ['required', 'digits_between:0,9'],
                'registered' => ['required', 'digits_between:0,9'],
                'expierence' => ['required', 'numeric', 'between:1,100'],
                'registered' => ['required', 'numeric', 'between:1,100'],
            ],
            [
                'name.required' => 'member name required',
                'surname.required' => 'member surname required',
                'live.required' => 'member city name required',
                'expierence.required' => 'member expierence time required',
                'registered.required' => 'member registered time required',
                'name.min' => 'too short member name',
                'name.max' => 'too long member name',
                'surname.min' => 'too short member surname',
                'surname.max' => 'too long member surname',
                'live.min' => 'too short member city name',
                'live.max' => 'too long member city name',
                'expierence.digits_between' => 'incorrect experience time format',
                'registered.digits_between' => 'incorrect registered time format',
                'expierence.numeric_between:1,100' => 'so many years of experience can’t be',
                'registered.numeric_between:1,100' => 'man cannot fish for so many years'

            ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        if ($request->register > $request->expierence) {
            return redirect()->route('member.create')->with('info_message', 'cannot be written');
        } else {

            $member = new Member;
            $member->name = $request->name;
            $member->surname = $request->surname;
            $member->live = $request->live;
            $member->expierence = $request->expierence;
            $member->registered = $request->registered;
            $member->reservoir_id = $request->reservoir_id;
            $member->save();
            return redirect()->route('member.index')->with('success_message', 'succesfully recorded.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        $member = Member::where('id', $member->id)->paginate(self::RESULTS_IN_PAGE)->withQueryString();
        return view('member.show', ['member' => $member]);
    }
    public function uploadPhoto(Member $member, Request $request)
    {
        if ($request->has('photo')) {
            $img = Image::make($request->file('photo'));
            $fileName = Str::random(5) . ".jpg";
            $folder = public_path('/memberPhoto');
            $img->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($folder . '/' . $fileName, 80, 'jpg');
            $member->photo_name = $fileName;
            $member->save();
        }
        return redirect()->route('member.index', ['member' => $member]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $reservoirs = Reservoir::all();
        return view('member.edit', ['member' => $member, 'reservoirs' => $reservoirs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'min:3', 'max:100'],
                'surname' => ['required', 'min:3', 'max:150'],
                'live' => ['required', 'min:5', 'max:50'],
                'expierence' => ['required', 'digits_between:0,9'],
                'registered' => ['required', 'digits_between:0,9'],
                'expierence' => ['required', 'numeric', 'between:1,100'],
                'registered' => ['required', 'numeric', 'between:1,100'],
            ],
            [
                'name.required' => 'member name required',
                'surname.required' => 'member surname required',
                'live.required' => 'member city name required',
                'expierence.required' => 'member expierence time required',
                'registered.required' => 'member registered time required',
                'name.min' => 'too short member name',
                'name.max' => 'too long member name',
                'surname.min' => 'too short member surname',
                'surname.max' => 'too long member surname',
                'live.min' => 'too short member city name',
                'live.max' => 'too long member city name',
                'expierence.digits_between' => 'incorrect experience time format',
                'registered.digits_between' => 'incorrect registered time format',
                'expierence.numeric_between:1,100' => 'so many years of experience can’t be',
                'registered.numeric_between:1,100' => 'man cannot fish for so many years'

            ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        if ($request->register > $request->expierence) {
            return redirect()->route('member.edit')->with('info_message', 'cannot be written.');
        } else {
            $member->name = $request->name;
            $member->surname = $request->surname;
            $member->live = $request->live;
            $member->expierence = $request->expierence;
            $member->registered = $request->registered;
            $member->reservoir_id = $request->reservoir_id;
            $member->save();
            return redirect()->route('member.index')->with('success_message', 'succesfully changed.');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('member.index') > with('success_message', 'succesfully deleted');
    }
}
