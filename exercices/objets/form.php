<?php

/**
 * Class Form
 * Permet de génerer un formulaire rapidement et simplement
 */
class form
{
    /**
     * @var string utilisé dans la fonction surround
     */
    private $surround = 'p';
    /**
     * @var array|mixed tableau de valeur passés a la construction de l'objet
     */
    private $data;

    /**
     * @param array $data tableau de valeur dans le formulaire
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * @param string $html texte a entourer de html
     * @return string retourne du code html
     */
    private function surround($html)
    {
        return "<{$this->surround}>".$html."</{$this->surround}>";
    }

    /**
     * @param mixed $index index de l'élément dans le tableau
     * @return mixed|null
     */
    private function getValue($index)
    {
        if (isset($this->data[$index]))
        {
            $this->data[$index] = null;
        }
        return $this->data[$index];
    }

    /**
     * @param string $name nom de l'input
     * @return string retourne un input html
     */
    public function input($name)
    {
        return $this->surrount("<input type='text' name='".$name."'>");
    }

    /**
     * @return string
     */
    public function submit()
    {
        return $this->surround("<input type='submit'>envoyer</input>");
    }
}