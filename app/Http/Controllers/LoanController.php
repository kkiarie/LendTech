<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Auth\Events\Registered;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


public function apiLoans()
{
    $loans = Loan::where("user_id",">",0)->orderby("id","asc")->get();
    return $loans;
}

public function ApiLogin(Request $request)
{


    $email=$request->email;
    $password=$request->password;

    if (Auth::attempt(['email' => $email, 'password' => $password])) {
        $data = Auth::user();
      
         $message=["status"=>"success","message"=>"login was sucessfull","data"=>$data];
      }
      else{

        $message=["status"=>"error","message"=>"invalid login credentials"];
      }

      return $message;
}


public function ApiMakeLoan(Request $request)
{


        
        $user_id=$request->user_id;
        $amount=$request->amount;
        $number_of_days=$request->number_of_days;
        $interest=15;
        $amount_due=round($amount*1.15);
        $due_date=Carbon::now()->addDays($number_of_days);
        $record= new Loan();
        $record->user_id=$user_id;
        $record->amount=$amount;
        $record->due_date=$due_date;
        $record->loan_interest=$interest;
        $record->amount_due=$amount_due;
        $record->repayment_status=0;
        $record->number_of_days=$number_of_days;
        if($record->save())
        {

            return ["status"=>"success","message"=>$record];
        }
        else{

            return ["status"=>"error","message"=>"An error occured, please try again"];
        }


}


public function ApiApproveLoan(Request $request)
{
        $id=$request->LoanId;
        
        if(Loan::find($id))
        {
            $record = Loan::find($id);
            if($record->repayment_status==0)
            {
                $record->repayment_status=1;
                if($record->save())
                {
                $message=["status"=>"Loan Approved"];
                return  $message;
                }
             }

            else{

                $message=["status"=>"Unable to approve loan , current  status is ".$record->repayment_status];
                return  $message;

            } 

            }

        else{

            $message=["status"=>"Loan doesnot exist"];
            return  $message;
        }
  
}


public function notifyProjectOwner($message,$number)
{



$username = 'womenpower'; // use 'sandbox' for development in the test environment
$apiKey   = 'b23353e8e057af9e33d17ae168615a83cbbc0b0e5488f5a37f54ee659bdc411b'; // use your sandbox app API key for development in the test environment
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
        // $record=User::find(1);
        // $record->name="Administrator";
        // $record->email="admin@mail.com";
        // $record->phone_number="0700100100";
        // $record->save();

        // Loan::truncate();
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
            $rt= Loan::find($id);
            $number=$rt->UserLoan->phone_number;
            $message="Hello ".$rt->UserLoan->name.", your loan for ".$rt->amount_due ." is due on ".$rt->due_date.".";
            $this->notifyProjectOwner($message,$number);
             return redirect('/loans')->with('status','Record update.');
        }
    }

    public function loanpay($id=null)
    {
        $record = Loan::find($id);
        $record->repayment_status=2;
        if($record->save())
        {
            $rt= Loan::find($id);
            $number=$rt->UserLoan->phone_number;
            $message="Hello ".$rt->UserLoan->name.", your loan of ".$rt->amount_due ." has been paid.";
            $this->notifyProjectOwner($message,$number);
             return redirect('/loans')->with('status','Record update.');
        }
    }


    public function loannotify($id=null)
    {
        $record = Loan::find($id);
        $record->repayment_status=1;
        if($record)
        {
            $number=$record->UserLoan->phone_number;
            $message="Hello $record->UserLoan->name, your loan for ".$record->amount_due ." is due on $record->due_date.";
            $this->notifyProjectOwner($message,$number);
             return redirect('/loans')->with('status','Record update.');
        }
    }

    public function loanOption($UserID)
    {
        
        $Loan =Loan::where("user_id",$UserID)->whereIn("repayment_status",[0,1])->get()->count();
        return $Loan;
    }
    public function create()
    {
        //
        $UserID = auth()->user()->id;
        if($this->loanOption($UserID)>0)
        {
            
             return redirect('/loans')->with('error','You currently have unpaid loans or pending loan approval.');
        }
        else{
            return view("formloan");
        }
        
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
