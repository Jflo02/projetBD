<p>
    Filtrer les voyages :
</p>

<p>
    <table border=1>
        <tr>
            <form action="./resultat_recherche.php?" method="GET">
                <td><label for="date_debut">Date de début</label></td>
                <td><input type="date" id="date_debut" name="date_debut"></td>
                <td><label for="jours">Nombre de jours</label></td>
                <td>Mininum <input type="number" id="jours_min" name="jours_min" min="1"></td>
                <td>Maximum <input type="number" id="jours_max" name="jours_max" min="1"></td>
                <td><label for="nombre_passa">Nombre de places</label></td>
                <td><input type="number" id="nombre_passa" name="nombre_passa"></td>
                <td><label for="prix">Prix</label></td>
                <td>Mininum <input type="number" id="prix_min" name="prix_min" min="1"></td>
                <td>Maximum <input type="number" id="prix_max" name="prix_max" min="1"></td>
                <td><input type="submit" value="Rechercher"></td>
            </form>
        </tr>
    </table>
        <br><br>
</p>