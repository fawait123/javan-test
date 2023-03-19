<?php

use Illuminate\Support\Facades\Route;
use App\Models\Family;
use Illuminate\Http\Request;


Route::get('/', function () {
    $data = Family::with('child.grandchild')->get();
    return view('welcome',compact('data'));
})->name('home');


Route::get('/create',function(){
    $data = Family::with('child.grandchild')->get();
    return view('form',[
        'family'=>$data
    ]);
})->name('create');

Route::get('/edit/{id}',function(Request $request,$id){
    $data = Family::with('child.grandchild')->get();
    $family = Family::find($id);
    return view('form',[
        'family'=>$data,
        'id'=>$id,
        'data'=>$family
    ]);
})->name('edit');


Route::post('/store',function(Request $request){
    $request->validate([
        'name'=>'required',
        'gender'=>'required',
    ]);

    Family::create([
        'name'=>$request->name,
        'gender'=>$request->gender,
        'parentID'=>$request->parentID
    ]);

    return redirect()->route('home');
})->name('store');

Route::put('/update/{id}',function(Request $request,$id){
    $request->validate([
        'name'=>'required',
        'gender'=>'required',
    ]);

    Family::where('id',$id)->update([
        'name'=>$request->name,
        'gender'=>$request->gender,
        'parentID'=>$request->parentID
    ]);

    return redirect()->route('home');
})->name('update');

Route::delete('/destroy/{id}',function(Request $request,$id){
    $family = Family::find($id);
    $family->delete();
    return redirect()->route('home');
})->name('destroy');
