
import SettingStorage from "src/modules/Auth/services/crypt/SettingStorage";

export default {
  getUserName() {
    const tokenObject = SettingStorage.get('token', null);
    return tokenObject?.name;
  },
};
