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
                        <th>Structure Name</th>
                        <th>Corporation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($structures as $structure)
                        <tr>
                            <td>{{ $structure->name }}</td>
                            <td>{{ $structure->corporation->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('javascript')
<script>
    $(document).ready(function() {
        $('#moondrills-table').DataTable({
            order: [[0, "asc"]]
        });
    });
</script>
@endpush