@php
use Carbon\Carbon;
@endphp
<html>

<body>
    <style>
        table th{
            text-align: left;
        }
    </style>
    <table style="width: 100%;" id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5  dataTable no-footer">
    <caption>Cash Credit Numbers ({{date('d-m-Y h:m', strtotime(now()))}})</caption>
        <thead>
            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                <th>#</th>
                <th>Number</th>
                <th>Company</th>
                <th>Status</th>
            </tr>

        </thead>
        <tbody>
            @php
            $cnt =1;
            @endphp
            @foreach($numbers as $num)
            <tr>
                <td class="pe-0">{{$cnt}}</td>

                <td class="pe-0">{{$num->number}}</td>
                <td class="pe-0">{{$num->company->name}}</td>
                <td>
                    @if($num->expired)
                    <label class="badge badge-danger">Used</label>
                    @else
                    <label class="badge badge-success">Unused</label>
                    @endif
                </td>

            </tr>
            @php
            $cnt++;
            @endphp
            @endforeach
        </tbody>
    </table>
</body>

</html>