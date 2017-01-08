<?php
include_once 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';
include 'config.php';
$server_name = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL);
/* Setup swiftmailer using your email server information */
if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
    $transport = Swift_SmtpTransport::newInstance(EMAIL_HOST, EMAIL_PORT); // 25 for remote server 587 for localhost:
} else {
    $transport = Swift_SmtpTransport::newInstance(EMAIL_HOST, 25);
}

$transport->setUsername(EMAIL_USERNAME);
$transport->setPassword(EMAIL_PASSWORD);

/* Setup To, From, Subject and Message */
$message = Swift_Message::newInstance();

$submit = htmlspecialchars($_POST['submit']);
if (isset($submit) && $submit === "submit") {

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $subject = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email_from = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    /* Person or people to send email to */
    $message->setTo([
        'jrpepp@pepster.com' => 'John R. Pepp',
        'pepster@pepster.com' => 'John Pepp',
        'jrpepp2014@jrpepp.com' => 'Johnny Pepp'
    ]);

    $message->setSubject($subject); // Subject:
    $message->setBody($comments); // Message:
    $message->setFrom($email_from, $name); // From and Name:

    $mailer = Swift_Mailer::newInstance($transport); // Setting up mailer using transport info that was provided:
    $result = $mailer->send($message, $failedRecipients);

    if ($result) {
        header("Location: email.php");
        exit();
    } else {
        echo "<pre>" . print_r($failedRecipients, 1) . "</pre>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Email Demo</title>
        <link rel="stylesheet" href="lib/css/reset.css">
        <link rel="stylesheet" href="lib/css/grids.css">
        <link rel="stylesheet" href="lib/css/emailstyle.css">
    </head>
    <body>
        <form id="contact"  class="container" action="email.php" method="post"  autocomplete="on">

            <fieldset>

                <legend><?php echo (isset($errMessage)) ? $errMessage : 'Contact Details'; ?></legend>

                <label for="name" accesskey="U">Your Name</label>
                <input name="name" type="text" id="name" placeholder="Enter your name" required="required" />

                <label for="email" accesskey="E">Email</label>
                <input name="email" type="email" id="email" placeholder="Enter your Email Address"  required="required" />

                <label for="phone" accesskey="P">Phone <small>(optional)</small></label>
                <input name="phone" type="tel" id="phone" size="30" placeholder="Enter your phone number" />

                <label for="website" accesskey="W">Website <small>(optional)</small></label>
                <input name="website" type="text" id="website" placeholder="Enter your website address" />

            </fieldset>

            <fieldset>

                <legend>Your Comments</legend>

                <div class="radioBlock">
                    <input type="radio" id="radio1" name="reason" value="support" checked>
                    <label class="radioStyle" for="radio1">support</label>
                    <input type="radio" id="radio2" name="reason" value="advertise">
                    <label class="radioStyle" for="radio2">advertise</label>  
                    <input type="radio" id="radio3" name="reason" value="error">
                    <label class="radioStyle" for="radio3">Report a Bug</label>    
                </div>

                <label class="textBox" for="comments">Comments</label>
                <textarea name="comments" id="comments" placeholder="Enter your comments" spellcheck="true" required="required"></textarea>             

            </fieldset>

            <input type="submit" name="submit" value="submit">

        </form>
    </body>
</html>
