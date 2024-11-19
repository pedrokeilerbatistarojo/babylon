
export default {
  setFloatByStringNumber: (amount) => parseFloat(amount.replace(/,/g, '')),
};
