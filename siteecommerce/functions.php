<?php

function aItems(string $titre, string $id): string
{
    $id .= ".php";
    $class = "textMenu";
    if ($_SERVER['SCRIPT_NAME'] === "/www/ecommerce/".$id) {
        $class .= "2";
    }
    return ("<a id='".$class."' href='".$id."'>".$titre."</a>");
}

function GenHeader(): string
{
    return "<header><nav class='right-align'><h1 id='titresite' style='text-align: center'>Meub'Ebéniste</h1>".
        aItems("Inscription", "inscription").
        aItems("Contact", "contact").
        aItems("Nos Produits", "tableauProduits").
        aItems("Mon Panier", "panier").
        aItems("FAQ", "faq").
        aItems("Déconnexion", "scripts/sessionExit")."</nav></header>";
}

function GenFooter(): string
{
    return "<footer><nav>" .
        aItems("Inscription", "inscription").
        aItems("Contact", "contact").
        aItems("Nos Produits", "tableauproduits").
        aItems("Mon Panier", "panier").
        aItems("FAQ", "faq").
        aItems("Déconnexion", "scripts/sessionExit")."</nav></footer>";
}
