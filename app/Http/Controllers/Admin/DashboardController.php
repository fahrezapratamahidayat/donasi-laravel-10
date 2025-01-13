<?php

namespace App\Http\Controllers;
use App\Models\Donasi;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalCompaign = Donasi::count();
        $activeCampaign = Donasi::where("status", "active")->count();
        $pendingCampaign = Donasi::where("status", "pending")->count();
        $totalDonations = Donasi::where("status_pembayaran", "settlement")->sum("jumlah_donasi");
        $recentCampaigns = Donasi::with("user")->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCampaigns',
            'activeCampaigns',
            'pendingCampaigns',
            'totalDonations',
            'recentCampaigns'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
