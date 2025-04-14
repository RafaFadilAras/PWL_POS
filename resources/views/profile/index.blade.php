@extends('layouts.template')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-body box-profile">
                <div class="text-center mb-2">
                    @if($user->foto)
                        <img class="profile-user-img img-fluid img-circle" 
                             src="{{ asset('storage/' . $user->foto) }}" 
                             alt="User profile picture" style="width: 120px; height: 120px;">
                    @else
                        <img class="profile-user-img img-fluid img-circle" 
                             src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" 
                             alt="Default profile picture" style="width: 120px; height: 120px;">
                    @endif
                </div>
                <h3 class="profile-username text-center">{{ $user->nama }}</h3>
                <p class="text-muted text-center">{{ $user->getRoleName() }}</p>
                <hr>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><b>Username</b></span>
                        <span>{{ $user->username }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><b>Level</b></span>
                        <span>{{ $user->getRole() }}</span>
                    </li>
                </ul>
                <div class="row mb-3">
                    <div class="col-md-12 mb-2">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-1">
                                <div class="custom-file">
                                    <input type="file" name="foto" 
                                        class="custom-file-input @error('foto') is-invalid @enderror" id="foto">
                                    <label class="custom-file-label" for="foto">Pilih file</label>
                                </div>
                                @error('foto')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG (Max: 2MB)</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-2">
                                <i class="fas fa-upload"></i> Upload Foto
                            </button>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <form action="{{ url('/profile/remove_foto') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" {{ $user->foto ? '' : 'disabled' }}>
                                <i class="fas fa-trash"></i> Hapus Foto
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
