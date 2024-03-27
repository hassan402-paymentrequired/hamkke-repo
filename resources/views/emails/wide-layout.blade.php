<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        span {
            font-weight: 600;
        }

        .other-txt {
            text-align: left !important;
        }

        .other-cnt {
            width: 80% !important;
        }

        @media screen and (max-width: 600px) {
            .img-max {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            .max-width {
                max-width: 100% !important;
            }

            .mobile-wrapper {
                width: 85% !important;
                max-width: 85% !important;
            }

            .mobile-padding {
                padding-left: 5% !important;
                padding-right: 5% !important;
            }

            .top-bg {
                padding-top: 20px !important;
            }

            .logo {
                width: 250px !important;
            }

            .headline {
                height: 80px !important;
            }

            .headline h2 {
                padding-top: 20px !important;
                font-size: 20px !important;
                font-weight: 500 !important;
            }

            .icon {
                margin: 15px 0 !important;
                height: auto !important;
            }

            .main-icon {
                width: 60px !important;
            }

            .main-txt table {
                width: 100% !important;
                font-size: 13px !important;
            }

            .main-txt h2 {
                font-size: 16px !important;
                padding-bottom: 10px !important;
                line-height: 24px !important;
            }

            .main-txt h2 br {
                display: none;
            }

            .main-txt p {
                font-size: 14px !important;
                line-height: 1.5 !important;
            }

            .main-txt p br {
                display: none;
            }

            .btn {
                font-size: 14px !important;
                padding: 10px 42px !important;
            }

            .other-txt {
                font-size: 12px !important;
                margin-bottom: 0 !important;
            }

            .download img {
                width: 120px !important;
            }

            .bottom-txt {
                font-size: 12px !important;
            }

            .bottom-txt br {
                display: none;
            }

            .t-table {
                width: 100% !important;
                font-size: 14px !important;
            }

            .other-tb {
                width: 100% !important;
            }
        }

        @media screen and (max-width: 375px) {
            .logo {
                width: 200px !important;
            }

            .headline {
                height: 60px !important;
            }

            .headline h2 {
                padding-top: 15px !important;
                font-size: 20px !important;
                font-weight: 500 !important;
            }

            .icon {
                margin: 0 auto !important;
                height: auto !important;
            }

            .main-icon {
                width: 50px !important;
            }

            .main-txt h2 {
                font-size: 14px !important;
                padding: 10px 0 !important;
                line-height: 1.5 !important;
            }

            .main-txt h2 br {
                display: none;
            }

            .main-txt p {
                font-size: 12px !important;
                line-height: 1.5 !important;
                margin-bottom: 0 !important;
            }

            .btn {
                font-size: 12px !important;
                padding: 12px 25px !important;
            }

            .download img {
                width: 120px !important;
            }

            .main-txt .greetings {
                padding-bottom: 0 !important;
            }

            .t-table {
                width: 100% !important;
                font-size: 13px !important;
            }

            .other-tb {
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="!important background-color: #f4f4f4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; height: 100% !important; margin: 0; padding: 0; width: 100% !important;"
      bgcolor="#F4f4f4">
<!-- HIDDEN PREHEADER TEXT -->
<div style="color: #fefefe; display: none; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
    {{ config('app.name') }}
</div>
<table
    border="0"
    cellpadding="0"
    cellspacing="0"
    class="main"
    width="100%"
    style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin: auto !important;">
    <tbody>
    <tr>
        <td
            align="center"
            valign="top"
            width="100%"
            background="images/bg.jpg"
            bgcolor="#F4F4F4"
            style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f4f4f4;  mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 35px 20px 0;"
            class="mobile-padding top-bg">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600"> <![endif]-->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                   style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse !important; max-width: 800px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                <tbody>
                <tr>
                    <td align="center" valign="top"
                        style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 10px 0 30px;">
                        <img src="{{ asset('images/logo.jpeg') }}" border="0" class="logo"
                             style="-ms-interpolation-mode: bicubic; border: 0; display: block; height: auto; line-height: 100%; outline: none; text-decoration: none; width: 300px;">
                    </td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#ffffff"
                        style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-radius: 10px 10px 0 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"></td>
                </tr>
                </tbody>
            </table>
            <!--[if (gte mso 9)|(IE)]> </td> </tr> </table> <![endif]-->
        </td>
    </tr>
    <tr>
        <td align="center" height="100%" valign="top" width="100%" bgcolor="#f4f4f4"
            style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 0 20px 20px;"
            class="mobile-padding">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="800"> <![endif]-->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                   style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse !important; max-width: 800px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                <tbody>
                <tr>
                    <td align="center" valign="top"
                        style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-family: Open Sans, Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 0 0 25px;">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%"
                               style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                            <tbody>
                            <tr>
                                <td align="center" bgcolor="#ffffff"
                                    style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-radius: 0 0 10px 10px; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 25px;">
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                           style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                        <tbody>
                                        <tr></tr>
                                        <tr>
                                            <td align="center"
                                                style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 20px 0 15px;">
                                                <table border="0" cellspacing="0" cellpadding="0"
                                                       style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                       width="90%" class="other-tb">
                                                    <tbody>
                                                    <tr>
                                                        <td align="left" class="other-cnt">
                                                            {{-- Greeting --}}
                                                            @if (!empty($greeting))
                                                                <h2>{{ $greeting }}</h2>
                                                            @endif

                                                            @yield('content')
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--[if (gte mso 9)|(IE)]> </td> </tr> </table> <![endif]-->
        </td>
    </tr>
    <tr>
        <td align="center" height="100%" valign="top" width="100%" bgcolor="#f4f4f4"
            style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 0 15px 40px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600"> <![endif]-->
            <table id="promo" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <tr>
                    <td align="center" colspan="2">
                        <p style="color:#a2a2a2; font-size:13px; line-height:17px; font-style:italic; margin-top:10px; font-weight:400;"
                           class="bottom-txt">If you have received this communication in error, please delete this
                            <br>
                            mail and notify us immediately at
                            <a href="#" style="color: #4A90E2;">{{ config('app.contact.email') }}</a>.</p>
                    </td>
                </tr>
                </tbody>
            </table>

            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                   style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; border-collapse: collapse !important; max-width: 800px; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                <tbody>
                <tr>
                    <td align="center" valign="top"
                        style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #999999; font-family: Open Sans, Helvetica, Arial, sans-serif; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 0;">
                        <p style="font-size: 14px; line-height: 20px;">©  {{ date('Y')." ".config('app.name') }}</p>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--[if (gte mso 9)|(IE)]> </td> </tr> </table> <![endif]-->
        </td>
    </tr>
    </tbody>
</table>

</body>

</html>
