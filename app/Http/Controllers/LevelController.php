<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorelevelRequest;
use App\Http\Requests\UpdatelevelRequest;
use App\Models\Level;
use Illuminate\Http\Response;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorelevelRequest $request
     * @return Response
     */
    public function store(StorelevelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Level $level
     * @return Response
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Level $level
     * @return Response
     */
    public function edit(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatelevelRequest $request
     * @param Level $level
     * @return Response
     */
    public function update(UpdatelevelRequest $request, Level $level)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Level $level
     * @return Response
     */
    public function destroy(Level $level)
    {
        //
    }
}
