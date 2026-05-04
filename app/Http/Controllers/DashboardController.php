<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // --- ADMIN LOGIC ---
        if ($user->isAdmin()) {
            $days = $request->query('days', 7); // Handle Admin filter

            $adminChartData = Transaction::selectRaw('DATE(created_at) as date, count(*) as count')
                ->where('created_at', '>=', now()->subDays($days))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();

            // Calculate Growth %
            $currentCount = Transaction::where('created_at', '>=', now()->subDays($days))->count();
            $previousCount = Transaction::whereBetween('created_at', [now()->subDays($days * 2), now()->subDays($days)])->count();
            $growth = ($previousCount > 0) ? (($currentCount - $previousCount) / $previousCount) * 100 : 100;

            return view('dashboard', [
                'totalUsers' => User::where('role', 'user')->count(),
                'totalTransactions' => Transaction::count(),
                'totalSystemWallets' => Wallet::count(),
                'chartLabels' => $adminChartData->pluck('date'),
                'chartData' => $adminChartData->pluck('count'),
                'growth' => round($growth, 1),
                'filterDays' => $days
            ]);
        }

        // --- USER DATA WITH FILTERS ---
        $wallets = $user->wallets;
        $selectedWallet = $request->query('wallet_id');
        $period = $request->query('period', 'this_month');

        // Determine Date Range
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($period === 'last_30') {
            $startDate = Carbon::now()->subDays(30);
            $endDate = Carbon::now();
        } elseif ($period === 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }

        // Base Query for Transactions
        $query = Transaction::where('user_id', $user->id)
            ->whereBetween('transaction_date', [$startDate, $endDate]);

        if ($selectedWallet) {
            $query->where('wallet_id', $selectedWallet);
        }

        // 1. Stats Cards
        $totalBalance = $user->wallets()->sum('current_balance');
        $monthlyIncome = (clone $query)->whereHas('category', fn($q) => $q->where('type', 'Income'))->sum('amount');
        $monthlyExpense = (clone $query)->whereHas('category', fn($q) => $q->where('type', 'Expense'))->sum('amount');

        // 2. Spending by Category (Pie Chart)
        $categoryData = (clone $query)->whereHas('category', fn($q) => $q->where('type', 'Expense'))
            ->with('category')
            ->get()
            ->groupBy('category.category_name')
            ->map(fn($group) => $group->sum('amount'));

        // --- Dynamic Trend Data ---
        $trendLabels = [];
        $incomeTrend = [];
        $expenseTrend = [];

        $monthsToDisplay = ($period === 'this_year') ? 11 : 5; 
        $startingPoint = ($period === 'this_year') 
            ? Carbon::now()->startOfYear() 
            : Carbon::now()->subMonths($monthsToDisplay);

        for ($i = 0; $i <= $monthsToDisplay; $i++) {
            $month = $startingPoint->copy()->addMonths($i);
            $trendLabels[] = $month->format('M Y');

            $incomeTrend[] = Transaction::where('user_id', $user->id)
                ->when($selectedWallet, fn($q) => $q->where('wallet_id', $selectedWallet))
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->whereHas('category', fn($q) => $q->where('type', 'Income'))
                ->sum('amount');

            $expenseTrend[] = Transaction::where('user_id', $user->id)
                ->when($selectedWallet, fn($q) => $q->where('wallet_id', $selectedWallet))
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->whereHas('category', fn($q) => $q->where('type', 'Expense'))
                ->sum('amount');
        }

        $recentTransactions = (clone $query)->with(['wallet', 'category'])->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalBalance', 'monthlyIncome', 'monthlyExpense', 'recentTransactions',
            'categoryData', 'trendLabels', 'incomeTrend', 'expenseTrend', 'wallets'
        ));
    }
}