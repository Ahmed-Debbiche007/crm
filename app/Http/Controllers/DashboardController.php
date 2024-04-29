<?php

namespace App\Http\Controllers;

use App\Models\Abonnements;
use App\Models\Depenses;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class DashboardController extends Controller
{
    public function index()
    {
        $abonements = Abonnements::all();
        $depenses = Depenses::all();
        // make a new array where the key is the year, the object has 4 keys: total abnnements, total_paid abnnements, total_unpaid abnnements, total depenses
        $data = [];
        foreach ($abonements as $abonement) {
            $year = $abonement->annee;
            if (!isset($data[$year])) {
                $data[$year] = [
                    'total_abonnements' => 0,
                    'total_paid' => 0,
                    'total_unpaid' => 0,
                    'total_depenses' => 0
                ];
            }
            $data[$year]['total_abonnements'] += $abonement->amount;
            $data[$year]['total_paid'] += $abonement->reglements->sum('amount');
            $data[$year]['total_unpaid'] += $abonement->amount - $abonement->reglements->sum('amount');
        }

        foreach ($depenses as $depense) {
            $date = new DateTime($depense->date . '-01');
            $year = $date->format('Y');
            if (!isset($data[$year])) {
                $data[$year] = [
                    'total_abonnements' => 0,
                    'total_paid' => 0,
                    'total_unpaid' => 0,
                    'total_depenses' => 0
                ];
            }
            $data[$year]['total_depenses'] += $depense->amount;
        }
        
        ksort($data);       
        $prev = 0;
        foreach ($data as $year => $value) {
            $data[$year]['reste'] = $prev;
            $prev = $data[$year]['total_paid'] - $data[$year]['total_depenses'];
        }
        return view('pages.dashboard.index', [
            'data' => $data
        ]);
    }
}
