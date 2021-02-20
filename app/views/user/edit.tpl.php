<div class="container my-4">

    <a href="<?= $router->generate( 'user-list' ) ?>" class="btn btn-success float-right">
        Retour
    </a>

    <h2>Modifier des utilisateurs</h2>
    <form action="<?= $router->generate( 'user-update', [ "id" => $user->getId() ] ) ?>" method="POST" class="mt-5">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $user->getfirstname(); ?>" placeholder="Nom de l'utilisateur">
        </div>
        <div class="form-group">
            <label for="name">Prenom</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $user->getLastname(); ?>" placeholder="Prénom de l'utilisateur">
        </div>
        <div class="form-group">
            <label for="subtitle">Rôle</label>
            <select  class="custom-select" id="brand" name="brand_id" aria-describedby="brandHelpBlock" value="<?= $user->getRole() ?>">>
                <option value="1">admin</option>
                <option value="2">catalog-manager</option>
            </select>
            <small id="brandHelpBlock" class="form-text text-muted">
                Le rôle de la personne 
            </small>
        </div>

        <button type="submit" class="btn btn-primary btn-block mt-5">Ajouter</button>
    </form>
</div>