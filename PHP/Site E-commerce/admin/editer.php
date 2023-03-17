<?php
require_once '../config/auth.php';
if(!connected()) {
    header('Location: ../mysite/connexion.php');
    exit();
};
    $lastname = $_SESSION['lastname'];
    $name = $_SESSION['name'];
    $birthday = $_SESSION['birthday'];
    $phone_number = $_SESSION['phone_number'];
    $mail = $_SESSION['mail'];

require_once("../config/commandes.php");

if(!isset($_GET['id'])){
    header("Location: afficher.php");
}

if(empty($_GET['id']) OR !is_numeric($_GET['id'])){
    header("Location: afficher.php");
}

if(isset($_GET['id'])){
    
    if(!empty($_GET['id']) OR is_numeric($_GET['id']))
    {
        $id = $_GET['id'];
        $items = afficherUnProduit($id);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	<title></title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <a class="navbar-brand" href="../">Couwhainesihh</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="../admin/afficher.php">Produits</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" aria-current="page" href="../admin/">Nouveau</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="supprimer.php">Suppression</a>
            </li>

            <li class="nav-item">
            <a class="nav-link active" style="font-weight: bold; color: green" href="" >Modification</a>
            </li>
            
        </ul>
        <div style="margin-right: 500px">
        <h5 style="color: #545659; opacity: 0.5;">Connecté en tant que: <?= $name ?></h5>
        </div>
        <a class="btn btn-danger d-flex" style="display: flex; justify-content: flex-end;" href="destroy.php">Se deconnecter</a>
        </div>
    </div>
    </nav>

    <div class="album py-5 bg-light">
        <div class="container">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

<?php foreach ($items as $item): ?>
        
    <form method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">L'image du produit</label>
        <input type="name" class="form-control" name="image" value="<?= $item->image ?>" required>

    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Nom du produit</label>
        <input type="text" class="form-control" name="name" value="<?= $item->name ?>"  required>

    </div>
        <label for="exampleInputPassword1" class="form-label">Categorie du produit</label>
        <input type="text" class="form-control" name="category" value="<?= $item->category ?>"  required>
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Prix</label>
        <input type="number" class="form-control" name="price" value="<?= $item->price ?>" required>
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Stock</label>
        <input type="number" class="form-control" name="stock" value="<?= $item->stock ?>" required>
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Description</label>
        <textarea class="form-control" name="description" required><?= $item->description ?></textarea>
    </div>

    <button type="submit" name="valider" class="btn btn-success">Enregistrer</button>
    </form>

    <?php endforeach; ?>

</div></div></div>

    
</body>
</html>

<?php

    if(isset($_POST['valider']))
    {
        if(isset($_POST['image']) AND isset($_POST['name']) AND isset($_POST['category']) AND isset($_POST['price']) AND isset($_POST['stock']) AND isset($_POST['description']))
        {
        if(!empty($_POST['image']) AND !empty($_POST['name']) AND !empty($_POST['category']) AND !empty($_POST['price']) AND !empty($_POST['stock']) AND !empty($_POST['description']))
            {
                $image = htmlspecialchars(strip_tags($_POST['image']));
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $category = htmlspecialchars(strip_tags($_POST['category']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $stock = htmlspecialchars(strip_tags($_POST['stock']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
            
                if(isset($_GET['id'])){
    
                    if(!empty($_GET['id']) OR is_numeric($_GET['id']))
                    {
                        $id = $_GET['id'];
                    }
                }

            try 
            {
                modifier($name, $image, $price, $description, $stock, $category, $id);
                header('Location: afficher.php');
            } 
            catch (Exception $e) 
            {
                $e->getMessage();
            }

            }
        }
    }

?>