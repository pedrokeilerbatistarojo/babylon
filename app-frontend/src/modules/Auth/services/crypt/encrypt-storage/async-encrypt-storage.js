import { EncryptStorage } from './encrypt-storage';
export class AsyncEncryptStorage {
    constructor(secretKey, options) {
        this.encryptStorage = new EncryptStorage(secretKey, options);
    }
    get length() {
        return Promise.resolve(this.encryptStorage.length);
    }
    async setItem(key, value) {
        return new Promise(resolve => {
            resolve(this.encryptStorage.setItem(key, value));
        });
    }
    async getItem(key) {
        return new Promise(resolve => {
            const storageValue = this.encryptStorage.getItem(key);
            resolve(storageValue);
        });
    }
    async removeItem(key) {
        return new Promise(resolve => {
            resolve(this.encryptStorage.removeItem(key));
        });
    }
    async getItemFromPattern(pattern) {
        return new Promise(resolve => {
            const storageValues = this.encryptStorage.getItemFromPattern(pattern);
            resolve(storageValues);
        });
    }
    async removeItemFromPattern(pattern) {
        return new Promise(resolve => {
            resolve(this.encryptStorage.removeItemFromPattern(pattern));
        });
    }
    async clear() {
        return new Promise(resolve => {
            resolve(this.encryptStorage.clear());
        });
    }
    async key(index) {
        return new Promise(resolve => {
            resolve(this.encryptStorage.key(index));
        });
    }
    async encryptString(str) {
        return new Promise(resolve => {
            const encryptedValue = this.encryptStorage.encryptString(str);
            resolve(encryptedValue);
        });
    }
    async decryptString(str) {
        return new Promise(resolve => {
            const decryptedValue = this.encryptStorage.decryptString(str);
            resolve(decryptedValue);
        });
    }
}
