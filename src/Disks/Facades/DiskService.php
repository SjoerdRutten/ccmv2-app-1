<?php

namespace Sellvation\CCMV2\Disks\Facades;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Sellvation\CCMV2\Disks\Models\Disk;

class DiskService
{
    public function disk(Disk|int $disk): FileSystem
    {
        $disk = is_int($disk) ? Disk::find($disk) : $disk;

        switch ($disk->type) {
            case 'ftp':
                return $this->getFtpDisk($disk);
        }
    }

    private function getFtpDisk(Disk $disk): FileSystem
    {
        return Storage::createFtpDriver([
            'driver' => 'ftp',
            'host' => \Arr::get($disk->settings, 'host'),
            'username' => \Arr::get($disk->settings, 'username'),
            'password' => \Arr::get($disk->settings, 'password'),
            'port' => (int) \Arr::get($disk->settings, 'port'),
            'ssl' => false,
        ]);
    }
}
