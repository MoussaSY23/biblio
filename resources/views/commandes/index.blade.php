@extends('layouts.app')

@section('content')
    <div class="content-wrapper p-4">
        <section class="content-header mb-4">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark font-weight-bold">📦 Liste des Commandes</h1>
                    </div>
                    <div class="col-sm-6 text-sm-right mt-2 mt-sm-0">
                        @auth
                            @if(Auth::user()->role == 'client')
                                <a href="{{ route('commandes.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                                    <i class="fas fa-plus mr-2"></i> Nouvelle Commande
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @auth
                    <div class="row">
                        @forelse($commandes->groupBy('utilisateur_id') as $utilisateurId => $userCommandes)
                            @php
                                $client = $userCommandes->first()->client;
                            @endphp

                            @if(Auth::user()->role == 'gestionnaire' || Auth::user()->id == $client->id)
                                <div class="col-md-12 mb-4">
                                    <div class="card shadow-sm rounded border" style="border-left: 5px solid #f0f0f0;">
                                        <div class="card-header bg-light py-3">
                                            <h5 class="m-0 font-weight-bold text-info">
                                                <i class="fas fa-user mr-2"></i> Commandes de {{ $client->prenom }} {{ $client->nom }}
                                            </h5>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead class="bg-secondary text-white">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date de Commande</th>
                                                        <th>Statut</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($userCommandes as $commande)
                                                        @php
                                                            $borderColor = '';
                                                            switch ($commande->statut) {
                                                                case 'en_preparation':
                                                                    $borderColor = 'border-warning';
                                                                    break;
                                                                case 'en_attente':
                                                                    $borderColor = 'border-info';
                                                                    break;
                                                                case 'expedie':
                                                                    $borderColor = 'border-primary';
                                                                    break;
                                                                case 'payee':
                                                                    $borderColor = 'border-success';
                                                                    break;
                                                                case 'Livrée':
                                                                    $borderColor = 'border-success';
                                                                    break;
                                                                case 'Annulée':
                                                                    $borderColor = 'border-danger';
                                                                    break;
                                                                case 'En cours':
                                                                    $borderColor = 'border-warning';
                                                                    break;
                                                                default:
                                                                    $borderColor = 'border-secondary';
                                                                    break;
                                                            }
                                                        @endphp
                                                        <tr class="{{ $borderColor }}">
                                                            <td>{{ $commande->id }}</td>
                                                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                                            <td>
                                                                    <span class="badge rounded-pill
                                                                        @if($commande->statut == 'en_preparation') bg-warning text-dark
                                                                        @elseif($commande->statut == 'en_attente') bg-info
                                                                        @elseif($commande->statut == 'expedie') bg-primary
                                                                        @elseif($commande->statut == 'payee') bg-success
                                                                        @elseif($commande->statut == 'Livrée') bg-success
                                                                        @elseif($commande->statut == 'Annulée') bg-danger
                                                                        @elseif($commande->statut == 'En cours') bg-warning text-dark
                                                                        @else bg-secondary
                                                                        @endif">
                                                                        {{ str_replace('_', ' ', $commande->statut) }}
                                                                    </span>
                                                            </td>
                                                            <td class="text-right">
                                                                <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-info btn-sm rounded-pill" title="Voir les détails">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                @if(Auth::user()->role == 'gestionnaire' && !in_array($commande->statut, ['Livrée', 'Annulée', 'payee']))
                                                                    <button type="button" class="btn btn-warning btn-sm rounded-pill ml-1" data-toggle="modal" data-target="#editStatusModal{{ $commande->id }}" title="Modifier le statut">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>

                                                                    <div class="modal fade" id="editStatusModal{{ $commande->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel{{ $commande->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="editStatusModalLabel{{ $commande->id }}">Modifier le statut de la commande #{{ $commande->id }}</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group">
                                                                                            <label for="statut">Nouveau statut</label>
                                                                                            <select class="form-control" id="statut" name="statut">
                                                                                                <option value="en_preparation" {{ $commande->statut == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                                                                                                <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                                                                <option value="expedie" {{ $commande->statut == 'expedie' ? 'selected' : '' }}>Expédiée</option>
                                                                                                <option value="payee" {{ $commande->statut == 'payee' ? 'selected' : '' }}>Payée</option>
                                                                                                <option value="Livrée" {{ $commande->statut == 'Livrée' ? 'selected' : '' }}>Livrée</option>
                                                                                                <option value="Annulée" {{ $commande->statut == 'Annulée' ? 'selected' : '' }}>Annulée</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Annuler</button>
                                                                                        <button type="submit" class="btn btn-primary rounded-pill">Enregistrer</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center rounded">
                                    <i class="fas fa-info-circle mr-2"></i> Aucune commande trouvée.
                                </div>
                            </div>
                        @endforelse
                    </div>
                @else
                    <div class="alert alert-warning text-center rounded">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Veuillez vous connecter pour consulter vos commandes.
                    </div>
                @endauth
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection
