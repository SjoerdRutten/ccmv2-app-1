<?php

namespace Sellvation\CCMV2\BladeData\Facades;

use Sellvation\CCMV2\BladeData\Extensions\BladeExtension;
use Spatie\StructureDiscoverer\Discover;

class BladeExtensions
{
    private array $extensions = [];

    public function registerBladeExtension(BladeExtension $extension)
    {
        $this->extensions[] = $extension;
    }

    public function discover()
    {
        foreach (Discover::in(__DIR__.'/../Extensions')
            ->classes()
            ->extending(BladeExtension::class)
            ->get() as $extension) {
            $this->registerBladeExtension(new $extension);
        }
    }

    public function getExtensions()
    {
        $this->discover();

        return $this->extensions;
    }

    public function mergeData(array &$data, $type)
    {
        foreach ($this->getExtensions() as $extension) {
            if (
                (($type === 'EMS') && $extension->showEMS) ||
                (($type === 'CMS') && $extension->showCMS)
            ) {
                $data = $extension->addData($data);
            }
        }

        return $data;
    }

    private function getVariables($type)
    {
        $variables = [];
        foreach ($this->getExtensions() as $extension) {
            if (
                (($type === 'EMS') && $extension->showEMS) ||
                (($type === 'CMS') && $extension->showCMS)
            ) {
                $variables = array_merge($variables, $extension->getVariables());
            }
        }

        return $variables;
    }

    public function getCmsVariables()
    {
        $variables = $this->getVariables('CMS');

        $variables['site'] = 'Site object';
        $variables['sitePage'] = 'SitePage object';
        $variables['siteLayout'] = 'SiteLayout object';

        ksort($variables);

        return $variables;
    }

    public function getEmsVariables()
    {
        $variables = $this->getVariables('EMS');

        ksort($variables);

        return $variables;
    }
}
