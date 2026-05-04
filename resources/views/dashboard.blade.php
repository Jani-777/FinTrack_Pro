<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ auth()->user()->isAdmin() ? 'Admin Control Center' : 'Financial Overview' }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
        @if(auth()->user()->isAdmin())
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 mb-8 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Platform Analytics</h3>
                    <p class="text-xs text-slate-400 uppercase font-semibold tracking-wider">System-wide monitoring</p>
                </div>
                <form action="{{ route('dashboard') }}" method="GET">
                    <select name="days" onchange="this.form.submit()" class="border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 font-semibold">
                        <option value="7" {{ request('days') == 7 ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="30" {{ request('days') == 30 ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90" {{ request('days') == 90 ? 'selected' : '' }}>Last 90 Days</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <h4 class="text-indigo-900/50 text-xs font-bold uppercase tracking-widest">Total Users</h4>
                            <p class="text-4xl font-black text-indigo-600 mt-2 tracking-tighter">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-2xl text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-6 rounded-3xl shadow-xl text-white relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 text-slate-800 opacity-20 transform group-hover:scale-110 transition-transform">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    </div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <h4 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Global Transactions</h4>
                            <div class="flex items-baseline gap-2 mt-2">
                                <p class="text-4xl font-black tracking-tighter">{{ $totalTransactions }}</p>
                                <span class="px-2 py-1 rounded-lg text-xs font-bold {{ $growth >= 0 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                                    {{ $growth >= 0 ? '↑' : '↓' }} {{ abs($growth) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-amber-50/50 p-6 rounded-3xl border border-amber-100 group hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-amber-900/50 text-xs font-bold uppercase tracking-widest">System Wallets</h4>
                            <p class="text-4xl font-black text-amber-500 mt-2 tracking-tighter">{{ $totalSystemWallets }}</p>
                        </div>
                        <div class="p-3 bg-amber-100 rounded-2xl text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 mb-8">
                <div class="mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">Transaction Velocity</h3>
                    <p class="text-sm text-slate-400">Activity volume across all users</p>
                </div>
                <div class="h-80">
                    <canvas id="adminChart"></canvas>
                </div>
            </div>

        @else
            <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 mb-8">
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label value="Time Period" class="text-xs font-bold text-slate-500 uppercase mb-1 ml-1" />
                        <select name="period" class="w-full border-slate-200 rounded-xl text-sm focus:ring-indigo-500 bg-slate-50 font-medium">
                            <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="last_30" {{ request('period') == 'last_30' ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <x-input-label value="Source Wallet" class="text-xs font-bold text-slate-500 uppercase mb-1 ml-1" />
                        <select name="wallet_id" class="w-full border-slate-200 rounded-xl text-sm focus:ring-indigo-500 bg-slate-50 font-medium">
                            <option value="">All Wallets</option>
                            @foreach($wallets as $wallet)
                                <option value="{{ $wallet->wallet_id }}" {{ request('wallet_id') == $wallet->wallet_id ? 'selected' : '' }}>
                                    {{ $wallet->wallet_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="h-10 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200">
                            Apply
                        </button>
                        @if(request()->anyFilled(['period', 'wallet_id']))
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl font-bold text-xs text-slate-600 uppercase tracking-widest hover:bg-slate-50 transition-all">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-slate-900 p-8 rounded-3xl shadow-2xl text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <h4 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Net Worth</h4>
                        <p class="text-4xl font-black mt-2 tracking-tighter">@money($totalBalance)</p>
                    </div>
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-center">
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Period Income</h4>
                    <p class="text-3xl font-black text-emerald-600 mt-2 tracking-tighter">+@money($monthlyIncome)</p>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-center">
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Period Spent</h4>
                    <p class="text-3xl font-black text-rose-600 mt-2 tracking-tighter">-@money($monthlyExpense)</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8">
                <div class="mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">Cash Flow Performance</h3>
                    <p class="text-sm text-slate-400">Monthly Income vs Expense Analysis</p>
                </div>
                <div class="h-80">
                    <canvas id="cashFlowChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-indigo-600 rounded-full"></span>
                        Spending by Category
                    </h3>
                    <div class="h-64">
                        <canvas id="userCategoryChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <span class="w-2 h-6 bg-slate-800 rounded-full"></span>
                            Recent Activity
                        </h3>
                        <a href="{{ route('transactions.index') }}" class="text-xs font-bold text-indigo-600 uppercase hover:underline">View History →</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentTransactions as $tx)
                            <div class="flex justify-between items-center p-4 hover:bg-slate-50 rounded-2xl transition border border-transparent hover:border-slate-100">
                                <div class="flex gap-3 items-center">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold uppercase">
                                        {{ substr($tx->category->category_name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-800">{{ $tx->category->category_name }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $tx->wallet->wallet_name }} • {{ \Carbon\Carbon::parse($tx->transaction_date)->format('M d') }}</span>
                                    </div>
                                </div>
                                <span class="text-sm font-black tracking-tighter {{ $tx->category->type == 'Income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $tx->category->type == 'Income' ? '+' : '-' }}@money($tx->amount)
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <p class="text-slate-400 font-medium italic">No activity recorded for this period.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Helper for Gradient Chart Backgrounds
            const createGradient = (ctx, colorStart, colorEnd) => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, colorStart);
                gradient.addColorStop(1, colorEnd);
                return gradient;
            };

            @if(auth()->user()->isAdmin())
                const adminCtx = document.getElementById('adminChart').getContext('2d');
                new Chart(adminCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [{
                            label: 'Transactions',
                            data: {!! json_encode($chartData) !!},
                            borderColor: '#4f46e5',
                            borderWidth: 3,
                            backgroundColor: createGradient(adminCtx, 'rgba(79, 70, 229, 0.2)', 'rgba(79, 70, 229, 0)'),
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#4f46e5'
                        }]
                    },
                    options: { 
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { display: false } },
                            y: { grid: { borderDash: [5, 5] }, beginAtZero: true }
                        }
                    }
                });
            @else
                const userCtx = document.getElementById('userCategoryChart').getContext('2d');
                new Chart(userCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($categoryData->keys()) !!},
                        datasets: [{
                            data: {!! json_encode($categoryData->values()) !!},
                            backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4'],
                            hoverOffset: 20
                        }]
                    },
                    options: { 
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25, font: { weight: 'bold', size: 11 } } } }
                    }
                });

                const flowCtx = document.getElementById('cashFlowChart').getContext('2d');
                new Chart(flowCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($trendLabels) !!},
                        datasets: [
                            {
                                label: 'Income',
                                data: {!! json_encode($incomeTrend) !!},
                                borderColor: '#10b981',
                                borderWidth: 3,
                                backgroundColor: createGradient(flowCtx, 'rgba(16, 185, 129, 0.1)', 'rgba(16, 185, 129, 0)'),
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Expense',
                                data: {!! json_encode($expenseTrend) !!},
                                borderColor: '#ef4444',
                                borderWidth: 3,
                                backgroundColor: createGradient(flowCtx, 'rgba(239, 68, 68, 0.1)', 'rgba(239, 68, 68, 0)'),
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, ticks: { callback: value => '₱' + value.toLocaleString() } }
                        }
                    }
                });
            @endif
        });
    </script>
</x-app-layout>