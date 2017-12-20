<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Reset Your Password</h2>

        <div>
            Hello {{$username}},<br>
            This is <b>Todo yo~</b>. Don't worry, we will help you to reset your password.<br>
            Please follow the link below to reset
            {{ URL::to('password/reset/' . $token . '_email_verify') }}.<br/>

        </div>

        <br><hr><br>
        
        <div>
            Respectfully,<br>
            ervice@todoyo.com
        </div>
    </body>
</html>