@extends('web::layouts.grids.12')

@section('title', 'Moon Drills')
@section('page_header', 'Moon Drills')

@section('full')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Metenox Moon Drills</h3>
        </div>
        <div class="card-body">
            @if($structures->isNotEmpty())
                <ul>
                @foreach($structures as $structure)
                    <li>Structure ID: {{ $structure->structure_id }}, Corporation ID: {{ $structure->corporation_id }}</li>
                @endforeach
                </ul>
            @else
                <p>Нет доступных структур</p>
            @endif
        </div>
    </div>
@endsection