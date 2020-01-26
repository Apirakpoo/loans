<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\loan;
class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = loan::orderBy('id','desc')->get();
        return view('loan.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loan.add');
    }

    public function search(Request $request)
    {
      $lm_min = $request->get('lm_min');
      $lm_max = $request->get('lm_max');
      $ir_min = $request->get('ir_min');
      $ir_max = $request->get('ir_max');
      $loans = loan::whereBetween('amount',[$lm_min, $lm_max])->orwhereBetween('rate',[$ir_min, $ir_max])->get();
      return view('loan.index', compact('loans'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'amount'=> 'required|integer|between:1000,100000000',
        'term'=> 'required|integer|between:1,50',
        'rate'=> 'required|integer|between:1,36',
        'month'=> 'required|integer',
        'year'=> 'required|integer|between:2017,2050'
      ]);
      $start_date = $request->get('year') . '-' . $request->get('month') . '-01';
      $loans = new loan([
        'amount'=> $request->get('amount'),
        'term'=> $request->get('term'),
        'rate'=> $request->get('rate'),
        'start_date'=> $start_date
      ]);
      $loans->save();
      $id = $loans->id;
      //dd($loans->id);
      //return redirect()->route('loan.show, $id')->with( ['data' => 'Database'] );
      return redirect()->route( 'loan.show', $id)->with( [ 'id' => $id ] );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $loans = loan::findOrFail($id);
      return view('loan.show', compact('loans', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $loans = loan::find($id);
      return view('loan.edit', compact('loans', 'id'));
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
      $this->validate($request,[
        'amount'=> 'required|integer|between:1000,100000000',
        'term'=> 'required|integer|between:1,50',
        'rate'=> 'required|integer|between:1,36',
        'month'=> 'required|integer',
        'year'=> 'required|integer|between:2017,2050'
      ]);

      $start_date = $request->get('year') . '-' . $request->get('month') . '-01';

      $loans = loan::find($id);
      $loans->amount = $request->get('amount');
      $loans->rate = $request->get('rate');
      $loans->term = $request->get('term');
      $loans->start_date = $start_date;
      $loans->save();

      $last_id = $loans->id;
      return redirect()->route( 'loan.show', $id)->with( [ 'id' => $last_id ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $loans = loan::find($id);
      $loans->delete();
      return redirect()->route('loan.index')->with("success","The loan #$id has been deleted successfully.");
    }

}
