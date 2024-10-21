<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin;

use Laravel\Pennant\Feature;
use Livewire\Component;

class Features extends Component
{
    public array $features = [];

    public function mount()
    {
        $this->loadFeatures();
    }

    public function updated($property, $value)
    {
        $key = explode('.', $property)[1];

        $featureName = \Arr::get($this->features, $key.'.name');

        if ($value) {
            \Auth::user()->currentEnvironment->addFeature($featureName);
        } else {
            \Auth::user()->currentEnvironment->removeFeature($featureName);
        }

        Feature::purge([$featureName]);
    }

    private function loadFeatures()
    {
        foreach (Feature::all() as $feature => $active) {
            if (! \Str::startsWith($feature, 'admin')) {
                $this->features[] = [
                    'name' => $feature,
                    'active' => \Auth::user()->currentEnvironment->hasFeature($feature),
                ];
            }
        }
    }

    public function render()
    {
        return view('ccm::livewire.admin.features');
    }
}
