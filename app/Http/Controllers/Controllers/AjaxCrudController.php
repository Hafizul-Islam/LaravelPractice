<?php

namespace App\Http\Controllers\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxCrudController extends Controller
{
    protected $rules=[
        'name'  => 'required',
        'email' => 'required',
        'phone' => 'required'
    ];

    public function index()
    {
        return view('Crud.crudWithAjax');
    }

    public function getcontactlist()
    {
        return Contact::all();
    }

   

   
    public function store(Request $request)
    {
        $Validator=\Validator::make($request->all(), $this->rules)->validate();

        Contact::create($request->all());
        return [
            'success'=>true,
            'message'=>'inserted successfully',
            'data'   => $request,
        ];
    }
 
    public function update(Request $request)
    {
        if($request->has('id')){
            Contact::find($request->input('id'))->update($request->all());
            return [
                'messege'=>'updated successfully'
            ];
        }
        
    }

   
    public function destroy(Request $request)
    {
        if($request->has('id')){
            Contact::find($request->input('id'))->delete();
            return [
                'messege'=>'deleted successfully'
            ];
        }
    }
}
