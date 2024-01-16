<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="dark:text-gray-100 m-12 rounded-lg">

        <h2 class="px-96 mt-4 mb-4 text-2xl font-semibold leadi">Customers</h2>

        <button type="button" class="mx-96 mr-1 mb-4 px-8 py-2 font-semibold border rounded dark:border-gray-100 dark:text-gray-100 hover:bg-blue-700 hover:text-white hover:scale-105 duration-200">
            <a href="{{ route("admin.mails.create") }}">Create a new Customers</a>
        </button>
        <div class="flex justify-center">
            <table class="text-xs text-left whitespace-nowrap">
               
                <thead>
                    <tr class="dark:bg-gray-700">
                        <th class="p-2">Name</th>
                        <th class="p-2">Host</th>
                        <th class="p-2">Username</th>
                        <th class="p-2">Smtp</th>
                        <th class="p-2">Port</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-b dark:bg-gray-900 dark:border-gray-700">
                    @foreach ($mails as $mail)
                        <tr class="project-item">
                            <td class="pl-2 pe-8 py-2">
                                <p>{{$mail->mailName}}</p>
                            </td>
                            <td class="pl-2 pe-8">
                                <p>{{$mail->mailHost}}</p>
                            </td>
                            <td class="pl-2 pe-8">
                                <p>{{$mail->mailUsername}}</p>
                            </td>
                            <td class="px-2 py-2">
                                <p>{{$mail->mailSmtpSecure}}</p>
                            </td>
                            <td class="px-2 py-2 whitespace-normal">
                                <p>{{$mail->mailPort}}</p>
                            </td>
                            <td class="px-1 py-2 ">
                                <div class="flex">
                                   
    
                                    <button class="ml-2 px-2 py-2 font-semibold border rounded dark:border-gray-100 dark:text-gray-100 hover:bg-yellow-500 hover:text-black">
                                        <a class="button mx-1" href="{{route('admin.mails.edit', ['mail' => $mail->id]) }}">Edit</a>
                                    </button>
    
                                    <form
                                        action="{{ route('admin.mails.destroy', ['mail' => $mail->id]) }}"
                                        method="post"
                                        class="d-inline-block mx-1"
                                    >
                                        @csrf
                                        @method('delete')
                                        <button class="px-2 py-2 font-semibold border rounded dark:border-gray-100 dark:text-gray-100 hover:bg-red-700 hover:text-white">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>