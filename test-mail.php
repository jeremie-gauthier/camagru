<?PHP
$sender = "camagru.jergauth.42@gmail.com";
$recipient = "jeremiegthr@gmail.com";

$subject = "php mail test";
$message = "php test message";
$headers = [
  'From' => $sender,
  'Reply-To' => $sender,
  'MIME-Version' => '1.0',
  'Content-Type' => 'text/html;'
];

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
    echo "Error: Message not accepted";
}
?>