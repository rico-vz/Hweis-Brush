<?php

namespace App\Providers;

use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{

    public function boot(): void
    {
        Window::open()
            ->width(1280)
            ->height(720)
            ->resizable(false)
            ->title("Hwei's Brush")
            ->rememberState()
            ->titleBarHidden();
    }


    public function phpIni(): array
    {
        return [];
    }
}
