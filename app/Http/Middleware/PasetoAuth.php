<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use ParagonIE\Paseto\Protocol\Version4;
use ParagonIE\Paseto\Parser;
use ParagonIE\Paseto\Keys\AsymmetricPublicKey;
use ParagonIE\Paseto\Exception\PasetoException;
use ParagonIE\Paseto\Purpose;
use ParagonIE\Paseto\ProtocolCollection;

use Symfony\Component\HttpFoundation\Response;


class PasetoAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil token dari header Authorization (Bearer token)
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            // Ambil kunci publik yang di-encode dari .env
            $publicKeyEncoded = env('PASETO_PUBLIC_KEY');
            if (!$publicKeyEncoded) {
                return response()->json(['error' => 'Public key not found'], 500);
            }

            // Decode kunci publik
            $publicKey = AsymmetricPublicKey::fromEncodedString($publicKeyEncoded);

            // Buat koleksi protokol untuk memungkinkan hanya PASETO V4
            $protocols = ProtocolCollection::v4();

            // Parser untuk memverifikasi token
            $parser = (new Parser())
                ->setPurpose(Purpose::public()) // PASETO V4 adalah token publik
                ->setKey($publicKey)   // Kunci publik untuk verifikasi
                ->setAllowedVersions($protocols);

            // Memverifikasi dan memparse token
            $parsedToken = $parser->parse($token);

            // Ambil klaim dari token (misalnya user ID)
            $claims = $parsedToken->getClaims();
            $userId = $claims['sub']; // 'sub' biasanya menyimpan ID pengguna

            // Lanjutkan request jika token valid
            $request->attributes->set('userId', $userId); // Simpan user ID di request
            return $next($request);

        } catch (PasetoException $e) {
            // Token tidak valid atau gagal diverifikasi
            return response()->json(['error' => 'Invalid token: ' . $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
    }
}
