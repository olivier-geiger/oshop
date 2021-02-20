<div class="container my-4">

    <a href="<?= $router->generate( 'type-list' ) ?>" class="btn btn-success float-right">
        Retour
    </a>

    <h2>Ajouter un type</h2>
    
    <form action="<?= $router->generate( 'type-create' ) ?>" method="POST" class="mt-5">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nom du type">
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>