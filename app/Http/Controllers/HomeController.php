<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $dashboardData = $this->getDashboardData($user);
        
        return view('home', compact('user', 'dashboardData'));
    }
    
    /**
     * Get dashboard data based on user role
     */
    private function getDashboardData($user)
    {
        $data = [];
        
        switch ($user->role) {
            case 'admin':
                $data = [
                    'total_users' => \App\Models\User::count(),
                    'total_vendors' => \App\Models\User::where('role', 'vendor')->count(),
                    'total_buyers' => \App\Models\User::where('role', 'buyer')->count(),
                    'recent_registrations' => \App\Models\User::latest()->limit(5)->get(),
                ];
                break;
                
            case 'vendor':
                // TODO: Add device and sales data when models are created
                $data = [
                    'total_devices' => 0, // Will be updated when Device model is created
                    'devices_sold' => 0,
                    'pending_reports' => 0,
                    'monthly_sales' => 0,
                ];
                break;
                
            case 'buyer':
                // TODO: Add device and report data when models are created
                $data = [
                    'owned_devices' => 0, // Will be updated when Device model is created
                    'active_reports' => 0,
                    'resolved_reports' => 0,
                ];
                break;
                
            case 'manufacturer':
                // TODO: Add manufacturing data when models are created
                $data = [
                    'total_devices' => 0,
                    'fault_reports' => 0,
                    'performance_metrics' => [],
                ];
                break;
        }
        
        return $data;
    }
}