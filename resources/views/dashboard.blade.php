{{-- @dd($dataForFacultiesAndYears) --}}
@extends('layouts.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mt-3 fs-2 text-center">UIGM</h1>
            <canvas class="my-3 w-100" width="900" height="350" id="myChart"></canvas>
        </div>
        <div class="col-md-12">
            <h1 class="mt-3 fs-2 text-center">By Fakultas</h1>
            <canvas class="my-3 w-100" width="900" height="350" id="myChart"></canvas>
        </div>
        <div class="row">
            <div class="col-md-4">
                <ul>
                    @foreach ($distinctYears as $year)
                        <li>{{ $year }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <ul>
                    @foreach ($distinctFaculties as $faculty)
                        <li>{{ $faculty }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <ul>
                    @foreach ($dataForFacultiesAndYears as $data)
                        <li>{{ $data['FE'] }},</li>
                    @endforeach
                    {{-- {{ $feData = [] }}
                    @foreach ($dataForFacultiesAndYears as $item)
                        {{ $feData[] = $item['FE'] }}
                    @endforeach --}}
                    {{-- @foreach ($dataForFacultiesAndYears as $data)
                        <li>{{ $data['FE'] }},</li>
                    @endforeach --}}

                </ul>
            </div>

        </div>



        {{-- <div class="col-md-12">
            <h1 class="mt-3 fs-2 text-center">By Fakultas</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">NPM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Program Studi</th>
                        <th scope="col">Fakutlas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <th>{{ $d->NPM }}</th>
                            <td>{{ $d->Nama }}</td>
                            <td>{{ $d->Program_Studi }}</td>
                            <td>{{ $d->Fakultas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $data->links() }}
        </div> --}}
    </div>
    <div id="dataByFaculty" data-data="{{ json_encode($dataForFacultiesAndYears) }}"></div>
@endsection
