<?php

if (! function_exists('unique_slug')) {
    /**
     * Genera un slug único para $model->table a partir de $title.
     */
    function unique_slug(\CodeIgniter\Model $model, string $title, ?int $ignoreId = null): string
    {
        $base = url_title(strtr($title, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'Ñ' => 'N',
        ]), '-', true);
        $base = $base !== '' ? substr($base, 0, 120) : 'item';
        $slug = $base;
        $n    = 2;

        while (true) {
            $query = db_connect()->table($model->getTable())->where('slug', $slug);

            if ($ignoreId !== null) {
                $query->where('id !=', $ignoreId);
            }

            if ($query->countAllResults() === 0) {
                return $slug;
            }

            $slug = $base . '-' . $n++;
        }
    }
}

if (! function_exists('render_content')) {
    /**
     * Contenido escrito por el admin. Si contiene HTML se imprime tal cual
     * (el admin es de confianza); si es texto plano, se respetan los saltos de línea.
     */
    function render_content(?string $text): string
    {
        $text = (string) $text;

        if ($text === '') {
            return '';
        }

        return $text !== strip_tags($text) ? $text : nl2br(esc($text));
    }
}

if (! function_exists('youtube_embed_id')) {
    /**
     * Devuelve el ID de video de una URL de YouTube (watch, youtu.be, embed, shorts) o null.
     */
    function youtube_embed_id(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (preg_match('~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}

if (! function_exists('normalize_tags')) {
    /**
     * "PHP, CI4 ,php" => "php,ci4"
     */
    function normalize_tags(?string $tags): string
    {
        $list = array_filter(array_map(
            static fn ($t) => trim(mb_strtolower($t)),
            explode(',', (string) $tags)
        ), static fn ($t) => $t !== '');

        return implode(',', array_unique($list));
    }
}

if (! function_exists('save_uploaded_image')) {
    /**
     * Guarda una imagen subida en public/uploads/$dir y devuelve su ruta relativa
     * ("uploads/$dir/xxx.jpg"), o null si el archivo no es una imagen válida.
     */
    function save_uploaded_image(?\CodeIgniter\HTTP\Files\UploadedFile $file, string $dir): ?string
    {
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

        if (! $file || ! $file->isValid() || $file->hasMoved()
            || $file->getSize() > 3 * 1024 * 1024
            || ! in_array($file->getMimeType(), $allowed, true)) {
            return null;
        }

        $target = FCPATH . 'uploads/' . $dir;

        if (! is_dir($target)) {
            mkdir($target, 0755, true);
        }

        $name = $file->getRandomName();
        $file->move($target, $name);

        return 'uploads/' . $dir . '/' . $name;
    }
}

if (! function_exists('delete_uploaded_file')) {
    function delete_uploaded_file(?string $path): void
    {
        // Solo dentro de public/uploads, sin permitir ".."
        if ($path && str_starts_with($path, 'uploads/') && ! str_contains($path, '..')) {
            $full = FCPATH . $path;

            if (is_file($full)) {
                unlink($full);
            }
        }
    }
}
