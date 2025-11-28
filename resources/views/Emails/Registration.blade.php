<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Registrasi</title>
    <style>
        /* Style untuk merapikan struktur email di tengah */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            text-align: left;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #4CAF50;
        }

        .message {
            margin-top: 20px;
            line-height: 1.6;
            color: #333;
        }

        .credentials-box {
            margin: 20px 0;
            padding: 15px;
            background-color: #e6ffe6;
            border-left: 5px solid #4CAF50;
            border-radius: 4px;
        }

        .cta-link {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
            font-size: 0.9em;
            color: #777;
        }

        .warning {
            color: #d9534f;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Informasi Akun Paroki Melania</h2>
        </div>

        <div class="message">
            {{-- Mengakses properti 'name' dari model $registration --}}
            <p>Yth. Saudara/i <strong>{{ $registration->name ?? $registration->email }}</strong>,</p>

            <p>Terima kasih telah melakukan registrasi pendaftaran Baptis / Katekumen. Berikut kami sampaikan
                informasi akun Anda:</p>

            <div class="credentials-box">
                <p>
                    <strong>Email (Username) :</strong> <code>{{ $registration->email }}</code>
                    <br>
                    {{-- Akses langsung variabel $password yang diteruskan dari Mailable --}}
                    <strong>Password :</strong> <code>{{ $password }}</code>
                </p>
            </div>

            <p class="warning">
                <strong>Waspada terhadap penipuan yang mengatasnamakan Paroki Melania. Informasi hanya
                    akan disampaikan oleh pihak Paroki Melania.</strong>
            </p>

            <p>Silakan login pada halaman berikut untuk melengkapi data dan memantau status pendaftaran Anda:</p>

            <a href="http://localhost:8000/user/login" class="cta-link" style="color: white; text-decoration: none;">
                LOGIN KE AKUN ANDA
            </a>

        </div>

        <div class="footer">
            <p>Demikian informasi ini kami sampaikan.</p>
            <p>Hormat kami,</p>
            <p><strong>Tim Administrasi Paroki Melania</strong></p>
        </div>
    </div>
</body>

</html>
