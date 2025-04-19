@extends('layouts.app')

@section('content')
    <style>
        /* ... Vos styles SweetAlert2 ... */
        .search-container {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .search-input-group {
            display: flex;
            align-items: center;
        }

        .search-input {
            border: 1px solid #ced4da;
            border-radius: 0.375rem 0 0 0.375rem;
            padding: 0.75rem;
            flex-grow: 1;
            font-size: 1rem;
        }

        .search-button {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
            border-radius: 0 0.375rem 0.375rem 0;
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        .search-button:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .book-card {
            height: auto !important; /* Permet à la carte de s'adapter au contenu */
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            overflow: hidden; /* Empêche les éléments internes de dépasser */
        }

        .book-image-container {
            height: 150px; /* Taille fixe plus petite pour l'image */
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .book-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-body {
            padding: 1rem;
            text-align: center;
        }

        .book-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis; /* Ajoute des points de suspension si le titre est trop long */
        }

        .book-author, .book-price, .book-stock, .book-category {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .book-actions {
            background-color: #f8f9fa;
            padding: 0.75rem;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid #e0e0e0;
        }

        .book-actions .btn {
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.3rem;
        }
    </style>

    <div class="container py-5">
        <div class="search-container mb-3">
            <form action="{{ route('livres.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher par titre ou auteur" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">🔍 Rechercher</button>
                    </div>
                </div>
                <div class="col-md-auto">
                    <select name="categorie" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        @php
                            $categories = \App\Models\Livre::distinct()->pluck('categorie')->filter();
                        @endphp
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('categorie') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">📚 Liste des Livres</h1>
            <a href="{{ route('livres.create') }}" class="btn btn-success">➕ Ajouter un livre</a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($livres as $livre)
                <div class="col">
                    <div class="card book-card h-100">
                        <div class="book-image-container">
                            <img src="{{ asset('storage/' . $livre->image) }}" class="book-image rounded-top-4" alt="{{ $livre->titre }}">
                            @if($livre->stock < 5)
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">Stock Faible</span>
                            @endif
                        </div>
                        <div class="card-body book-body">
                            <h5 class="card-title book-title">{{ $livre->titre }}</h5>
                            <p class="card-text text-muted book-author">✍️ {{ $livre->auteur }}</p>
                            <p class="card-text text-info book-category">🏷️ {{ ucfirst($livre->categorie) }}</p>
                            <p class="card-text text-success fw-bold book-price">💰 {{ $livre->prix }} €</p>
                            <p class="card-text text-secondary book-stock">📦 {{ $livre->stock }} en stock</p>
                        </div>
                        <div class="card-footer bg-light book-actions border-0 rounded-bottom-4">
                            <a href="{{ route('livres.show', $livre) }}" class="btn btn-primary btn-sm">👁 Voir</a>
                            @if(\Illuminate\Support\Facades\Auth::user()->role != 'client')
                                <a href="{{ route('livres.edit', $livre) }}" class="btn btn-warning btn-sm">✏️ Modifier</a>
                                <form id="delete-form-{{ $livre->id }}" action="{{ route('livres.destroy', $livre) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDeletion(event, {{ $livre->id }})" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center">
                            <p class="card-text">Aucun livre disponible pour le moment.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $livres->links() }}
        </div>
    </div>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: "{{ session('success') }}",
                confirmButtonColor: '#4f46e5',
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444',
            });
        </script>
    @elseif(session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Avertissement',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#facc15',
            });
        </script>
    @endif

    <script>
        function confirmDeletion(event, id) {
            event.preventDefault();
            Swal.fire({
                title: "Êtes-vous sûr de vouloir supprimer ce livre ?",
                text: "Cette action est irréversible !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#d1d5db",
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
