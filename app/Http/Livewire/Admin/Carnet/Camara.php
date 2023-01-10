<?php

namespace App\Http\Livewire\Admin\Carnet;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Camara extends Component
{
	use WithFileUploads;

    protected $listeners = ['storePhoto','guardarFoto'];

    public $photos = [];

	public $imagen = '',$url = '', $imagen_recortada;

    public function storePhoto($imageBlob) {
		$this->reset(['imagen','url']);
		$this->imagen = $imageBlob;
        $imageBlob = str_replace('data:image/png;base64,', '', $imageBlob);
        $imageBlob = str_replace(' ', '+', $imageBlob);
        $imageName = 'photo' . Str::slug('RAMON') . '.png';
        // $imageName = 'photo' . Str::slug(Carbon::now()) . '.png';
        // $photo = new Photo();
        // $photo->name = $imageName;
        // $photo->path = '/storage/' . $imageName;
        Storage::disk('public')->put($imageName, base64_decode($imageBlob));
        // $photo->save();
		$this->url = Storage::disk('public')->url($imageName);
		$this->emit('ocultar_fotos');
		// return dd($url);
			$this->emit('crop',$this->url);

        // $this->photos = Photo::all();
    }
    public function guardarFoto($imageBlob) {
		// $this->imagen = $imageBlob;
		$this->reset(['imagen_recortada','url']);
        $imageBlob = str_replace('data:image/png;base64,', '', $imageBlob);
        $imageBlob = str_replace(' ', '+', $imageBlob);
        $imageName = 'photo' . Str::slug('RAMON') . '.png';
        // $imageName = 'photo' . Str::slug(Carbon::now()) . '.png';
        // $photo = new Photo();
        // $photo->name = $imageName;
        // $photo->path = '/storage/' . $imageName;
        Storage::disk('public')->put($imageName, base64_decode($imageBlob));
        // $photo->save();
		$this->imagen_recortada = Storage::disk('public')->url($imageName);
		// $this->reset(['imagen']);
		$this->emit('ocultar_fotos');
		$this->emit('mensajes','success','Foto guardada correctamente.');
		// return dd($url);
			// $this->emit('crop',$this->url);
        // $this->photos = Photo::all();
    }
    public function mount() {
        // Photo::truncate();
    }
    public function render()
    {
        return view('livewire.admin.carnet.camara');
    }
}
