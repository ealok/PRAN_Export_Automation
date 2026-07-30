@foreach ($sale_contracts as $sale_contract)
<tr>
    <td>{{ $sale_contract->sales_contract_no }}</td>
    <td>{{ date('d-m-Y', strtotime($sale_contract->dated)) }}</td>
    <td>{{ $sale_contract->invoice_no }}</td>
    <td>{{ isset($sale_contract->company) ? $sale_contract->company->name : '' }}</td>
    <td>
        {{ isset($sale_contract->bank) ? $sale_contract->bank->name : '' }}
        <br>
        <span style="font-size:10px;font-weight:bold">
            {{ $sale_contract->export_no }}
        </span>
    </td>
    <td>{{ $sale_contract->final_destination }}</td>
    <td>
        @if($sale_contract->desk_approve_at)
            Ci Posted
        @elseif($sale_contract->approver_id)
            Desk Posted
        @else
            New SC
        @endif
    </td>
    <td>
        <a href="{{ url('/jo/create') }}/{{ Crypt::encrypt($sale_contract->id) }}/{{ Crypt::encrypt($party_id) }}"
           class="btn btn-xs btn-primary btn-flat">Create JO</a>
        <a href="{{ url('/view/sale_contact') }}/{{ Crypt::encrypt($sale_contract->id) }}/{{ Crypt::encrypt($party_id) }}"
           class="btn btn-xs btn-success btn-flat">Show</a>
    </td>
</tr>
@endforeach
