<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use AfricasTalking\SDK\AfricasTalking;
class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public function notifyProjectOwner($message,$number)
{



$username = 'int'; // use 'sandbox' for development in the test environment
$apiKey   = 'bd2785794bd83efd62fa397bd5da9299ce594455d3b8180fdb36698ec1ed9bc2'; // use your sandbox app API key for development in the test environment
$AT       = new AfricasTalking($username, $apiKey);

// Get one of the services
$sms      = $AT->sms();

// Use the service
$result   = $sms->send([
'to'      => $number,
'message' =>  $message
]);                

            //exit();

}


    public function index()
    {
        //
        $UserStatus = auth()->user()->status;
        if($UserStatus==0)
        {
            //show personal loans
            $Loans = Loan::where("user_id",auth()->user()->id)->orderby("id","asc")->paginate(50);
    

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

    public function approveloan($id=null)
    {
        $record = Loan::find($id);
        $record->repayment_status=1;
        if($record->save())
        {
            $number=$record->UserLoan->phone_number;
            $message=$record->UserLoan->phone_number;
            $this->notifyProjectOwner($message,$number);
             return redirect('/loans')->with('status','Record update.');
        }
    }
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
        $record->repayment_status=0;
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
