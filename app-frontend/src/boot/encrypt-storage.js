import SettingStorage from 'src/modules/Auth/services/crypt/SettingStorage';

export default async () => {
  await SettingStorage.init();
}
