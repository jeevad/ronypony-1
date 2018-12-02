<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link
            href="http://fonts.googleapis.com/css?family=Roboto:400,300,500,700,400italic,900"
            rel="stylesheet" type="text/css">
</head>
<body bgcolor="#eaeaea"
      style="margin: 0; font-family: Arial, Helvetica, sans-serif; color: #444444; padding: 0;">
<table bgcolor="#eaeaea"
       style="width: 100%; padding: 0; border: 0; font-family: Arial, Helvetica, sans-serif;">
    <tr>
        <td>
            <table bgcolor="#2e2e2e" style="padding: 0; border: 0; width: 100%;">
                <tr>
                    <td></td>
                    <td
                            style="padding: 28px 0; clear: both; display: block; margin: 0 auto; max-width: 600px;">
                        <div
                                style="display: block; margin: 0 auto; max-width: 600px; padding: 15px;">
                            <table style="padding: 0; border: 0; width: 100%;">
                                <tr>
                                    <td style="text-align: center"><a href="{{ config('app.url') }}" target="_blank">
                                            <img
                                                    alt="{{ config('app.name') }}"
                                                    src="{{ asset('images/logo.png') }}"
                                                    style="max-width: 100%; border: 0;">
                                        </a></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>
            <table style="padding: 0; border: 0; width: 100%;">
                <tr>
                    <td></td>
                    <td class="container"
                        style="clear: both; display: block; margin: 0 auto; max-width: 600px;">
                        <div
                                style="display: block; margin: 0 auto; max-width: 600px; padding: 15px;">
                            <table style="padding: 0; border: 0; width: 100%;">
                                <tr>
                                    <td>
                                        <h3
                                                style="margin: 10px 0; font-size: 34px; color: #808080; font-weight: bold; text-align: center; line-height: 40px;">
                                            Thank you for signing up!</h3>

                                        <div
                                                style="display: block; margin: 0 auto; max-width: 600px; padding: 15px;">
                                            <div
                                                    style="box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1), 0 0 0 #eaeaea; padding: 20px 15px 40px; background-color: #fff; border-radius: 4px; margin-bottom: 2px; text-align: center;">
                                                <h3
                                                        style="text-align: center; font-size: 22px; font-weight: normal;">
                                                    Your account is almost ready</h3>

                                                <a href="{{ $action }}" target="_blank"
                                                   style="background-color: #046dd1;background-image: linear-gradient(to bottom, #0980f3 0%, #046dd1 100%);border: 1px solid #046dd1;border-radius: 3px;color: #fff;font-weight: bold;padding: 8px 30px;text-align: center;text-decoration: none;width: auto; text-transform:uppercase; font-size:14px; display:inline-block;">
                                                    Confirm
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>



