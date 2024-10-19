@extends('web::layouts.grids.12')

@section('title', trans('billing::billing.pastbill'))
@section('page_header', trans('billing::billing.pastbill'))

@section('full')
    @include("treelib::giveaway")

    <input type="hidden" id="year" value="{{ $year }}">
    <input type="hidden" id="month" value="{{ $month }}">

    <ul class="nav nav-pills pb-3">
        <li class="nav-item"><a class="nav-link" href="#tab3"
                                data-toggle="tab">{{ trans('billing::billing.summary-ind-mining') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab2"
                                data-toggle="tab">{{ trans('billing::billing.summary-corp-pve') }}</a></li>
        <li class="nav-item"><a class="nav-link active" href="#tab1"
                                data-toggle="tab">{{ trans('billing::billing.summary-corp-mining') }}</a></li>
        <li class="nav-item"><a href="#tab4" data-toggle="tab" class="nav-link"><i class="fa fa-history"></i> Previous Bills</a></li>

        <li class="nav-item ml-auto">
            <form action="{{ route("billing.recalculateMonth") }}" method="POST">
                @csrf
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <button type="submit" class="btn btn-warning confirmform" data-seat-action="recalculate the bills for {{$year}}-{{$month}}? Recalculating on old data might lead to different results. Old results can't be restored. Continue">Recalculate Bill</button>
            </form>
            <a href="{{ route('billing.refresh') }}" class="btn btn-primary">Refresh Billing Data</a>
        </li>
    </ul>

    <div class="form-group">
        <label for="month">Месяц:</label>
        <select id="month" name="month" class="form-control">
            @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
            @endfor
        </select>
    </div>
    <div class="form-group">
        <label for="year">Год:</label>
        <select id="year" name="year" class="form-control">
            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
    </div>
    <button id="updateStats" class="btn btn-primary">Обновить статистику</button>

    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('billing::billing.summary-corp-mining') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="livenumbers">
                        <p class="mb-3">
                            Debug Info: {{ $debugInfo['user'] }}, 
                            Characters: {{ $debugInfo['characterIds'] }}, 
                            Corporations: {{ $debugInfo['corporationIds'] }}, 
                            Year: {{ $debugInfo['year'] }},
                            Month: {{ $debugInfo['month'] }},
                            Stats Count: {{ $debugInfo['statsCount'] }}, 
                            Dates Count: {{ $debugInfo['datesCount'] }},
                            Raw Stats: <pre>{{ json_encode($debugInfo['rawStats'], JSON_PRETTY_PRINT) }}</pre>
                        </p>
                        <thead>
                            <tr>
                                <th>Corporation</th>
                                <th>Alliance</th>
                                <th>Mined Amount (adjusted)</th>
                                <th>Tax Owed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($stats->isNotEmpty() && $stats->first()->corporation_id !== 0)
                                @foreach($stats as $row)
                                    <tr>
                                        <td>{{ $row->corporation->name ?? 'N/A' }}</td>
                                        <td>{{ $row->corporation->alliance->name ?? 'N/A' }}</td>
                                        <td data-sort="{{ $row->mining_total ?? 0 }}">{{ number_format($row->mining_total ?? 0, 2) }}</td>
                                        <td data-sort="{{ $row->mining_tax ?? 0 }}">{{ number_format($row->mining_tax ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">Нет данных для отображения за выбранный период. Попробуйте выбрать другой месяц или год.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @include("treelib::creator-code")
            </div>
        </div>

        <div class="tab-pane" id="tab2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('billing::billing.summary-corp-pve') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="livepve">
                        <thead>
                            <tr>
                                <th>Corporation</th>
                                <th>Alliance</th>
                                <th>Total Bounties</th>
                                <th>Tax Owed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($stats->isNotEmpty() && $stats->first()->corporation_id !== 0)
                                @foreach($stats as $row)
                                    <tr>
                                        <td>{{ $row->corporation->name ?? 'N/A' }}</td>
                                        <td>{{ $row->corporation->alliance->name ?? 'N/A' }}</td>
                                        <td data-sort="{{ $row->pve_total ?? 0 }}">{{ number_format($row->pve_total ?? 0, 2) }}</td>
                                        <td data-sort="{{ $row->pve_tax ?? 0 }}">{{ number_format($row->pve_tax ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">Нет данных для отображения за выбранный период. Попробуйте выбрать другой месяц или год.</td>
                                </tr>
                            @endif
                        </tbody>
                        </tbody>
                    </table>
                </div>
                @include("treelib::creator-code")
            </div>
        </div>
        <div class="tab-pane" id="tab3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('billing::billing.summary-ind-mining') }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <select class="form-control w-100" id="corpspinner">
                            <option disabled selected value="0">Please Choose a Corp</option>
                            @foreach($stats as $row)
                                <option value="{{ $row->corporation->corporation_id }}">{{ $row->corporation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table table-striped"
                           id='indivmining'>
                        <thead>
                        <tr>
                            <th>Character Name</th>
                            <th>Mining Amount</th>
                            <th>Tax Due</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- There need to be dumy rows when creating the table or it won't work for some reason https://datatables.net/forums/discussion/42979/row-add-node-how-to-set-data-sort-->
                                <td></td>
                                <td data-sort="0"></td>
                                <td data-sort="0"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @include("treelib::creator-code")
            </div>
        </div>
        <div class="tab-pane" id="tab4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('billing::billing.previousbill') }}</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <a href="{{ route('billing.view') }}"
                           class="list-group-item list-group-item-action">
                            Current
                        </a>
                        @foreach($dates->chunk(3) as $date)
                            @foreach ($date as $yearmonth)
                                <a href="{{ route('billing.pastbilling', ['year' => $yearmonth['year'], 'month' => $yearmonth['month']]) }}"
                                   class="list-group-item list-group-item-action">
                                    {{ date('Y-M', mktime(0,0,0, $yearmonth['month'], 1, $yearmonth['year'])) }}
                                </a>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                @include("treelib::creator-code")
            </div>
        </div>
    </div>
    </div>
    </div>

@endsection

@push('javascript')
    @include('web::includes.javascript.id-to-name')

    <script type="application/javascript">

        table = $('#indivmining').DataTable({
        });

        ids_to_names();


        $('#corpspinner').select2({
            width: '100%' // need to override the changed default
        });

        $('#corpspinner').on('select2:select',function (e) {

            $('#indivmining').find('tbody').empty();
            id = e.params.data.id;
            year = $('#year').val();
            month = $('#month').val();

            if (id > 0) {
                $.ajax({
                    headers: function () {
                    },
                    url: "/billing/character/" + id + "/" + year + "/" + month,
                    type: "GET",
                    dataType: 'json',
                    timeout: 10000
                }).done(function (result) {
                    if (result) {
                        table.clear();
                        for (var char of result) {
                            const name = char.character_name ? char.character_name : "{{ trans('web::seat.unknown') }}"
                            const tr = document.createElement("tr")
                            tr.innerHTML = '<td><a href="/billing/user/character/'+ char.character_id +'#bills'+year.toString()+month.toString()+'">'+name+'</a></td><td data-sort="'+char.mining_total+'">'+ new Intl.NumberFormat('en-US').format(char.mining_total)+ ' ISK</td><td data-sort="'+char.mining_tax+'">'+ new Intl.NumberFormat('en-US').format(char.mining_tax)+" ISK</td>"
                            table.row.add(tr);
                        }
                        table.draw();
                        ids_to_names();
                    }
                });
            }
        });

        $(document).ready( function () {
            $('#livenumbers').DataTable();
            $('#livepve').DataTable();
        } );

        $('#updateStats').click(function() {
            var month = $('#month').val();
            var year = $('#year').val();
            window.location.href = '{{ route('billing.pastbilling') }}/' + year + '/' + month;
        });
    </script>
@endpush
