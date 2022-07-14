<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title >Transaction Avec Nous</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">


    </head>
    <body class="font-sans antialiased">

        <section class="bg-gray-50 md:pb-8" >
            <div class=" bg-white overflow-auto rounded border md:mx-8 lg:mx-10  md:flex md:justify-between">
                <div class=" md:my-3 md:w-1/3 lg:w-1/6 md:border-l-4 md:ml-4">
                    <span class=" underline font-bold my-3 pl-4 hidden md:block">Client</span>
                    <h3 class=" text-xl my-2 pl-4 ">{{$customer->name}}</h3>
                    <p class=" my-2 pl-4 ">{{$customer->address}}</p>
                </div>
                <div class=" md:w-1/3 lg:w-1/6 md:border-l-4 hidden md:block">
                    <span class=" underline font-bold my-3 pl-4 hidden md:block ">De</span>
                    <h3 class=" text-xl my-2 pl-4 ">{{$company->name}}</h3>
                    <p class=" my-2 pl-4 ">{{$company->address}}</p>
                </div>
            </div>
            <h3 class=" text-xl my-3 pl-8 hidden md:block">Transaction a ce jour: {{ date('d-m-Y') }}</h3>
            <div class=" bg-white overflow-auto rounded border md:mx-8 lg:mx-10 mx-10 hidden md:block">
                <table class=" w-full text-center">
                    <thead class="bg-gray-400">
                        <th></th>
                        <th class="py-2">Libelle</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Solde</th>
                    </thead>
                    <tbody class="">
                    @foreach($transactions as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="py-2">#{{ $item->id }}
                                <p class="text-muted text-xs">{{ substr($item->created_at, 0,10)}}</p>
                            </td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->debit/100}}</td>
                            <td>{{ $item->credit/100 }}</td>
                            <td>{{ number_format($item->solde/100)  }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <ul class="w-full divide-y bg-white rounded-md border block md:hidden mx-2 overflow-hidden">
                <li class="w-full bg-slate-400 px-3 py-4">
                    <h3 class=" text-xl">Transaction a ce jour: {{ date('d-m-Y') }}</h3>
                </li>
                @foreach($transactions as $item)
                <li class="hover:bg-slate-50">

                    <div class="flex flex-row gap-1 -justify-between px-2 py-2">
                        <div class="w-20">
                            <h4>{{ $item->id }}</h4><td class="py-2">
                            <p class="text-muted text-xs">{{ substr($item->created_at, 0,10)  }}</p>
                        </div>
                        <div class="flex-1">
                            <p>{{ $item->description }}</p>
                            @if ($item->debit >0 )
                                <span class="text-muted text-sm font-bold text-red-600 px-2">- {{ number_format($item->debit/100)}}</span>
                            @endif
                            @if ($item->credit >0 )
                                <span class="text-muted text-sm font-bold text-green-600 px-2">+ {{ number_format($item->credit/100)}}</span>
                            @endif

                        </div>
                        <div class="w-24 font-semibold">
                            {{ number_format($item->solde/100) }}
                        </div>

                    </div>





                </li>
            @endforeach
            </ul>
        </section>




    </body>
</html>
