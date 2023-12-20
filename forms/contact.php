<?php
// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'cskillers123@gmail.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!empty($_POST['voornaam']) && !empty($_POST['naam']) && !empty($_POST['email']) &&
            !empty($_POST['adres']) && !empty($_POST['postcode']) && !empty($_POST['gemeente']) &&
            !empty($_POST['gsm']) && !empty($_POST['taal']) && !empty($_POST['periode']) &&
            isset($_POST['voorwaarden'])) {

            // Load PHP Email Form library
            if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
                include($php_email_form);
            } else {
                throw new Exception('Unable to load the "PHP Email Form" Library!');
            }

            // Create an instance of PHP_Email_Form
            $contact = new PHP_Email_Form;
            $contact->ajax = true;

            $contact->to = $receiving_email_address;
            $contact->from_name = $_POST['voornaam'] . ' ' . $_POST['naam'];
            $contact->from_email = $_POST['email'];
            $contact->subject = 'Inschrijving';

            $contact->add_message($_POST['voornaam'] . ' ' . $_POST['naam'], 'Naam');
            $contact->add_message($_POST['email'], 'Email');
            $contact->add_message($_POST['adres'], 'Adres');
            $contact->add_message($_POST['postcode'] . ' ' . $_POST['gemeente'], 'Postcode en Gemeente');
            $contact->add_message($_POST['gsm'], 'GSM');
            $contact->add_message($_POST['taal'], 'Taal');
            $contact->add_message($_POST['periode'], 'Periode');
            $contact->add_message($_POST['vragen'], 'Vragen of Opmerkingen');

            if (isset($_POST['factuur'])) {
                $contact->add_message('Ja', 'Factuur');
            } else {
                $contact->add_message('Nee', 'Factuur');
            }

            // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
            /*
            $contact->smtp = array(
                'host' => 'example.com',
                'username' => 'example',
                'password' => 'pass',
                'port' => '587'
            );
            */

            // Send the email
            $result = $contact->send();

            // Output success or failure message
            if ($result === 'OK') {
                echo 'success'; // You can customize this success message
            } else {
                throw new Exception('Form submission failed. ' . $result);
            }
        } else {
            throw new Exception('Invalid form data. Please fill in all required fields.');
        }
    } catch (Exception $e) {
        echo 'error: ' . $e->getMessage(); // You can customize this error message
    }
} else {
    header('Location: /'); // Redirect if accessed directly
    exit();
}
?>
