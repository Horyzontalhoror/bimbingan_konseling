<?php

if (!function_exists('badgeKategori')) {
    function badgeKategori($value)
    {
        return match ($value) {
            'Baik', 'Rajin', 'Tidak Pernah' =>
            '<span class="badge badge-success">' . $value . '</span>',
            'Cukup', 'Ringan' =>
            '<span class="badge badge-warning">' . $value . '</span>',
            'Butuh Bimbingan', 'Sering Absen', 'Sering' =>
            '<span class="badge badge-danger">' . $value . '</span>',
            default =>
            '<span class="badge badge-secondary">N/A</span>',
        };
    }
}
