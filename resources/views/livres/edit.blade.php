@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier le Livre</h1>
        <form action="{{ route('livres.update', $livre->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre" class="form-control" value="{{ $livre->titre }}" required>
            </div>
            <div class="form-group">
                <label for="auteur">Auteur</label>
                <input type="text" name="auteur" id="auteur" class="form-control" value="{{ $livre->auteur }}" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" name="prix" id="prix" class="form-control" value="{{ $livre->prix }}" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ $livre->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ $livre->stock }}" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <input type="text" name="categorie" id="categorie" class="form-control" value="{{ $livre->categorie }}">
                @error('categorie')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-warning">Modifier</button>
        </form>
    </div>
@endsection
