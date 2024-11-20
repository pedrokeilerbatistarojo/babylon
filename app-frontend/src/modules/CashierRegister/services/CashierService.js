export default {
  getCashierCartTotal(cart){
    if(cart){
      return cart.reduce((sum, item) => sum + item.subtotal, 0);
    }
    else return 0;
  },
}
