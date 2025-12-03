<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Atur Ulang Password</title>
    <style>
        /* Variabel Warna Disesuaikan ke Skema Hijau Paroki */
        :root {
            --primary-color: #4CAF50; /* Warna Hijau Paroki */
            --danger-color: #d9534f;
            --light-primary: #eaf8ea;
            --border-primary: #a5d6a7;
        }
        
        /* Style dasar */
        body {
            background-color: #f0f0f0; 
            margin: 0; 
            padding: 0;
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Style untuk merapikan struktur email di tengah */
        .container {
            max-width: 600px; /* Lebar email lebih standar */
            margin: 20px auto;
            padding: 20px;
            text-align: left;
            background-color: #ffffff; /* Latar belakang body email putih */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
        }

        .header h2 {
            color: #333;
            font-size: 24px;
        }

        .message {
            margin-top: 25px;
            line-height: 1.6;
            color: #333;
        }

        /* Style untuk tombol CTA */
        .cta-link {
            display: inline-block;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }
        
        /* Box kustom untuk menyorot link mentah */
        .link-box {
            margin: 20px 0;
            padding: 15px;
            background-color: var(--light-primary);
            border-left: 5px solid var(--border-primary);
            border-radius: 4px;
        }
        
        .link-text {
            font-size: 0.9em; 
            color: #555; 
            word-break: break-all;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
            font-size: 0.9em;
            color: #777;
        }

        .warning {
            color: var(--danger-color);
            font-weight: bold;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid var(--danger-color);
            background-color: #fcebeb;
            border-radius: 4px;
            font-size: 0.95em;
        }
        
        /* Untuk memastikan link di email tidak berubah warna default */
        a {
            color: var(--primary-color);
            text-decoration: none;
        }
    </style>
</head>

<body style="background-color: #f0f0f0; margin: 0; padding: 0;">
    <div class="container">
        
        <div class="header">
            <h2>Permintaan Atur Ulang Password</h2>
        </div>

        <div class="message">
            {{-- Menggunakan properti $data dari Mailable --}}
            <p>Yth. Saudara/i <strong>{{ $data->name ?? 'Pengguna' }}</strong>,</p>

            <p>Kami menerima permintaan untuk mengatur ulang (reset) password akun Anda yang terdaftar dengan email **{{ $data->email ?? 'N/A' }}**.</p>

            <p>Untuk melanjutkan proses ini, silakan klik tombol di bawah ini. Anda akan diarahkan ke halaman untuk memasukkan password baru:</p>

            {{-- Tombol CTA untuk reset password --}}
            <p style="text-align: center;">
                {{-- MENGGUNAKAN URL HARDCODED + VARIABEL $data->{'code-password'} --}}
                <a href="{{ url('/user/reset-password/' . $data->{'code-password'}) }}" 
                    class="cta-link" 
                    style="color: white; text-decoration: none;">
                    ATUR ULANG PASSWORD
                </a>
            </p>
            
            <p style="margin-top: 15px;">Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan tautan berikut di browser Anda:</p>
            
            {{-- Box untuk menampilkan link mentah --}}
            <div class="link-box">
                <p class="link-text">
                    {{-- MENGGUNAKAN URL HARDCODED + VARIABEL $data->{'code-password'} --}}
                    <a href="{{ url('/user/reset-password/' . $data->{'code-password'}) }}" style="color: #4CAF50;">
                        {{ url('/user/reset-password/' . $data->{'code-password'}) }}
                    </a>
                </p>
            </div>
            
            <p style="margin-top: 25px;">Jika Anda **tidak** mengajukan permintaan ini, mohon segera abaikan email ini dan pastikan Anda tidak membagikan informasi akun Anda.</p>
            
            <div class="warning">
                <strong>Peringatan Keamanan:</strong> Tautan ini hanya berlaku untuk waktu yang singkat dan hanya dapat digunakan **satu kali**. Setelah digunakan atau kadaluarsa, Anda harus meminta tautan baru.
            </div>

        </div>

        <div class="footer">
            <p>Demikian informasi ini kami sampaikan. Kami berkomitmen menjaga keamanan data Anda.</p>
            <p>Hormat kami,</p>
            <p><strong>Tim Administrasi Paroki Santa Melania</strong></p>

            <p style="margin-top: 10px; font-size: 0.85em;">
                Untuk kendala atau informasi lebih lanjut, silakan hubungi kami:<br>
                <strong>Email:</strong> <a href="mailto:parokimelaniabdg@gmail.com" style="color: #4CAF50;">parokimelaniabdg@gmail.com</a><br>
                <strong>WhatsApp:</strong> <a href="[https://wa.me/6281321272634](https://wa.me/6281321272634)" style="color: #4CAF50;">+62 813-2127-2634</a>
            </p>
        </div>
    </div>
</body>

</html>