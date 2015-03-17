<?php

namespace Project\Controller;

class Phylogenetic extends Controller
{
    const DEFAULT_NB_TAXONS     = 3,
          DEFAULT_NB_CHARACTERS = 3;
    
    public function matrice()
    {
        if ( !$this->app['lib.phylogenetic']->isMatriceSet() ) {
            $matrice = $this->app['lib.phylogenetic']->initializeMatrice(self::DEFAULT_NB_TAXONS, self::DEFAULT_NB_CHARACTERS);
        } else {
            $matrice = $this->app['lib.phylogenetic']->getMatrice();
        }
        
        return $this->render('Phylogenetic/matrice', array(
            'matrice' => $matrice,
            'step'    => 1
        ));
    }
    
    public function saveMatriceCase()
    {
        $taxa      = $this->request->get('taxa');
        $character = $this->request->get('character');
        $value     = $this->request->get('value');
        
        $this->app['lib.phylogenetic']->setMatrice($taxa, $character, $value);
        
        return new \Symfony\Component\HttpFoundation\Response();
    }
    
    public function saveMatriceTaxaName()
    {
        $number   = $this->request->get('number');
        $taxaName = $this->request->get('value');
        
        $this->app['lib.phylogenetic']->setMatriceTaxaName($number, $taxaName);
        
        return new \Symfony\Component\HttpFoundation\Response();
    }
    
    public function matriceAddCharacter()
    {
        $matrice = $this->app['lib.phylogenetic']->addCharacter();

        return $this->render('Phylogenetic/matrice_table', array(
            'matrice' => $matrice
        ));
    }
    
    public function matriceAddTaxa()
    {
        $matrice = $this->app['lib.phylogenetic']->addTaxa();

        return $this->render('Phylogenetic/matrice_table', array(
            'matrice' => $matrice
        ));
    }
    
    public function matriceReset()
    {
        $matrice = $this->app['lib.phylogenetic']->initializeMatrice(self::DEFAULT_NB_TAXONS, self::DEFAULT_NB_CHARACTERS);

        return $this->render('Phylogenetic/matrice_table', array(
            'matrice' => $matrice
        ));
    }
}