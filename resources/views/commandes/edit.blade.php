@extends('layouts.app')

@section('content')
    @php use Illuminate\Support\Str; @endphp
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary"><i class="fas fa-edit me-2"></i>Modifier la Commande #{{ $commande->id }}</h1>
            <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-left me-2"></i> Retour à la Commande
            </a>
        </div>

        <div class="mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-secondary mb-3"><i class="fas fa-user me-2"></i>Informations Client</h5>
                    <div class="mb-3">
                        <label for="utilisateur_id" class="form-label fw-bold">Client :</label>
                        <span class="form-control-plaintext">{{ $commande->client->prenom }} {{ $commande->client->nom }}</span>
                        <input type="hidden" name="utilisateur_id" value="{{ $commande->utilisateur_id }}">
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-secondary mb-3"><i class="fas fa-book me-2"></i>Livres Actuellement dans la Commande</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">Image</th>
                                    <th>Titre</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($commande->elements as $element)
                                    <tr data-livre-id="{{ $element->livre_id }}">
                                        <td class="text-center">
                                            @if($element->livre->image)
                                                <img src="{{ asset('storage/' . $element->livre->image) }}" alt="{{ $element->livre->titre }}" style="max-width: 40px; height: auto;">
                                            @else
                                                <span class="text-muted">Pas d'image</span>
                                            @endif
                                        </td>
                                        <td>{{ $element->livre->titre }}</td>
                                        <td class="text-center">
                                            <input type="number" name="quantites[{{ $element->livre_id }}]" class="form-control form-control-sm w-auto mx-auto" value="{{ $element->quantite }}" min="1">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="supprimerLivre({{ $commande->id }}, {{ $element->livre_id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-secondary mb-3"><i class="fas fa-plus me-2"></i>Ajouter de Nouveaux Livres</h5>
                        <div class="mb-3">
                            <input type="text" id="searchInput" class="form-control border rounded-pill shadow-sm"
                                   placeholder="🔍 Rechercher par titre ou auteur...">
                        </div>
                        <div class="row">
                            @foreach($livres as $livre)
                                <div class="col-md-4 col-lg-3 mb-4 livre-card"
                                     data-titre="{{ $livre->titre }}"
                                     data-auteur="{{ $livre->auteur }}">
                                    <div class="card h-100 border-0 shadow rounded-3">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('storage/' . $livre->image) }}"
                                                 class="img-fluid rounded-3 mb-2"
                                                 alt="{{ $livre->titre }}"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            <h6 class="card-title fw-semibold text-dark small">{{ Str::limit($livre->titre, 30) }}</h6>
                                            <p class="text-muted mb-0 small">{{ Str::limit($livre->auteur, 20) }}</p>
                                            <p class="text-success fw-bold mb-2 small">{{ number_format($livre->prix, 2, ',', ' ') }} €</p>
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="nouveaux_produits[]" value="{{ $livre->id }}"
                                                       class="form-check-input" id="nouveau_produit_{{ $livre->id }}">
                                                <label class="form-check-label small" for="nouveau_produit_{{ $livre->id }}">Ajouter</label>
                                            </div>
                                            <div>
                                                <label for="nouvelle_quantite_{{ $livre->id }}" class="form-label small">Qté</label>
                                                <input type="number" name="nouvelles_quantites[{{ $livre->id }}]"
                                                       id="nouvelle_quantite_{{ $livre->id }}"
                                                       class="form-control form-control-sm rounded-pill w-auto mx-auto" min="1" value="1" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i>Mettre à jour la Commande
                        </button>
                        <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-secondary btn-lg px-4 rounded-pill shadow-sm ms-2">
                            <i class="fas fa-ban me-2"></i>Annuler
                        </a>
                    </div>
        </form>
    </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Activation/désactivation du champ quantité pour les nouveaux produits
            document.querySelectorAll('input[name="nouveaux_produits[]"]').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    let quantiteInput = document.getElementById('nouvelle_quantite_' + this.value);
                    quantiteInput.disabled = !this.checked;
                    if (!this.checked) quantiteInput.value = 1;
                });
            });

            // Filtrage des livres pour l'ajout
            document.getElementById('searchInput').addEventListener('input', function () {
                let query = this.value.toLowerCase();
                document.querySelectorAll('.livre-card').forEach(function (card) {
                    let titre = card.getAttribute('data-titre').toLowerCase();
                    let auteur = card.getAttribute('data-auteur').toLowerCase();
                    card.style.display = (titre.includes(query) || auteur.includes(query)) ? 'block' : 'none';
                });
            });

            // Afficher tous les livres au chargement initial
            document.querySelectorAll('.livre-card').forEach(function (card) {
                card.style.display = 'block';
            });
        });

        function supprimerLivre(commandeId, livreId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce livre de la commande ?')) {
                fetch(`/commandes/${commandeId}/livres/${livreId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            // Supprimer la ligne du tableau en JavaScript
                            const rowToRemove = document.querySelector(`[data-livre-id="${livreId}"]`);
                            if (rowToRemove) {
                                rowToRemove.remove();
                            }
                            // Vous pouvez également afficher un message de succès ici si vous le souhaitez
                        } else {
                            console.error('Erreur lors de la suppression du livre:', response.status);
                            alert('Erreur lors de la suppression du livre.');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur réseau:', error);
                        alert('Erreur réseau lors de la suppression du livre.');
                    });
            }
        }
    </script>

    {{-- SweetAlert2 pour afficher les messages flash --}}
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

    {{-- SweetAlert2 pour les erreurs de validation --}}
    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur de saisie',
                text: "{{ $errors->first() }}",
                confirmButtonColor: '#d33',
            });
        </script>
    @endif
@endsection
