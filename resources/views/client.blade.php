@extends('format.layout')

@section('title')
    Client Page
@endsection

@section('header')
    @parent
@endsection

@section('content')

<div class="container mt-4">

    <h2 class="text-success border-bottom border-success pb-2">Client Page</h2>

    {{-- While Loop --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">While Loop</h5>

            @php $i = 1; @endphp

            @while($i <= 10)
                {{ $i }} <br>
                @php $i++; @endphp
            @endwhile

        </div>
    </div>


    {{-- Star Pattern --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Star Pattern</h5>

            <div style="font-family: monospace;" class="text-success">
                @for($a = 1; $a <= 5; $a++)
                    @for($b = 1; $b <= $a; $b++)
                        *
                    @endfor
                    <br>
                @endfor
            </div>

        </div>
    </div>


    {{-- Grade Check --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Grade Check</h5>

            Grade: <strong>{{ $grade }}</strong> <br>

            @if($grade % 2 == 1)
                <span class="text-warning fw-bold">ODD NUMBER</span>
            @else
                <span class="text-success fw-bold">EVEN NUMBER</span>
            @endif

        </div>
    </div>


    {{-- Client List --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Client List</h5>

            <table class="table table-bordered table-striped text-center">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Address</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $client['name'] }}</td>
                        <td>{{ $client['sex'] }}</td>
                        <td>{{ $client['address'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            Total Clients: <strong>{{ $loop->count ?? count($clients) }}</strong>

        </div>
    </div>

</div>

@endsection


@section('footer')
    @parent
@endsection