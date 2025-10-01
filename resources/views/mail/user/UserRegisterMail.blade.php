<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à Agilize AI</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f5f5f5;">

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 30px 15px;">
                <table role="presentation" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 10px; overflow:hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">

                    <!-- Cabeçalho -->
                    <tr>
                        <td align="center" style="background-color:#4F46E5; padding: 30px;">
                            <h1 style="margin:0; color:#ffffff; font-size: 26px;">Seja bem-vindo, {{ $user->nome }}!</h1>
                        </td>
                    </tr>

                    <!-- Corpo -->
                    <tr>
                        <td style="padding: 30px; color:#333333; line-height:1.6; font-size:16px;">
                            <p>Olá <strong>{{ $user->nome }}</strong>,</p>
                            <p>É um prazer ter você conosco na <strong>Agilize AI</strong>! 🎉</p>
                            <p>Agora você tem acesso a uma plataforma que vai facilitar sua rotina, trazendo mais agilidade e praticidade.</p>
                            <p>Estamos muito felizes em ter você na nossa comunidade!</p>
                        </td>
                    </tr>

                    <!-- Botão CTA -->
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <a href="{{ url('/') }}"
                               style="background-color:#4F46E5; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:6px; font-size:16px; display:inline-block;">
                                Acessar a plataforma
                            </a>
                        </td>
                    </tr>

                    <!-- Rodapé -->
                    <tr>
                        <td align="center" style="background-color:#f9f9f9; padding: 20px; font-size:13px; color:#777777;">
                            <p style="margin:0;">&copy; {{ date('Y') }} Agilize AI. Todos os direitos reservados.</p>
                            <p style="margin:5px 0;">Este e-mail foi enviado automaticamente, não responda.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
