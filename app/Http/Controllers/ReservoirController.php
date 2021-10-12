<?php

namespace App\Http\Controllers;

use App\Models\Reservoir;
use Illuminate\Http\Request;
use Validator;
use Laravel\Ui\Presets\React;
use Intervention\Image\ImageManagerStatic as Image;
use Str;



class ReservoirController extends Controller
{
    const RESULTS_IN_PAGE = 8;
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservoirs = Reservoir::orderBy('area', 'desc')->paginate(self::RESULTS_IN_PAGE)->withQueryString();
        return view('reservoir.index', ['reservoirs' => $reservoirs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reservoir.create');
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
                'title' => ['required', 'min:3', 'max:200'],
                'area' => ['required', 'numeric', 'between:0,1000.99'],
            ],
            [
                'title.required' => 'reservoir title required',
                'area.required' => 'reservoir area required',
                'title.min' => 'too short reservoir title',
                'title.max' => 'too long reservoir title',
                'area.numeric_between:0,99.99' => 'invalid area format',
            ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $reservoir = new Reservoir();
        $reservoir->title = $request->title;
        $reservoir->area = $request->area;
        $reservoir->about = $request->about;
        $reservoir->save();
        return redirect()->route('reservoir.index')->with('success_message', 'succesfully recorded.');
    }
    public function uploadPhoto(Reservoir $reservoir, Request $request)
    {
        if ($request->has('photo')) {
            $img = Image::make($request->file('photo'));
            $fileName = Str::random(5) . ".jpg";
            $folder = public_path('/reservoirPhoto');
            $img->resize(120, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($folder . '/' . $fileName, 80, 'jpg');
            $reservoir->photo_name = $fileName;
            $reservoir->save();
        }
        return redirect()->route('reservoir.index', ['reservoir' => $reservoir]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservoir  $reservoir
     * @return \Illuminate\Http\Response
     */
    public function show(Reservoir $reservoir)
    {

        $reservoir = Reservoir::where('id', $reservoir->id)->paginate(self::RESULTS_IN_PAGE)->withQueryString();
        return view('reservoir.show', ['reservoir' => $reservoir]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservoir  $reservoir
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservoir $reservoir)
    {
        return view('reservoir.edit', ['reservoir' => $reservoir]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservoir  $reservoir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservoir $reservoir)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => ['required', 'min:3', 'max:200'],
                'area' => ['required', 'numeric', 'between:0,1000.99'],
            ],
            [
                'title.required' => 'reservoir title required',
                'area.required' => 'reservoir area required',
                'title.min' => 'too short reservoir title',
                'title.max' => 'too long reservoir title',
                'area.numeric_between:0,99.99' => 'invalid area format',
            ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $reservoir->title = $request->title;
        $reservoir->area = $request->area;
        $reservoir->about = $request->about;
        $reservoir->save();
        return redirect()->route('reservoir.index')->with('success_message', 'succesfully changed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservoir  $reservoir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservoir $reservoir)
    {
        if ($reservoir->reservoirMember()->count()) {
            return 'You cannot delete because you have an assigned member';
        }
        $reservoir->delete();
        return redirect()->route('reservoir.index');
    }
}
