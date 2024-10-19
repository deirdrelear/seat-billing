@extends('web::layouts.grids.12')

@section('title', 'Moon Drills')
@section('page_header', 'Moon Drills')

@section('full')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Metenox Moon Drills</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="moondrills-table">
                <thead>
                    <tr>
                        <th>Corporation ID</th>
                        <th>Number of Structures</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($structures as $structure)
                        <tr>
                            <td>{{ $structure->corporation_id }}</td>
                            <td>{{ $structure->count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Нет доступных структур</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('javascript')
<script>
    $(document).ready(function() {
        $('#moondrills-table').DataTable();
    });
</script>
@endpush