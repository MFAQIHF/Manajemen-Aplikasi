<?php
class Validator // memastikan deskirpsi, kemungkinan dan dampak sudah ada dalam data
{
    public static function validateRisikoInput($data)
    {
        return isset($data['nama_risiko'], $data['kemungkinan'], $data['dampak']);
    }
}
