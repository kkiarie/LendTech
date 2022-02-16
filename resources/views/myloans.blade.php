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
                    
                @if(!$Loans->isEmpty())   

                <table class="table table-inverse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach ($Setups as $item)    
                        <tr>
                            <td></td>
                        </tr>
                      @foreach   
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
