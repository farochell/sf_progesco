<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   14/01/2020
 * @time  :   19:24
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension
 *
 * @package App\Twig
 *
 */
class AppExtension extends AbstractExtension
{
    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('currencyFormat', [$this, 'currencyFormat']),
        ];
    }
    
    /**
     * @param        $value
     * @param string $currency
     *
     * @return string
     */
    public function currencyFormat($value, $currency = "XOF")
    {
        $fmt = numfmt_create( 'fr_FR', \NumberFormatter::CURRENCY );
        
        return numfmt_format_currency($fmt, $value, $currency);
    }
}