<?php

use App\Models\Conversion;
use App\Models\Species;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $search = '';
    public int $product_id;
    public int $selected_species = 0;
    public int $qty = 0;
   

    public function species(): Collection
    {
        return Species::get()
        ->map(function ($species) {
            return [
                'id' => $species->id,
                'species' => "{$species->species} - {$species->local_name}",
            ];
        });
    }

    public function calculate()
    {
        
        return Conversion::with('species', 'product')->where('species_id', $this->selected_species)->get();
    }
    

    public function with(): array
    {
        return [
          
            'species' => $this->species(),
            'conversions' => $this->calculate(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Kalkulator Konversi Pemanfaatan Jenis Ikan" separator progress-indicator>
    </x-header>

    <!-- Select -->
    <x-card>
    <x-form wire:submit="calculate">
        <div class="row">
            <div class="col-xl-4 md:col-md-6 mt-3">
                <x-choices-offline
                    label="Pilih Jenis"
                    wire:model="selected_species"
                    :options="$species"
                    option-label="species"
                    option-value="id"
                    single
                    searchable />
            </div>
            <div class="col-md-4 md:col-md-6 mt-3">
                <x-input type="number" label="Jumlah" placeholder="Masukan Jumlah Ekor" suffix="Ekor" wire:model="qty" />
            </div>
            <div class="col-md-4 md:col-md-6 mt-3">
                <x-button label="Kalkulasikan" type="submit" class="btn-primary" spinner="calculate" />
            </div>
        </div>
    </x-form>
       
    </x-card>
    @if ($conversions->count() > 0)
    <x-card class="mt-3">

     <table class="min-w-full table-auto border-collapse border border-slate-500 rounded-lg overflow-hidden">
        <thead class="bg-slate-700 text-white dark:bg-slate-900 dark:text-gray-300">
            <tr>
                <th class="px-4 py-2 border border-slate-600 text-center dark:border-slate-700">No</th>
                <th class="px-4 py-2 border border-slate-600 text-center dark:border-slate-700">Jenis</th>
                <th class="px-4 py-2 border border-slate-600 text-center dark:border-slate-700">Jumlah</th>
                <th class="px-4 py-2 border border-slate-600 text-center dark:border-slate-700">Hasil</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-slate-800 dark:text-gray-300">
            @foreach ($conversions as $conversion)
                <tr class="hover:bg-slate-100 dark:hover:bg-slate-700 transition ease-in-out duration-150">
                    <td class="px-4 py-2 border border-slate-300 dark:border-slate-700">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border border-slate-300 dark:border-slate-700">{{ $conversion->species->species }}</td>
                    <td class="px-4 py-2 border border-slate-300 dark:border-slate-700">{{ $conversion->species->local_name }}</td>
                    <td class="px-4 py-2 border border-slate-300 dark:border-slate-700 text-center">
                        {{ ($conversion->species->weight * $this->qty)*($conversion->conversion_factor/100) }}
                    Kg </td>
                </tr>
            @endforeach
        </tbody>
    </table>
     </x-card>
    @endif
   
</div>
