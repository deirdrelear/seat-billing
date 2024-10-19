@extends('web::layouts.grids.12')

@section('title', 'Moon Drills')
@section('page_header', 'Moon Drills')

@section('full')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Metenox Moon Drills</h3>
        </div>
        <div class="card-body">
            <ul>
            @forelse($structures as $structure)
                <li>{{ $structure->name }}</li>
            @empty
                <li>Нет доступных структур</li>
            @endforelse
            </ul>
        </div>
    </div>
@endsection