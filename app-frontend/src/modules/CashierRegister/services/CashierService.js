export default {
  getCashierCartTotal(cart){
    if(cart){
      return cart.reduce((sum, item) => sum + item.subtotal, 0);
    }
    return 0;
  },
  getListShortcutAmounts(type){
    const MxnList = [
      {
        currency: "MXN",
        amount: 100
      },
      {
        currency: "MXN",
        amount: 200
      },
      {
        currency: "MXN",
        amount: 500
      },
      {
        currency: "MXN",
        amount: 1000
      }
    ];

    const UsdList = [
      {
        currency: "USD",
        amount: 5
      },
      {
        currency: "USD",
        amount: 10
      },
      {
        currency: "USD",
        amount: 20
      },
      {
        currency: "USD",
        amount: 100
      }
    ];

    if(type === 'MXN'){
      return MxnList;
    }else if(type === 'USD'){
      return UsdList;
    }else{
      return MxnList;
    }
  },
  getPaymentMethods(){
    return ['EFECTIVO', 'TARJETA', 'TRANSFERENCIA'];
  }
}
