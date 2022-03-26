<?php

namespace App\Http\Controllers;

use App\FakeNumber;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class FakeNumberController extends Controller
{
    protected $model;

    protected $rView = 'backend.fake_number.';

    public function __construct(FakeNumber $model)
    {
        return $this->model = $model;
    }

    public function index()
    {
        return view($this->rView.'index');
    }

    public function ssd()
    {
        $number = $this->model->query();
        return Datatables::of($number)
        ->addColumn('action', function ($each) {
            $edit_icon = "";
            $delete_icon = "";
            
            $edit_icon = '<a href="'.url('admin/fake_number/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            
            $delete_icon = '<a href="'.url('admin/fake_number/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view($this->rView . 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->model->create($request->all());
        return redirect('/admin/fake_number')->with('create', 'Created Successfully');
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
        $number = $this->model->findOrFail($id);
        return view($this->rView.'edit', compact('number'));
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
        //return $request->all();
        $this->model->find($id)->update($request->all());
        return redirect('/admin/fake_number')->with('update', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $number = $this->model->findOrFail($id);
        $number->delete();

        return 'success';
    }

    
}
