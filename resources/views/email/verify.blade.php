<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verify Your Email Address</h2>

        <div>
            Thanks for creating an account with the <b>Todo yo~</b><br>
            Please follow the link below to verify your email address
            {{ URL::to('register/verify/' . $confirmation_code . '_email_verify') }}.<br/>
        </div>

        <br><hr><br>
        
        <div>
            Respectfully,<br>
            ervice@todoyo.com
        </div>

    </body>
</html>