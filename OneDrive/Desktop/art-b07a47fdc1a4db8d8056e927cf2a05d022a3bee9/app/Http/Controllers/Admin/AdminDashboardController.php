<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tableau;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\CustomOrder;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $tableauxCount = Tableau::count();
        $categoriesCount = Category::count();
        $ordersCount = Reservation::count();
        $customOrdersCount = CustomOrder::count();

        $totalCount = $tableauxCount + $categoriesCount + $ordersCount + $customOrdersCount;

        $tableauxPercentage = $totalCount > 0 ? ($tableauxCount / $totalCount) * 100 : 0;
        $categoriesPercentage = $totalCount > 0 ? ($categoriesCount / $totalCount) * 100 : 0;
        $ordersPercentage = $totalCount > 0 ? ($ordersCount / $totalCount) * 100 : 0;
        $customOrdersPercentage = $totalCount > 0 ? ($customOrdersCount / $totalCount) * 100 : 0;


        return view('admin.dashboard', compact(
            'tableauxCount',
            'categoriesCount',
            'ordersCount',
            'customOrdersCount',
            'tableauxPercentage',
            'categoriesPercentage',
            'ordersPercentage',
            'customOrdersPercentage'
        ));
    }
}
