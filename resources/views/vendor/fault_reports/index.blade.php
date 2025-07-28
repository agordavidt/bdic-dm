@extends('layouts.dashboard')

@section('title', 'Device Fault Reports')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Device Fault Reports</a>
          </li>
        </ul>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Device</th>
                          <th>Buyer</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th>Reported At</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($reports as $report)
                          <tr>
                            <td>{{ $report->device->model ?? '-' }}</td>
                            <td>{{ $report->user->name ?? '-' }}</td>
                            <td>{{ Str::limit($report->description, 40) }}</td>
                            <td>
                              <div class="badge badge-opacity-{{ 
                                $report->status == 'pending' ? 'warning' : 
                                ($report->status == 'resolved' ? 'success' : 'primary') 
                              }}">
                                {{ ucfirst($report->status) }}
                              </div>
                            </td>
                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                            <td>
                              <a href="{{ route('vendor.fault_reports.show', $report) }}" class="btn btn-sm btn-info"><i class="mdi mdi-eye"></i></a>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="6" class="text-center">No fault reports found.</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  <div class="mt-3">
                    {{ $reports->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection