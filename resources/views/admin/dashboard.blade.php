@extends('layouts.app')

@section('title', 'AngkorTech Computer | Dashboard')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="container-fluid mt-3" data-aos="fade-down" data-aos-duration="1000">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-0 mt-0">Dashboard</h3>
                @php
                    $user = null;
                    foreach (['admin', 'manager', 'cashier', 'customer', 'web'] as $guard) {
                        if (Auth::guard($guard)->check()) {
                            $user = Auth::guard($guard)->user();
                            break;
                        }
                    }
                @endphp
                <p class=" mt-0 mb-0">
                    Today is {{ now('Asia/Phnom_Penh')->format('l, F j, Y') }} -
                    {{ now('Asia/Phnom_Penh')->format('h:i A') }}
                </p>
                <h6 class="mt-0">
                    {{ $greeting }}, {{ $user?->name ?? 'Guest' }}!

                </h6>

            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2 ">Manage</a>
                <a href="{{ route('users.index') }}" class="btn btn-primary btn-round">Add User</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">User</p>
                                    <h4 class="card-title">{{ $users->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Customers</p>
                                    <h4 class="card-title">{{ $customers->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Sale Amounts</p>
                                    <h4 class="card-title">${{ number_format($totalSales, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="far fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Sale</p>
                                    <h4 class="card-title">{{ $sales->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Order</p>
                                    <h4 class="card-title">{{ $onlineOrders->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa-solid fa-box-archive"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Categories</p>
                                    <h4 class="card-title">{{ $categories->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Products</p>
                                    <h4 class="card-title">{{ $products->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="bi bi-basket2-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Accessories</p>
                                    <h4 class="card-title">{{ $accessories->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" data-aos="fade-down" data-aos-duration="1100">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Stock Overview</h1>

            <div class="d-none d-sm-inline-block">
                <span class="text-muted">Last updated: {{ now()->format('M j, Y g:i A') }}</span>
            </div>
        </div>
        <!-- Stock Overview Cards -->
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Stock Records</p>
                                    <h4 class="card-title">{{ $stocks->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fa-solid fa-cubes"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Products in Stock</p>
                                    <h4 class="card-title">{{ $products->sum('stock_quantity') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="bi bi-basket2-fill"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Accessories in Stock</p>
                                    <h4 class="card-title">{{ $accessories->sum('stock_quantity') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Stock Value</p>
                                    <h4 class="card-title">${{ number_format($totalStockValue, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Detailed Analysis -->
        <div class="row">
            <!-- Stock Movement Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4 rounded-0">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Stock Movement (Last 30 Days)</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="stockMovementChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Distribution by Type -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4 rounded-0">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Stock Distribution</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="stockDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chart-container {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }

        .chart-loaded {
            opacity: 1;
            transform: translateY(0);
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2) !important;
        }

        /* Loading animation for charts */
        @keyframes chartLoading {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        canvas {
            animation: chartLoading 0.8s ease-out;
        }
    </style>

    <script>
        // Stock Movement Chart with Animation
        const movementCtx = document.getElementById('stockMovementChart').getContext('2d');
        const stockMovementChart = new Chart(movementCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($stockMovementDates) !!},
                datasets: [{
                        label: 'Products Stock',
                        data: {!! json_encode($productStockData) !!},
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        borderWidth: 2,
                        pointBackgroundColor: '#4e73df',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Accessories Stock',
                        data: {!! json_encode($accessoryStockData) !!},
                        borderColor: '#1cc88a',
                        backgroundColor: 'rgba(28, 200, 138, 0.05)',
                        borderWidth: 2,
                        pointBackgroundColor: '#1cc88a',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart',
                    animateScale: true,
                    animateRotate: true
                },
                transitions: {
                    show: {
                        animations: {
                            x: {
                                from: 0
                            },
                            y: {
                                from: 0
                            }
                        }
                    },
                    hide: {
                        animations: {
                            x: {
                                to: 0
                            },
                            y: {
                                to: 0
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: false,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#2D3748',
                        bodyColor: '#4A5568',
                        borderColor: '#E2E8F0',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y.toLocaleString() + ' units';
                                return label;
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                elements: {
                    line: {
                        tension: 0.4
                    }
                }
            }
        });

        // Stock Distribution Chart with Animation
        const distributionCtx = document.getElementById('stockDistributionChart').getContext('2d');
        const stockDistributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Products', 'Accessories'],
                datasets: [{
                    data: [
                        {{ $products->sum('stock_quantity') }},
                        {{ $accessories->sum('stock_quantity') }}
                    ],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                    borderWidth: 2,
                    hoverBorderWidth: 3,
                    hoverOffset: 8
                }],
            },
            options: {
                maintainAspectRatio: false,
                cutout: '60%',
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart',
                    animateScale: true,
                    animateRotate: true
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        const meta = chart.getDatasetMeta(0);
                                        const style = meta.controller.getStyle(i);

                                        return {
                                            text: label + ': ' + data.datasets[0].data[i]
                                                .toLocaleString() + ' units',
                                            fillStyle: style.backgroundColor,
                                            strokeStyle: style.borderColor,
                                            lineWidth: style.borderWidth,
                                            pointStyle: style.pointStyle,
                                            hidden: isNaN(data.datasets[0].data[i]) || meta.data[i]
                                                .hidden,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#2D3748',
                        bodyColor: '#4A5568',
                        borderColor: '#E2E8F0',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value.toLocaleString()} units (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Add refresh animation function
        function refreshCharts() {
            // Fade out animation
            document.querySelectorAll('.chart-container canvas').forEach(canvas => {
                canvas.style.transition = 'opacity 0.3s ease';
                canvas.style.opacity = '0.3';
            });

            // Simulate data refresh (in real scenario, you'd fetch new data here)
            setTimeout(() => {
                // Fade in animation
                document.querySelectorAll('.chart-container canvas').forEach(canvas => {
                    canvas.style.transition = 'opacity 0.5s ease';
                    canvas.style.opacity = '1';
                });

                // Re-initialize charts with new data (optional)
                // stockMovementChart.update();
                // stockDistributionChart.update();
            }, 300);
        }

        // Optional: Add click handler to refresh button if you have one
        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.getElementById('refreshCharts');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', refreshCharts);
            }

            // Add initial loading animation
            setTimeout(() => {
                document.querySelectorAll('.chart-container').forEach(container => {
                    container.style.opacity = '1';
                    container.style.transition = 'opacity 0.8s ease';
                });
            }, 100);
        });

        // Handle page visibility changes for smooth animations
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                // Page became visible again, refresh charts
                setTimeout(() => {
                    stockMovementChart.update('active');
                    stockDistributionChart.update('active');
                }, 500);
            }
        });
    </script>
@endsection
