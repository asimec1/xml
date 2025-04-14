<?php
$xml = new DOMDocument();
$xml->load("studenti.xml"); // tvoj XML dokument

$xpath = new DOMXPath($xml);
$studenti = $xpath->query("/Studenti/Student");

foreach ($studenti as $student) {
    $ime = $xpath->evaluate("string(Ime)", $student);
    $prezime = $xpath->evaluate("string(Prezime)", $student);
    
    $kolokviji = $xpath->query("Predmet/Kolokviji/Kolokvij", $student);
    
    $zbroj = 0;
    $brojac = 0;
    foreach ($kolokviji as $k) {
        $zbroj += (int)$k->nodeValue;
        $brojac++;
    }

    $prosjek = $brojac > 0 ? round($zbroj / $brojac, 2) : 0;

    echo "<p>$ime $prezime – Prosjek kolokvija: <strong>$prosjek</strong></p>";
}
?>