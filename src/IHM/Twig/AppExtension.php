<?php

namespace App\IHM\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig_Environment;
use Twig_Extension;
use Twig_Function;

/**
 * AppExtension class
 * Classe de gestion des extensions Twig
 */
class AppExtension extends \Twig_Extension
{

    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    /**
     * RoutingExtension constructor.
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app_extension';
    }


    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('generateUrlForTabRows', [$this, 'generateUrlForTabRows']),
            new Twig_Function('generatePathForTabRows', [$this, 'generatePathForTabRows']),
            new Twig_Function('generateCustomUrl', [$this, 'generateCustomUrl']),
        ];
    }

    /**
     * Genere un chemin absolu pour un lien correpondant à une action sur une ligne du tableau
     * @param  string $route
     * @param  string $nameRowElement
     * @param  string $idRowElement
     * @param  array $otherParams
     */
    public function generateUrlForTabRows($route, $nameRowElement, $idRowElement, array $otherParams = [])
    {
        echo $this->generator->generate($route, array_merge([$nameRowElement => $idRowElement], $otherParams), TRUE);
    }


    /**
     * @param string $route
     * @param array $param
     */
    public function generateCustomUrl($route, array $param = [])
    {
        echo $this->generator->generate($route, $param, TRUE);
    }

    /**
     * Genere un chemin path pour un lien correpondant à une action sur une ligne du tableau
     * @param string $route
     * @param string $nameRowElement
     * @param string $idRowElement
     * @param array $otherParams
     */
    public function generatePathForTabRows($route, $nameRowElement, $idRowElement, array $otherParams = [])
    {
        if (is_array($idRowElement)) {
            echo $this->generator->generate($route, array_merge($idRowElement, $otherParams), FALSE);
        } else {
            echo $this->generator->generate($route, array_merge([$nameRowElement => $idRowElement], $otherParams), FALSE);
        }
    }


}