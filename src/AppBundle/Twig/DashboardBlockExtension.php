<?php

/*
 * This file is part of sonata-project.
 *
 * (c) 2010 Thomas Rabaix
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Twig;

use \Twig\Environment;

class DashboardBlockExtension extends \Twig_Extension
{
    
    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('dashboard_count_block_render', array($this, 'dashboardRender'), array(
            'is_safe' => array('html'),
            'needs_environment' => true
            )),
            new \Twig_SimpleFunction('dashboard_message_block_render', array($this, 'dashboardMessageRender'), array(
            'is_safe' => array('html'),
            'needs_environment' => true
            )),
        );
        
    }
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }
    
    public function dashboardRender(\Twig_Environment $env, $class = 'default', $icon = 'globe', $count = '20', $label = 'default'){
        
        if($class=="lime"){
            $color = 'dark';
        } else {
            $color = 'light';
        }
        return $env->render(':embed:block/block-sign.html.twig', array('class'=>$class, 'icon'=>$icon, 'label'=>$label, 'count'=>$count, 'color'=>$color));
        
    }
    
    public function dashboardMessageRender(\Twig_Environment $env){
        
        return $env->render(':embed:block/block-message.html.twig');
        
    }

    public function getName()
    {
        return 'dashboard_block';
    }
}
