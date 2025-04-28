<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    public $state = [];
    public $photo;

    public function mount()
    {
        $this->state = collect(Auth::user())->only(['name', 'email'])->toArray();
    }

    public function updateProfileInformation()
    {
        $user = \App\Models\User::find(Auth::id());

        $validated = Validator::make(
            array_merge($this->state, ['photo' => $this->photo]),
            [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
            ]
        )->validate();

        if (!empty($validated['name'])) {
            $user->name = $validated['name'];
        }

        if (!empty($validated['email'])) {
            $user->email = $validated['email'];
        }

        if ($this->photo) {
            $path = $this->photo->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        session()->flash('success', 'Profil berhasil diperbarui.');
    }

    public function savePhoto()
    {
        $this->validate([
            'photo' => ['required', 'image', 'max:1024'], // Validate the photo input
        ]);

        $user = Auth::user();

        // Store the photo and update the user's profile photo path
        $path = $this->photo->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
        $user->save();

        session()->flash('success', 'Foto profil berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        // Delete the photo file if it exists
        if ($user->profile_photo_path && \Storage::disk('public')->exists($user->profile_photo_path)) {
            \Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Remove the photo path from the user's profile
        $user->profile_photo_path = null;
        $user->save();

        session()->flash('success', 'Foto profil berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information-form');
    }
}
