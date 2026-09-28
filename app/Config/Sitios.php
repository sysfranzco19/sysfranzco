<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Sitios de la red SysFranzCo (subdominios de sysfranzco.com).
 *
 * Se muestran en la sección "Nuestros sitios" de la home y en el menú.
 * Para agregar un subdominio nuevo basta con añadir una entrada, por ejemplo:
 *
 *     [
 *         'nombre'      => 'Tutoriales',
 *         'url'         => 'https://tutoriales.sysfranzco.com',
 *         'descripcion' => 'Guías paso a paso de programación y soporte técnico.',
 *         'icono'       => '📚',
 *     ],
 */
class Sitios extends BaseConfig
{
    /**
     * @var list<array{nombre: string, url: string, descripcion: string, icono: string}>
     */
    public array $sitios = [
        [
            'nombre'      => 'Rutas',
            'url'         => 'https://rutas.sysfranzco.com',
            'descripcion' => 'Descubre rutas y destinos para conocer la riqueza natural de Bolivia.',
            'icono'       => '🗺️',
        ],
    ];
}
