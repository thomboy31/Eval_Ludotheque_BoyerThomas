<?php


include_once('utils/utils.php');

if(isset($_POST['submitCo'])){
    if(!empty($_POST['emailCo']) && !empty($_POST['passwordCo'])){
        if(filter_var($_POST['emailCo'],FILTER_VALIDATE_EMAIL)){
            $email = trim($_POST['emailCo']);
             try{
                $pdo = new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                $request = $pdo->prepare('SELECT m.id_membre, m.prenom, m.nom, m.email, m.mot_de_passe, m.date_inscription FROM membre m WHERE m.email = ?');
                 $request->bindParam(1,$email,PDO::PARAM_STR);
                 $request->execute();
                 $data = $request->fetch(PDO::FETCH_ASSOC);
                     if(!empty($data)){
                         if(password_verify($_POST['passwordCo'],$data["mot_de_passe"])){
                
                        $_SESSION['id'] = $data['id_membre'];
                        $_SESSION['nom'] = $data['nom'];
                        $_SESSION['prenom'] = $data['prenom'];
                        $_SESSION['email'] = $data['email'];
                        $_SESSION['date_inscription'] = $data['date_inscription'];
                    
                    $messageCo = "{$_SESSION['prenom']} {$_SESSION['nom']} est bien connecté !";
                        header('Location: index.php');
                        exit();
                    }else{
                         $messageCo = "Email et/ou Mot de Passe incorrect.";
                      }

                }else{
                    $messageCo = "Email et/ou Mot de Passe incorrect.";
                }
                }catch(EXCEPTION $error){
                   die($error->getMessage());
                  }
                   }else{
                       $messageCo = 'Vous devez entrer un email valide';
        }
                        }else{
                             $messageCo = 'Veuillez remplir tous les champs';
    }
}

include('includes/header.php');

?>

     <main>
        <?php if(!empty($messageCo)): ?>
        <p><?php echo htmlspecialchars($messageCo); ?></p>
    <?php endif; ?>

        <form action="" method="post">
    <label for="email">email<input type="text" name="emailCo" id="email"></label>
    <label for="mot_de_passe">mot de passe<input type="passwordCo" name="password" id="password"></label>
    <input type="submit" name="submitco">
  </form>
  </main>  

<?php 
include('includes/footer.php'); 
?>
