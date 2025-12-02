<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Override para impedir redirecionamento automático para rotas inexistentes (ex: 'login')
     */
    protected function redirectTo($request): ?string
    {
        return null; // ← AQUI RESOLVE O PROBLEMA
    }
}
