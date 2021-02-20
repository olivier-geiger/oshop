<div class="container my-4">

    <a href="<?= $router->generate( 'user-list' ) ?>" class="btn btn-success float-right">
        Retour
    </a>

    <h2>Ajouter un utilisateur</h2>
    
    <form action="<?= $router->generate( 'user-create' ) ?>" method="POST" class="mt-5">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname">
        </div>
        <div class="form-group">
            <label for="name">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname">
        </div>
        <div class="form-group">
            <label for="name">E-mail</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="name">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="name">Confirmation</label>
            <input type="password" class="form-control" id="confirm" name="confirm">
        </div>
        <div class="form-group">
            <label for="category">Status</label>
            <select class="custom-select" id="status" name="status">
                <option value="0">-</option>
                <option value="1">Actif</option>
                <option value="2">Désactivé</option>
            </select>
        </div>
        <div class="form-group">
            <label for="category">Role</label>
            <select class="custom-select" id="status" name="status">
                <option value="0">-</option>
                <option value="1">admin</option>
                <option value="2">catalog-manager</option>
            </select>
        </div>
        
        <input type="hidden" name="token" value="#" />
        <button type="submit" class="btn btn-primary btn-block mt-5">
            Valider
        </button>
    </form>
</div>