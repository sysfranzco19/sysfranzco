<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function privacy()
    {
        return view('pages/privacy', [
            'ads'         => true,
            'title'       => 'Política de privacidad | Sysfranzco',
            'description' => 'Cómo Sysfranzco usa cookies, cuentas de usuario y publicidad de Google AdSense.',
        ]);
    }
}
