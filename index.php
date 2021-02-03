<!doctype html>
<html>
<head>
    <meta charset="utf-8"  />
    <link rel="stylesheet" href="gb.css"
    <title>Gästebuch</title>
</head>
<body>
<main>
    <h1>Gästebuch</h1>
    <section class="eintraege">
        <?php
        $pfadDatei = "Einträge.csv";
        if(count($_POST) > 0) {
            $_POST["nachricht"] = str_replace(";", ",", $_POST['nachricht']);
            $daten = $_POST;
            array_push($daten, time());
            $datensatz = join(";", $daten) . PHP_EOL;
            file_put_contents($pfadDatei, $datensatz, FILE_APPEND);
            header("location: .");
        }
        function lese_Datensaetze($datei)
        {
            $datensaetze = explode(PHP_EOL, $datei);
            return array_map("lese_Datenfelder", $datensaetze);
        }

        function lese_Datenfelder($datensatz)
        {
            $felder = explode(";", $datensatz);
            return $felder;
        }

        if (is_file($pfadDatei)) {
            $datei = file_get_contents($pfadDatei);
            $daten = lese_Datensaetze($datei);
            foreach ($daten as $eintrag) {
                if (count($eintrag) == 4) {
                    printf("<div class=eintrag><a href=mailto:%s>%s</a>" .
                        " schrieb am %s um %s Uhr:<p>%s</p></div>",
                        $eintrag[1],
                        $eintrag[0],
                        date("d.m.Y", $eintrag[3]),
                        date("H:i", $eintrag[3]),
                        htmlspecialchars($eintrag[2])
                    );
                }
            }
        }?>
        <h2>Neuer Eintrag</h2>
        <form method=post>
            <label for=name>Name:
                <input type=text name=name maxlength=255 required/>
            </label><br>
            <label for=email>E-Mail:
                <input type=email name=email maxlength=255 required/>
            </label><br>
            <label for=nachricht>Nachricht:
                <textarea name=nachricht maxlength=1000 required></textarea>
            </label><br>
            <button type="submit">Abschicken</button>
        </form>
    </section>
</main>
</body>
</html>