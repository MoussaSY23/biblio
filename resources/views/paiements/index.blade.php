@extends('layouts.app')

@section('content')
    <div class="content-wrapper p-4">
        <section class="content-header mb-4">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark font-weight-bold">💸 Liste des Paiements</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm rounded">
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Commande #</th>
                                            <th>Montant (€)</th>
                                            <th>Méthode de Paiement</th>
                                            <th>Date de Paiement</th>
                                            <th class="text-right">Détails</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($paiements as $paiement)
                                            <tr>
                                                <td>{{ $paiement->id }}</td>
                                                <td>
                                                    <a href="{{ route('commandes.show', $paiement->commande->id) }}" title="Voir la commande #{{ $paiement->commande->id }}">
                                                        {{ $paiement->commande->id }}
                                                    </a>
                                                </td>
                                                <td>{{ number_format($paiement->montant, 2) }}</td>
                                                <td>{{ ucfirst($paiement->methode_paiement) }}</td>
                                                <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-info btn-sm rounded-pill" title="Voir les détails du paiement">
                                                        <i class="fas fa-eye"></i> Voir
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Aucun paiement trouvé.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection
