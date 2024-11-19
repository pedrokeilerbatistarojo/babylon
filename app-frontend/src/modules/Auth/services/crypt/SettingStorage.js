import { EncryptStorage } from './encrypt-storage';

// eslint-disable-next-line
import * as FingerprintJS from '@fingerprintjs/fingerprintjs';

class SettingStorage {

  constructor(){
    this.store = localStorage;
  }

  async init(){
    const fp = await FingerprintJS.load({debug : false});
    const result = await fp.get();
    this.store = new EncryptStorage(result.visitorId, {
      prefix: '@instance1',
    });
  }

  set(key, value) {
    this.store.setItem(key,value);
  }

  get(key, value) {

    try {

      const data = this.store.getItem(key);

      if(data !== null && data !== undefined){
        return data;
      } else {
        return value;
      }

    } catch (ex) {
      return null;
    }
  }

  remove(key){
    this.store.removeItem(key);
  }

  getStorage() {
    return this.store;
  }
}

const instance = new SettingStorage();
//window.SettingStorage = instance;

export default instance;
