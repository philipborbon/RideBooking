<?php

namespace RideBooking\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function passengerDailyPayment(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, DATE_FORMAT(t.created_at, '%M %d, %Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    WHERE t.type = 'payment'
			    GROUP BY u.id, u.firstname, u.lastname, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Passenger's Daily Payment";

		return view('report.passenger', compact('reports', 'title'));
	}

	public function passengerMonthlyPayment(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, DATE_FORMAT(t.created_at, '%M %Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    WHERE t.type = 'payment'
			    GROUP BY u.id, u.firstname, u.lastname, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Passenger's Montly Payment";

		return view('report.passenger', compact('reports', 'title'));
	}

	public function passengerYearlyPayment(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, DATE_FORMAT(t.created_at, '%Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    WHERE t.type = 'payment'
			    GROUP BY u.id, u.firstname, u.lastname, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Passenger's Yearly Payment";

		return view('report.passenger', compact('reports', 'title'));
	}

	public function driverDailyCollection(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, v.description AS vehicle, v.cabnumber, DATE_FORMAT(t.created_at, '%M %d, %Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    INNER JOIN vehicles v ON v.driverid = u.id
			    WHERE t.type = 'collection'
			    GROUP BY u.id, u.firstname, u.lastname, v.description, v.cabnumber, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Driver's Daily Collection";

		return view('report.driver', compact('reports', 'title'));
	}

	public function driverMonthlyCollection(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, v.description AS vehicle, v.cabnumber, DATE_FORMAT(t.created_at, '%M, %Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    INNER JOIN vehicles v ON v.driverid = u.id
			    WHERE t.type = 'collection'
			    GROUP BY u.id, u.firstname, u.lastname, v.description, v.cabnumber, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Driver's Montly Collection";

		return view('report.driver', compact('reports', 'title'));
	}

	public function driverYearlyCollection(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, v.description AS vehicle, v.cabnumber, DATE_FORMAT(t.created_at, '%Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    INNER JOIN vehicles v ON v.driverid = u.id
			    WHERE t.type = 'collection'
			    GROUP BY u.id, u.firstname, u.lastname, v.description, v.cabnumber, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Driver's Yearly Collection";

		return view('report.driver', compact('reports', 'title'));
	}

	public function operatorDailyBoundary(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, DATE_FORMAT(t.created_at, '%M %d, %Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    INNER JOIN vehicles v ON v.operatorid = u.id
			    WHERE t.type = 'boundary'
			    GROUP BY u.id, u.firstname, u.lastname, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Operator's Daily Boundary";

		return view('report.operator', compact('reports', 'title'));
	}

	public function operatorMonthlyBoundary(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, DATE_FORMAT(t.created_at, '%M %Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    INNER JOIN vehicles v ON v.operatorid = u.id
			    WHERE t.type = 'boundary'
			    GROUP BY u.id, u.firstname, u.lastname, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Operator's Montly Boundary";

		return view('report.operator', compact('reports', 'title'));
	}

	public function operatorYearlyBoundary(){
		$query = "
			SELECT u.id, u.firstname, u.lastname, DATE_FORMAT(t.created_at, '%Y') AS date, SUM(t.amount) AS amount
				FROM wallet_transactions t
			    INNER JOIN wallets w ON t.fromwalletid = w.id
			    INNER JOIN users u ON w.userid = u.id
			    INNER JOIN vehicles v ON v.operatorid = u.id
			    WHERE t.type = 'boundary'
			    GROUP BY u.id, u.firstname, u.lastname, date
			    ORDER BY date, u.firstname
		";


		$reports = DB::select($query);
		$title = "Operator's Yearly Boundary";

		return view('report.operator', compact('reports', 'title'));
	}

	public function vehicleDailyIncome(){
		$query = "
			SELECT v.id, v.description, v.cabnumber, DATE_FORMAT(c.fordate, '%M %d, %Y') AS date, SUM(c.amount) AS amount
					FROM vehicle_collections c
			        INNER JOIN vehicles v ON c.vehicleid = v.id
			        GROUP BY v.id, v.description, v.cabnumber, date
			        ORDER BY date, v.description
		";

		$reports = DB::select($query);
		$title = "Vehicle's Yearly Income";

		return view('report.vehicle', compact('reports', 'title'));
	}

	public function vehicleMonthlyIncome(){
		$query = "
			SELECT v.id, v.description, v.cabnumber, DATE_FORMAT(c.fordate, '%M %Y') AS date, SUM(c.amount) AS amount
					FROM vehicle_collections c
			        INNER JOIN vehicles v ON c.vehicleid = v.id
			        GROUP BY v.id, v.description, v.cabnumber, date
			        ORDER BY date, v.description
		";

		$reports = DB::select($query);
		$title = "Vehicle's Montly Income";

		return view('report.vehicle', compact('reports', 'title'));
	}

	public function vehicleYearlyIncome() {
		$query = "
			SELECT v.id, v.description, v.cabnumber, DATE_FORMAT(c.fordate, '%Y') AS date, SUM(c.amount) AS amount
					FROM vehicle_collections c
			        INNER JOIN vehicles v ON c.vehicleid = v.id
			        GROUP BY v.id, v.description, v.cabnumber, date
			        ORDER BY date, v.description
		";

		$reports = DB::select($query);
		$title = "Vehicle's Yearly Income";

		return view('report.vehicle', compact('reports', 'title'));
	}

	public function index(){
		return view('report.index');
	}
}
