<?php


if($_SERVER["REQUEST_METHOD"] == "POST") {

    //twoje dane
    $email = 'admin@spedia.tk';

//dane z formularza
    $formName = $_POST['formName'];
    $formEmail = $_POST['formEmail'];
    $formText = $_POST['formText'];

    if(!empty($formName) && !empty($formEmail) && !empty($formText)) {

//--- początek funkcji weryfikującej adres e-mail ---
        function checkMail($checkmail) {
            if(filter_var($checkmail, FILTER_VALIDATE_EMAIL)) {
                if(checkdnsrr(array_pop(explode("@",$checkmail)),"MX")){
                    return true;
                }else{
                    return false;
                }
            } else {
                return false;
            }
        }
//--- koniec funkcji ---


        if(checkMail($formEmail)) {
            //dodatkowe informacje: ip i host użytkownika
            $ip = $_SERVER['REMOTE_ADDR'];
            $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);

            //tworzymy szkielet wiadomości
            //treść wiadomości
            $mailText = "Od: $formName, $formEmail /*($ip, $host)*/ \n Treść wiadomości: \n $formText ";

            //adres zwrotny
            $mailHeader = "From: $formName <$formEmail>";

            //funkcja odpowiedzialna za wysłanie e-maila
            @mail($email, ("Message from: $formEmail"), $mailText, $mailHeader) or die('Error: message not sent');

            //komunikat o poprawnym wysłaniu wiadomości
            echo 'Message sent';
        } else {
            echo 'E-mail adress is incorrect';
        }

    } else {
        //komunikat w przypadku nie powodzenia
        echo 'Please fill all fields';
    }
}
?>