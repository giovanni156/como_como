<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\MenuResource;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\StoreMenuFoodRequest;
use App\Http\Requests\DeleteMenuFoodRequest;
use App\Http\Requests\UpdateMenuFoodRequest;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MenuResource::collection(Menu::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'menu_type' => '0',
            'it_is_ideal' => false,
            'owner_id' => $request->owner_id,
            'user_id' => $request->user_id,
        ]);

        return response($menu, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return response($menu, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'menu_type' => '0',
            'it_is_ideal' => false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response('deleted', Response::HTTP_OK);
    }

    /**
     * Add food to menu
     *
     * @param  StoreMenuFoodRequest $request
     * @param  Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function addFood(StoreMenuFoodRequest $request, Menu $menu)
    {
        $menu->foods()->attach(
            $request->food_id,
            [
                'food_weight' => $request->food_weight,
                'kind_of_food' => $request->kind_of_food
            ]
        );

        return response('added', Response::HTTP_CREATED);
    }

    /**
     * Delete food from menu
     *
     * @param  DeleteMenuFoodFoodRequest $request
     * @param  Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function deleteFood(DeleteMenuFoodRequest $request, Menu $menu)
    {
        $menu->foods()->detach($request->food_id);

        return response('deleted', Response::HTTP_OK);
    }

    /**
     * Update food from menu
     *
     * @param  UpdateMenuFoodFoodRequest $request
     * @param  Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function updateFood(UpdateMenuFoodRequest $request, Menu $menu)
    {
        $menu->foods()
            ->updateExistingPivot(
                $request->food_id,
                [
                    'weight' => $request->weight,
                    'kind_of_food' => $request->kind_of_food]
            );

        return response('updated', Response::HTTP_OK);
    }
}
