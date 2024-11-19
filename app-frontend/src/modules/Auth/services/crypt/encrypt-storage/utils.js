import { AES, Rabbit, RC4, RC4Drop, enc } from 'crypto-js';
export function getEncriptation(encAlgorithm, secretKey) {
    const algorithms = {
        AES,
        Rabbit,
        RC4,
        RC4Drop,
    };
    return {
        encrypt: (value) => {
            return algorithms[encAlgorithm].encrypt(value, secretKey).toString();
        },
        decrypt: (value) => {
            return algorithms[encAlgorithm]
                .decrypt(value, secretKey)
                .toString(enc.Utf8);
        },
    };
}
