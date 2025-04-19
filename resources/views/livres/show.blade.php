@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg rounded-lg">
                    <div class="row g-0">
                        <div class="col-md-4 p-4">
                            <img src="{{ asset('storage/' . $livre->image) }}" alt="{{ $livre->titre }}" class="img-fluid rounded">
                            @if($livre->stock < 5)
                                <div class="mt-2">
                                    <span class="badge bg-danger">Stock Faible</span>
                                </div>
                            @elseif($livre->stock > 10)
                                <div class="mt-2">
                                    <span class="badge bg-success">En Stock</span>
                                </div>
                            @else
                                <div class="mt-2">
                                    <span class="badge bg-warning text-dark">Stock Limité</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h2 class="card-title fw-bold mb-3">{{ $livre->titre }}</h2>
                                <p class="card-text mb-2"><i class="fas fa-user text-muted me-2"></i> <strong>Auteur:</strong> {{ $livre->auteur }}</p>
                                <p class="card-text mb-3"><i class="fas fa-tag text-success me-2"></i> <strong>Prix:</strong> <span class="text-success fw-bold">{{ number_format($livre->prix, 2) }} €</span></p>
                                <p class="card-text mb-3"><i class="fas fa-box-open text-secondary me-2"></i> <strong>Stock:</strong> {{ $livre->stock }} exemplaire(s) disponible(s)</p>
                                <p class="card-text mb-3"><i class="fas fa-book-open text-info me-2"></i> <strong>Description:</strong></p>
                                <p class="card-text">{{ $livre->description }}</p>

                                <div class="mt-4">
                                    <button class="btn btn-outline-secondary rounded-pill">
                                        <i class="far fa-heart me-2"></i> Ajouter à la liste de souhaits
                                    </button>
                                    <a href="{{ route('livres.index') }}" class="btn btn-link ms-2"><i class="fas fa-arrow-left me-1"></i> Retour à la liste</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection
