@extends('web::layouts.grids.12')

@section('title', 'Настройки скидок')
@section('page_header', 'Настройки скидок')

@section('full')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('billing.discount.settings.update') }}">
                @csrf
                <div class="form-group">
                    <label for="max_discount">Максимальная общая скидка (%)</label>
                    <input type="number" step="0.1" class="form-control" id="max_discount" name="max_discount" value="{{ $settings['max_discount'] }}" min="0" max="100">
                </div>
                <div class="form-group">
                    <label for="discount_per_fleet">Скидка за участие в одном флоте (%)</label>
                    <input type="number" step="0.1" class="form-control" id="discount_per_fleet" name="discount_per_fleet" value="{{ $settings['discount_per_fleet'] }}" min="0" max="100">
                </div>
                <div class="form-group">
                    <label for="max_fleet_discount">Максимальная скидка за участие во флотах (%)</label>
                    <input type="number" step="0.1" class="form-control" id="max_fleet_discount" name="max_fleet_discount" value="{{ $settings['max_fleet_discount'] }}" min="0" max="100">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить настройки</button>
            </form>
        </div>
    </div>
@stop