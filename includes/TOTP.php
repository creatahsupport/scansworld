<?php
class TOTP {
    public static function generateSecret($length = 16) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= $chars[rand(0, 31)];
        }
        return $secret;
    }

    public static function getCode($secret, $timeSlice = null) {
        if ($timeSlice === null) {
            $timeSlice = floor(time() / 30);
        }

        $secretKey = self::_base32Decode($secret);
        $time = pack('N*', 0) . pack('N*', $timeSlice);
        $hmac = hash_hmac('sha1', $time, $secretKey, true);
        $offset = ord(substr($hmac, -1)) & 0x0F;
        $hashpart = substr($hmac, $offset, 4);
        $value = unpack('N', $hashpart);
        $value = $value[1];
        $value = $value & 0x7FFFFFFF;

        return str_pad($value % 1000000, 6, '0', STR_PAD_LEFT);
    }

    public static function verifyCode($secret, $code, $discrepancy = 1) {
        $currentTimeSlice = floor(time() / 30);
        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $calculatedCode = self::getCode($secret, $currentTimeSlice + $i);
            if ($calculatedCode == $code) {
                return true;
            }
        }
        return false;
    }

    public static function getQRCodeGoogleUrl($name, $secret, $title = null) {
        $url = 'otpauth://totp/' . urlencode($name) . '?secret=' . $secret;
        if ($title) {
            $url .= '&issuer=' . urlencode($title);
        }
        return "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($url) . "&size=200x200";
    }

    private static function _base32Decode($secret) {
        if (empty($secret)) return '';
        $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $base32charsFlipped = array_flip(str_split($base32chars));
        $output = '';
        $v = 0;
        $vbits = 0;
        for ($i = 0; $i < strlen($secret); $i++) {
            $v <<= 5;
            $v += $base32charsFlipped[$secret[$i]];
            $vbits += 5;
            if ($vbits >= 8) {
                $vbits -= 8;
                $output .= chr(($v >> $vbits) & 0xFF);
            }
        }
        return $output;
    }
}
