export default {
  isEmptyOrWhitespace(str) {
    if (typeof str === 'string') {
      return str.trim() === '';
    }
    return str == null;
  },
  isHumanReadableFormat(date) {
    return (
      /^\d{2}\/\d{2}\/\d{4}$/.test(date) ||
      "La fecha no es correcta (dd/mm/yyyy)"
    );
  },
  required: (content) => !!content || "El campo es requerido",
  isPostalCode: (pc) =>
    /^\d{5}$/.test(pc) || "Require 5 dígitos",
  isNumberNotNull: (number) => number !== null && number >= 0 || "El valor tiene que ser mayor o igual que cero",
  isDateSet: (date) => date !== undefined && date !== null && date !== '',
  validUsername: (field) => /^[a-z][a-z0-9_-]+$/.test(field) || "El nombre de usuario debe tener el formato correcto",
  validEmail: (field) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field) || "El email debe tener el formato correcto",
  validPhone: (field) => /^[0-9]{10}$/.test(field) || "El teléfono debe tener 10 dígitos",
  validPassword: (field) => /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+[\]{};':"\\|,.<>\/?`~\-])[A-Za-z\d!@#$%^&*()_+[\]{};':"\\|,.<>\/?`~\-]{8,}$/.test(field) ||
    "Mínimo 8 caracteres, 1 mayúscula, 1 número, 1 carácter especial"
};
