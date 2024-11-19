import {InvalidSecretKeyError} from './errors';
import {getEncriptation} from './utils';

const secret = new WeakMap();
/**
 * EncryptStorage provides a wrapper implementation of `localStorage` and `sessionStorage` for a better security solution in browser data store
 *
 * @param {string} secretKey - A secret to encrypt data must be contain min of 10 characters
 * @param {EncrytStorageOptions} options - A optional settings to set encryptData or select `sessionStorage` to browser storage
 */
export class EncryptStorage {
    constructor(secretKey, options) {
        if (secretKey.length < 10) {
            throw new InvalidSecretKeyError();
        }
        secret.set(this, secretKey);
        this.storage = window[(options === null || options === void 0 ? void 0 : options.storageType) || 'localStorage'];
        this.prefix = (options === null || options === void 0 ? void 0 : options.prefix) || '';
        this.stateManagementUse = (options === null || options === void 0 ? void 0 : options.stateManagementUse) || false;
        this.encriptation = getEncriptation((options === null || options === void 0 ? void 0 : options.encAlgorithm) || 'AES', secret.get(this));
    }
    getKey(key) {
        return this.prefix ? `${this.prefix}:${key}` : key;
    }
    get length() {
        return this.storage.length;
    }
    setItem(key, value) {
        const storageKey = this.getKey(key);
        const valueToString = typeof value === 'object' ? JSON.stringify(value) : String(value);
        const encryptedValue = this.encriptation.encrypt(valueToString);
        this.storage.setItem(storageKey, encryptedValue);
    }
    getItem(key) {
        const storageKey = this.getKey(key);
        const item = this.storage.getItem(storageKey);
        if (item) {
            const decryptedValue = this.encriptation.decrypt(item);
            if (this.stateManagementUse) {
                return decryptedValue;
            }
            try {
                return JSON.parse(decryptedValue);
            }
            catch (error) {
                return decryptedValue;
            }
        }
        return undefined;
    }
    removeItem(key) {
        const storageKey = this.getKey(key);
        this.storage.removeItem(storageKey);
    }
    removeItemFromPattern(pattern, options = {}) {
        const { exact = false } = options;
        const storageKeys = Object.keys(this.storage);
        const filteredKeys = storageKeys.filter(key => {
            if (exact) {
                return key === this.getKey(pattern);
            }
            if (this.prefix) {
                return key.includes(pattern) && key.includes(this.prefix);
            }
            return key.includes(pattern);
        });
        filteredKeys.forEach(key => {
            this.storage.removeItem(key);
        });
    }
    getItemFromPattern(pattern, options = {}) {
        const { multiple = true, exact = false } = options;
        const keys = Object.keys(this.storage).filter(key => {
            if (exact) {
                return key === this.getKey(pattern);
            }
            if (this.prefix) {
                return key.includes(pattern) && key.includes(this.prefix);
            }
            return key.includes(pattern);
        });
        if (!keys.length) {
            return undefined;
        }
        if (!multiple) {
            const [key] = keys;
            const formattedKey = this.prefix
                ? key.replace(`${this.prefix}:`, '')
                : key;
            return this.getItem(formattedKey);
        }
      return keys.reduce((accumulator, key) => {
          const formattedKey = this.prefix
            ? key.replace(`${this.prefix}:`, '')
            : key;
          accumulator[formattedKey] = this.getItem(formattedKey);
          return accumulator;
        }, {});
    }
    clear() {
        this.storage.clear();
    }
    key(index) {
        return this.storage.key(index);
    }
    encryptString(str) {
      return this.encriptation.encrypt(str);
    }
    decryptString(str) {
      return this.encriptation.decrypt(str);
    }
}
export default EncryptStorage;
