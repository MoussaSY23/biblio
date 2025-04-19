@extends('layouts.app')

@section('content')
    <div class="container py-6">
        <h1 class="mb-6 text-center text-3xl font-semibold text-gray-900 dark:text-gray-100">
            <i class="bi bi-bar-chart-line-fill text-indigo-500 me-2"></i> Tableau de Bord - Statistiques du Jour
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-green-400 to-green-600 shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-white font-semibold">
                            <i class="bi bi-cash-coin text-xl me-2"></i> Recettes du jour
                        </div>
                        <span class="inline-flex items-center justify-center p-2 rounded-full bg-green-700 bg-opacity-50">
                            <i class="bi bi-arrow-up-short text-white text-lg"></i>
                        </span>
                    </div>
                    <p class="text-white text-3xl font-bold">{{ number_format($recettes, 2, ',', ' ') }} €</p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-white font-semibold">
                            <i class="bi bi-hourglass-split text-xl me-2"></i> Commandes en cours
                        </div>
                        <span class="inline-flex items-center justify-center p-2 rounded-full bg-yellow-700 bg-opacity-50">
                            <i class="bi bi-clock-fill text-white text-lg"></i>
                        </span>
                    </div>
                    <p class="text-white text-3xl font-bold">{{ count($commandesEnCours) }}</p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-white font-semibold">
                            <i class="bi bi-check-circle-fill text-xl me-2"></i> Commandes payées
                        </div>
                        <span class="inline-flex items-center justify-center p-2 rounded-full bg-indigo-700 bg-opacity-50">
                            <i class="bi bi-check-all text-white text-lg"></i>
                        </span>
                    </div>
                    <p class="text-white text-3xl font-bold">{{ count($commandesPayees) }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h4 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">
                        <i class="bi bi-check-double text-green-500 me-2"></i> Détail des Commandes Payées
                    </h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Heure</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Montant (€)</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($commandesPayees as $commande)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">#{{ $commande->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $commande->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ number_format($commande->montant_total, 2, ',', ' ') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Aucune commande payée.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h4 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">
                        <i class="bi bi-hourglass-split text-yellow-500 me-2"></i> Détail des Commandes en Cours
                    </h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Heure</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($commandesEnCours as $commande)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">#{{ $commande->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ ucfirst($commande->statut) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $commande->created_at->format('H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Aucune commande en cours.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h4 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">
                        <i class="bi bi-graph-up text-blue-500 me-2"></i> Commandes par Mois
                    </h4>
                    <canvas id="chartCommandes" height="200"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h4 class="mb-4 font-semibold text-gray-900 dark:text-gray-100">
                        <i class="bi bi-book-half text-purple-500 me-2"></i> Top 5 Livres Vendus ce Mois
                    </h4>
                    <canvas id="chartLivres" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const commandesCtx = document.getElementById('chartCommandes').getContext('2d');
        new Chart(commandesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($moisLabels) !!},
                datasets: [{
                    label: 'Commandes',
                    data: {!! json_encode($commandesParMois) !!},
                    backgroundColor: '#6366f1', // Indigo 500
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        const livresCtx = document.getElementById('chartLivres').getContext('2d');
        new Chart(livresCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($titres) !!},
                datasets: [{
                    data: {!! json_encode($quantites) !!},
                    backgroundColor: ['#22c55e', '#3b82f6', '#facc15', '#ef4444', '#8b5cf6'], // Tailwind colors
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'rgb(75, 85, 99)' // Text color
                        }
                    }
                }
            }
        });
    </script>
@endsection
