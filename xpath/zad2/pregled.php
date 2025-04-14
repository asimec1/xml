<?php
$imeTrazeno = $_GET['ime'] ?? '';

$xml = new DOMDocument();
$xml->load("studenti.xml");

$xpath = new DOMXPath($xml);

// Pronađi sve studente s traženim imenom
$query = "/Studenti/Student[Ime='$imeTrazeno']";
$studenti = $xpath->query($query);

echo "<h2>Rezultati pretrage za ime: <em>$imeTrazeno</em></h2>";

if ($studenti->length === 0) {
    echo "<p>Nema studenata s tim imenom.</p>";
} else {
    echo "<table border='1' cellpadding='6'>";
    echo "<tr><th>Ime</th><th>Prezime</th><th>Ocjene</th><th>Prosjek</th></tr>";

    foreach ($studenti as $student) {
        $ime = $xpath->evaluate("string(Ime)", $student);
        $prezime = trim($xpath->evaluate("string(Prezime)", $student));
        
        $kolokviji = $xpath->query("Predmet/Kolokviji/Kolokvij", $student);
        $ocjene = [];
        $zbroj = 0;

        foreach ($kolokviji as $k) {
            $ocjena = (int)$k->nodeValue;
            $ocjene[] = $ocjena;
            $zbroj += $ocjena;
        }

        $prosjek = count($ocjene) ? round($zbroj / count($ocjene), 2) : 0;
        $sveOcjene = implode(", ", $ocjene);

        echo "<tr>";
        echo "<td>$ime</td><td>$prezime</td><td>$sveOcjene</td><td>$prosjek</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>
