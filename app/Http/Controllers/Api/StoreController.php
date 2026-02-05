<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        return Store::select('id', 'name','code','postal_code','prefecture','city','address_line','is_active',)->orderby('id')->get();
    }

    public function store(StoreStoreRequest $request)
    {
        $store = Store::create($request->validated());
        return Store::select(
            'id',
            'name',
            'code',
            'postal_code',
            'prefecture',
            'city',
            'address_line', 
            'is_active',
            )->where('id',$store->id)->first();
    }    

    public function show(Store $store )
    {
        return $store;
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $data = $request->validated();
        $store->update($data);

        return Store::select(
            'id',
            'name',
            'code',
            'postal_code',
            'prefecture',
            'city',
            'address_line', 
            'is_active',
            )->where('id',$store->id)->first();
    }
}
