<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Vuelo; // Asegúrate de importar Vuelo

class OfertasController extends Controller
{
    /**
     * Display a listing of special offers.
     */
    public function index()
    {
        $today = Carbon::now()->toDateString();
        $inTwoWeeks = Carbon::now()->addWeeks(2)->toDateString();

        $ofertas = [
            [
                'id' => 1,
                'titulo' => 'Escapada Romántica a Cancún',
                'descripcion' => '7 días y 6 noches en hotel 5 estrellas todo incluido en Cancún, vuelos redondos incluidos. ¡Perfecto para parejas!',
                'precio_desde' => 1200.00,
                'imagen_url' => 'https://source.unsplash.com/random/400x300/?cancun,beach,couple',
                'vigencia' => 'Hasta 31/08/2025',
                'origen_prefill' => 'Ciudad de México',
                'destino_prefill' => 'Cancún',
                'fecha_prefill' => $inTwoWeeks, 
                'vuelo_id_asociado' => 'a0e7f8e0-c1b2-4d3e-9f01-2a3b4c5d6e7f', // ¡REEMPLAZAR!
                'paypal_payment_link' => 'https://www.paypal.com/ncp/payment/NRAN3MMYNHCE8', // ¡GENERAR Y REEMPLAZAR!
            ],
            [
                'id' => 2,
                'titulo' => 'Aventura en la Selva Maya',
                'descripcion' => 'Explora ruinas antiguas, cenotes y la selva. 5 días y 4 noches con tours guiados.',
                'precio_desde' => 850.00,
                'imagen_url' => 'https://source.unsplash.com/random/400x300/?maya,jungle,adventure',
                'vigencia' => 'Hasta 15/09/2025',
                'origen_prefill' => 'Guadalajara',
                'destino_prefill' => 'Mérida',
                'fecha_prefill' => $today,
                'vuelo_id_asociado' => 'c2d9h0g2-e3f4-6f5g-1h23-4c5d6e7f8g9h', // ¡REEMPLAZAR!
                'paypal_payment_link' => 'https://www.paypal.com/ncp/payment/RUGH4SAHSJSKL', // ¡GENERAR Y REEMPLAZAR!
            ],
            [
                'id' => 3,
                'titulo' => 'Ruta del Tequila Express',
                'descripcion' => 'Un fin de semana inmerso en la cultura del tequila, con visitas a destilerías y degustaciones. Desde Guadalajara.',
                'precio_desde' => 350.00,
                'imagen_url' => 'https://source.unsplash.com/random/400x300/?tequila,mexico,agave',
                'vigencia' => 'Hasta 30/09/2025',
                'origen_prefill' => 'Guadalajara',
                'destino_prefill' => 'Puebla',
                'fecha_prefill' => $inTwoWeeks,
                'vuelo_id_asociado' => 'g6h3l4k6-i7j8-0j9k-5l67-8g9h0i1j2k3l', // ¡REEMPLAZAR!
                'paypal_payment_link' => 'https://www.paypal.com/ncp/payment/LXAMDWM627D7Y', // ¡GENERAR Y REEMPLAZAR!
            ],
            [
                'id' => 4,
                'titulo' => 'Descuento en Vuelos Nacionales',
                'descripcion' => '20% de descuento en tu próximo vuelo dentro de México. Aplica en rutas seleccionadas.',
                'precio_desde' => null,
                'imagen_url' => 'https://source.unsplash.com/random/400x300/?airplane,mexico,city',
                'vigencia' => 'Válido del 01/08 al 15/08/2025',
                'origen_prefill' => null, 
                'destino_prefill' => null,
                'fecha_prefill' => null,
                'vuelo_id_asociado' => null,
                'paypal_payment_link' => 'https://www.paypal.com/ncp/payment/YOUR_DESCUENTO_PAYPAL_LINK_4', // ¡GENERAR Y REEMPLAZAR!
            ],
            [
                'id' => 5,
                'titulo' => 'Paquete Familiar a Puerto Vallarta',
                'descripcion' => '8 días y 7 noches en resort familiar con actividades para niños, y vistas al mar. ¡Incluye tours a islas cercanas!',
                'precio_desde' => 1800.00,
                'imagen_url' => 'https://source.unsplash.com/random/400x300/?puerto-vallarta,family,beach-resort',
                'vigencia' => 'Hasta 20/09/2025',
                'origen_prefill' => 'Ciudad de México',
                'destino_prefill' => 'Puerto Vallarta',
                'fecha_prefill' => $inTwoWeeks,
                'vuelo_id_asociado' => 'f5g2k3j5-h6i7-9i8j-4k56-7f8g9h0i1j2k', // ¡REEMPLAZAR!
                'paypal_payment_link' => 'https://www.paypal.com/ncp/payment/GH7Q98JUDNUX6', // ¡GENERAR Y REEMPLAZAR!
            ],
            [
                'id' => 6,
                'titulo' => 'Escapada Cultural a Oaxaca',
                'descripcion' => '4 días y 3 noches explorando la rica gastronomía y artesanías de Oaxaca. Vuelos y hospedaje boutique.',
                'precio_desde' => 600.00,
                'imagen_url' => 'https://source.unsplash.com/random/400x300/?oaxaca,culture,food',
                'vigencia' => 'Hasta 10/10/2025',
                'origen_prefill' => 'Monterrey',
                'destino_prefill' => 'Oaxaca',
                'fecha_prefill' => $inTwoWeeks,
                'vuelo_id_asociado' => 'j9k6o7n9-l0m1-3m2n-8o90-1j2k3l4m5n6o', // ¡REEMPLAZAR!
                'paypal_payment_link' => 'https://www.paypal.com/ncp/payment/BWSC9QGLGDJUU', // ¡GENERAR Y REEMPLAZAR!
            ],
            [
                'id' => 7,
                'titulo' => 'Aventura Extrema en Barrancas del Cobre',
                'descripcion' => '5 días de senderismo, tirolesa y conexión con la naturaleza en el impresionante cañón. Hospedaje y guías.',
                'precio_desde' => 950.00,
                'imagen_url' => 'https://source.unsplash.com/random/400x300/?copper-canyon,mountains,hiking',
                'vigencia' => 'Hasta 25/10/2025',
                'origen_prefill' => 'Guadalajara',
                'destino_prefill' => 'Chihuahua',
                'fecha_prefill' => $inTwoWeeks,
                'vuelo_id_asociado' => null, 
                'paypal_payment_link' => 'https://www.paypal.com/ncp/payment/R4DX3JMVBWKYW', // ¡GENERAR Y REEMPLAZAR!
            ],
            [
                'id' => 8,
                'titulo' => 'Noches Mágicas en San Miguel de Allende',
                'descripcion' => '3 días y 2 noches en una de las ciudades más bellas de México. Paseos a caballo y degustación de vinos.',
                'precio_desde' => 480.00,
                'imagen_url' => 'https://source.unsplash.com/random/400x300/?san-miguel-de-allende,colonial,city',
                'vigencia' => 'Hasta 05/11/2025',
                'origen_prefill' => 'Ciudad de México',
                'destino_prefill' => 'Guanajuato',
                'fecha_prefill' => $inTwoWeeks,
                'vuelo_id_asociado' => null,
                'paypal_payment_link' => 'https://www.paypal.com/ncp/payment/AZNELDHSQUHR2', // ¡GENERAR Y REEMPLAZAR!
            ],
        ];

        return view('ofertas.index', compact('ofertas'));
    }

    // ... (tu método showDetails() aquí) ...
}