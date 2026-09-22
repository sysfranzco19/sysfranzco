<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuración de Google AdSense.
 *
 * Los anuncios solo se cargan en producción para no generar impresiones/clics
 * propios durante el desarrollo (viola las políticas de AdSense).
 *
 * Los IDs de bloque se crean en AdSense > Anuncios > Por unidad de anuncio y se
 * ponen en .env (ej. adsense.slotInline = 1234567890). Sin ID, el bloque no se
 * dibuja; los anuncios automáticos funcionan igual solo con el script.
 */
class AdSense extends BaseConfig
{
    public string $client = 'ca-pub-2740977378426451';

    /** Bloque de anuncio dentro de listados y entre secciones. */
    public string $slotInline = '';

    /** Bloque de anuncio al final de artículos y detalle de proyecto. */
    public string $slotArticle = '';
}
