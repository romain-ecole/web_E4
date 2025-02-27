<?php

namespace objets;

/**
 * classe objet pour un personnage et ses caractéristiques
 */
class personnages
{
    /**
     * @param string $nom nom donné au personnage a sa création
     */
    public function __construct($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @param string $name nom de la variable a acceder
     * @return int|mixed|void
     */
    public function getVar($name)
    {
        switch ($name) {
            case 'vie': return $this->vie;
            case 'atk': return $this->atk;
            case 'nom': return $this->nom;
        }
    }

    /**
     * @param string $name nom de la variable a acceder
     * @param mixed $value valeur a donner à la variable
     * @return void
     */
    public function setVar($name, mixed $value)
    {
        switch ($name) {
            case 'vie': $this->vie = $value; break;
            case 'atk': $this->atk = $value; break;
            case 'nom': $this->nom = $value; break;
        }
    }

    /**
     * @param object $cible objet personnage ciblé
     * @return string texte envoyé dans la console
     */
    public function attaquer($cible)
    {
        $cible->vie -= $this->atk;
        if ($cible->mort())
        {
            return $cible->name.' est mort';
        }
        return $cible->name.' a perdu '.$this->atk.' PV, il lui en reste '.$cible->vie;
    }

    /**
     * @param int $vies vie du personnage avant sa régeneration
     * @return void
     */
    public function regenerer(int $vies = 100)
    {
        if ($this->vie + $vies >= 100)
        {
            $this->vie = 100;
        }
        else
        {
            $this->vie += $vies;
        }
    }

    /**
     * @return bool
     */
    public function mort()
    {
        return $this->vie <= 0;
    }

    /**
     * @var int
     */
    public $vie = 80;
    /**
     * @var int
     */
    public $atk = 20;
    /**
     * @var string
     */
    public $nom;
}