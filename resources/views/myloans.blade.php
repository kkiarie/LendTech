<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <h3>My Loans</h3> 
                @if(!$Loans->isEmpty())   

                  <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Loan Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach ($Loans as $item)    
                        <tr>
                            <td>{{$loop->iteration}}.</td>
                            <td>{{$item->UserLoan->name}}</td>
                            <td>{{$item->UserLoan->phone_number}}</td>
                            <td>{{number_format($item->amount_due,2)}}</td>
                            <td>{{$item->due_date}}</td>
                            <td><?php 
                            if($item->repayment_status==0) { echo "<button>Pending Approval</button>";}
                            else if($item->repayment_status==1) { echo "<button>Approved</button>";}
                            else if($item->repayment_status==2) { echo "<button>Loan Paid</button>";}
                        ?></td>

                                <td>
                            <?php 
                            if($item->repayment_status==1):?>
                            <a href="{{ URL::to("/loan-pay/$item->id") }}" onclick="return confirm('Are you sure ?')">
                            <button type="buttfon" class="btn btn-success ">Pay Loan</button>
                         
                            <?php endif;?>
                        </a>
                        </td>
                        </tr>
                     @endforeach  
                    </tbody>
                </table>
                <nav aria-label="...">
                <div class="pagination">
                {{ $Loans->links() }}
                </div>
                </nav>
                </div>
                @else
                <p style="padding:10px">No records added at the moment.</p>
                @endif
                </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
