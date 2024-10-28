<?php

namespace Sellvation\CCMV2\Ccm\Components\dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class TypesenseCollectionsCard extends Component
{
    public function render(): View
    {
        $this->getCollections();

        return view('ccm::components.dashboard.typesense-collections-card')
            ->with([
                'collections' => $this->getCollections(),
            ]);
    }

    private function getCollections()
    {
        $collections = new Collection(\Typesense::getCollections());

        return $collections->filter(function ($item) {
            return \Str::endsWith($item['name'], '_'.\Auth::user()->currentEnvironmentId);
        });
    }
}
