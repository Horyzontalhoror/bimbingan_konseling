<div class="mb-3">
    <label for="photo">Foto Profil</label>
    <input type="file" id="photo" wire:model="photo" class="form-control">
    @error('photo') <span class="text-danger">{{ $message }}</span> @enderror

    <div class="mt-3">
        <button type="button" wire:click="savePhoto" class="btn btn-primary">Simpan</button>
        <button type="button" wire:click="deletePhoto" class="btn btn-danger">Hapus</button>
    </div>

    @if (auth()->user()->profile_photo_path)
        <div class="mt-2">
            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" width="100" class="rounded">
        </div>
    @endif
</div>
