<?php

namespace Sellvation\CCMV2\Ccm\Facades;

class CcmMenu
{
    private array $ccmMenu = [];

    private array $menu = [];

    public function registerMenuItem(string $key, array $item)
    {
        \Arr::add($this->menu, $key, $item);
    }

    public function addMenuItem(array $item)
    {
        $this->menu[] = $item;
    }

    public function addCcmMenuItem(array $item)
    {
        $this->ccmMenu[] = $item;
    }

    public function getMenu()
    {
        return array_merge($this->ccmMenu, $this->menu);
    }
}
