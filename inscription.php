<?php



include_once('utils/utils.php');

$message="";
$prenom="";
$nom="";
$email="";
$password="";

if(isset($_POST['submit'])){
   if(!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['mot_de_passe'])){
               if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                            if(mb_strlen($_POST['mot_de_passe'],'UTF-8')>= 12){



$prenom = trim($_POST['prenom']);
$nom = trim($_POST['nom']);
$email = trim($_POST['email']);
$password = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
                            
                            
                            try{
                                $pdo= new PDO('mysql:host=localhost;dbname=ludotheque','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                                $request = $pdo->prepare('SELECT m.prenom, m.nom, m.email FROM membre m WHERE m.email = ?');
                                $request->bindParam(1,$email,PDO::PARAM_STR);
                                $request->execute();
                                $data = $request->fetch(PDO::FETCH_ASSOC);
                                  if(empty($data)){
                                    $request = $pdo->prepare('INSERT INTO membre (prenom, nom, email, mot_de_passe) VALUES(?, ?, ?, ?)');
                                                    $request->bindParam(1,$prenom,PDO::PARAM_STR);
                                                    $request->bindParam(2,$nom,PDO::PARAM_STR);
                                                    $request->bindParam(3,$email,PDO::PARAM_STR);
                                                    $request->bindParam(4,$password,PDO::PARAM_STR);
                                                     $request->execute();
                                
                                                      $message = "L'utilisateur a été enregistré :  {$prenom} {$nom} - {$email}";
                            
                            
                                  }else{
                                    $message = "Cette email est déjà utilisé par un autre compte.";
                                       }
                            }catch(EXCEPTION $error){
                                                die($error->getMessage());
                                            }
                            }else{
                              $message = "Votre mot de passe doit faire au moins 12 caractères.";
                              }
               }else{
                 $message = "Votre email n'est pas au bon format.";
                   }
   }else{
     $message = "Veuillez remplir tous les champs du formulaire.";
    }
}

include('includes/header.php');

?>


     <main>
        <?php if(!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

        <form action="" method="post">
    <label for="prenom">prenom<input type="text" name="prenom" ></label>
    <label for="nom">nom<input type="text" name="nom" ></label>
    <label for="email">email<input type="text" name="email"></label>
    <label for="mot_de_passe">mot de passe<input type="password" name="mot_de_passe"></label>
    <input type="submit" name="submit">
  </form>
  </main>

  <?php 
include('includes/footer.php'); 
?>

