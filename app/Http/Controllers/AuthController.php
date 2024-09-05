<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use ParagonIE\Paseto\Keys\AsymmetricSecretKey;
use ParagonIE\Paseto\Builder;
use ParagonIE\Paseto\Protocol\Version4;
use ParagonIE\Paseto\Purpose;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input login (email dan password)
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            // Ambil kunci privat dari .env dan decode
            $privateKeyEncoded = env('PASETO_PRIVATE_KEY');
            if (!$privateKeyEncoded) {
                return response()->json(['error' => 'Private key not found'], 500);
            }

            try {
                // Decode kunci privat
                $privateKey = AsymmetricSecretKey::fromEncodedString($privateKeyEncoded);

                // Buat token PASETO
                $token = (new Builder())
                    ->setVersion(new Version4())
                    ->setPurpose(Purpose::public())
                    ->setKey($privateKey)
                    ->setIssuer('your-app-name')
                    ->setAudience('your-app-users')
                    ->setSubject($user->id) // Masukkan ID pengguna sebagai subjek token
                    ->setExpiration(new \DateTimeImmutable('+18 hour'))
                    ->toString();

                // Kembalikan token ke frontend
                return response()->json(['token' => $token]);
            }catch (\Exception $e) {
                return response()->json(['error' => 'Signing failed: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
