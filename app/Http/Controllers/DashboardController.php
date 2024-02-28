<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'title' => 'UIGM',
            'data' => Dashboard::paginate(7)
        ]);
    }

    public function fetchDataForDashboard()
    {
        $distinctYears = Dashboard::distinct()->pluck('Tahun')->toArray();
        $distinctFaculties = Dashboard::distinct()->pluck('Fakultas')->toArray();

        // Fetch data for each year
        $dataByYear = [];
        foreach ($distinctYears as $year) {
            $dataByYear[$year] = Dashboard::select(
                'Tahun',
                DB::raw('COUNT(DISTINCT NPM) AS JmlAll'),
                DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="Ekonomi" THEN NPM END) AS FE'),
                DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="Teknik" THEN NPM END) AS FT'),
                DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="FKIP" THEN NPM END) AS FKIP'),
                DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="FIPB" THEN NPM END) AS FIPB'),
                DB::raw('COUNT(DISTINCT CASE WHEN Fakultas="FASILKOM SAINS" THEN NPM END) AS FIlkom')
            )
                ->where('Tahun', $year)
                ->groupBy('Tahun')
                ->get()
                ->toArray();
        }

        $dataForFacultiesAndYears = Dashboard::selectRaw('LEFT(NPM, 4) AS TahunGanjil,
            COUNT(DISTINCT CASE WHEN Fakultas = "Ekonomi" THEN NPM END) AS FE,
            COUNT(DISTINCT CASE WHEN Fakultas = "FASILKOM SAINS" THEN NPM END) AS FIlkom,
            COUNT(DISTINCT CASE WHEN Fakultas = "Teknik" THEN NPM END) AS FT,
            COUNT(DISTINCT CASE WHEN Fakultas = "FIPB" THEN NPM END) AS FIPB,
            COUNT(DISTINCT CASE WHEN Fakultas = "FKIP" THEN NPM END) AS FKIP')
            ->whereBetween(DB::raw('LEFT(NPM, 4)'), ['2019', '2023'])
            ->whereIn('Tahun', ['20191', '20231'])
            ->whereIn('Fakultas', ['Ekonomi', 'FASILKOM SAINS', 'Teknik', 'FIPB', 'FKIP'])
            ->groupBy('TahunGanjil')
            ->get()
            ->toArray();

        return view('dashboard', [
            'title' => 'UIGM',
            'distinctYears' => $distinctYears,
            'distinctFaculties' => $distinctFaculties,
            'dataByYear' => $dataByYear,
            'dataForFacultiesAndYears' => $dataForFacultiesAndYears,
        ]);
    }
}
