<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP for Property Finder Registration</title>
</head>
<body>
    <p>Your OTP for Property Finder Registration is: <strong>{{ $code }}</strong></p>
    <p>Please use this OTP to verify your email address.</p>
</body>
</html>

{{--

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    style="font-family: system-ui, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"
    dir="rtl">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $sitting->title }}</title>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage"
    style="font-family: system-ui; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;"
    bgcolor="#f6f6f6">

    <table class="body-wrap"
        style="font-family: system-ui; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"
        bgcolor="#f6f6f6">
        <tr style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: system-ui; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
                valign="top"></td>
            <td class="container" width="600"
                style="font-family: system-ui; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
                valign="top">
                <div class="content"
                    style="font-family: system-ui; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0"
                        style="font-family: system-ui; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;"
                        bgcolor="#fff">
                        <tr style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class=""
                                style="font-family: system-ui; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; border-bottom: 1px solid #e8e8e8;font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;"
                                align="center" bgcolor="#71b6f9" valign="top">
                                <a href="#"> <img src="{{ url($sitting->icon) }}" height="100"
                                        alt="logo" /></a> <br />

                            </td>
                        </tr>
                        <tr style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-wrap"
                                style="font-family: system-ui; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                                valign="top">
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;text-align: center;">
                                    <tr
                                        style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block"
                                            style="font-family: system-ui; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                            valign="top">

                                        </td>
                                    </tr>

                                    <tr
                                        style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" dir="rtl"
                                            style="font-family: system-ui; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                            valign="top">

                                            {!! $content !!}

                                            <p>Your OTP for Property Finder Registration is: <strong>{{ $code }}</strong></p>

                                        </td>
                                    </tr>
                                    @if ($EmailTemplate['is_login'] == 1)
                                        <tr
                                            style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
                                            <td class="content-block"
                                                style="font-family: system-ui; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                                valign="top">
                                                <a href="{{ route('Admin.home') }}" class="btn-primary"
                                                    style="font-family: system-ui; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #002060; margin: 0; border-color: #002060; border-style: solid; border-width: 8px 16px;">
                                                    @lang('login')
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr
                                        style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block"
                                            style="font-family: system-ui; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: right;"
                                            valign="top">
                                            تحياتنا
                                            <br>
                                            {{ $sitting->title }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="footer"
                        style="font-family: system-ui; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                        <table width="100%"
                            style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <tr style="font-family: system-ui; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <td class="aligncenter content-block"
                                    style="font-family: system-ui; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                    align="center" valign="top">
                                    ©
                                    جميع الحقوق محفوظة لـ <strong>{{ $sitting->title }}</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td style="font-family: system-ui; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
                valign="top"></td>
        </tr>
    </table>
</body>

</html> --}}
