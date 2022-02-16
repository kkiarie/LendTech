<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $UserStatus = auth()->user()->status;
        if($UserStatus==0)
        {
            //show personal loans
            $Loans = Loan::where("user_id",">",0)->orderby("id","asc")->paginate(50);
    

             return view('myloans',compact("Loans"));
        }
        else{

            $Loans = Loan::where("user_id",">",0)->orderby("id","asc")->paginate(50);
             return view('loans',compact("Loans"));
        }
        
       

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("formloan");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'amount' => ['required', 'integer','not_in:0'],
            'number_of_days' => ['required','integer','not_in:0'],
 
        ]);
        $amount=$request->amount;
        $number_of_days=$request->number_of_days;
        $interest=15;
        $amount_due=round($amount*1.15);
        $due_date=Carbon::now()->addDays($number_of_days);
        $record= new Loan();
        $record->user_id=auth()->user()->id;
        $record->amount=$amount;
        $record->due_date=$due_date;
        $record->loan_interest=$interest;
        $record->amount_due=$amount_due;
        $record->repayment_status=1;
        $record->number_of_days=$number_of_days;
        if($record->save())
        {
            return redirect('/loans')->with('status','Record created.');
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
