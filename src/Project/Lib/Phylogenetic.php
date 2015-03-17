<?php

namespace Project\Lib;

class Phylogenetic
{
    protected $app;
    
    function __construct($app) 
    {
        $this->app = $app;
    }
    
    public function setMatrice($taxa, $character, $value)
    {
        $matrice = $this->getMatrice();
        $matrice[$taxa]['values'][$character] = $value;
        
        $this->app['session']->set('phylogenetic.matrice', $matrice);
        
        return $matrice;
    }
    
    public function isMatriceSet()
    {
        $matrice = $this->app['session']->get('phylogenetic.matrice', array());
        return !empty($matrice);
    }
    
    public function getMatrice()
    {
        return $this->app['session']->get('phylogenetic.matrice', array());
    }
    
    public function initializeMatrice($nbTaxons, $nbCharacters)
    {
        $matrice = array();
        for ( $i = 1; $i <= $nbTaxons; $i++ ) {
            $matrice[$i] = array(
                'taxa'   => 'Taxa ' . $i,
                'values' => array()
            );
            
            for ( $j = 1; $j <= $nbCharacters; $j++ ) {
                $matrice[$i]['values'][$j] = '0';
            }
        }
        
        $this->app['session']->set('phylogenetic.matrice', $matrice);
        
        return $matrice;
    }
    
    public function setMatriceTaxaName($number, $taxaName)
    {
        $matrice = $this->getMatrice();
        $matrice[$number]['taxa'] = $taxaName;
        
        $this->app['session']->set('phylogenetic.matrice', $matrice);
        
        return $matrice;
    }
    
    public function addCharacter($nb = 1)
    {
        $newMatrice = $matrice = $this->getMatrice();
        
        foreach ( $matrice as $i => $row ) {
            for( $j = 1 ; $j <= $nb ; $j++ ) {
                $newMatrice[$i]['values'][] = '0';
            }
        }
        
        $this->app['session']->set('phylogenetic.matrice', $newMatrice);
        
        return $newMatrice;
    }
    
    public function addTaxa($nb = 1)
    {
        $newMatrice = $matrice = $this->getMatrice();
        
        $entry = current($newMatrice);
        $nbCharacter = count($entry['values']);
        
        $values = array();
        for ( $i = 1 ; $i <= $nbCharacter ; $i++ ) {
            $values[$i] = '0';
        }
        
        for ( $j = 1 ; $j <= $nb ; $j++ ) {
            $newMatrice[] = array(
                'taxa'   => 'Taxa ' . ((string) count($matrice)+1),
                'values' => $values
            );
        }
        
        $this->app['session']->set('phylogenetic.matrice', $newMatrice);
        
        return $newMatrice;
    }
}