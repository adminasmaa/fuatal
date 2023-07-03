@php
use Carbon\Carbon;
@endphp
<html>

<body>
    <style>
        table th {
            text-align: left;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 15px;
        }
    </style>
    <table style="width: 100%;" id="dataTableBuilder" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
        <caption>All QR Codes [{{$type}}] ({{date('d-m-Y h:m', strtotime(now()))}})</caption>
        <thead>
            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                <th>#</th>
                <th>{{$type}} Number</th>
                <th>Product</th>
                <th>Gift Type</th>
                <th>BAR-Code</th>
                <th>QR-Code</th>
            </tr>

        </thead>
        <tbody>
            @foreach($lotteryListing as $item)

            <tr>
                <td class="pe-0">{{$loop->iteration}}</td>
                <td class="pe-0">{{$item->random_number}}</td>
                <td class="pe-0">{{isset($item->product->title) ? $item->product->title : '-'}}</td>
                <td class="pe-0">{{isset($item->type) ? $item->type : '-'}}</td>
                <td class="pe-0">
                    @if($item->bar_code)
                    @php
                    $barcode = asset('uploads/barcodes/lotteries/'.$item->bar_code);
                    @endphp
                    <img style="width:67px;" src="{{$barcode}}">
                    @else
                    Generating.
                    @endif
                </td>
                <td class="pe-0">
                    @if($item->qr_code)
                    @php
                    $qrcode = asset('uploads/qrcodes/lotteries/'.$item->qr_code);
                    @endphp
                    <img style="width:67px;" src="{{$qrcode}}">
                    @else
                    Generating.
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>