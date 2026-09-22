<?php

if (! function_exists('adsense_enabled')) {
    /**
     * Anuncios solo en producción y en páginas con contenido público.
     */
    function adsense_enabled(): bool
    {
        return ENVIRONMENT === 'production' && config('AdSense')->client !== '';
    }
}

if (! function_exists('adsense_script')) {
    /**
     * Script de AdSense (habilita también los anuncios automáticos).
     */
    function adsense_script(): string
    {
        if (! adsense_enabled()) {
            return '';
        }

        return '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client='
            . esc(config('AdSense')->client, 'attr') . '" crossorigin="anonymous"></script>';
    }
}

if (! function_exists('ad_unit')) {
    /**
     * Bloque de anuncio manual. $name: 'inline' | 'article'.
     * No dibuja nada si no hay ID de bloque configurado.
     */
    function ad_unit(string $name): string
    {
        if (! adsense_enabled()) {
            return '';
        }

        $config = config('AdSense');
        $slot   = $name === 'article' ? $config->slotArticle : $config->slotInline;

        if ($slot === '') {
            return '';
        }

        return '<div class="ad"><ins class="adsbygoogle" style="display:block" data-ad-client="'
            . esc($config->client, 'attr') . '" data-ad-slot="' . esc($slot, 'attr')
            . '" data-ad-format="auto" data-full-width-responsive="true"></ins>'
            . '<script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div>';
    }
}
