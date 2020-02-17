<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\View;
use DB;
use Charts;
use Carbon\Carbon;

class ChartController extends Controller
{
    //
    public function chart1()
    {
    	$users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
    				->get();
        $chart = Charts::database($users, 'bar', 'highcharts')
			      ->title("Monthly new Register Users")
			      ->elementLabel("Total Users")
			      ->dimensions(1000, 500)
			      ->responsive(false)
			      ->groupByMonth(date('Y'), true);
        return view('charts.chart1',compact('chart'));
    }
}
