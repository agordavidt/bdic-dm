@if(auth()->user()->isBuyer() && $device->buyer_id === auth()->id())
    <div class="mb-3">
        <a href="{{ route('buyer.fault_reports.create', $device) }}" class="btn btn-danger me-2">Report Fault</a>
        @if($device->status !== 'stolen')
            <form action="{{ route('devices.update-status', $device) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="stolen">
                <button type="submit" class="btn btn-warning">Flag as Stolen</button>
            </form>
        @else
            <span class="badge bg-danger">Device flagged as stolen</span>
        @endif
    </div>
@endif 