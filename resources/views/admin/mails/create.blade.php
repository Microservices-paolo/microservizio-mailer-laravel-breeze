<x-app-layout>
    

    <section class="m-5 p-6 dark:bg-gray-800 dark:text-gray-50">
        <div class="p-5">
            <h1 class="text-2xl font-bold">Create a new Customer</h1>
            <form 
            method="POST" 
            action="{{ route('admin.mails.store') }}" 
            enctype="multipart/form-data"  
            novalidate
            class="container flex flex-col mx-auto space-y-12"
            >
                {{-- Per protezione dati --}}
                @csrf 
                {{-- Per protezione dati --}}
                <fieldset class="grid grid-cols-4 gap-6 p-12 rounded-md shadow-sm dark:bg-gray-900">
                    <div class="space-y-2 col-span-full lg:col-span-1">
                        <p class="font-medium">Informations</p>
                        <p class="text-xs">Put the information here to create a new customer</p>
                    </div>
                    <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                        {{-- Nome --}}
            
                        <div class="col-span-full sm:col-span-3">
                            <label 
                            for="mailName" class="form-label" style="font-weight:700; font-size:20px">
                                Name
                            </label>
                            <input 
                            type="text" 
                            class="w-full rounded-md focus:ring focus:ri focus:ri dark:border-gray-700 dark:text-gray-900 form-control @error('mailName') is-invalid @enderror" 
                            id="mailName" 
                            name="mailName" 
                            value="{{ old('mailName')}}">
                
                            <div class="invalid-feedback">
                                @error('mailName') {{ $message }} @enderror
                            </div>
                        </div>

                        {{-- Host --}}
                
                        <div class="col-span-full sm:col-span-3">
                            <label for="mailHost" class="form-label" style="font-weight:700; font-size:20px">
                                Host
                            </label>
                            <input 
                            type="text" 
                            class="w-full rounded-md focus:ring focus:ri focus:ri dark:border-gray-700 dark:text-gray-900 form-control @error('mailHost') is-invalid @enderror" 
                            id="mailHost" 
                            name="mailHost" 
                            value="{{ old('mailHost')}}">
                
                            <div class="invalid-feedback">
                                @error('mailHost') {{ $message }} @enderror
                            </div>
                        </div>

                        {{-- Username --}}
                
                        <div class="col-span-full sm:col-span-3">
                            <label for="mailUsername" class="form-label" style="font-weight:700; font-size:20px">
                                Username
                            </label>
                            <input 
                            type="text" 
                            class="w-full rounded-md focus:ring focus:ri focus:ri dark:border-gray-700 dark:text-gray-900 form-control @error('mailUsername') is-invalid @enderror" 
                            id="mailUsername" 
                            name="mailUsername" 
                            value="{{ old('mailUsername')}}">
                
                            <div class="invalid-feedback">
                                @error('mailUsername') {{ $message }} @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                
                        <div class="col-span-full sm:col-span-3">
                            <label for="mailPassword" class="form-label" style="font-weight:700; font-size:20px">
                                Password
                            </label>
                            <input 
                            type="password" 
                            class="w-full rounded-md focus:ring focus:ri focus:ri dark:border-gray-700 dark:text-gray-900 form-control @error('mailPassword') is-invalid @enderror" 
                            id="mailPassword" 
                            name="mailPassword" 
                            value="{{ old('mailPassword')}}">
                
                            <div class="invalid-feedback">
                                @error('mailPassword') {{ $message }} @enderror
                            </div>
                        </div>

                        {{-- Smtp --}}

                        <div class="col-span-full sm:col-span-3">
                            <label for="mailSmtpSecure" class="form-label" style="font-weight:700; font-size:20px">
                                Smtp
                            </label>
                            <input 
                            type="text" 
                            class="w-full rounded-md focus:ring focus:ri focus:ri dark:border-gray-700 dark:text-gray-900 @error('mailSmtpSecure') is-invalid @enderror" 
                            id="mailSmtpSecure" name="mailSmtpSecure" value="{{ old('mailSmtpSecure')}}">
                
                            <div class="invalid-feedback">
                                @error('mailSmtpSecure') {{ $message }} @enderror
                            </div>
                        </div>
                        

                        {{-- Port--}}

                        <div class="col-span-full sm:col-span-3">
                            <label for="mailPort" class="form-label" style="font-weight:700; font-size:20px">
                                Port
                            </label>
                            <input 
                            type="text" 
                            class="w-full rounded-md focus:ring focus:ri focus:ri dark:border-gray-700 dark:text-gray-900 @error('mailPort') is-invalid @enderror" 
                            id="mailPort" name="mailPort" value="{{ old('mailPort')}}">
                
                            <div class="invalid-feedback">
                                @error('mailPort') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>

                   
                </fieldset>
                <div class="w-100 flex justify-center">
                    <button class="px-20 py-3 font-semibold rounded dark:bg-gray-100 dark:text-gray-800 btn">Create</button>
                </div>
            </form>
        </div>
    </section>

</x-app-layout>