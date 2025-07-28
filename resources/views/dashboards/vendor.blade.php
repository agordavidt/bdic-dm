@extends('layouts.dashboard')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
          </li>
        </ul>
        <div>
          <div class="btn-wrapper">
            <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
            <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a>
          </div>
        </div>
      </div>
      
      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
          <div class="row">
            <div class="col-sm-12">
              <div class="statistics-details d-flex align-items-center justify-content-between">
                <div>
                  <p class="statistics-title">Total Devices</p>
                  <h3 class="rate-percentage">{{ $totalDevices }}</h3>
                </div>
                <div>
                  <p class="statistics-title">Devices Sold</p>
                  <h3 class="rate-percentage">{{ $devicesSold }}</h3>
                </div>
                <div>
                  <p class="statistics-title">Products</p>
                  <h3 class="rate-percentage">{{ $totalProducts }}</h3>
                </div>
                <div>
                  <p class="statistics-title">Fault Reports</p>
                  <h3 class="rate-percentage">{{ $totalFaults }}</h3>
                </div>
                <div>
                  <p class="statistics-title">Pending Faults</p>
                  <h3 class="rate-percentage">{{ $pendingFaults }}</h3>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-8 d-flex flex-column">
              <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card card-rounded">
                    <div class="card-body">
                      <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                          <h4 class="card-title card-title-dash">Recent Devices</h4>
                          <p class="card-subtitle card-subtitle-dash">Recently registered devices</p>
                        </div>
                      </div>
                      <div class="table-responsive mt-1">
                        <table class="table select-table">
                          <thead>
                            <tr>
                              <th>Model</th>
                              <th>Buyer</th>
                              <th>Registered</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse($recentDevices as $device)
                              <tr>
                                <td>
                                  <h6>{{ $device->model }}</h6>
                                </td>
                                <td>
                                  <h6>{{ $device->buyer_name ?? '-' }}</h6>
                                </td>
                                <td>{{ $device->created_at->format('M d, Y') }}</td>
                              </tr>
                            @empty
                              <tr>
                                <td colspan="3" class="text-center">No recent devices</td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 d-flex flex-column">
              <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card card-rounded">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title card-title-dash">Recent Fault Reports</h4>
                          </div>
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Device</th>
                                  <th>Status</th>
                                  <th>Reported</th>
                                </tr>
                              </thead>
                              <tbody>
                                @forelse($recentFaults as $fault)
                                  <tr>
                                    <td>{{ $fault->device->model ?? '-' }}</td>
                                    <td>
                                      <div class="badge badge-opacity-{{ 
                                        $fault->status == 'pending' ? 'warning' : 
                                        ($fault->status == 'resolved' ? 'success' : 'primary') 
                                      }}">
                                        {{ ucfirst($fault->status) }}
                                      </div>
                                    </td>
                                    <td>{{ $fault->created_at->format('M d, Y') }}</td>
                                  </tr>
                                @empty
                                  <tr>
                                    <td colspan="3" class="text-center">No recent faults</td>
                                  </tr>
                                @endforelse
                              </tbody>
                            </table>
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
      </div>
    </div>
  </div>
</div>
@endsection