@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>

    <div class="container mt-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold text-primary mb-0">Commande #{{ $commande->id }}</h1>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('commandes.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-2"></i> Retour aux commandes
                </a>
            </div>
        </div>

        <div class="row">
            @if(Auth::user()->role === 'gestionnaire')
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-info mb-3"><i class="bi bi-gear-fill me-2"></i> Gestion de la Commande</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Statut actuel : <span class="badge bg-info">{{ ucfirst($commande->statut) }}</span></label>
                                <form action="{{ route('commandes.updateStatut', $commande->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <select name="statut" id="statut" class="form-control rounded-start">
                                            <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En Attente</option>
                                            <option value="en_preparation" {{ $commande->statut == 'en_preparation' ? 'selected' : '' }}>En Préparation</option>
                                            <option value="expediee" {{ $commande->statut == 'expediee' ? 'selected' : '' }}>Expédiée</option>
                                            <option value="payee" {{ $commande->statut == 'payee' ? 'selected' : '' }}>Payée</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-primary rounded-end"><i class="bi bi-check-circle-fill me-2"></i> Mettre à jour</button>
                                    </div>
                                </form>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-bold">Paiement :</h6>
                                @if($commande->statut != 'payee')
                                    <form action="{{ route('paiements.store', $commande->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{$commande->id}}" name="commande_id">
                                        <div class="mb-2">
                                            <label for="methode_paiement" class="form-label fw-bold">Méthode</label>
                                            <input type="text" name="methode_paiement" class="form-control rounded" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="montant" class="form-label fw-bold">Montant (€)</label>
                                            <input type="number" name="montant" class="form-control rounded" step="0.01" required>
                                        </div>
                                        <button type="submit" class="btn btn-success rounded-pill"><i class="bi bi-cash-coin me-2"></i> Enregistrer le Paiement</button>
                                    </form>
                                @else
                                    <p class="text-success"><i class="bi bi-check-circle-fill me-2"></i> Commande payée</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="{{ Auth::user()->role === 'gestionnaire' ? 'col-md-6' : 'col-md-12' }} mb-4">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-secondary mb-3"><i class="bi bi-info-circle-fill me-2"></i> Détails de la Commande</h5>
                        <p class="mb-2">
                            <strong class="text-muted">Client:</strong>
                            <span class="fw-semibold">{{ App\Models\User::find($commande->utilisateur_id)->prenom }} {{ App\Models\User::find($commande->utilisateur_id)->nom }}</span>
                        </p>
                        <p class="mb-2">
                            <strong class="text-muted">Date de création:</strong>
                            <span>{{ $commande->created_at->format('d M Y, H:i') }}</span>
                        </p>
                        <p class="mb-0">
                            <strong class="text-muted">Montant total:</strong>
                            <span class="h5 text-success fw-bold">{{ number_format($montantTotalCommande, 2, ',', ' ') }}€</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="fw-bold text-primary mb-3"><i class="bi bi-book-fill me-2"></i> Livres Commandés</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($commande->elements as $element)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-4">
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/' . $element->livre->image) }}" class="img-fluid rounded-3 mb-3" alt="{{ $element->livre->titre }}" style="max-width: 120px; height: 180px; object-fit: cover;">
                                <h6 class="card-title fw-bold">{{ $element->livre->titre }}</h6>
                                <p class="text-muted small">{{ $element->livre->auteur }}</p>
                                <p class="mb-1"><strong class="text-muted">Quantité:</strong> {{ $element->quantite }}</p>
                                <p class="mb-1"><strong class="text-muted">Prix unitaire:</strong> {{ number_format($element->prix, 2, ',', ' ') }}€</p>
                                <p class="mb-0"><strong class="text-success">Total:</strong> {{ number_format($element->prix * $element->quantite, 2, ',', ' ') }}€</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-5">
            <h3 class="fw-bold text-warning mb-3"><i class="bi bi-exclamation-triangle-fill me-2"></i> Actions</h3>
            <div class="d-flex gap-2">
                @if(Auth::user()->role == 'client')
                    @if($commande->statut == 'en_attente')
                        <a href="{{ route('commandes.edit', $commande->id) }}" class="btn btn-outline-warning rounded-pill">
                            <i class="bi bi-pencil-fill me-2"></i> Modifier la commande
                        </a>
                        <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" id="delete-form-{{ $commande->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button" class="btn btn-outline-danger rounded-pill" onclick="confirmDeletion(event, {{ $commande->id }})">
                            <i class="bi bi-trash-fill me-2"></i> Annuler la commande
                        </button>
                    @endif
                @endif

                @if(Auth::user()->role == 'gestionnaire')
                        @if(Auth::user()->role == 'client')
                    <a href="{{ route('commandes.edit', $commande->id) }}" class="btn btn-outline-warning rounded-pill">
                        <i class="bi bi-pencil-fill me-2"></i> Modifier la commande
                    </a>
                        @endif
                    <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" id="delete-form-{{ $commande->id }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" class="btn btn-outline-danger rounded-pill" onclick="confirmDeletion(event, {{ $commande->id }})">
                        <i class="bi bi-trash-fill me-2"></i> Annuler la commande
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: "{{ session('success') }}",
                confirmButtonColor: '#28a745',
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33',
            });
        </script>
    @endif

    <script>
        function confirmDeletion(event, id) {
            event.preventDefault();

            Swal.fire({
                title: "Êtes-vous sûr de vouloir supprimer cette commande ?",
                text: "Cette action est irréversible !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Oui, supprimer",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
