@extends('format.layout')

@section('title')
    Home
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="text-center py-4">
        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
             style="width:80px;height:80px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" viewBox="0 0 16 16">
                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5v-5h3v5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L8.354 1.146z"/>
            </svg>
        </div>
        <h1 class="fw-bold mb-2">Student Management Dashboard</h1>
        <p class="text-muted lead mb-4">A simple portal to manage and view enrolled students.</p>
        <hr class="my-4">
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-3">
                <div class="card-body">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:56px;height:56px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#198754" viewBox="0 0 16 16">
                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.759 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                        </svg>
                    </div>
                    <h5 class="fw-semibold">View Students</h5>
                    <p class="text-muted small mb-3">Browse the full list of enrolled students along with their course and year level.</p>
                    <a href="{{ url('/students') }}" class="btn btn-primary btn-sm">Go to Students</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center p-3">
                <div class="card-body">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:56px;height:56px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#0dcaf0" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </div>
                    <h5 class="fw-semibold">About</h5>
                    <p class="text-muted small mb-3">Learn more about this Student Management Dashboard and its purpose.</p>
                    <a href="{{ url('/about') }}" class="btn btn-info btn-sm text-dark">Learn More</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection