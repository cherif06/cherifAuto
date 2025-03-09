<footer>
    <div class="footer">
        <div class="texte">
            <h1>Nous contacter</h1>
            <p>
                Si vous avez une question a nous poser ou bien une 
                proposition a faire n’hesitez pas a nous contacter.
                Nous sommes disponibles 7j/7.
            </p>
            <p>Numero : +221 33 333 33 33</p>
        </div>
        <div class="form">
            <form action="traitement_message.php" method="post" >
                <?php if(!$_SESSION['LOGGED']) :?>
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom"><br>
                    <label for="email">Email :</label>
                    <input type="text" name="email"><br>
                <?php endif; ?>
                <textarea type="text" name="mess" placeholder="Message"></textarea><br>
                <button name="question" type="submit">Envoyer</button>
            </form>
        </div>
    </div>
    <p>copyright © 2025 Cherif Bakhoum.Tout droits reservés</p>
</footer>