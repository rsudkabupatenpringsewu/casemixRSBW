@extends('..layout.layoutDashboard')
@section('title', 'TESTING')

@section('konten')
    <div class="container mt-5">
        <form>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Ketik sesuatu..." aria-label="Ketik sesuatu..." aria-describedby="reset-icon">
            <button class="btn btn-outline-secondary reset-icon" type="button" id="reset-icon">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </form>
      </div>

@endsection
