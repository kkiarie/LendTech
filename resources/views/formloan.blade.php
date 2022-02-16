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
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('loans.store') }}">
            {{ csrf_field() }}

            <!-- Name -->
            <div>
                <x-label for="amount" :value="__('Loan Amount')" />

                <x-input id="amount" class="block mt-1 w-full" type="text" name="amount" :value="old('amount')"  autofocus  placeholder="Amount"/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="number_of_days" :value="__('Number Of Days')" />

                <x-input id="number_of_days" class="block mt-1 w-full" type="text" name="number_of_days" :value="old('number_of_days')"  placeholder="Number Of Days" />
            </div>




            <div class="flex items-center justify-end mt-4">
       

                <x-button class="ml-4">
                    {{ __('Apply For Loan') }}
                </x-button>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
